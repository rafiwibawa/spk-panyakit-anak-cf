<script>
    // variable
    // fixing nested bootstrap modal scrolling issue
    let bootstrapModalCounter = 0; //counter is better then using visible selector
    
    $(document).ready(function() {
        $('.modal').on("hidden.bs.modal", function(e) {
            --bootstrapModalCounter;
            if (bootstrapModalCounter > 0) {
                //don't need to recalculate backdrop z-index; already handled by css
                //$('.modal-backdrop').first().css('z-index', parseInt($('.modal:visible').last().css('z-index')) - 10);
                $('body').addClass('modal-open');
            }

            $('body').css('padding-right', '');
        }).on("show.bs.modal", function(e) {
            ++bootstrapModalCounter;
            //don't need to recalculate backdrop z-index; already handled by css
        });
    });

    // function expression
    const logout = () => new Promise((resolve, reject) => {
        localStorage.clear();

        axios({
            method: 'get',
            url: '{{ url('logout') }}',
        }).then((res) => {
            clickLink("{{ url('/') }}", duration.animation);
            resolve();
        }).catch((err) => {
            const {
                message
            } = err.response.data;
            setNotify({
                content: message,
                type: 'error'
            });
            reject();
        });
    });

    const setBranchAndCompany = (branch_name, company_name) => {
        axios({
            method: 'post',
            url: "{{ url('set-branch-and-company') }}",
            data: {
                branch_name,
                company_name
            },
        }).then((res) => {                 
            location.reload();
        }).catch((err) => {
            const {
                message
            } = err.response.data;
            setNotify({
                content: message,
                type: 'error'
            });
        });
    };

    const testBranchAndCompany = (branch_name, company_name) => {
        axios({
            method: 'post',
            url: "{{ url('set-branch-and-company') }}",
            data: {
                branch_name,
                company_name
            },
        }).then((res) => {
            // location.reload();
        }).catch((err) => {
            const {
                message
            } = err.response.data;
            setNotify({
                content: message,
                type: 'error'
            });
        });
    };

    const setBranch = (branch_name) => {
        setBranchAndCompany(branch_name, company_name);
    };

    const setCompany = (company_name) => {
        setBranchAndCompany(branch_name, company_name);
    };

    const setBrand = (brand_id) => {
        axios({
            method: 'post',
            url: '{{ url('set-brand') }}',
            data: {
                brand_id
            },
        }).then((res) => {
            // clear datatable localstorage
            for (const itemName in localStorage) {
                if (itemName.startsWith('DataTables')) {
                    removeItems(itemName);
                }
            }            
            
            location.reload();
        }).catch((err) => {
            const {
                message
            } = err.response.data;
            setNotify({
                content: message,
                type: 'error'
            });
        });
    };

    const testBrand = (brand_id) => {
        axios({
            method: 'post',
            url: '{{ url('set-brand') }}',
            data: {
                brand_id
            },
        }).then((res) => {
            // clear datatable localstorage
            for (const itemName in localStorage) {
                if (itemName.startsWith('DataTables')) {
                    removeItems(itemName);
                }
            }

            // location.reload();
        }).catch((err) => {
            const {
                message
            } = err.response.data;
            setNotify({
                content: message,
                type: 'error'
            });
        });
    };

    const showModal = (identifier) => {
        $(identifier).modal('show');
    };

    const hideModal = (identifier) => {
        $(identifier).modal('hide');
    };

    const setNotify = (options) => {
        // options:
        // - title
        // - content
        // - type [success, info, warning, error]

        options = {
            type: 'info',
            ...options,
        };

        const toastrParams = [];

        if (options.hasOwnProperty('content')) toastrParams.push(options.content);
        if (options.hasOwnProperty('title')) toastrParams.push(options.title);

        toastr[options.type](...toastrParams);
    };

    const setConfirm = (options, cb) => {
        // options:
        // - title
        // - content
        // - size
        // - buttons
        // - closeButton
        // - backdrop
        // - callback

        options = {
            title: false,
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-sm btn-primary',
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn btn-sm btn-light-primary',
                },
            },
            closeButton: false,
            backdrop: false,
            callback: function(result) {
                cb(result);
            },
            onHidden: function (e) {
                --bootstrapModalCounter;
                if (bootstrapModalCounter > 0) {
                    //don't need to recalculate backdrop z-index; already handled by css
                    //$('.modal-backdrop').first().css('z-index', parseInt($('.modal:visible').last().css('z-index')) - 10);
                    $('body').addClass('modal-open');
                }

                $('body').css('padding-right', '');
            },
            onShow: function (e) {
                ++bootstrapModalCounter;
                //don't need to recalculate backdrop z-index; already handled by css
            },
            ...options,
        };

        if (options.content) {
            options.message = options.content;
            delete options.content;
        }

        bootbox.confirm(options);
    };

    const handleErrorResponse = (response, container) => {
        const {
            status
        } = response;

        if (status === 401) logout();

        if (
            container &&
            response.hasOwnProperty('data') &&
            response.data.hasOwnProperty('errors') &&
            Object.keys(response.data.errors).length > 0
        ) {
            for (const attr in response.data.errors) {
                if ($(`.${attr}-field`).length) {
                    $(container).find(`.${attr}-field`).addClass('is-invalid');
                    $(container).find(`.${attr}-validation span`).text(response.data.errors[attr][0]);
                    $(container).find(`.${attr}-validation`).css('display', '');

                    setTimer(`${container}.${attr}`, duration.popup, () => {
                        // reverse action
                        $(container).find(`.${attr}-field`).removeClass('is-invalid');
                        $(container).find(`.${attr}-validation span`).text('');
                        $(container).find(`.${attr}-validation`).css('display', 'none');
                    });
                } else {
                    setNotify({
                        content: response.data.errors[attr][0],
                        type: 'error',
                    });

                    break;
                }
            }
        } else if (
            response.hasOwnProperty('data') &&
            response.data.hasOwnProperty('errors') &&
            Object.keys(response.data.errors).length > 0
        ) {
            let content = null;

            for (const attr in response.data.errors) {
                if (!content && response.data.errors[attr][0]) {
                    content = response.data.errors[attr][0];
                }
            }

            if (!content) content = 'Server busy, please try again later!';

            setNotify({
                content,
                type: 'warning',
            });

        } else if (
            response.hasOwnProperty('data') &&
            response.data.hasOwnProperty('message') &&
            response.data.message
        ) {
            setNotify({
                content: response.data.message,
                type: 'warning',
            });
        } else {
            setNotify({
                content: 'Server busy, please try again later!',
                type: 'warning',
            });
        }
    };

    const spinButton = (options) => {
        // options:
        // - id
        // - isIconButton

        options = {
            isIconButton: false,
            ...options,
        }

        return {
            start: function() {
                $(options.id).attr('disabled', 'disabled');
                $(`${options.id} .btn-spinner`).css('display', '');

                if (options.isIconButton) {
                    $(`${options.id} i`).css('display', 'none');
                }
            },
            stop: function() {
                $(options.id).removeAttr('disabled');
                $(`${options.id} .btn-spinner`).css('display', 'none');

                if (options.isIconButton) {
                    $(`${options.id} i`).css('display', '');
                }
            },
        };
    };


    const spinHtml = (options) => {
        // options:
        // - id
        // - isIconButton

        options = {
            isIconButton: false,
            ...options,
        }

        return {
            start: function() {
                $(options.id).append(`
                <div class="spinner-border mt-2" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            `)
            },
            stop: function() {
                $(options.id).remove()

            },
        };
    };

    const renderSelect2 = (identifier, options) => {
        $(identifier).off('change');
        $(identifier).empty();
        $(identifier).append('<option></option>');

        const onChange = options.onChange;
        delete options.onChange;

        if (options) {
            $(identifier).select2(options);
        } else {
            $(identifier).select2();
        }

        if (onChange) {
            $(identifier).on('change', onChange);
        }
    };

    const renderResumable = (container, options) => {
        // options:
        // - url
        // - onSuccess
        // - maxFiles
        // - maxFileSize
        // - fileType

        options = {
            maxFiles: 1,
            maxFileSize: 10 * 1000 * 1000, // ~ 10 MB
            onSuccess: function(file) {
                // do some action
            },
            reset: function() {
                resetResumable(container);
            },
            ...options,
        };

        const identifier = document.querySelector(container).dataset.id;

        const r = new Resumable({
            maxFiles: options.maxFiles,
            maxFileSize: options.maxFileSize,
            maxFileSizeErrorCallback: function(file, errorCount) {
                setNotify({
                    content: `Maximum image size is ${options.maxFileSize / 1000000} MB.`,
                    type: 'error'
                });
            },
            fileType: options.fileType,
            fileTypeErrorCallback: function(file, errorCount) {
                setNotify({
                    content: `File type must be ${options.fileType.join(', ')}.`,
                    type: 'error'
                });
            },
            target: options.url,
            chunkSize: 1 * 1024 * 1024, // 1MB
            simultaneousUploads: 3,
            testChunks: false,
            throttleProgressCallbacks: 1,
            headers: {
                Authorization: `Bearer ${getItems('token')}`,
                Accept: 'application/json',
            },
        });

        if (!r.support) setNotify({
            content: 'Your browser does not support.',
            type: 'error'
        });

        r.assignBrowse(document.getElementById(`${identifier}-button`));
        r.assignDrop(document.getElementById(`${identifier}-drop`));

        r.on('fileAdded', function(file, event) {
            options.reset();
            blockElement(`${identifier}-drop`);
            r.upload();
        });

        r.on('fileProgress', function(file, message) {
            const progress = file.progress() * 100;
            $(`${container} .progress-bar`).css('width', `${progress}%`);
        });

        r.on('fileSuccess', function(file, message) {
            if (message) {
                const res = JSON.parse(message);
                const {
                    file_path,
                    file_name,
                    file_url
                } = res;

                $(`${container} .resumable-uploaded`).append(`
                    <button
                        type="button"
                        class="btn btn-sm btn-light-primary"
                        onclick="openNewTab('${file_url}')"
                    >
                        <span class="spinner-border spinner-border-sm btn-spinner" role="status" aria-hidden="true" style="display: none;"></span>
                        ${file_name}
                    </button>
                `);

                options.onSuccess({
                    file_path,
                    file_name,
                    file_url
                });
            } else {
                setNotify({
                    content: 'Please try again.',
                    type: 'error'
                });
            }

            unblockElement(`${identifier}-drop`);
        });

        r.on('fileError', function(file, message) {
            setNotify({
                content: 'Failed to upload file.',
                type: 'error'
            });
            unblockElement(`${identifier}-drop`);
        });
    };

    const resetResumable = (container) => {
        $(`${container} .progress-bar`).css('width', '0%');
        $(`${container} .resumable-uploaded`).empty();
    };

    const resumableAddItem = (container, options = {}) => {
        const {
            file_name,
            url
        } = options;

        $(`${container} .resumable-uploaded`).append(`
            <button
                type="button"
                class="btn btn-sm btn-light-primary"
                onclick="openNewTab('${url}')"
            >
                <span class="spinner-border spinner-border-sm btn-spinner" role="status" aria-hidden="true" style="display: none;"></span>
                ${file_name}
            </button>
        `);
    };

    const clearResumable = (container, formInput) => {
        resetResumable(container);
        $(formInput).val(null);
    };

    const blockElement = (identifier, options = {}) => {
        // options:
        // - message
        // - icon
        // - timeout

        const icon = options.hasOwnProperty('icon') ? options.icon : 'bx-loader-circle';
        delete options.icon;

        $(identifier).block({
            message: `<div class="bx ${icon} icon-spin font-medium-2"></div>`,
            timeout: 2000,
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.8,
                cursor: 'wait',
            },
            css: {
                color: '#475F7B',
                border: 0,
                padding: 0,
                backgroundColor: 'transparent',
                width: '40%',
                height: '40%',
            },
            ...options,
        });
    };

    const unblockElement = (identifier) => {
        $(identifier).unblock();
    };

    // toNumber
    // numeral.register('locale', 'id', {
    //     delimiters: {
    //         thousands: '.',
    //         decimal: ',',
    //     },
    //     abbreviations: {
    //         thousand: 'k',
    //         million: 'm',
    //         billion: 'b',
    //         trillion: 't'
    //     },
    //     currency: {
    //         symbol: 'Rp'
    //     },
    // });

    // numeral.locale('id');

    // const toNumber = (s) => {
    //     const type = typeof s;

    //     if (type === 'number') return s;
    //     if (type !== 'string') return 0;

    //     const n = numeral(s).value();

    //     if (!n) return 0;
    //     return n;
    // };

    // const numberInputFocusOut = (strNumber, decimal = false) => {
    //     const type = typeof strNumber;

    //     if (type !== 'string') return '0';

    //     strNumber = strNumber.replace(/[^0-9,]/g, '');
    //     strNumberArr = strNumber.split(',');
    //     if (strNumberArr.length === 1) strNumberArr.push('00');

    //     strNumberArr[0] = numeral(strNumberArr[0]).value().toLocaleString('id-ID');
    //     strNumber = strNumberArr[0];

    //     if (decimal) strNumber = `${strNumber},${strNumberArr[1]}`;

    //     return strNumber;
    // };

    const numberInputFocusIn = (strNumber, decimal = false) => {
        const type = typeof strNumber;

        if (type !== 'string') return '0';

        strNumber = strNumber.replace(/[^0-9,]/g, '');
        strNumberArr = strNumber.split(',');
        if (strNumberArr.length === 1) strNumberArr.push('00');

        strNumber = strNumberArr[0];

        if (decimal) strNumber = `${strNumber},${strNumberArr[1]}`;

        return strNumber;
    };

    $('.set-number').keyup(function(event) {
        $(this).val(numberInputFocusIn($(this).val()))
        // var form_id = $(this).closest("form").attr('id')
        // $(`#${form_id}`).find('input[name=price]').val(numberInputFocusIn($(this).val()));
    });
</script>
