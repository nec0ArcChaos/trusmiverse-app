<!-- <!DOCTYPE html>
<html>
<head>
    <title>Push Notification</title>
</head>
<body>

<h2>Kirim Push Notif ke Flutter</h2>

<input type="text" id="token" placeholder="FCM Token" style="width:400px" value="cJCAhZOjSRKKLOMjOYePqy:APA91bE4o5cY6_lapE2xScRocCZtyksZW51FK2k0Ls7wrHke6L-Kklsg4gD_952qGmAYEp2vxfqjG-U8KJ3nSwYkhsTbZr5hrjwhL2nhXqNeU-hOkz7TBSY"><br><br>
<span> Judul Notif</span><br>
<input type="text" id="title" placeholder="Judul"><br><br>
<span> Pesan Notif</span><br>
<input type="text" id="body" placeholder="Pesan"><br><br>
<input type="hidden" id="notif_id" placeholder="Notif Id" value="" ><br><br>


<hr>
<span> Pilih nama menu</span><br>
<select id="nama_menu">
    <option value="push">Push Notif</option>
    <option value="blast">Trusmi Blast</option>
    <option value="mom">Mom</option>

</select><br><br><br>

<span> No Transaksi menu</span><br>
<input type="text" id="trx_id" placeholder="Transaction Id" value="1752"><br><br>


<input type="file" name="file" id="file"><br><br>

<button id="btnSend">Kirim</button>

<pre id="result"></pre>



<script>
document.getElementById('btnSend').addEventListener('click', function () {

    const fd = new FormData();
    fd.append('token', document.getElementById('token').value);
    fd.append('title', document.getElementById('title').value);
    fd.append('body', document.getElementById('body').value);

    fd.append('trx_id', document.getElementById('trx_id').value);
    fd.append('nama_menu', document.getElementById('nama_menu').value);


    const fileInput = document.getElementById('file');
    if (fileInput.files.length > 0) {
        fd.append('file', fileInput.files[0]);
    }

    fetch('<?= site_url("push/send") ?>', {
        method: 'POST',
        body: fd
    })
    .then(res => res.json())
    .then(res => {
        document.getElementById('result').innerText =
            JSON.stringify(res, null, 2);
    })
    .catch(err => alert(err));
});
</script>

</body>
</html> -->


<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active">Push Notification</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                
                <!-- HEADER -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-bell h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col align-self-center">
                            <h6 class="fw-medium mb-0">Kirim Push Notification</h6>
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="card-body">
                    <div class="row g-4">

                        <!-- LEFT FORM -->
                        <div class="col-lg-6">

                            <!-- USER -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Pilih Karyawan</label>
                                <select name="employees" id="employees" class="form-control" multiple>
                                    <!-- <option value="" selected disabled>Select Employee</option> -->
                                    <?php foreach ($list_employees as $emp) : ?>
                                        <option value="<?php echo $emp->fcm_token ?>" data-user_id="<?= $emp->user_id ?>"><?php echo $emp->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- TOKEN -->
                            <div class="form-group mb-3">
                                <label class="mb-1">FCM Token</label>
                                <input type="text" id="token" class="form-control"
                                       placeholder="Masukkan FCM Token">
                            </div>

                            <!-- TITLE -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Judul Notif</label>
                                <input type="text" id="title" class="form-control"
                                       placeholder="Judul Notifikasi">
                            </div>

                            <!-- BODY -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Pesan Notif</label>
                                <textarea type="text" id="body" class="form-control"
                                       placeholder="Isi Pesan"></textarea>
                            </div>

                            <!-- MENU -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Menu</label>
                                <select id="nama_menu" class="form-control">
                                    <option value="push" selected>Push Notif</option>
                                    <!-- <option value="blast">Trusmi Blast</option>
                                    <option value="mom">Mom</option> -->
                                </select>
                            </div>

                            <!-- TRX -->
                            <div class="form-group mb-3">
                                <label class="mb-1">No Transaksi</label>
                                <input type="text" id="trx_id" class="form-control"
                                       placeholder="Transaction ID">
                            </div>

                            <!-- FILE -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Upload File (optional)</label>
                                <input type="file" id="file" class="form-control">
                            </div>

                            <!-- BUTTON -->
                            <div class="text-end">
                                <button id="btnSend" class="btn btn-theme">
                                    Kirim Notifikasi <i class="bi bi-send"></i>
                                </button>
                            </div>

                        </div>

                        <!-- RIGHT RESULT -->
                        <div class="col-lg-6">
                            <label class="mb-2">Response</label>
                            <pre id="result" style="height:400px; overflow:auto; background:#111; color:#0f0; padding:15px; border-radius:10px;"></pre>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>