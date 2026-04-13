<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Vendors Style-->
    <style>
        .idcard {
            background-image: url('<?= base_url() ?>/assets/img/bg_idcard.jpeg');
            background-size: cover;
            width: 450px;
            /* 225px * 2 */
            height: 704px;
            /* 352px * 2 */
            border-width: 1px;
            border-color: black;
        }

        .img_idcard {
            border-radius: 100%;
            height: 260px;
            /* 130px * 2 */
            width: 236px;
            /* 118px * 2 */
            margin-top: 156px;
            /* 78px * 2 */
            object-fit: cover;
        }
    </style>

</head>

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">

<body style="background-color: #CCCCCC;margin: 0">
    <section class="sheet">
        <table cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" border="0">
            <tbody>
                <tr>
                    <td>
                        <!-- <canvas id="cekrek"> -->
                        <div class="idcard text-center" id="cekrek">
                            <img class="img_idcard" src="http://trusmiverse.com/hr/uploads/profile/<?= $my_profile->profile_picture; ?>" alt="" />
                            <div class="text-center" style="margin-top: 25px;color: black; font-size: 25px; font-weight: bold;">
                                <p><?= $my_profile->employee_name ?></p>
                            </div>
                            <div class="text-center">
                                <p style="margin-top: 10px;color: black; font-size: 18px;">
                                    <?= $my_profile->designation_name ?>
                                </p>
                            </div>
                        </div>
                        <!-- </canvas> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

</body>

</html>