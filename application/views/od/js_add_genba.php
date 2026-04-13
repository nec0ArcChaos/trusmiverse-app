<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript">
    $(document).ready(function() {

        $('#pic').select2({ height: '100%' });
        $('#company_id').select2({ height: '100%' });
        $('#department_id').select2({ height: '100%' });
        $('#rekomendasi').select2({ height: '100%' });
        $('#masalah').select2({ height: '100%' });
        $('#id_dokumen').select2({ height: '100%' });
        $('#select_narasumber').select2({
            placeholder: '-- Pilih Narasumber --',
            allowClear: true
        });

        $('#tanggal').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });

        $('#company_id').change(function(e) {
            let id = $(this).val();
            $.ajax({
                url: '<?php echo base_url() ?>od_dokumen_genba/getDepartemen/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    set_dat = '<option value="" disabled selected>Select Departemen</option>';
                    for (i = 0; i < data.length; i++) {
                        set_dat += '<option value="' + data[i].department_id + '">' + data[i].department_name + '</option>';
                    }
                    $('#department_id').html(set_dat);
                }
            });
        });

        $('#department_id').change(function(e) {
            let id = $(this).val();
            $.ajax({
                url: '<?php echo base_url() ?>od_dokumen_genba/getNarasumber/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    set_dat = '';
                    for (i = 0; i < data.length; i++) {
                        set_dat += '<option value="' + data[i].user_id + '">' + data[i].nama + ' - ' + data[i].designation_name + '</option>';
                    }
                    $('#select_narasumber').html(set_dat);
                }
            });

            $.ajax({
                url: '<?php echo base_url() ?>od_dokumen_genba/getDokumen/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    set_dat = '<option value="" disabled selected>Select Dokumen</option>';
                    for (i = 0; i < data.length; i++) {
                        set_dat += '<option value="' + data[i].id_sop + '">' + data[i].nama_dokumen + '</option>';
                    }
                    $('#id_dokumen').html(set_dat);
                }
            });
        });

        $('#rekomendasi').change(function(e) {
            let isi = $(this).val();
            if (isi == "" || isi == null) {
                $('#other').prop('disabled', false);
            } else {
                $('#other').prop('disabled', true);
            }
        });
    });

    $('#submit').click(function(e) {
        e.preventDefault();

        const fields = [
            { element: $('#pic'), name: 'pic' },
            { element: $('#tanggal'), name: 'tanggal' },
            { element: $('#divisi'), name: 'divisi' },
            { element: $('#company_id'), name: 'company_id' },
            { element: $('#department_id'), name: 'department_id' },
            { element: $('#select_narasumber'), name: 'narasumber' },
            { element: $('#id_dokumen'), name: 'id_dokumen' },
            { element: $('#rekomendasi'), name: 'rekomendasi' },
            { element: $('#analisa'), name: 'analisa' },
            { element: $('#solusi'), name: 'solusi' },
            { element: $('#temuan'), name: 'temuan' },
            { element: $('#masalah'), name: 'masalah' },
            { element: $('#keluhan'), name: 'keluhan' },
            { element: $('#keinginan'), name: 'keinginan' },
            { element: $('#file'), name: 'file', type: 'file' },
            { element: $('#evaluasi'), name: 'evaluasi' }
        ];

        let isValid = true;

        fields.forEach((field) => {
            const value = field.element.val();
            if (field.type === 'file') {
                if (field.element[0].files.length === 0) {
                    field.element.addClass('is-invalid');
                    if (isValid) { field.element.focus(); isValid = false; }
                } else {
                    field.element.removeClass('is-invalid');
                }
            } else {
                if (value === null) {
                    field.element.addClass('is-invalid');
                    if (isValid) { field.element.focus(); isValid = false; }
                } else {
                    field.element.removeClass('is-invalid');
                }
            }
        });

        if (isValid) {
            $('#other').prop('disabled', false);
            var formdata = new FormData($('#form_add_genba')[0]);

            Swal.fire({
                title: "Simpan",
                text: "Simpan data genba?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Save!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?= base_url('od_dokumen_genba/simpanGenba') ?>`,
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (!response) {
                                Swal.fire({ title: "Error!", text: "Data gagal disimpan!", icon: "warning", showConfirmButton: false, timer: 2000 });
                            } else {
                                Swal.fire({ title: "Success!", text: "Data berhasil disimpan!", icon: "success", showConfirmButton: false, timer: 2000 });
                                $('#form_add_genba')[0].reset();
                                $('#pic, #company_id, #department_id, #rekomendasi, #masalah, #id_dokumen, #select_narasumber').val(null).trigger('change');
                                window.location.replace("<?= base_url('dokumen_genba') ?>");
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({ title: "Error!", text: "Terjadi kesalahan saat menyimpan data!", icon: "error", showConfirmButton: false, timer: 2000 });
                        }
                    });
                }
            });
        }
    });
</script>
