 <div class="modal fade " id="add-form__add-gejala-modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="add-form__add-gejala-modal" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="add-form__add-gejala-form" autocomplete="off">
                    <div class="row">

                        {{-- gejala --}}
                        <div class="col-12 col-md-12">
                            <fieldset class="form-group">
                                <label >Gejala <span style="color: rgb(249, 91, 91">*</span></label>

                                <select class="form-control" name="gejala_id"
                                    data-placeholder="Select gejala"></select>

                                <div class="gejala_id-validation invalid-feedback" style="display: none;">
                                    <i class="bx bx-radio-circle"></i>
                                    <span></span>
                                </div>
                            </fieldset>
                        </div> 

                    </div>
                </form>
            </div>

            <div class="modal-footer"> 
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>

                <button id="add-form__add-gejala-form__submit" form="add-form__add-gejala-form" type="submit" class="btn btn-sm btn-primary">
                    <span class="spinner-border spinner-border-sm btn-spinner" role="status" aria-hidden="true" style="display: none;"></span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
 
<script> 

    $('#add-form__add-gejala-modal').on('hidden.bs.modal', function() {
        $(this).find('select[name=gejala]').val(null).trigger('change');
        $(this).find('input[name=stok]').val(null);
    });

    renderSelect2('#add-form__add-gejala-form select[name=gejala_id]', {
        data: [],
        // minimumResultsForSearch: Infinity,
        dropdownAutoWidth: true,
        width: '100%',
        containerCssClass: 'gejala_id-field',
    });

    axios({
        method: 'get',
        url: '{{ url('penyakit/add-from/select2-gejala') }}',
        headers: {
            Authorization: `Bearer ${getItems('token')}`,
            Accept: 'application/json',
        },
    }).then((res) => {
        const { gejala } = res.data;
        renderSelect2('#add-form__add-gejala-form select[name=gejala_id]', {
            data: gejala,
            // minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
            width: '100%',
            containerCssClass: 'gejala_id-field',
            allowClear: true,
        });
 
    }).catch((err) => {
        console.log(err);
        // handleErrorResponse(err.response);
    });


    $('#add-form__add-gejala-form').submit(function(event) {
        event.preventDefault();

        const spin = spinButton({ id: '#add-form__add-gejala-form__submit' });
        spin.start();

        const gejala_id = $(this).find('select[name=gejala_id]').val(); 

        axios({
            method: 'post',
            url: '{{ url('penyakit/validate-gejala') }}',
            data: { gejala_id },
            headers: {
                Authorization: `Bearer ${getItems('token')}`,
                Accept: 'application/json',
            },
        }).then((res) => {
            const { gejala_data } = res.data;
  
            // property (response):
            // - name

            let items = getItems('addForm__Gejala', []);
            const lastId = getItems('addForm__GejalaLastId', 0) + 1;

            // client validation
            let errors = {};

            // name, unique
            items.map((item) => {
                if (gejala_data.name === item.name) {
                    errors.name = ['The size must be unused.'];
                }
            });

            if (Object.keys(errors).length > 0) {
                handleErrorResponse({ data: { errors } }, '#add-form__add-gejala-form');
                spin.stop();
                return;
            }

            items = [...items, {
                id: lastId, // id (client property)
                ...gejala_data,
            }];
  
            setItems('addForm__Gejala', items);
            setItems('addForm__GejalaLastId', lastId);

            hideModal('#add-form__add-gejala-modal');
            addForm__ReloadGejalaTable();
            
            spin.stop();
        }).catch((err) => {
            console.log(err);
            handleErrorResponse(err, '#add-form__add-gejala-form');
            spin.stop();
        });
    });
</script> 
