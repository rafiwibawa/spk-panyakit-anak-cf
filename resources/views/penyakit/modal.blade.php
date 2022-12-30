<div class="modal fade" id="modal_penyakit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <form action="" method="" autocomplete="off" id="form_penyakit">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah penyakit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama<span class="text-danger">*</span></label>
                        <input type="text" name="name" parsley-trigger="change" required
                            placeholder="Nama" class="form-control">
                    </div>  

                    <div class="form-group">
                        <label>Kode<span class="text-danger">*</span></label>
                        <input type="text" name="kode" parsley-trigger="change" required
                            placeholder="Kode" class="form-control">
                    </div> 

                    {{-- <div class="form-group">
                        <label>Image<span class="text-danger">*</span></label>
                        <input type="file" name="image" id="img" parsley-trigger="change" required
                            placeholder="Image" class="form-control"> --}}
                    {{-- </div>  --}}

                    <div class="form-group">
                        <label>Description<span class="text-danger">*</span></label>
                        <textarea type="text" name="description"  
                            class="form-control note-editor"></textarea>
                    </div> 

                    @component('penyakit.gejala.component', [
                        // table config here
                    ])
                        {{-- slot --}}
                    @endcomponent  

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light btn-loading">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
