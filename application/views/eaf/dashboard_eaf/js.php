<script>

let modalBudget;
let tableBudget;
let tableDetail; // ⭐ DataTable modal (GLOBAL)

/* =====================================================
   INIT
===================================================== */
$(document).ready(function(){

    const modalEl = document.getElementById('modalDetailBudget');

    modalBudget = new bootstrap.Modal(modalEl,{
        backdrop:'static',
        keyboard:true
    });

    /* ===============================
       TABLE OVERVIEW
    =============================== */

    if($.fn.DataTable.isDataTable('#table_budget_overview')){
        tableBudget = $('#table_budget_overview').DataTable();
        tableBudget.ajax.reload();
    }
    else{

        tableBudget = $('#table_budget_overview').DataTable({
            processing:true,
            paging:true,
            searching:true,
            info:true,
            ordering:false,
            responsive:true,

            ajax:{
                url:"<?= base_url('eaf/dashboard_eaf/get_budget_overview')?>",
                type:"POST",
                data:function(d){
                    d.bulan=$('#bulan').val();
                    d.tahun=$('#tahun').val();
                },
                dataSrc:function(json){

                    const priority={
                        danger:1,
                        warning:2,
                        success:3
                    };

                    json.data.sort(
                        (a,b)=>priority[a.status_color]-priority[b.status_color]
                    );

                    renderOverBudget(json.data);

                    return json.data;
                }
            },

            columns:[
                {
                    data:'company_kode',
                    className:'text-start',
                    render:d=>`
                        <span 
                            class="company-click text-primary fw-bold d-block"
                            style="cursor:pointer;text-align:justify;">
                            ${d}
                        </span>
                    `
                },
                {data:'budget_ytd',className:'text-end',render:d=>'Rp '+d},
                {data:'budget_mtd',className:'text-end',render:d=>'Rp '+d},
                {data:'actual_store',className:'text-end',render:d=>'Rp '+d},
                {
                    data:'persen_mtd',
                    className:'text-end',
                    render:function(data,type,row){

                        let color='text-success fw-bold';

                        if(row.status_color==='danger') color='text-danger fw-bold';
                        else if(row.status_color==='warning') color='text-warning fw-bold';

                        return `<span class="${color}">${data}%</span>`;
                    }
                },
                {data:'alert',className:'text-center'},
                {data:'sisa_budget',className:'text-end',render:d=>'Rp '+d}
            ]
        });

    }

    /* FILTER */
    $('#bulan,#tahun').on('change',()=>{
        tableBudget.ajax.reload();
    });

    /* CLICK ROW */
    $('#table_budget_overview tbody').on(
        'click',
        '.company-click',
        function(){

            let row=tableBudget.row($(this).closest('tr')).data();

            if(row){
                $('#modal_company').text(row.company_kode);
                loadModalDetail(row.company_kode);
            }
        }
    );

});


/* =====================================================
   LOAD DETAIL MODAL
===================================================== */
function loadModalDetail(company_kode){

    modalBudget.show();

    $('#modal_detail_content').html(`
        <div class="text-center p-5">
            <div class="spinner-border text-primary"></div>
            <div class="mt-2">Memuat detail data...</div>
        </div>
    `);

    $.ajax({
        url:"<?= base_url('eaf/dashboard_eaf/get_detail_company')?>",
        type:'POST',
        data:{company_kode},
        dataType:'json',

        success:function(res){
            renderModalDetail(res.data);
        },

        error:function(){
            modalBudget.hide();
            alert('Gagal memuat detail data');
        }
    });
}


/* =====================================================
   RENDER TABLE MODAL
===================================================== */
function renderModalDetail(data){

    let html=`
    <table id="modal_detail_table"
        class="table table-hover table-bordered align-middle nowrap w-100">

        <thead class="table-light">
        <tr>
            <th>Jenis Biaya</th>
            <th>User</th>
            <th class="text-end">Budget Awal</th>
            <th class="text-end">Penambahan</th>
            <th class="text-end">Cash Out</th>
            <th class="text-end">Actual</th>
            <th class="text-end">%</th>
            <th class="text-end">Sudah LPJ</th>
            <th class="text-end">Belum LPJ</th>
            <th class="text-end">Reimburse</th>
            <th class="text-end">Sisa</th>
            <th class="text-end">Over</th>
        </tr>
        </thead>
        <tbody>
    `;

    if(data?.length){

        data.forEach(b=>{

            html+=`
            <tr>
                <td><span class="badge bg-primary">${b.nama_biaya||'-'}</span></td>
                <td>${b.employee_name||'-'}</td>
                <td class="text-end">${Number(b.budget_awal||0).toLocaleString('id-ID')}</td>
                <td class="text-end">${Number(b.nominal_tambah||0).toLocaleString('id-ID')}</td>
                <td class="text-end text-danger">${Number(b.cash_out||0).toLocaleString('id-ID')}</td>
                <td class="text-end fw-bold">${Number(b.actual_budget||0).toLocaleString('id-ID')}</td>
                <td class="text-end">${b.persen||0}%</td>

                <td class="text-end">${Number(b.sudah_lpj||0).toLocaleString('id-ID')}</td>
                <td class="text-end">${Number(b.belum_lpj||0).toLocaleString('id-ID')}</td>
                <td class="text-end">${Number(b.rembers||0).toLocaleString('id-ID')}</td>
                <td class="text-end">${Number(b.sisa||0).toLocaleString('id-ID')}</td>

                <td class="text-end text-danger fw-bold">
                    ${Number(b.total_over_budget||0).toLocaleString('id-ID')}
                </td>
            </tr>`;
        });

    }else{
        html+=`<tr><td colspan="13" class="text-center">Tidak ada data</td></tr>`;
    }

    html+=`</tbody></table>`;

    $('#modal_detail_content').html(html);


    /* ===============================
       INIT DATATABLE MODAL
    =============================== */

    if(tableDetail){
        tableDetail.destroy();
    }

    tableDetail=$('#modal_detail_table').DataTable({
        scrollY:"55vh",
        scrollX:true,
        scrollCollapse:true,

        autoWidth:true, // ⭐ FIX UTAMA
        responsive:true,

        info:true,
        pageLength:10,
        lengthChange:false
    });

}


/* =====================================================
   FIX WIDTH SAAT MODAL MUNCUL
===================================================== */
$('#modalDetailBudget').on('shown.bs.modal',function(){

    if(tableDetail){
        tableDetail.columns.adjust().draw();
    }

});

/* =====================================================
   OVER BUDGET RENDER (punyamu tetap)
===================================================== */
function renderOverBudget(data){

    let html='';

    let dangerData=data.filter(d=>d.status_color==='danger');

    if(!dangerData.length){
        $('#overbudget_container').html('');
        return;
    }

    html+=`
    <div class="card shadow-sm border-0">
    <div class="card-body">
    <h6 class="text-danger fw-bold mb-4">
        🔺 BREAKDOWN BIAYA - OVER BUDGET
    </h6>
    <div class="row">`;

    dangerData.forEach((item,index)=>{

        let budgetMTD=parseInt(item.budget_mtd.replace(/,/g,''))||0;
        let actual=parseInt(item.actual_store.replace(/,/g,''))||0;
        let overBudget=actual-budgetMTD;

        // ✅ skip jika tidak over
        if(actual===0 || overBudget<=0) return;

        html+=`
        <div class="col-lg-4 col-md-6 mb-4">
        <div class="overbudget-card">

            <div class="d-flex justify-content-between mb-3">
                <b>${item.company_kode}</b>
                <span class="badge bg-danger">
                    OVER ${item.persen_mtd}%
                </span>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <small>Budget MTD</small>
                    <div><b>Rp ${item.budget_mtd}</b></div>
                </div>

                <div class="col-6 text-danger">
                    <small>Actual</small>
                    <div><b>Rp ${item.actual_store}</b></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6 text-danger">
                    <small>Over Budget</small>
                    <div>
                        <b>+ Rp ${overBudget.toLocaleString('id-ID')}</b>
                    </div>
                </div>

                <div class="col-6">
                    <small>Sisa YTD</small>
                    <div><b>Rp ${item.sisa_budget}</b></div>
                </div>
            </div>
        `;

        /* ===== PROFESSIONAL BREAKDOWN ===== */
        html += renderDetailBiaya(item, actual, index);

        html+=`</div></div>`;
    });

    html+=`</div></div></div>`;

    $('#overbudget_container').html(html);

    $('#overbudget_container .collapse').each(function(){
        new bootstrap.Collapse(this,{
            toggle:false
        });
    });
}

function renderDetailBiaya(item, actual, index){

    if(!item.detail_biaya) return '';

    let biaya = item.detail_biaya
        .map(b=>({
            nama:b.nama_biaya,
            nilai:Number(
                String(b.actual_biaya).replace(/[^\d.-]/g,'')
            )||0
        }))
        .filter(b=>b.nilai>0);

    if(!biaya.length) return '';

    biaya.sort((a,b)=>b.nilai-a.nilai);

    let top5     = biaya.slice(0,5);
    let sisaData = biaya.slice(5);

    let totalValid = biaya.length;
    let collapseId = `detail_${index}`;

    let html=`
    <div class="mt-3">
        <small class="fw-bold text-danger">
            🔥 Breakdown Biaya
        </small>
    `;

    /* TOP DRIVER */
    top5.forEach((b,i)=>{

        let percent = actual>0 ? (b.nilai/actual)*100 : 0;

        html+=`
        <div class="cost-row">
            <div class="d-flex justify-content-between">
                <span>${i+1}. ${b.nama}</span>
                <b>Rp ${b.nilai.toLocaleString('id-ID')}</b>
            </div>

            <div class="progress progress-sm">
                <div class="progress-bar bg-danger"
                     style="width:${percent}%"></div>
            </div>
        </div>`;
    });

    if(sisaData.length){

        html+=`
        <div class="text-center mt-2">

            <button
                class="btn btn-sm btn-light w-100 toggle-breakdown"
                data-target="#${collapseId}"
                data-total="(${totalValid} biaya)">

                Show Full Breakdown (${totalValid} biaya)
            </button>

        </div>

        <div class="collapse mt-3 budget-collapse" id="${collapseId}">
            <div class="detail-scroll">`;

        sisaData.forEach(b=>{
            html+=`
            <div class="d-flex justify-content-between small mb-1">
                <span>${b.nama}</span>
                <span class="text-danger">
                    Rp ${b.nilai.toLocaleString('id-ID')}
                </span>
            </div>`;
        });

        html+=`
            </div>
        </div>`;
    }

    html+=`</div>`;

    return html;
}

$(document).on('click','.toggle-breakdown',function(){

    const btn=$(this);
    const target=btn.data('target');

    $(target).collapse('toggle');
});

$(document).on('shown.bs.collapse','.budget-collapse',function(){

    const btn=$(this)
        .prev()
        .find('.toggle-breakdown');

    btn.text('Hide Breakdown');
});

$(document).on('hidden.bs.collapse','.budget-collapse',function(){

    const btn=$(this)
        .prev()
        .find('.toggle-breakdown');

    btn.text(
        'Show Full Breakdown '+
        (btn.data('total')||'')
    );
});

// function renderDetailBiaya(item, actual, index){

//     if(!item.detail_biaya) return '';

//     /* =========================
//        AMBIL BIAYA VALID
//     ==========================*/
//     let biaya = item.detail_biaya
//         .map(b=>({
//             nama: b.nama_biaya,
//             nilai:Number(
//                 String(b.actual_biaya)
//                     .replace(/[^\d.-]/g,'')
//             )||0
//         }))
//         .filter(b=>b.nilai>0);

//     if(!biaya.length) return '';

//     /* =========================
//        SORT TERBESAR
//     ==========================*/
//     biaya.sort((a,b)=>b.nilai-a.nilai);

//     let top5     = biaya.slice(0,5);
//     let sisaData = biaya.slice(5);

//     let totalValid = biaya.length;
//     let totalSisa  = sisaData.length;

//     /* ✅ UNIQUE COLLAPSE ID */
//     let collapseId = `detail_${index}`;

//     let html=`
//     <div class="mt-3">
//         <small class="fw-bold text-danger">
//             🔥 Breakdown Biaya
//         </small>
//     `;

//     /* ================= TOP DRIVER ================= */
//     top5.forEach((b,i)=>{

//         let percent = actual>0 ? (b.nilai/actual)*100 : 0;

//         html+=`
//         <div class="cost-row">
//             <div class="d-flex justify-content-between">
//                 <span>${i+1}. ${b.nama}</span>
//                 <b>Rp ${b.nilai.toLocaleString('id-ID')}</b>
//             </div>

//             <div class="progress progress-sm">
//                 <div class="progress-bar bg-danger"
//                      style="width:${percent}%"></div>
//             </div>
//         </div>`;
//     });

//     /* ================= BREAKDOWN ================= */
//     if(totalSisa>0){

//         html+=`
//         <div class="text-center mt-2">

//             <button class="btn btn-sm btn-light w-100 toggle-breakdown" data-total="(${totalValid} biaya)"
//                 data-bs-toggle="collapse"
//                 data-bs-target="#${collapseId}"
//                 aria-expanded="false">

//                 Show Full Breakdown (${totalValid} biaya)
//             </button>

//         </div>

//         <div class="collapse mt-3 budget-collapse" id="${collapseId}">
//             <div class="detail-scroll">`;

//         sisaData.forEach(b=>{
//             html+=`
//             <div class="d-flex justify-content-between small mb-1">
//                 <span>${b.nama}</span>
//                 <span class="text-danger">
//                     Rp ${b.nilai.toLocaleString('id-ID')}
//                 </span>
//             </div>`;
//         });

//         html+=`
//             </div>
//         </div>`;
//     }
//     else{

//         html+=`
//         <div class="text-center mt-2">
//             <small class="text-muted">
//                 ✔ Semua biaya utama sudah ditampilkan (${totalValid} biaya)
//             </small>
//         </div>`;
//     }

//     html+=`</div>`;

//     return html;
// }
// /* =====================================
//    COLLAPSE BUTTON SYNC (FINAL)
// ===================================== */
// /* ================= SHOW ================= */
// $(document).on('shown.bs.collapse','.budget-collapse',function(){

//     const collapseId = this.id;

//     const btn = $('.toggle-breakdown[data-bs-target="#'+collapseId+'"]');

//     btn.text('Hide Breakdown');
// });


// /* ================= HIDE ================= */
// $(document).on('hidden.bs.collapse','.budget-collapse',function(){

//     const collapseId = this.id;

//     const btn = $('.toggle-breakdown[data-bs-target="#'+collapseId+'"]');

//     btn.text(
//         'Show Full Breakdown ' +
//         (btn.attr('data-total') || '')
//     );
// });

</script>