<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<!-- <script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script> -->
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<!-- ck editor -->
<script src="<?= base_url(); ?>assets/pages/ckeditor5-build-classic/ckeditor.js"></script>
<script src="<?= base_url(); ?>assets/pages/select2/select2.min.js"></script>

<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<script src="<?= base_url(); ?>assets/pages/font/CS-Line/csicons.min.js"></script>
<script src="<?= base_url(); ?>assets/pages/dropzone/dropzone.min.js"></script>
<script src="<?= base_url(); ?>assets/pages/dropzone/dropzone.templates.js"></script>



<script>
    var editor;
    Dropzone.autoDiscover = false;
	var dZUpload = "";
    
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#titlecalendar').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
        }

        $('.range').daterangepicker({
            startDate: start,
            endDate: end,
            "drops": "down",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);



        let toolbar_ = [
            {
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
            {
                "name": "document",
                "groups": ["mode"]
            },
            // {
            //     "name": "about",
            //     "groups": ["about"]
            // }
        ];

        // CKEDITOR START
        // message = CKEDITOR.instances['message'];
        // if (message) {
            //     message.destroy(true);
            // }
        // var config = {};
        // config.placeholder = 'some value'; 
        // config.height = '50%';
        // config.toolbarGroups = toolbar_;
        // config.removeButtons = 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord';
        // config.extraPlugins = 'emoji';
        // message = CKEDITOR.replace('message', config);
        // editor = CKEDITOR.instances.message;
        // CKEDITOR END

        editor = ClassicEditor
            .create( document.querySelector( '#message' ), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                toolbar: [ 'heading', '|', 'bold', 'italic','emoji'],
                removePlugins: [ 'Heading' ],
            })
            .then( newEditor => {
                editor = newEditor;
            })
            .catch( error => {
                console.error( error );
            } );


        // dropZone
        var dZUpload = $("#dropzoneServerFiles") && new Dropzone("#dropzoneServerFiles", {
		// dZUpload = new Dropzone("#dropzoneServerFiles", {

			url: "<?= base_url('trusmi_blast/upload_file') ?>", 
			maxFilesize: 200,
            maxFiles:1,
			thumbnailWidth: 160, 
            acceptedFiles: "image/*,application/pdf",
			previewTemplate: DropzoneTemplates.previewTemplate, 
			init: function () {
				this.on("success", (function (e, t) { 
					// console.log(`success: ${t}`)
					data = JSON.parse(t);
					// console.log(`data: ${data.data}`)
					id = data.data.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '-').replace(".","-").replace(/ /g,"");
					// uploaded_file = `<input type="hidden" name="file" id="attachment_preview" class="uploaded_file file_${id}" value="${data.data}" >
					// 				<input type="hidden" name="size" class="uploaded_file file_${id}" value="${data.size}" >
					// 				<input type="hidden" name="ext" class="uploaded_file file_${id}" value="${data.ext}" >
					// 				`;
					// $('#file_uploads').append(uploaded_file)
                    $('#attachment').val(data.data)
				}))
				// , this.on("addedfile", (e => { 
				// 	e.type 
				// 	&& !e.type.match(/image.*/) 
				// 	&& (e.documentPrev || 
				// 		(e.previewTemplate.classList.remove("dz-image-preview"), 
				// 			e.previewTemplate.classList.add("dz-file-preview"), 
				// 			e.previewTemplate.classList.add("dz-complete"), 
				// 			e.documentPrev = !0, this.emit("addedfile", e), 
				// 			this.removeFile(e)
				// 		)
				// 	) 
				// }))
			},
			// addRemoveLinks: true,
			removedfile: function(file) {
				// var name = file.name; 

                attachment = $('#attachment').val();
                
				$.ajax({
					url: '<?= base_url('trusmi_blast/remove_file') ?>',
					type: 'POST',
					dataType: 'json',
					data: {name: attachment,request: 2},
					sucess: function(response){
						console.info('success: ' + response);
					},
                    error: function(err){
                        error_alert(JSON.stringify(err));
                    }
				});
                $('#attachment').val('')
				// $(`#file_uploads`).empty();

				var _ref;
				return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
			}
		});
        // dropZone


        filter_blast();


    }); // END :: Ready Function

    function filter_blast(){
        start = $('#start').val();
        end = $('#end').val();
        dt_wa_blast(start, end) 
    }

    function dt_wa_blast(start, end) {
        $('#dt_wa_blast').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [5, 'desc'],
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>trusmi_blast/dt_wa_blast",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [
                // {
                //     "data": "id",
                //     "render" : function(data, type, row, meta){
                //         return (meta.row + 1)
                //     },
                // },
                {
                    "data": "title",
                },
                {
                    "data": "employees",
                },
                {
                    "data": "message",
                    "render" : function(data, type, row, meta){
                        return data        
                    }
                },
                {
                    "data": "attachment",
                    "render" : function(data, type, row, meta){
                        if(data != ''){
                            ext = data.split('.').pop();
                            url = `https://trusmiverse.com/apps/assets/whatsapp_blast/${data}`;
                            if(ext == 'pdf'){
                                return `<a href="${url}" target="_blank" title="Download PDF">
                                            <i class="bi bi-file-earmark-pdf" style="color: red; font-size:18pt"></i>
                                        </a>`
                            }else{
                                return `<a href="${url}" target="_blank" title="Lihat Attachment">
                                            <i class="bi bi-card-image text-success" style="font-size:18pt"></i>
                                        </a>`
                            }
                        }else{
                            return `-`
                        }
                        
                        
                    }
                },
                {
                    "data": "created_by",
                },
                {
                    "data": "created_at",
                },
                
            ],
        });
    }

    function send_wa_blast(){
        $('#title_blast').val("");
        get_send_to();
        editor.setData('');
        dropzone = Dropzone.forElement("#dropzoneServerFiles");
        dropzone.removeAllFiles();
        $('.dz-preview').remove();
		$('.dz-message').show();
        $('#attachment').val('')
        $('#modalAdd').modal('show');

    }

    function get_send_to() {
        array = [];
        item = `<option value="" disabled>Send to ...</option>`;
        $.ajax({
            'url': '<?= site_url('trusmi_blast/get_send_to') ?>',
            'type': 'GET',
            'dataType': 'json',
            'success': function(response) {
                $.each(response, function(index, value){
                    item += `<option value="${value.user_id}" data-contact="${value.contact_no}" data-username="${value.username}" data-employee_name="${value.employee_name}">${value.full_name}</option>`
                });
                $('#send_to').html(item);
            },
            'complete' : function(){
                setTimeout(() => { 
                    $("#send_to").select2({
                        placeholder: "Send to",
                        multiple: true,
                        dropdownParent: $("#modalAdd"),
                    });
                }, 500);
            }
        })
    }

    function pilih_karyawan(){
        karyawans = [];
        $('#send_to').find(':selected').each(function() {
            obj = {
                    user_id: $(this).val(),
                    contact: $(this).data('contact'),
                    employee_name: $(this).data('employee_name')
                };
            karyawans.push(obj);

        })
        // console.info(karyawans);
    }

    function submit_blast(){
        title_blast = $('#title_blast').val();
        karyawans = [];
        $('#send_to').find(':selected').each(function() {
            obj = {
                    user_id: $(this).val(),
                    contact: $(this).data('contact'),
                    employee_name: $(this).data('employee_name')
                };
            karyawans.push(obj);
        })
        message_input = editor.getData();

        if(title_blast == ''){
            $('#title_blast').focus()
        }else if(karyawans.length == 0){
            $('#send_to').select2('open');
        }else if(message_input == ''){
            editor.focus();
        }else{
            $("#modalAddConfirm").modal("show");
        }
    }

    function confirm_wa_blast(){

        title_blast = $('#title_blast').val();
        employees = [];
        contact = [];
        nama = [];
        messages = [];
        messages_converted = [];
        message_input = editor.getData();
        attachment = $('#attachment').val();
        ext = attachment.split('.').pop();
        // console.info(`attachment: ${attachment}`)
        // console.info(`ext: ${ext}`)
        $('#send_to').find(':selected').each(function() {

            employees.push($(this).val());
            contact.push($(this).data('contact'));
            nama.push($(this).data('employee_name'));
            messages.push(message_input);
        })

        $.ajax({
            url : '<?= base_url('trusmi_blast/save_wa_blast') ?>',
            type : 'POST',
            dataType : 'json',
            data : {
                title: title_blast,
                employees: employees,
                message: message_input,
                attachment: attachment,
            },
            beforeSend: function() {
                $('#btn_save_confirm').attr('disabled', true);
                $("#btn_save_confirm").html("Please wait...");
            },
            success : function(response){
                console.info(response)
                if (response.insert == true) {
                    
                    delimiter = "*";
                    $.each(nama, function(index, value){
                        messages_converted[index] = messages[index].replace('[NAMA]', value);
                        messages_converted[index] = messages_converted[index].replace(/<br>/g, '\n');
                        messages_converted[index] = messages_converted[index].replace(/&nbsp;/g, '\n');
                        messages_converted[index] = messages_converted[index].replace(/<\/p><p>/g, '\n');
                        messages_converted[index] = messages_converted[index].replace(/<\/?strong>/g,`*`);
                        messages_converted[index] = messages_converted[index].replace(/<\/?i>/g,`_`);
                        messages_converted[index] = messages_converted[index].replace(/<[^>]+>/g, '');
                        messages_converted[index] = messages_converted[index].replace(/\*_\*/g, '*_ *');
                        messages_converted[index] = messages_converted[index].replace(/(\*[^*]+)\s*(\*)/g, function(match, p1, p2) {
                            return p1.trim() + p2;
                        });
                        messages_converted[index] = messages_converted[index].replace(/(\_[^_]+)\s_(\_)/g, function(match, p1, p2) {
                            return p1.trim() + p2;
                        });
                        messages_converted[index] = messages_converted[index].replace(/\*(.*?)\*(?![_\s])/g, function(match, group) {
                            return '*' + group + '* ';
                        });
                        messages_converted[index] = messages_converted[index].replace(/_(.*?)_(?![_*\s])/g, function(match, group) {
                            return '_' + group + '_ ';
                        });

                        // messages_converted[index] = messages_converted[index].replace(RegExp(delimiter + "\\s+", "g"), delimiter);
                        // messages_converted[index] = messages_converted[index].replace(RegExp("\\s+" + delimiter, "g"), delimiter);
                        
                        if(attachment == ''){
                            send_wa_trusmi([contact[index]], messages_converted[index]);
                        }else{
                            if(ext == 'pdf'){
                                type = 'file';
                            }else{
                                type = 'image';
                            }
                            url = `https://trusmiverse.com/apps/assets/whatsapp_blast/${attachment}`;
                            send_wa_file_trusmi([contact[index]], type, url, attachment, messages_converted[index]);
                        }
                        
                        console.info(messages[index]);
                        console.info(messages_converted[index]);
                    })
                    
                } else {
                    error_alert('Unrecognized Error');
                }
                
                // $("#modalAdd").modal("hide");
                // $("#modalAddConfirm").modal("hide");
            },
            error : function(err){
                console.info(err)
            },
            complete: function() {
                $('#btn_save_confirm').attr('disabled', false);
                $("#btn_save_confirm").html("Yes, Save");
                filter_blast();
            },
        })

    }

    // NOTIFY
    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 1500,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }
</script>