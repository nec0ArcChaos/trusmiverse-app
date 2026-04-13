<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<script>
<?php if ($data->created_at < '2025-04-23') { ?>
    // addnew
    $(document).ready(function() {
        get_divisi();
        get_jabatan();
    });

    function get_divisi() {
        divisi = `<option data-placeholder="true"></option>`;
        $.ajax({
            url: "<?php echo base_url() ?>trusmi_approval_ade/get_divisi",
            dataType: "JSON",
            type: "POST",
            success: function(res) {
                for (i = 0; i < res.divisi.length; i++) {
                divisi += `<option value="` + res.divisi[i].id_divisi + `">` + res.divisi[i].divisi + `</option>`
                }
                $('#divisi').empty();
                $('#divisi').append(divisi);
                new SlimSelect({
                    select: '#divisi',
                    settings: {
                        placeholderText: 'Divisi ?',
                    }
                })
            }
        })
    }

    function get_jabatan() {
        jabatan = `<option data-placeholder="true"></option>`;
        $.ajax({
        url: "<?php echo base_url() ?>trusmi_approval_ade/get_jabatan",
        type: "POST",
        dataType: "JSON",
        success: function(res) {
            for (i = 0; i < res.jabatan.length; i++) {
            jabatan += `<option value="` + res.jabatan[i].role_id + `">` + res.jabatan[i].role_name + `</option>`
            }
            $('#jabatan').empty();
            $('#jabatan').append(jabatan);
            new SlimSelect({
                select: '#jabatan',
                settings: {
                    placeholderText: 'Jabatan ?',
                }
            })
        }
        })
    }

    $('#jabatan').on('change', function() {
        jabatan = $("#jabatan").val().toString().split(",");
        $('#jabatan_hidden').val(jabatan);
        console.log($('#jabatan_hidden').val());
    })
    $('#divisi').on('change', function() {
        divisi = $("#divisi").val().toString().split(",");
        $('#divisi_hidden').val(divisi);
        console.log($('#divisi_hidden').val());
    })

    function simpan_memo() {
        console.log('simpan memo..');
        let form_data = new FormData();

        no_app = $('#no_app').val();
        user_id = $('#user_id').val();
        tipe_memo = $('#tipe_memo').val();
        note = $('#note').val();
        file_1 = $('#file_1').val();
        divisi = $('#divisi').val();
        jabatan = $('#jabatan').val();
        divisi_hidden = $('#divisi_hidden').val();
        jabatan_hidden = $('#jabatan_hidden').val();
        form_data.append("file_1", file_1);
        form_data.append("tipe_memo", tipe_memo);
        form_data.append("note", note);
        form_data.append("divisi", divisi_hidden);
        form_data.append("jabatan", jabatan_hidden);

        form_data.append("no_app", no_app);
        form_data.append("user_id", user_id);

        if (tipe_memo == '#') {
            new PNotify({
                title: `Oopss`,
                text: `Harap memilih tipe memo`,
                icon: 'icofont icofont-info-circle',
                type: 'error',
                delay: 1500,
            });
            $('#tipe_memo').focus();
        } else if (note == '') {
            new PNotify({
                title: `Oopss`,
                text: `Anda belum mengisi Note`,
                icon: 'icofont icofont-info-circle',
                type: 'error',
                delay: 1500,
            });
            $('#note').focus();
        }
        //  else if (file_memo == '') {
        //     new PNotify({
        //         title: `Oopss`,
        //         text: `Harap mengupload file memo`,
        //         icon: 'icofont icofont-info-circle',
        //         type: 'error',
        //         delay: 1500,
        //     });
        //     $('#subject').focus();
        // }
         else if (divisi == '') {
            // swal('Warning!', 'Harap memilih divisi', 'error');
            new PNotify({
                title: `Oopss`,
                text: `Harap memilih divisi`,
                icon: 'icofont icofont-info-circle',
                type: 'error',
                delay: 1500,
            });
            $('#subject').focus();
        } else if (jabatan == '') {
            // swal('Warning!', 'Harap memilih jabatan', 'error');
            new PNotify({
                title: `Oopss`,
                text: `Harap memilih jabatan`,
                icon: 'icofont icofont-info-circle',
                type: 'error',
                delay: 1500,
            });
            $('#subject').focus();
        } else {
            $('#btn_simpan_memo').prop('disabled', true);
            $.ajax({
                // 'url': "<?php //echo base_url('trusmi_approval_ade/simpan_memo') ?>",
                'url': "https://trusmicorp.com/rspproject/memo_api/simpan_memo",
                'type': "POST",
                'data': form_data,
                'dataType': "JSON",
                'processData': false, // Prevent jQuery from processing the data
                'contentType': false, // Prevent jQuery from setting the content type
                // 'beforeSend': function() {
                //     $('#spinner').modal('show');
                //     $("#btn_simpan_memo").attr("disabled", true);
                // },
                'success': function(response) {
                    console.log(response);
                    new PNotify({
                        title: `Success`,
                        text: `Memo Saved`,
                        icon: 'icofont icofont-check',
                        type: 'success',
                        delay: 1500,
                    }); 
                    window.location.href = "<?= base_url('trusmi_approval_ade') ?>";
                    $('#btn_simpan_memo').prop('disabled', false);
                    // $('#spinner').modal('hide');
                    // $('#modal_input_memo').modal('hide');
                    // $("#btn_simpan_memo").removeAttr("disabled");
                    // $('#list_memo').DataTable().ajax.reload();
                    // swal('Success!', 'Berhasil menambah memo', 'success');
                }
            })
        }
    }

    test_ajax();
    function test_ajax() {
        $.ajax({
            'url': "<?= base_url('trusmi_approval_ade/data_test') ?>",
            'type': "POST",
            'data': {
                'nama': 'Ade'
            },
            'dataType': "JSON",
            // 'processData': false, // Prevent jQuery from processing the data
            // 'contentType': false, // Prevent jQuery from setting the content type
            // 'beforeSend': function() {
            //     $('#spinner').modal('show');
            //     $("#btn_simpan_memo").attr("disabled", true);
            // },
            'success': function(response) {
                console.log(response);
            }
        })
    }

    test_ajax2();
    function test_ajax2() {
        $.ajax({
            'url': "https://trusmicorp.com/rspproject/memo_api/index",
            'type': "GET",
            'dataType': "JSON",
            'success': function(response) {
                console.log(response);
            }
        })
    }

<?php } else { ?>

    $(document).ready(function() {
        initType = new SlimSelect({
            select: "#tipe_memo"
        });

        initCompany = new SlimSelect({
            select: "#company_id"
        });

        initRole = new SlimSelect({
            select: "#role_id"
        });

        initDepartment = new SlimSelect({
            select: "#department_id"
        });

        // initType.setSelected('#');
        // $('#tipe_memo').val('#');
        initCompany.setSelected('');
        $('#company_id').val('');
        initDepartment.setSelected('');
        $('#department_id').val('');
        initRole.setSelected('');
        $('#role_id').val('');
    }); 

    function get_department() {
        company_id = $('#company_id').val();
        if (company_id != null && company_id != '#' && company_id.length != 0) {
            $.ajax({
            url: "<?= base_url('memo/get_department') ?>",
            method: "POST",
            data: {
                company_id: company_id
            },
            dataType: "JSON",
            beforeSend: function(){
                initDepartment.destroy()
            },
            success: function(res) {
                var data = res.department 
                var selectOption = ``;
                $.each(data, function(i, val){
                    selectOption += `<option value="${val.department_id}">${val.department_name}</option>`
                })
                $('#department_id').html(selectOption)

                
                initDepartment = new SlimSelect({
                    select: "#department_id"
                });
            }
            })
        } else {
            initDepartment.destroy()
            $('#department_id').html('')
        }
    }

    function simpan_memo() {
        let form_data = new FormData();
        tipe_memo = $('#tipe_memo').val();
        note = $('#note').val();
        file_memo = $('#file_memo').val();
        company_id = $('#company_id').val();
        department_id = $("#department_id").val().toString().split(",");
        role_id = $("#role_id").val().toString().split(",");
        no_app = $('#no_app').val();
        user_id = $('#user_id').val();
        file_1 = $('#file_1').val();
        form_data.append("tipe_memo", tipe_memo);
        form_data.append("note", note);
        form_data.append("company_id", company_id);
        form_data.append("department_id", department_id);
        form_data.append("role_id", role_id);

        form_data.append("file_1", file_1);

        form_data.append("no_app", no_app);
        form_data.append("user_id", user_id);

        if (tipe_memo == null) {
        swal('Warning!', 'Harap memilih tipe memo', 'error');
        } else if (note == '') {
        swal('Warning!', 'Harap mengisi note', 'error');
        }  else if (company_id == '') {
        swal('Warning!', 'Harap memilih Company', 'error');
        } else if (department_id == '') {
        swal('Warning!', 'Harap memilih Department', 'error');
        } else if (role_id == '') {
        swal('Warning!', 'Harap memilih Role/Jabatan', 'error');
        } else {
        swal({
            title: "Simpan Memo?",
            icon: "info",
            buttons: true,
            dangerMode: false,
            })
            .then((simpan) => {
            if (simpan) {
                $.ajax({
                'url': "<?= base_url('memo/simpan_memo_approval') ?>",
                'type': "POST",
                'data': form_data,
                'dataType': "JSON",
                'processData': false, // Prevent jQuery from processing the data
                'contentType': false, // Prevent jQuery from setting the content type
                'beforeSend': function() {

                },
                'success': function(response) {
                    console.log(response);
                    if (response.insert_memo) {
                        swal('Success!', 'Berhasil menambah memo', 'success');
                        setTimeout(() => {
                            window.location.href = "<?= base_url('trusmi_approval') ?>";
                        }, 500);
                    } else {
                        swal('Warning!', 'Gagal menambah memo ', 'error');
                    }
                }
                })
            }
            });
        }
    }

<?php } ?>
    function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

                extension = 'png,';

                imgElement.onload = function(e) {
                    const canvas = document.createElement("canvas");

                    if (e.target.width > e.target.height) {
                        const MAX_WIDTH = 1024;
                        const scaleSize = MAX_WIDTH / e.target.width;
                        canvas.width = MAX_WIDTH;
                        canvas.height = e.target.height * scaleSize;
                    } else {
                        const MAX_HEIGHT = 1024;
                        const scaleSize = MAX_HEIGHT / e.target.height;
                        canvas.height = MAX_HEIGHT;
                        canvas.width = e.target.width * scaleSize;
                    }

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                    var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
                    // document.querySelector(string).value = g_string;
                    saveFile(g_string, wait, done, string, submit);
                }
            } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                // document.querySelector(string).value = g_string;
                saveFile(g_string, wait, done, string, submit);
            }


        }

        function saveFile(string, wait, done, str, submit) {

            $.ajax({
                'url': '<?php echo base_url() ?>trusmi_approval/upload_file',
                'type': 'POST',
                'data': {
                    string: string
                },
                'success': function(response) {
                    document.querySelector(str).value = response;
                    $(submit).prop('disabled', false);
                    $(wait).hide();
                    $(done).show();
                }
            });
        }
    }
</script>