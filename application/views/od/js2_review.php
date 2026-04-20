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
<!-- Datatable Buttons (core already loaded in main layout) -->
<script src="<?php echo base_url() ?>assets/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url() ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
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
    if(note.getData()== ''){
        note.setData( '<p>'+'- '+value+'</p>' );
        $(href).html("#note");
    }else{
        var old = note.getData();
        note.setData( '<p>'+old+'\n-'+value+'</p>' );
        $(href).html("#note");
    }
    

}

function hapus() {
    var note = CKEDITOR.instances['note'].setData('');
}

function submit_review() {
    var employee = $('[name="employee"]').val();
    var departement_name = $('[name="departement_name"]').val();
    var nama_dokumen = $('[name="nama_dokumen"]').val();
    var jabatan = $('[name="jabatan"]').val();
    var user_id = $('[name="user_id"]').val();
    var id_sop = $('[name="id_sop"]').val();
    var status = $('[name="status"]').val();
    var note = CKEDITOR.instances['note'].getData();
    var company = $('#company_id').val();
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
            send_notifikasi_review(nama_dokumen, departement_name, jabatan, status, note, employee,company)
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url() ?>review/insert',
                    type: 'POST',
                    data: {
                        user_id: user_id,
                        id_sop: id_sop,
                        status: status,
                        note: note,
                        tipe_menu: 1,
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