<main class="main mainheight">
    <style>
        .idcard {
            background-image: url('<?= base_url() ?>/assets/img/bg_idcard.jpeg');
            background-size: cover;
            width: 225px;
            height: 352px;
            border-width: 1px;
            border-color: black;

        }

        .img_idcard {
            border-radius: 100%;
            height: 130px;
            width: 118px;
            margin-top: 78px;
            object-fit: cover;
        }

        @media only screen and (max-width: 768px) {
            .btn-print {
                display: none;
            }
        }
    </style>
    <!-- page title bar -->
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-md-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0">My ID Card</h5>
                <p class="text-secondary">This is your personal ID Card</p>
                <br>
            </div>
            <div class="col-md-6">
                <div class="card align-items-center justify-content-center p-4">
                    <div class="idcard text-center">
                        <img class="img_idcard" src="http://trusmiverse.com/hr/uploads/profile/<?= $my_profile->profile_picture; ?>" alt="" />
                        <div class="text-center" style="margin-top: 10px; font-size: 12px; font-weight: bold;">
                            <?= $my_profile->employee_name ?>
                        </div>
                        <div class="text-center" style="margin-top: 10px; font-size: 10px;">
                            <b><?= $my_profile->designation_name ?></b>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a class="btn-print btn btn-warning float-end" onclick="printID()"> <i class="fa fa-print"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function printID() {
        var url = '<?= base_url('Idcard/Print') ?>';
        var windowName = 'popupWindow';
        var windowFeatures = 'width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes';

        var popupWindow = window.open(url, windowName, windowFeatures);
        // popupWindow.focus();
    }
</script>
<!-- Modal -->