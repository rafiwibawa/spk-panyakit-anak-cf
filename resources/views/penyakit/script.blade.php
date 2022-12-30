<script type="text/javascript">
    var Page = function() {
        var _componentPage = function(){
            var init_table;

            $(document).ready(function() {
                initTable();
                formSubmit();
                initAction();
            });

            const initTable = () => {
                init_table = $('#init-table').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    sScrollY: ($(window).height() < 700) ? $(window).height() - 200 : $(window).height() - 350,
                    ajax: {
                        type: 'POST',
                        url: "{{ url('penyakit/dt') }}", 
                    },
                    columns: [
                        { data: 'DT_RowIndex' },
                        { data: 'name' }, 
                        { data: 'kode' }, 
                        { defaultContent: '' }
                        ],
                    columnDefs: [
                        {
                            targets: 0,
                            searchable: false,
                            orderable: false,
                            className: "text-center"
                        },
                        {
                            targets: -1,
                            searchable: false,
                            orderable: false,
                            className: "text-center",
                            data: "id",
                            render : function(data, type, full, meta) {
                                return `
                                        <a title="Edit" class="btn-edit text-info" href="{{url('/penyakit')}}/${data}"><i class="fa fa-edit"></i></a>
                                   
                                        <a title="Hapus" class="btn-delete ml-1 text-danger" href="{{url('/penyakit')}}/${data}"><i class="fa fa-trash"></i></a>
                                    `
                            }
                        },
                    ],
                    order: [[1, 'asc']],
                    searching: true,
                    paging:true,
                    lengthChange:false,
                    bInfo:true,
                    dom: '<"datatable-header"><tr><"datatable-footer"ip>',
                    language: {
                        search: '<span>Search:</span> _INPUT_',
                        searchPlaceholder: 'Search.',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        processing: '<div class="text-center"> <div class="spinner-border text-primary" role="status"> <span class="sr-only">Loading...</span> </div> </div>',
                    },
                });

                $('#search').keyup(searchDelay(function(event) {
                    init_table.search($(this).val()).draw()
                }, 1000));

                $('#pageLength').on('change', function () {
                    init_table.page.len(this.value).draw();
                });
            },
            initAction = () => {
                $(document).on('click', '#add_btn', function(event){
                    event.preventDefault();

                    $('#form_penyakit').trigger("reset");
                    $('#form_penyakit').attr('action','{{url('penyakit')}}');
                    $('#form_penyakit').attr('method','POST');
                    

                    showModal('modal_penyakit');
                });

                $(document).on('click', '.btn-edit', function(event){
                    event.preventDefault();

                    var data = init_table.row($(this).parents('tr')).data();

                    $('#form_penyakit').trigger("reset");
                    $('#form_penyakit').attr('action', $(this).attr('href'));
                    $('#form_penyakit').attr('method','PUT');

                    $('#form_penyakit').find('input[name="name"]').val(data.name); 
                    $('#form_penyakit').find('input[name="kode"]').val(data.kode); 
                    

                    showModal('modal_penyakit');
                });

                $(document).on('click', '.btn-delete', function(event){
                    event.preventDefault();
                    var url = $(this).attr('href');

                    Swal.fire({
                        title: 'Hapus penyakit?',
                        text: "Akun penyakit yang dihapus akan hilang permanen!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal!',
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonClass: 'btn btn-danger ml-1',
                        buttonsStyling: false,
                    }).then(function (result) {
                        if (result.value) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                dataType: 'json',
                            })
                            .done(function(res, xhr, meta) {
                                if (res.status == 200) {
                                    toastr.success(res.message, 'Success')
                                    init_table.draw(false);
                                }
                            })
                            .fail(function(res, error) {
                                toastr.error(res.responseJSON.message, 'Gagal')
                            })
                            .always(function() { });
                        }
                    })
                });
            },
            formSubmit = () => {
                $('#form_penyakit').submit(function(event){
                    event.preventDefault();

                    // btn_loading('start')

                    const name = $(this).find('input[name="name"]').val();
                    const kode = $(this).find('input[name="kode"]').val(); 
                    const desc = $(this).find('textarea[name="description"]').val(); 

                    // const img = document.getElementById('img').files[0];
                    
                    const gejala = getItems('addForm__Gejala', []).map(gejala => {
                        // delete gejala.id; // client property

                        return gejala;
                    }); 

                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: { 
                            name,
                            kode, 
                            gejala, 
                            // img,
                            desc,
                        }, 
                        headers: {
                            Authorization: `Bearer ${getItems('token')}`,
                            Accept: 'application/json',
                        },
                    })
                    .done(function(res, xhr, meta) {
                        if (res.status == 200) {
                            toastr.success(res.message, 'Success')
                            init_table.draw(false);
                            hideModal('modal_penyakit');
                        }
                    })
                    .fail(function(res, error) {
                        toastr.error(res.responseJSON.message, 'Gagal')
                    })
                    .always(function() {
                        // btn_loading('stop')
                    });
                });
            }

            const showModal = function (selector) {
                $('#'+selector).modal('show')
            },
            hideModal = function (selector) {
                $('#'+selector).modal('hide')
            }

        };

        return {
            init: function(){
                _componentPage();



            // note
            var editor_config = {
                path_absolute : "/",
                selector: "textarea.note-editor",
                menubar: false,
                statusbar: false,
                plugins: [
                    "table advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | tableprops",
                table_toolbar: "tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                relative_urls: false,
                file_browser_callback : function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;

                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'File Manager',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    });
                }
            };

            tinymce.init(editor_config);
        } 

            
        }

    }();

    document.addEventListener('DOMContentLoaded', function() {
        Page.init();
    });

</script>
