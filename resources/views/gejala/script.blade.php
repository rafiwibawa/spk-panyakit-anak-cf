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
                        url: "{{ url('gejala/dt') }}", 
                    },
                    columns: [
                        { data: 'DT_RowIndex' },
                        { data: 'name' }, 
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
                                        <a title="Edit" class="btn-edit text-info" href="{{url('/gejala')}}/${data}"><i class="fa fa-edit"></i></a>
                                   
                                        <a title="Hapus" class="btn-delete ml-1 text-danger" href="{{url('/gejala')}}/${data}"><i class="fa fa-trash"></i></a>
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

                    $('#form_gejala').trigger("reset");
                    $('#form_gejala').attr('action','{{url('gejala')}}');
                    $('#form_gejala').attr('method','POST');
                    

                    showModal('modal_gejala');
                });

                $(document).on('click', '.btn-edit', function(event){
                    event.preventDefault();

                    var data = init_table.row($(this).parents('tr')).data();

                    $('#form_gejala').trigger("reset");
                    $('#form_gejala').attr('action', $(this).attr('href'));
                    $('#form_gejala').attr('method','PUT');

                    $('#form_gejala').find('input[name="name"]').val(data.name); 
                    

                    showModal('modal_gejala');
                });

                $(document).on('click', '.btn-delete', function(event){
                    event.preventDefault();
                    var url = $(this).attr('href');

                    Swal.fire({
                        title: 'Hapus gejala?',
                        text: "Akun gejala yang dihapus akan hilang permanen!",
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
                $('#form_gejala').submit(function(event){
                    event.preventDefault();

                    btn_loading('start')
                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: $(this).serialize(),
                    })
                    .done(function(res, xhr, meta) {
                        if (res.status == 200) {
                            toastr.success(res.message, 'Success')
                            init_table.draw(false);
                            hideModal('modal_gejala');
                        }
                    })
                    .fail(function(res, error) {
                        toastr.error(res.responseJSON.message, 'Gagal')
                    })
                    .always(function() {
                        btn_loading('stop')
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
            }
        }

    }();

    document.addEventListener('DOMContentLoaded', function() {
        Page.init();
    });

</script>
