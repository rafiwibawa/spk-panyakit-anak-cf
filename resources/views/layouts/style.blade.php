<style>
    .popover, .tooltip, body {
        font-family: 'IBM Plex Sans',Helvetica,Arial,serif;
    }

    .app-content {
        min-height: calc(100% - 6rem) !important;
    }

    .btn-spinner {
        position: relative;
        top: -1px;
    }
    
    .font-monospace {
        font-family: monospace !important;
    }

    .bootbox-body {
        font-size: 0.8rem;
    }

    .content-wrapper {
        padding: 0rem 0rem 0rem 0rem !important;
    }

    .select2-results__options {
        font-size: 0.8rem;
    }

    /* form */
    .form-label {
        font-size: 0.6rem;
    }

    .form-group {
        margin-bottom: 0.5rem;
    }

    .toast {
        border: none;
        font-size: 0.8rem;
    }

    .is-invalid {
        border-color: #FF5B5C !important;
    }

    .form-control:disabled {
        background-color: #f7f7f7;
    }
    
    form :disabled {
        color: #4f575f !important;
    }

    /* form checkbox */
    form .checkbox label {
        font-size: 0.8rem;
        margin-left: 2rem;
        color: #727E8C;
    }

    .checkbox input:disabled ~ label::before {
        border: none;
        background-color: #f7f7f7 !important;
    }

    .checkbox input:disabled ~ label::after {
        color: #4f575f !important;
    }

    /* form select2 */
    form .select2-container *:focus {
        outline: none;
    }

    form .select2-selection {
        min-height: 31px !important;
        height: 31px !important;
        padding: 5px 2px 5px 2px;
        border-radius: 3px;
        font-size: 0.8rem;
    }

    form .select2-selection--multiple {
        height: auto !important;
    }

    form .select2-selection__rendered {
        line-height: 20px !important;
        color: #475F7B !important;
    }

    form .select2-selection__arrow {
        min-height: 31px !important;
        height: 31px !important;
    }

    form .select2-selection__arrow b {
        margin-left: -5px !important;
    }

    form .select2-container--default.select2-container--disabled .select2-selection__rendered,
    form .select2-container--default.select2-container--disabled .select2-selection__placeholder {
        color: #4f575f !important;
    }

    form .select2-container--default.select2-container--disabled .select2-selection {
        border: 0;
    }

    form .select2-container--default.select2-container--disabled .select2-selection--single {
        background-color: #f7f7f7;
    }

    form .select2-container--default.select2-container--disabled.select2-container--focus .select2-selection {
        background-color: #f7f7f7;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }

    form .select2-container--default.select2-container--disabled .select2-selection__arrow b {
        display: none;
    }

    /* form resumable */
    form .resumable {
        border: none;
        padding: 0px;
        height: auto;
    }

    form .resumable .resumable-drop {
        border: 2px dashed #DFE3E7;
        height: 100px;
    }

    form .resumable .resumable-drop button {
        margin-top: 10px;
    }

    form .resumable .resumable-uploaded button {
        margin: 10px 10px 0px 0px;
    }

    form .resumable .resumable-progress .progress {
        margin: 10px 0px 0px 0px !important;
    }

    form .resumable .blockMsg {
        top: 30% !important;
        left: 30% !important;
    }

    /* form pickadate */
    form .picker__input:disabled {
        background-color: #f7f7f7;
    }

    /* form textarea */
    form textarea:disabled {
        resize: none;
    }

    /* content-container */
    .content-container {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }

    @media (max-width: 1199.98px) {
        .content-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }

    @media (max-width: 991.98px) {
        .content-container {
            padding-left: 1rem !important;
        }
    }

    @media (max-width: 576px) {
        .content-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }

    /* modal */
    .modal {
        /* fix nested modal issue */
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-body {
        padding: 1rem;
    }

    .modal-footer {
        padding: 0rem 1rem 1rem 1rem;
        border-top: 0px;
        display: inline-block;
    }

    .modal-footer > .btn,
    .modal-footer > .btn-group {
        float: right;
        margin: 2px;
    }

    .modal .dt-custom-button i {
        top: 2px;
    }

    .modal .dataTables_filter button i {
        top: 2px;
    }

    .modal .datatable-scroll td {
        border-top: 1px solid #DFE3E7 !important;
    }

    .modal .modal-content {
        border: none;
    }

    /* card */
    .card {
        margin-bottom: 0.5rem;
        border-radius: 3px;
    }

    .card-body {
        padding: 0.5rem;
    }

    /* dropdown button */
    .btn-group-dropdown .btn {
        border: none !important;
    }
    
    .btn-group-dropdown .dropdown-toggle {
        padding: 0rem 1rem 0rem 0rem !important;
    }

    .btn-group-dropdown .dropdown-toggle::after {
        top: 2px;
        left: 6px !important;
    }

    .btn-group-dropdown .dropdown-item {
        text-transform: capitalize;
        padding: 0.25rem 1rem;
        cursor: pointer;
    }

    /* dropdown button datatable */
    .btn-group-dropdown-datatable .btn {
        margin: 0rem !important;
        padding: 0rem 0.25rem 0rem 0.25rem !important;
        min-height: 25px;
        min-width: 25px;
        border: 1px solid #5A8DEE !important;
        color: #5A8DEE;
    }

    .btn-group-dropdown-datatable .btn:focus {
        color: #FFFFFF !important;
    }

    .btn-group-dropdown-datatable .dropdown-item {
        text-transform: capitalize;
        padding: 0.25rem 1rem;
        cursor: pointer;
    }

    /* component */
    /* select2 */
    .component .select2-container *:focus {
        outline: none;
    }

    .component .select2-selection {
        min-height: 31px !important;
        height: 31px !important;
        padding: 5px 2px 5px 2px;
        border-radius: 3px;
        font-size: 0.8rem;
    }

    .component .select2-selection__rendered {
        line-height: 20px !important;
        color: #475F7B !important;
    }

    .component .select2-selection__arrow {
        min-height: 31px !important;
        height: 31px !important;
    }

    .component .select2-selection__arrow b {
        margin-left: -5px !important;
    }

    .component .select2-container--default.select2-container--disabled .select2-selection__rendered,
    .component .select2-container--default.select2-container--disabled .select2-selection__placeholder {
        color: #4f575f !important;
    }

    .component .select2-container--default.select2-container--disabled .select2-selection {
        border: 0;
    }

    .component .select2-container--default.select2-container--disabled .select2-selection--single {
        background-color: #f7f7f7;
    }

    .component .select2-container--default.select2-container--disabled.select2-container--focus .select2-selection {
        background-color: #f7f7f7;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }

    .component .select2-container--default.select2-container--disabled .select2-selection__arrow b {
        display: none;
    }

    .component-select2-small .select2-container *:focus {
        outline: none;
    }

    .component-select2-small .select2-selection {
        min-height: 25px !important;
        height: 25px !important;
        padding: 5px 2px 5px 2px;
        border-radius: 3px;
    }

    .component-select2-small .select2-selection__rendered {
        line-height: 15px !important;
        color: #475F7B !important;
        font-size: 0.8rem;
    }

    .component-select2-small .select2-selection__arrow {
        min-height: 25px !important;
        height: 25px !important;
    }

    .component-select2-small .select2-selection__arrow b {
        margin-left: -2px !important;
    }
</style>
