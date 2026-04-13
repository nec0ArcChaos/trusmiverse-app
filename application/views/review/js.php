<!-- third party js -->
<script src="<?= base_url() ?>assets/vendor/ckeditor/ckeditor.js"></script>
<!-- <script src="<?= base_url() ?>assets/vendor/ckeditor/plugin.js"></script> -->
<!-- third party js ends -->
<!-- source whatsapp api & pnotify -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/whatsapp_api.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.buttons.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/web_support.js"></script>
<!-- source whatsapp api & pnotify -->
<!-- Datatable -->
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url() ?>assets/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url() ?>https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/fancybox/jquery.fancybox.min.js"></script>

<script>
$(document).ready(function() {

    aktifkan_ckeditor();

});


function aktifkan_ckeditor() {
    let toolbar_ = [{
            "name": "basicstyles",
            "groups": ["basicstyles"]
        },
        {
            "name": "links",
            "groups": ["links"]
        },
        {
            "name": "paragraph",
            "groups": ["list"]
        },
        // {
        // 	"name": "document",
        // 	"groups": ["mode"]
        // },
        // {
        // 	"name": "insert",
        // 	"groups": ["insert"]
        // },
        {
            "name": "styles",
            "groups": ["styles"]
        }
    ];
    let editor_5 = CKEDITOR.instances['note'];

    if (editor_5) {
        editor_5.destroy(true);
    }
    editor_5 = CKEDITOR.replace('note', {
        height: '50%',
        toolbarGroups: toolbar_,
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });
}

function tandai(value) {
    var note = CKEDITOR.instances['note'];
    if (note.getData() == '') {
        note.setData('<p>' + '<b>- ' + value + '</b></p>');
    } else {
        var old = note.getData();
        note.setData('<p>' + old + '\n<b>- ' + value + '</b></p>');
    }


}

function hapus() {
    var note = CKEDITOR.instances['note'].setData('');
}

function bagikan() {
    swal({
        title: "Bagikan Ke PIC Terdaftar?",
        // text: "",
        type: "info",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No, cancel!",
    }).then((result) => {
        if (result.value) {
            
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });
}

function submit_review() {
    var user_id = $('[name="user_id"]').val();
    var no_dok = $('[name="no_dok"]').val();
    var employee = $('[name="employee"]').val();
    var departement_name = $('[name="departement_name"]').val();
    var no_jp = $('[name="no_jp"]').val();
    var jabatan = $('[name="jabatan"]').val();
    var status = $('[name="status"]').val();
    var company = $('#company_id').val();
    console.log(status);
    
    var note = CKEDITOR.instances['note'].getData();
    if (status == null || note == '') {
        swal({
            title: "Opps!!",
            text: "Harap di isi semua.",
            type: "info",
            // icon: "error",
            // showCancelButton: true,
            // // confirmButtonColor: "#DD6B55",
            // confirmButtonText: "Yes",
            // cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        })
    } else {

        swal({
            title: "Submit Review?",
            // text: "",
            type: "info",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel!",
        }).then((result) => {
            if (result.value) {
                send_notifikasi_review(no_dok, departement_name, jabatan, status, note, employee,company);
                $.ajax({
                    url: '<?php echo base_url() ?>review/insert',
                    type: 'POST',
                    data: {
                        user_id: user_id,
                        no_jp: no_jp,
                        status: status,
                        note: note,
                        tipe_menu: 2,
                    },
                    'dataType': 'JSON',
                    success: function(response) {
                        $('select[name="status"] option[disabled]:selected').val();
                        CKEDITOR.instances['note'].setData('');
                        $('#btn_submit').prop('disabled', true);
                        swal({
                            title: "Thanks a lot!!",
                            text: "Kami senang Anda meluangkan waktu untuk memberikan Review. Terima kasih.",
                            type: "info",

                        });


                    }
                });
                
            } else {
                // swal("Cancelled", "Your data is safe", "error");
            }
        });
    }
}
function send_notifikasi_review(no_dok, departement_name, jabatan, status, note, employee,company) {
    // strip_tags(substr(note,0, 20))
    if(status == 1){
        status = 'Waiting Review';
    }else if(status == 2){
        status = 'Sesuai';
    }else if(status == 3){
        status = 'Sudah Tidak Relevan';
    }else{
        status = 'Revisi';
    }
    tgl = '<?= date('Y-m-d') ?>';
    // link = '🔗 <?= base_url('/review/sop/') ?>'+no_dok+'/'+data_pic[0];
    data_review = ``;
    data_review +=
        `\n📑Nama Dokumen : *${no_dok}*\n🔑Departemen : *${departement_name}*\n👔Job Position : *${jabatan}*\n🔴Status : *${status}*\n\n`;

    msg =
        `📢 Alert!!! Review has been submitted.\n${data_review}\n\n👤Created By : ${employee}\n🕐Requested At : ${tgl}`;

    if(company == 5 || company == 4 || company == 1){//bt, fbt, holding
        list_phone = [
            '081223553352'//Rindiany Syafira
        ];
    }else{
        list_phone = [
            '089656108701'//Sandi Dwi Hermawan
        ];
    }

    // console.info(msg)

    //list phone it ke wa sendiri
    send_wa(list_phone, msg);
    // if (id_user != 1) {
    //     send_wa(list_phone, msg);
    // }



}
</script>