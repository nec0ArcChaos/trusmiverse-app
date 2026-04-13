<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Vendors Style-->
    <style>
        table {
            font-size: 9px;
        }

        @media print {
            @page {
                size: 225px 352px;
                /* Set paper size to 21cm by 11cm and orientation to landscape */
                margin: 0;
            }

            footer {
                display: none
            }

            header {
                display: none
            }

            body {
                -webkit-print-color-adjust: exact !important;
            }
        }

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
    </style>

</head>

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">

<body style="background-color: #CCCCCC;margin: 0" onload="window.print()">
    <section class="sheet">
        <table cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" border="0">
            <tbody>
                <tr>
                    <td>
                        <div class="idcard text-center">
                            <img class="img_idcard" src="http://trusmiverse.com/hr/uploads/profile/<?= $my_profile->profile_picture; ?>" alt="" />
                            <div class="text-center" style="margin-top: 10px;color: black; font-size: 12px; font-weight: bold;">
                                <p><?= $my_profile->employee_name ?></p>
                            </div>
                            <div class="text-center">
                                <p style="margin-top: 10px;color: black; font-size: 10px;">
                                    <?= $my_profile->designation_name ?>
                                    <br>
                                    <?= $my_profile->employee_id ?>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </section>

</body>

</html>
<script>
    function closeWindow() {
        window.close();
    }

    window.onafterprint = closeWindow;
    window.print();
</script>