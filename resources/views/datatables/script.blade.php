<script>
    // DataTables default settings
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        deferRender: true,
        dom: `
            <"datatable-header"lBf><"datatable-scroll"t><"datatable-footer"p>
        `,
        initComplete: function () {
            dtInitComplete();
        },
        drawCallback: function () {
            dtDrawCallback();
        },
        language: {
            decimal: ',',
            lengthMenu: '_MENU_',
            paginate: {
                'first': $('html').attr('dir') === 'rtl' ?
                    'Last' : 'First',
                'last': $('html').attr('dir') === 'rtl' ?
                    'First' : 'Last',
                'next': $('html').attr('dir') === 'rtl' ?
                    'Previous' : 'Next',
                'previous': $('html').attr('dir') === 'rtl' ?
                    'Next' : 'Previous',
            },
            search: '',
            searchPlaceholder: 'Search',
            thousands: '.',
            zeroRecords: 'Data not found',
        },
        pageLength: 10,
        pagingType: 'full_numbers',
        responsive: true,
        stateSave: true,
        lengthMenu: [10, 25, 50, 100],
    });

    // pipelining function for DataTables
    // to be used to the ajax option of DataTables
    $.fn.dataTable.pipeline = function (opts) {
        // configuration options
        const conf = $.extend({
            pages: 5, // number of pages to cache
            url: '', // script url
            data: null, // function or object with parameters to send to the server matching how ajax.data works in DataTables
            method: 'GET', // ajax HTTP method,
            headers: {},
            success: function (json) {},
        }, opts);

        // private variables for storing the cache
        let cacheLower = -1;
        let cacheUpper = null;
        let cacheLastRequest = null;
        let cacheLastJson = null;

        return function (request, drawCallback, settings) {
            let ajax = false;
            let requestStart = request.start;
            const drawStart = request.start;
            const requestLength = request.length;
            const requestEnd = requestStart + requestLength;

            if (settings.clearCache) {
                // API requested that the cache be cleared
                ajax = true;
                settings.clearCache = false;
            } else if (
                cacheLower < 0 ||
                requestStart < cacheLower ||
                requestEnd > cacheUpper
            ) {
                // outside cached data - need to make a request
                ajax = true;
            } else if (
                JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
            ) {
                // properties changed (ordering, columns, searching)
                ajax = true;
            }

            // store the request for checking next time around
            cacheLastRequest = $.extend(true, {}, request);

            if (ajax) {
                // need data from the server
                if (requestStart < cacheLower) {
                    requestStart = requestStart - (requestLength * (conf.pages - 1));

                    if (requestStart < 0) {
                        requestStart = 0;
                    }
                }

                cacheLower = requestStart;
                cacheUpper = requestStart + (requestLength * conf.pages);

                request.start = requestStart;
                request.length = requestLength * conf.pages;

                // provide the same data options as DataTables
                if (typeof conf.data === 'function') {
                    // as a function it is executed with the data object as an arg for manipulation
                    // if an object is returned, it is used as the data object to submit
                    const d = conf.data(request);
                    if (d) {
                        $.extend(request, d);
                    }
                } else if ($.isPlainObject(conf.data)) {
                    // as an object, the data given extends the default
                    $.extend(request, conf.data);
                }

                settings.jqXHR = $.ajax({
                    cache: false,
                    data: request,
                    dataType: 'json',
                    headers: conf.headers,
                    success: function (json) {
                        cacheLastJson = $.extend(true, {}, json);

                        if (cacheLower !== drawStart) {
                            json.data.splice(0, drawStart - cacheLower);
                        }

                        if (requestLength >= -1) {
                            json.data.splice(requestLength, json.data.length);
                        }

                        drawCallback(json);
                        conf.success(json);
                    },
					error: function(res) {
                        const data = res.responseJSON;
                        const { status } = res;
                        
                        handleErrorResponse({ status, data });
                    },
                    type: conf.method,
                    url: conf.url,
                });
            } else {
                json = $.extend(true, {}, cacheLastJson);
                json.draw = request.draw; // update the echo for each response
                json.data.splice(0, requestStart - cacheLower);
                json.data.splice(requestLength, json.data.length);

                drawCallback(json);
            }
        }
    };

    // register an API method that will empty the pipelined data, forcing an ajax
    // fetch on the next draw (i.e. table.clearPipeline().draw())
    $.fn.dataTable.Api.register('clearPipeline()', function () {
        return this.iterator('table', function (settings) {
            settings.clearCache = true;
        });
    });

    // function expression
    const dtInitComplete = (identifier) => {
        if (identifier) {
            const dtTable = $(`${identifier}`).DataTable();
            const wrapper = `${identifier}_wrapper`;

            // enable select2 select for the length option
            $(`${wrapper} .dataTables_length select`).select2({
                minimumResultsForSearch: Infinity,
                width: 'auto',
            });

            // disable on keyup searching
            $(`${wrapper} .dataTables_filter input`).unbind();
            $(`${wrapper} .dataTables_filter`).append(`
                <button
                    type="button"
                    class="btn btn-icon btn-sm btn-outline-primary mr-1 mb-1 tooltip-light"
                    data-toggle="tooltip"
                    data-placement="left"
                    title="Search"
                >
                    <i class="bx bx-search"></i>
                </button>
            `);

            // bind filter input
            $(`${wrapper} .dataTables_filter input`).bind('keyup', function (e) {
                if (e.keyCode === 13) dtTable.search(this.value).draw();
            });

            $(`${wrapper} .dataTables_filter button`).on('click', function () {
                dtTable.search($(`${wrapper} .dataTables_filter input`).val()).draw();
                $(this).blur();
            });
        }
    };

    const dtDrawCallback = (identifier, options) => {
        if (identifier) {
            const dtTable = $(`${identifier}`).DataTable();
            const wrapper = `${identifier}_wrapper`;

            options = {
                renderTooltip: false,
                ...options,
            }

            if (options.renderTooltip) {
                $(`${wrapper} [data-toggle="tooltip"]`).tooltip();
                $(`${wrapper} [data-toggle="tooltip"]`).on('click', function() {
                    $(this).tooltip('hide');
                });
            }
        }
    };
</script>
