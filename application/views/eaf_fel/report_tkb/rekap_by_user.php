<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/bootstrap-datepicker.css" />
<!-- Date-time picker css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/pages/advance-elements/css/bootstrap-datetimepicker.css">


<style type="text/css">
    .lb-prev {
        display: none;
    }

    .lb-next {
        display: none;
    }

    .lb-details {
        display: none;
    }

    .fancybox-infobar {
        display: none;
    }

    .fancybox-toolbar {
        display: none;
    }

    .fancybox-navigation {
        display: none;
    }

    #fancybox-wrap {
        z-index: 1000000000;
    }
</style>

<!-- Spinner -->
<div class="modal fade bd-example-modal-lg" id="spinner" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
<!-- End Spinner -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title" style="font-size: 12pt;"><strong><?php echo $pageTitle ?></strong></h4>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-4">
                            <form method="POST" id="form_filter">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 input-group date" id="datetimepicker9">
                                            <input type="text" class="form-control" value="" name="periode" id="periode" placeholder="<?= date('Y') ?>-<?= date('m') ?>">
                                            <input type="hidden" name="period" id="period" value="" />
                                            <button type="button" class="btn btn-info btn-outline-info" id="filter_period">
                                                <span class="">Filter</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-sm-5"></div>
						<div class="col-sm-3"></div> -->
                    </div>

                    <input type="hidden" id="month" value="">
                    <!-- <input type="hidden" id="id_user" value="<?php echo $this->session->userdata('id_user'); ?>"> -->

                    <div class="dt-responsive table-responsive">
                        <table id="dt_rb_user" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Biaya</th>
                                    <th>Minggu ke</th>
                                    <th>Budget Awal</th>
                                    <th>Total Penambahan</th>
                                    <th>Cash Out</th>
                                    <th>Sudah LPJ</th>
                                    <th>Belum LPJ</th>
                                    <th>Reimburse</th>
                                    <th>Sisa Budget</th>
                                    <th>Over Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center" colspan="3" style="font-size: 14px;">TOTAL : </th>
                                    <th class="text-right" id="total_budget"></th>
                                    <th class="text-right" id="total_penambahan"></th>
                                    <th class="text-right" id="total_pengeluaran"></th>
                                    <th class="text-right" id="total_sudah_lpj"></th>
                                    <th class="text-right" id="total_belum_lpj"></th>
                                    <th class="text-right" id="total_reimburse"></th>
                                    <th class="text-right" id="total_sisa_budget"></th>
                                    <th class="text-right" id="total_over_budget"></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal detail budget -->
<div class="modal fade" id="modal_detail_budget" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Budget</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered" id="dt_detail_budget">
                        <thead>
                            <tr>
                                <th>Id Pengajuan</th>
                                <th>User</th>
                                <th>Tanggal Input</th>
                                <th>Tanggal Approve</th>
                                <th>Penerima</th>
                                <th>Kategori</th>
                                <th>Type</th>
                                <th>Pengajuan</th>
                                <th>Keperluan</th>
                                <th>Budget</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Status LPJ</th>
                                <th>Tanggal LPJ</th>
                                <th>Nominal LPJ</th>
                                <th>Deviasi</th>
                                <th>Cash Out</th>
                                <th>Actual Budget</th>
                                <th>Status Approve</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="7" style="font-size: 14px;">TOTAL : </th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #eee7e7;">
                <button class="btn btn-default" style="margin-right: 30px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Detail budget-->

<!-- js nominal -->
<!-- <script type="text/javascript">
		function nominal(angka, id) {
			$(id).val(formatRupiah(angka, ''));
		}

		function formatRupiah(angka, prefix) {
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split = number_string.split(','),
				sisa = split[0].length % 3,
				rupiah = split[0].substr(0, sisa),
				ribuan = split[0].substr(sisa).match(/\d{3}/gi);
			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
		}
	</script> -->

<!-- Add Detail Penambahan by Ade -->
<div class="modal fade" id="modal_detail_penambahan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg center" role="document" style="max-width: 95%;position:relative;top:0;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Penambahan <p id="text_nama_biaya"></p>
                </h4>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>

            <div class="modal-body" style="max-height: calc(100vh - 230px);overflow-y: auto;">
                <input type="hidden" name="id_biaya_tam" class="form-control" id="id_biaya_tam" readonly>
                <input type="hidden" name="id_minggu_tam" class="form-control" id="minggu_tam" readonly>
                <input type="hidden" name="id_bulan_tam" class="form-control" id="bulan_tam" readonly>
                <input type="hidden" name="tahun_tam" class="form-control" id="tahun_tam" readonly>
                <input type="hidden" name="nama_biaya_tam" id="nama_biaya_tam"><br>
                <!-- <a href="javascript:void(0)" class="btn btn-info" id="list_tambah">Add Budget Penambahan</a><br><br> -->
                <div class="table-responsive dt-responsive">
                    <table id="dt_list_penambahan" class="table table-striped nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>Nominal Tambah</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Update at</th>
                                <th>Update by</th>
                                <th>Note</th>
                                <th>Attachment BA</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Detail penambahan -->