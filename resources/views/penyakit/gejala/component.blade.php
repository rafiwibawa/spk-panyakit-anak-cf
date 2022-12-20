<div class="row" style="margin-top: 1.5rem;">
    <div class="col-12">  
        <table id="add-form__gejala-table" class="table zero-configuration nowrap">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th> 
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
 
<script>
    setItems('addForm__Gejala', []);
    setItems('addForm__GejelaLastId', 0);

    let addForm__GejalaTable = $('#add-form__gejala-table').DataTable({
        data: getItems('addForm__Gejala', []),
        columnDefs: [
            { // id
                data: 'id', 
                targets: 0,
                visible: false,
            },
            { // gejala
                data: 'name',
                targets: 1,
            }, 
            { // actions
                className: 'text-center',
                data: function(row, type, val, meta) {
                    return `  
                        <button
                            type="button"
                            class="btn btn-icon btn-sm btn-outline-primary mr-1 mb-1 dt-custom-button tooltip-light"
                            id="add-form__delete-mac-address-action-${row.id}"
                            onclick="addForm__DeleteGejala(${row.id})"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Delete"
                        >
                            <span class="spinner-border spinner-border-sm btn-spinner" role="status" aria-hidden="true" style="display: none;"></span>
                            <i style="color: blue" class="fa fa-trash"></i>
                        </button>
                    `;
                },
                orderable: false,
                searchable: false,
                targets: -1,
                width: '10%',
            },
        ],
        dom: `
            <"datatable-header"<"title-label"><"add-button">><"datatable-scroll"t><"datatable-footer">
        `,
        initComplete: function() {
            const wrapper = '#add-form__gejala-table_wrapper';

            dtInitComplete('#add-form__gejala-table');

            // title label
            $(`${wrapper} .title-label`).replaceWith(`
                <div class="dt-label title-label">
                    Gejala
                </div>
            `);

            // add button
            $(`${wrapper} .add-button`).replaceWith(`
                <button
                    id="add_button" 
                    type="button"
                    class="btn btn-icon btn-sm btn-outline-primary mr-1 mb-1 add-button dt-custom-button dt-custom-right tooltip-light"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Add"
                >
                    <i style="color: blue" class="fa fa-plus"></i>
                </button>
            `);

            $(`${wrapper} .add-button`).on('click', function() {
                showModal('#add-form__add-gejala-modal');
                $(this).blur();
            });
        },
        drawCallback: function () {
            const wrapper = '#add-form__gejala-table_wrapper';
            
            // tooltip
            // $(`${wrapper} [data-toggle="tooltip"]`).tooltip();
            $(`${wrapper} [data-toggle="tooltip"]`).on('click', function () {
                $(this).blur();
            });
        },
        order: [
            [0, 'desc'],
        ],
    }); 

    const addForm__ReloadGejalaTable = () => {
        addForm__GejalaTable.clear().draw();
        addForm__GejalaTable.rows.add(getItems('addForm__Gejala', []))
        addForm__GejalaTable.columns.adjust().draw(); 
    };

    const addForm__DeleteGejala = (id) => {
        const spin = spinButton({ id: `#add-form__delete-mac-address-action-${id}`, isIconButton: true });
        spin.start();

        let items = getItems('addForm__Gejala', []).filter(item => item.id !== id);
        
        setItems('addForm__Gejala', items);
        addForm__ReloadGejalaTable();            

        spin.stop();
    };
 
</script>  
