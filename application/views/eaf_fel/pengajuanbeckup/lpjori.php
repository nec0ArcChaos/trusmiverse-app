<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.css" />

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
						
					</div>

					<div class="dt-responsive table-responsive">
						<table id="dt_list_lpj" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>No Pengajuan</th>
									<th>Nama Penerima</th>
									<th>Divisi</th>
									<th>Nama Biaya</th>
									<th>Keterangan</th>
									<th>Admin</th>
									<th>Status <i class="icon-info" data-toggle="tooltip" title="" data-original-title="Lock LPJ : DLK > 24 Jam, Other > 48 Jam"></i></th>
									<th>Tanggal Input</th>
									<th>Leadtime</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_detail_lpj" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Pengajuan EAF</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="detail_lpj"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="save_lpj">Save</button>
			</div>
		</div>
	</div>
</div>

<!-- js upload foto -->
<script type="text/javascript">
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
						const MAX_WIDTH = 400;
						const scaleSize = MAX_WIDTH / e.target.width;
						canvas.width = MAX_WIDTH;
						canvas.height = e.target.height * scaleSize;
					} else {
						const MAX_HEIGHT = 400;
						const scaleSize = MAX_HEIGHT / e.target.height;
						canvas.height = MAX_HEIGHT;
						canvas.width = e.target.width * scaleSize;
					}

					const ctx = canvas.getContext("2d");

					ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

					const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

					var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
					document.querySelector(string).value = g_string;
				}
			} else {
				var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
				document.querySelector(string).value = g_string;
			}

		}
	}
	function nominal(angka, id){
		$(id).val(formatRupiah(angka, ''));
	}

	function formatRupiah(angka, prefix){
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split       = number_string.split(','),
		sisa        = split[0].length % 3,
		rupiah        = split[0].substr(0, sisa),
		ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
	}

			// function diff_date(start, end, ba, id){
			// 	var startn = new Date(start);
			// 	var endn   = new Date(end);
			// 								// selisih milliseconds
			// 	var diff = new Date(endn - startn);
			// 								// cari hari
			// 	var days = diff/1000/60/60/24;

			// 	if (days < 0) {
			// 		Swal.fire({
			// 			icon: "warning",
			// 			title: "Terlambat " + days + " hari!",
			// 			text: "Harus upload berita acara",
			// 			showConfirmButton: false,
			// 			timer: 2000,
			// 			timerProgressBar: true
			// 		});
			// 		$(ba).prop("disabled", false);
			// 		$(id).val(days);
			// 	}else{
			// 		$(ba).prop("disabled", true);
			// 		$(id).val(days);
			// 	}
			// }
</script>