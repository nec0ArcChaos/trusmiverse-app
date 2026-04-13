<form id="form_lpj" autocomplete="off">
	<input type="hidden" name="id_pengajuan_satu" value="<?= $id_pengajuan ?>" readonly>
	<input type="hidden" name="id_temp" id="id_temp" value="<?= $id_temp ?>" readonly>
	<input type="hidden" name="id_user" value="<?= $id_user ?>">
	<input type="hidden" name="id_divisi" value="<?= $id_divisi ?>">
	<div class="row">
		<div class="col-lg-4 col-md-2 col-sm-2">
			<label>Nama Penerima</label>
			<input type="text" required="" id="nama_penerima" name="nama_penerima" value="<?php echo $penerima['nama_penerima'] ?>" class="form-control input-sm" readonly>
			<input type="hidden" required="" id="tgl_input" name="tgl_input" value="<?php echo $penerima['tgl_input'] ?>" class="form-control input-sm" readonly>
		</div>
		<div class="col-lg-4 col-md-2 col-sm-2">
			<label>Nama Divisi</label>
			<?php foreach ($nama_divisi as $row) : ?>
				<input class="form-control" id="divisi" type="text" required name="divisi" placeholder="Nama Bank" value="<?= $row->nama_divisi ?>" readonly>
			<?php endforeach; ?>
		</div>
		<div class="col-lg-4 col-md-2 col-sm-2">
			<label>Nama Kategori</label>
			<select class="form-control" name="kategori" id="kategori" style="border: 1px solid #ccc" required>
				<option value="">-Pilih Kategori-</option>
				<?php foreach ($kategori as $row) : ?>
					<option value="<?php echo $row->id_kategori; ?>" selected><?php echo $row->nama_kategori; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<br>

	<?php foreach ($get_detail_keperluan_2 as $keys) : ?>
		<div class="row">
			<div class="col-lg-8 col-md-2 col-sm-2">
				<label>Nama Keperluan</label>
				<input type="text" value="<?php echo $keys->nama_keperluan; ?>" class="form-control input-sm" readonly><br>
			</div>
			<div class="col-lg-4 col-md-2 col-sm-2">
				<label>Total</label>
				<input class="form-control" type="text" name="nominal_pengajuan" value="<?php echo number_format($keys->nominal_uang, 0, ',', '.'); ?>" readonly>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-2 col-sm-2">
				<label>Keterangan</label>
				<input type="text" value="<?php echo $keys->note; ?>" class="form-control input-sm" readonly id="keterangan" name="keterangan"><br>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4 col-md-2 col-sm-2">
				<label>Nominal LPJ</label>
				<input type="hidden" name="nama_lpj" value="<?php echo $keys->nama_keperluan; ?>">
				<input type="hidden" name="id_pengajuan" value="<?php echo $keys->id_pengajuan; ?>">
				<input type="hidden" name="status" value="9">
				<input type="text" required="" id="nominal_lpj" onkeyup="nominal($(this).val(), '#nominal_lpj')" class="form-control input-sm" placeholder="Nominal LPJ" name="nominal_lpj" style="border: 1px solid #ccc" required>
			</div>
			<div class="col-lg-4 col-md-2 col-sm-2">
				<label>Note</label>
				<textarea class="form-control input-sm" name="note_lpj" placeholder="Note" style="border: 1px solid #ccc"></textarea>
			</div>
			<div class="col-lg-4 col-md-2 col-sm-2">
				<label>Attachment</label>
				<select class="form-control" name="attachment" id="attachment" style="border: 1px solid #ccc" required>
					<option value="1" selected>File</option>
					<option value="2">BA</option>
				</select>
			</div>
		</div>
		<div class="row" id="attach_hide">
			<div class="col-lg-4 col-md-2 col-sm-2">
				<label>Bukti Foto</label>
				<input style="padding: .4rem .75rem;" type="file" id="foto" class="form-control" onchange="compress('#foto', '#string', '.fa_wait', '.fa_done')" accept=".pdf,.jpg,.jpeg,.png" required>
				<small id="emailHelp" class="form-text text-muted">Diperbolehkan : .pdf, .jpg, .jpeg, .png (Jika lampiran lebih dari 1, gabungkan jadi 1 file pdf)</small>
				<input type="hidden" class="form-control" name="string" id="string">
				<div class="fa_wait" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Checking File ...</label></div>
				<div class="fa_done" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>File Complete.</label></div>
			</div>
		</div>
	<?php endforeach ?>


	<?php foreach ($id_biaya_lpj as $rowp) : ?>
		<input type="hidden" name="id_biaya_lpj" value="<?php echo $rowp->id_biaya_lpj; ?>">
	<?php endforeach; ?>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		$('#attachment').on('change', function() {
			if ($(this).val() == 2) {
				$('#attach_hide').hide();
			} else {
				$('#attach_hide').show();
			}
		});
	});

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

			// if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

			// 	extension = 'jpeg,';

			// 	imgElement.onload = function(e) {
			// 		const canvas = document.createElement("canvas");

			// 		if (e.target.width > e.target.height) {
			// 			const MAX_WIDTH = 400;
			// 			const scaleSize = MAX_WIDTH / e.target.width;
			// 			canvas.width = MAX_WIDTH;
			// 			canvas.height = e.target.height * scaleSize;
			// 		} else {
			// 			const MAX_HEIGHT = 400;
			// 			const scaleSize = MAX_HEIGHT / e.target.height;
			// 			canvas.height = MAX_HEIGHT;
			// 			canvas.width = e.target.width * scaleSize;
			// 		}

			// 		const ctx = canvas.getContext("2d");

			// 		ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

			// 		const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

			// 		var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
			// 		document.querySelector(string).value = g_string;
			// 	}
			// } else {
				var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
				document.querySelector(string).value = g_string;
			// }

		}
	}

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
</script>