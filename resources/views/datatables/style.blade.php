<style>
    /* custom button */
    .dt-custom-button {
        margin: 0rem !important;
        padding: 0rem !important;
        min-height: 25px;
        min-width: 25px;
    }

    .dt-custom-button i {
        top: 2px;
        font-size: 14px;
        border-radius: 3px;
    }

    /* custom select */
    .dt-custom-select .select2-container *:focus {
        outline: none;
    }

    .dt-custom-select .select2-selection {
        min-height: 25px !important;
        height: 25px !important;
        padding: 5px 2px 5px 2px;
        border-radius: 4px;
    }

    .dt-custom-select .select2-selection__rendered {
        line-height: 15px !important;
        color: #475F7B !important;
        font-size: 0.8rem;
    }

    .dt-custom-select .select2-selection__arrow {
        min-height: 25px !important;
        height: 25px !important;
    }

    .dt-custom-select .select2-selection__arrow b {
        margin-left: -2px !important;
    }

    @media only screen and (min-width: 769px) {
        .dt-custom-select .select2-container {
            top: -2px;
        }
    } 

    /* label */
    .dt-label {
        clear: left;
        margin: 0px 5px 5px 0px !important;
        display: inline-block;
        min-height: 25px;
        font-size: 14px;
        font-weight: 500;
        color: #475F7B;
        text-transform: uppercase;
        padding-top: 7px;
    }

    /* length */
    .dataTables_length {
        clear: left;
        margin: 0px 5px 5px 0px !important;
        display: inline-block;
    }

    .dataTables_length .select2-container *:focus {
        outline: none;
    }

    .dataTables_length .select2-selection {
        min-height: 25px !important;
        height: 25px !important;
        padding: 5px 2px 5px 2px;
        border-radius: 4px;
    }

    .dataTables_length .select2-selection__rendered {
        line-height: 15px !important;
        color: #475F7B !important;
        font-size: 0.8rem;
    }

    .dataTables_length .select2-selection__arrow {
        min-height: 25px !important;
        height: 25px !important;
    }

    .dataTables_length .select2-selection__arrow b {
        margin-left: -2px !important;
    }

    .dataTables_length label {
        margin-bottom: 0px;
    }

    @media only screen and (max-width: 768px) {
        .dataTables_length {
            margin: 0px 0px 5px 5px !important;
            float: right !important;
        }
    }
    @media only screen and (min-width: 769px) {
        .dataTables_length .select2-container {
            top: -3px;
        }
    }   

    /* filter */
    .dataTables_filter {
        float: right;
        margin: 0px 0px 0px 0px !important;
        display: inline-block;
        text-align: right !important;
    }

    .dataTables_filter label {
        margin: 0px 0px 5px 5px !important;
        display: inline-block;
        vertical-align: middle;
    }

    .dataTables_filter label input {
        padding: 0px 15px 0px 15px;
        height: 25px;
        border-radius: 3px;
        margin-left: 0px !important;
        width: 176px !important;
    }

    .dataTables_filter button {
        margin: 0px 0px 5px 0px !important;
        display: inline-block;
        padding: 0rem !important;
        min-height: 25px;
        min-width: 25px;
        vertical-align: middle;
    }

    .dataTables_filter button i {
        top: 2px;
        font-size: 14px;
        border-radius: 3px;
    }

    /* header content */
    .dt-custom-right {
        float: right;
        margin: 0px 0px 5px 5px !important;
        display: inline-block;
    }

    .dt-custom-left {
        clear: left;
        margin: 0px 5px 5px 0px !important;
        display: inline-block;
    }

    @media only screen and (max-width: 768px) {
        .dt-custom-left {
            float: right !important;
            margin: 0px 0px 5px 5px !important;
        }
    }

    /* pagination */
    .dataTables_paginate {
        float: right;
        clear: left;
        margin: 0px 0px 0px 0px !important;
        white-space: normal !important; /* default */
    }

    .dataTables_paginate .pagination {
        margin: 0px 0px 0px 0px !important;
        white-space: normal !important; /* default */
        display: inline-block !important; /* default */
    }

    .dataTables_paginate .paginate_button {
        margin: 5px 0px 0px 5px !important;
        display: inline-block;
    }

    .dataTables_paginate .paginate_button a {
        height: 25px;
        padding: 3px 10px 3px 10px !important;
        font-size: 12px;
        border-radius: 3px !important;
    }

    .dataTables_paginate .paginate_button .page-link {
        border: 1px solid #DFE3E7 !important;
        border-radius: 3px;
    }

    /* scroll */    
    .datatable-scroll th {
        padding: 0.5rem;
        font-size: 12px !important;
        border-bottom: none !important;
        outline: none;
    }
    
    .datatable-scroll .DTFC_RightHeadWrapper th {
        padding: 0.5rem;
        font-size: 0.6rem !important;
        border-bottom: 1px dashed #DFE3E7 !important;
        outline: none;
    }

    .datatable-scroll th:before {
        font-size: 0.8rem !important;
        top: 0px !important;
    }

    .datatable-scroll th:after {
        font-size: 0.8rem !important;
        top: 0px !important;
    }
    
    .datatable-scroll .dataTables_scrollHead th {
        border-bottom: 1px dashed #DFE3E7 !important;
    }

    .datatable-scroll td {
        padding: 0.5rem;
        font-size: 0.8rem;
    }

    .datatable-scroll .DTFC_RightBodyWrapper td {
        padding: 0.5rem;
        font-size: 0.8rem;
    }

    .datatable-scroll thead tr th {
        border: none;
    }

    .datatable-scroll .DTFC_RightHeadWrapper thead tr th {
        border: none;
    }

    /* pill badges */
    .datatable-scroll .badge-pill {
        text-transform: capitalize;
        font-size: 0.7rem;
    }

    /* footer */
    .datatable-footer {
        min-height: 32px;
    }

    .datatable-scroll tfoot tr th {
        border: none;
    }

    .datatable-scroll .DTFC_RightFootWrapper tfoot tr th {
        border: none;
    }

    /* counter */
    .datatable-footer .counter {
        font-size: 12px;
        padding-top: 5px;
        display: inline;
    }

    /* hover background color */
    .dataTables_scroll tbody tr:nth-child(even):hover td{
        background-color: #f2f4f4 !important;
    }

    .dataTables_scroll tbody tr:nth-child(odd):hover td {
        background-color: #f2f4f4 !important;
    }

    /* processing */
    .dataTables_processing {
        font-size: 0.8rem;
    }
</style>
