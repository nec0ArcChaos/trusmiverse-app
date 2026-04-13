<link rel="stylesheet" href="<?= base_url('assets/data-table/css/buttons.dataTables.min.css') ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">

<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="<?= base_url(); ?>assets/font_awesome/css/all.min.css"/>
<link rel="stylesheet" href="<?= base_url('assets/clockpicker/jquery-clockpicker.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/jquery-confirm/jquery-confirm.min.css') ?>">
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css"/>
<link rel="stylesheet" href="<?= base_url() ?>assets/dropzone/dropzone.min.css">
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<style>
    /* ================= CARD ================= */

.trusmi-card{
    border-radius:14px;
    background:#fff;
    padding-top:6px;
}
/* ================= HEADER SPACE ================= */

    .budget-card-header{
        padding:20px 24px 14px 24px;
    }

/* HEADER FLEX */
.budget-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
}

/* LEFT AREA */
.budget-left{
    display:flex;
    align-items:flex-start;
    gap:14px;
}

/* TITLE */
.budget-left h6{
    margin-bottom:6px;
}

/* LEGEND */
.budget-legend{
    font-size:12px;
    color:#6c757d;
    margin-top:4px;
}

.budget-legend span{
    margin-right:22px;
}

/* FILTER RIGHT */
.budget-filter{
    display:flex;
    align-items:center;
    gap:12px;
    padding-top:4px;
}

/* FILTER STYLE */
.filter-select{
    min-width:150px;
    height:38px;
    border-radius:10px;
    border:1px solid #dee2e6;
    padding:6px 12px;
    font-size:13px;
    background:#fff;
    transition:.25s;
}

/* HOVER */
.filter-select:hover{
    border-color:#6a5cff;
}

/* FOCUS */
.filter-select:focus{
    outline:none;
    border-color:#6a5cff;
    box-shadow:0 0 0 3px rgba(106,92,255,.12);
}

.table-responsive{
    overflow-x:auto;
    padding:0 12px 14px 12px;
}
/* ================= LEGEND ================= */

.budget-legend{
    font-size:12px;
    color:#6c757d;
}

.budget-legend span{
    margin-right:18px;
}

.legend-dot{
    width:8px;
    height:8px;
    border-radius:50%;
    display:inline-block;
    margin-right:5px;
}

.legend-dot.red{background:#ef5350;}
.legend-dot.yellow{background:#ffb300;}
.legend-dot.green{background:#43a047;}

/* ==============================
   OVERBUDGET PROFESSIONAL CARD
============================== */

.overbudget-card{
    border-left:5px solid #dc3545;
    border-radius:12px;
    background:#fff;
    padding:18px;
    box-shadow:0 3px 10px rgba(0,0,0,.06);
    transition:.2s;
}

.overbudget-card:hover{
    transform:translateY(-2px);
}

.progress-sm{
    height:6px;
    border-radius:10px;
}

.cost-row{
    margin-bottom:10px;
}

.detail-scroll{
    max-height:260px;
    overflow-y:auto;
    padding-right:6px;
}

.detail-scroll::-webkit-scrollbar{
    width:6px;
}

.detail-scroll::-webkit-scrollbar-thumb{
    background:#ddd;
    border-radius:10px;
}

.progress-sm{
    height:6px;
    border-radius:10px;
}

.cost-row{
    margin-top:8px;
}

.detail-scroll{
    max-height:180px;
    overflow-y:auto;
}

.arrow{
    transition:.3s;
}

.arrow.rotate{
    transform:rotate(180deg);
}

/* ================= TABLE ================= */

.trusmi-table thead{
    background:linear-gradient(90deg,#6a5cff,#4f8cff);
    color:#fff;
}

.trusmi-table th{
    text-align:center;
    padding:14px;
    font-weight:600;
    border:none;
}

.trusmi-table td{
    text-align:center;
    padding:12px;
    vertical-align:middle;
}

.trusmi-table tbody tr:hover{
    background:#f8f9fa;
}

/* ================= ROW LINE ================= */

.trusmi-table tbody tr{
    border-bottom:1px solid #e9ecef;
}

.trusmi-table tbody tr:last-child{
    border-bottom:none;
}

.trusmi-table td,
.trusmi-table th{
    border-right:1px solid #f1f3f5;
}

.trusmi-table td:last-child,
.trusmi-table th:last-child{
    border-right:none;
}

.trusmi-table tbody tr:nth-child(even){
    background:#fafbfc;
}

/* ================= STATUS ================= */

.status-circle{
    width:14px;
    height:14px;
    border-radius:50%;
    display:inline-block;
}

/* HEADER FLEX */
.budget-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

/* LEFT */
.budget-left{
    display:flex;
    align-items:center;
    gap:12px;
}

/* FILTER RIGHT */
.budget-filter{
    display:flex;
    gap:10px;
}

/* FILTER STYLE */
.filter-select{
    min-width:140px;
    height:36px;
    border-radius:8px;
    border:1px solid #dee2e6;
    padding:4px 10px;
    font-size:13px;
    transition:all .2s ease;
}

.filter-select:hover{
    border-color:#5b6df6;
}

.filter-select:focus{
    outline:none;
    border-color:#5b6df6;
    box-shadow:0 0 0 2px rgba(91,109,246,.15);
}

.company-click{
    cursor:pointer;
    font-weight:600;
    color:#0d6efd;
}

.company-click:hover{
    text-decoration:underline;
}

/* ================= MODAL STYLE ================= */

.budget-modal{
    border-radius:14px;
    overflow:hidden;
}

.budget-modal-header{
    background:linear-gradient(90deg,#6a5cff,#4f8cff);
    color:#fff;
}

.budget-modal-header .btn-close{
    filter:invert(1);
}

/* TABLE DETAIL */
.budget-detail-table{
    border-radius:10px;
    overflow:hidden;
}

.budget-detail-table thead{
    background:#f4f6fb;
}

.budget-detail-table td{
    padding:10px;
    vertical-align:middle;
}

/* AMOUNT */
.amount-danger{
    color:#ef5350;
    font-weight:600;
}
/* ================= KPI DOT ================= */

.status-dot{
    width:18px;
    height:18px;
    border-radius:50%;
    display:inline-block;
}

/* OVER BUDGET */
.status-dot.danger{
    background:#ef5350;
}

/* WARNING */
.status-dot.warning{
    background:#ffb300;
}

/* AMAN */
.status-dot.success{
    background:#43a047;
}

.overbudget-card{
    background:#fff;
    border-left:4px solid #ef5350;
    border-radius:12px;
    padding:18px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.progress{
    height:6px;
    background:#eee;
}

.progress-bar{
    height:6px;
}

/* ================= MODAL FIX ================= */


.modal-body{
    max-height:70vh;
    overflow:auto;
}

/* aktifkan kembali modal
.dataTables_wrapper{
    position: static !important;
} */

/* ===============================
   MODAL BUDGET TABLE FIX
================================*/

#modal_detail_table{
    font-size:13px;
}

#modal_detail_table th{
    white-space:nowrap;
    text-align:center;
    vertical-align:middle;
    background:#f5f7fa;
}

#modal_detail_table td{
    vertical-align:middle;
    white-space:nowrap;
}

/* angka rata kanan */
#modal_detail_table td.text-end{
    font-variant-numeric: tabular-nums;
}

/* badge kecil */
#modal_detail_table .badge{
    font-size:11px;
    padding:4px 8px;
    border-radius:6px;
}

/* zebra lebih clean */
#modal_detail_table tbody tr:nth-child(even){
    background:#fafafa;
}

/* header sticky */
.dataTables_scrollHead{
    position:sticky;
    top:0;
}

/* modal lebih lega */
.budget-modal .modal-body{
    padding:20px;
}

/* ================= MODAL DETAIL BUDGET ================= */

#modal_detail_table{
    font-size:13px;
}

#modal_detail_table th{
    white-space:nowrap;
    text-align:center;
    vertical-align:middle;
}

#modal_detail_table td{
    white-space:nowrap;
    vertical-align:middle;
}

/* angka sejajar seperti Excel */
.money{
    font-variant-numeric: tabular-nums;
}

/* badge kecil */
#modal_detail_table .badge{
    font-size:11px;
    padding:4px 8px;
    border-radius:6px;
}

/* zebra clean */
#modal_detail_table tbody tr:nth-child(even){
    background:#fafafa;
}

/* modal premium */
.budget-modal{
    border-radius:14px;
    overflow:hidden;
}

.budget-modal-header{
    background:linear-gradient(135deg,#5b6cff,#3b82f6);
    color:#fff;
}

.dataTables_wrapper{
    position:static !important;
}

.table-responsive{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}
/* ================= MOBILE TABLE FIX ================= */
.modal-body .table-responsive{
    width:100%;
    overflow-x:auto;
}

.modal-body table{
    width:100% !important;
}
table.dataTable{
    width:100% !important;
}

.dataTables_wrapper{
    width:100%;
}

#modalDetailBudget .modal-body{
    overflow:hidden;
}

#modalDetailBudget .modal-body{
    overflow:hidden;
}

/* header dan body align */
.dataTables_scrollHeadInner,
.dataTables_scrollHeadInner table{
    width:100% !important;
}

/* scroll owner hanya datatable */
.dataTables_scrollBody{
    overflow:auto !important;
}

/* kolom tidak gepeng */
#modal_detail_table th,
#modal_detail_table td{
    white-space: nowrap;
}
.modal-budget-wide{
    max-width: 80% !important;   /* hampir full layar */
    width:80%;
}

@media(max-width:768px){

    .budget-header{
        flex-wrap:wrap;
        align-items:flex-start;
    }

    .budget-left{
        width:100%;
    }

    .budget-filter{
        width:100%;
        flex-wrap:wrap;
    }

    .filter-select{
        width:100%;
    }

}


</style>