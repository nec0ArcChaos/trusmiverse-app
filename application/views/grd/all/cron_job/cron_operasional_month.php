<?php

    header('Access-Control-Allow-Origin: *');

	date_default_timezone_set('Asia/Jakarta');

    // KONEKSI DATABASE HR
    $servername = "192.168.23.175:1776";
    $opsrname   = "app_trusmiverse";
    $password   = "@Jawara2023";
    $dbname     = "hris";

    // Create connection
    $conn = new mysqli($servername, $opsrname, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	// KONEKSI DATABASE PCS
	$servername2    = "192.168.10.150:6030";
    $opsrname2      = "ittrusmi";
    $password2      = "jawara2022";
    $dbname2        = "pos_batik";

    // Create connection
    $conn2 = new mysqli($servername2, $opsrname2, $password2, $dbname2);
    // Check connection
    if ($conn2->connect_error) {
        die("Connection failed: " . $conn2->connect_error);
    }

    $month    	= date('Y-m');

    // $query_ops = mysqli_query(
    //     $conn2,
    //             "SELECT
    //                 x.periode,
    //                 x.company,
    //                 x.divisi,
    //                 x.nama_target,
    //                 x.target,
    //                 x.actual
    //             FROM
    //                 (
    //                     SELECT
    //                         SUBSTR(CURRENT_DATE(),1,7) AS periode,
    //                         5 AS company,
    //                         'Operasional' AS divisi,
    //                         'Sales' AS nama_target,
    //                         target.tgt_sale AS target,
    //                         SUM(t_sale.amount_payment) AS actual
                                        
    //                     FROM
    //                         t_sale,                     
    //                         (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE periode = SUBSTR(CURRENT_DATE(),1,7)) AS target

    //                     WHERE
    //                         t_sale.sale_mode = 'S' 
    //                         AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(CURRENT_DATE(),1,7)
                                        
    //                     UNION ALL

    //                     SELECT
    //                         SUBSTR(CURRENT_DATE(),1,7) AS periode,
    //                         5 AS company,
    //                         'Operasional' AS divisi,
    //                         'Basket Size' AS nama_target,
    //                         target,
    //                         ROUND((COALESCE(a.sale, 0) - COALESCE(a.ppn, 0) - COALESCE(a.souv, 0) - COALESCE(a.onl, 0) - COALESCE(a.bk, 0)) / NULLIF(sum_trx, 0)) AS actual
    //                     FROM
    //                         (
    //                             SELECT
    //                                 SUM( t_sale.amount_payment ) AS sale,
    //                                 SUM( IF ( t_sale.customer_id NOT IN ( 185955, 184330, 186971, 186972, 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ), t_sale.ppn, 0 )) AS ppn,
    //                                 SUM( IF ( t_sale.customer_id IN ( 185955 ), t_sale.amount_payment, 0 )) AS souv,
    //                                 SUM( IF ( t_sale.customer_id IN ( 184330, 186971, 186972 ), t_sale.amount_payment, 0 )) AS onl,
    //                                 SUM( IF ( t_sale.customer_id IN ( 86868, 162311, 199618, 266597, 301885, 344361, 360833, 406818, 483755, 484928, 485034, 498234, 503268 ), t_sale.amount_payment, 0 )) AS bk,
    //                                 COUNT(*) AS sum_trx,
    //                                 target 
    //                             FROM
    //                                 t_sale, 
    //                                 (SELECT SUM(basket_size) AS target FROM target_global WHERE periode = SUBSTR(CURRENT_DATE(),1,7)) AS target
    //                             WHERE sale_mode = 'S' 
    //                             AND SUBSTR( created_at, 1, 7 ) = SUBSTR(CURRENT_DATE(),1,7)
    //                         ) AS a
                                        
    //                     UNION ALL

    //                     SELECT
    //                         SUBSTR(CURRENT_DATE(),1,7) AS periode,
    //                         5 AS company,
    //                         'Operasional' AS divisi,
    //                         'Transaksi' AS nama_target,
    //                         target.tgt_trx AS target,
    //                         COUNT(t_sale.sale_id) AS actual
                                    
    //                     FROM
    //                         t_sale,                     
    //                         (SELECT SUM(trx) AS tgt_trx FROM target_global WHERE periode = SUBSTR(CURRENT_DATE(),1,7)) AS target

    //                     WHERE
    //                         t_sale.sale_mode = 'S' 
    //                         AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(CURRENT_DATE(),1,7)
                                
    //                     UNION ALL
                        
    //                     SELECT
    //                         SUBSTR(CURRENT_DATE(),1,7) AS periode,
    //                         5 AS company,
    //                         'Operasional' AS divisi,
    //                         'Sales Last' AS nama_target,
    //                         target.tgt_sale AS target,
    //                         SUM(t_sale.amount_payment) AS actual
                                    
    //                     FROM
    //                         t_sale,                     
    //                         (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE periode = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 MONTH),1,7)) AS target

    //                     WHERE
    //                         t_sale.sale_mode = 'S' 
    //                         AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 MONTH),1,7)
                            
    //                     UNION ALL
                        
    //                     SELECT
    //                         SUBSTR(CURRENT_DATE(),1,7) AS periode,
    //                         5 AS company,
    //                         'Operasional' AS divisi,
    //                         'Sales Last Year' AS nama_target,
    //                         target.tgt_sale AS target,
    //                         SUM(t_sale.amount_payment) AS actual
                                    
    //                     FROM
    //                         t_sale,                     
    //                         (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE periode = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR),1,7)) AS target

    //                     WHERE
    //                         t_sale.sale_mode = 'S' 
    //                         AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR),1,7)
                            
    //                     UNION ALL
                        
    //                     SELECT
    //                         SUBSTR(CURRENT_DATE(),1,7) AS periode,
    //                         5 AS company,
    //                         'Operasional' AS divisi,
    //                         'Sales This Year' AS nama_target,
    //                         target.tgt_sale AS target,
    //                         SUM(t_sale.amount_payment) AS actual
                                    
    //                     FROM
    //                         t_sale,                     
    //                         (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE SUBSTR(periode,1,4) = SUBSTR(CURRENT_DATE(),1,4)) AS target

    //                     WHERE
    //                         t_sale.sale_mode = 'S' 
    //                         AND SUBSTR(t_sale.created_at,1,4) = SUBSTR(CURRENT_DATE(),1,4)
                    
    //                 ) AS x
    //         ");

    $query_ops = mysqli_query(
        $conn2,
                "SELECT
                    x.periode,
                    x.company,
                    x.divisi,
                    x.nama_target,
                    x.target,
                    x.actual
                FROM
                    (
                        SELECT
                            a.periode,
                            5 AS company,
                            'Operasional' AS divisi,
                            'Sales' AS nama_target,
                            a.target,
                            COALESCE(a.sale,0) - COALESCE(a.ppn,0) - COALESCE(a.souv,0) - COALESCE(a.onl,0) - COALESCE(a.bk,0) AS actual

                        FROM
                            (
                                SELECT
                                    SUBSTR(t_sale.created_at,1,10) AS periode,
                                    5 AS company,
                                    'Operasional' AS divisi,
                                    'Sales' AS nama_target,
                                    target.tgt_sale AS target,
                                    SUM(t_sale.amount_payment) AS sale,
                                    SUM(IF(t_sale.customer_id NOT IN (185955, 184330, 186971,186972, 86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.ppn, 0)) AS ppn,
                                    SUM(IF(t_sale.customer_id IN (185955), t_sale.amount_payment, 0)) AS souv,
                                    SUM(IF(t_sale.customer_id IN (184330, 186971,186972), t_sale.amount_payment, 0)) AS onl,
                                    SUM(IF(t_sale.customer_id IN (86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.amount_payment, 0)) AS bk
                                                                                                
                                FROM
                                    t_sale,                     
                                    (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE periode = SUBSTR(CURRENT_DATE(),1,7)) AS target

                                WHERE
                                    t_sale.sale_mode = 'S' 
                                    AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(CURRENT_DATE(),1,7)
                                GROUP BY SUBSTR(t_sale.created_at,1,10)
                            ) AS a
                                                                                    
                        UNION ALL

                        SELECT
                            a.periode,
                            5 AS company,
                            'Operasional' AS divisi,
                            'Basket Size' AS nama_target,
                            a.target,
                            ROUND((COALESCE(a.sale, 0) - COALESCE(a.ppn, 0) - COALESCE(a.souv, 0) - COALESCE(a.onl, 0) - COALESCE(a.bk, 0)) / a.sum_trx,0) AS actual

                        FROM
                            (
                                SELECT
                                    SUBSTR(t_sale.created_at,1,10) AS periode,
                                    5 AS company,
                                    'Operasional' AS divisi,
                                    'Basket Size' AS nama_target,
                                    target.tgt_sale AS target,
                                    SUM(t_sale.amount_payment) AS sale,
                                    SUM(IF(t_sale.customer_id NOT IN (185955, 184330, 186971,186972, 86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.ppn, 0)) AS ppn,
                                    SUM(IF(t_sale.customer_id IN (185955), t_sale.amount_payment, 0)) AS souv,
                                    SUM(IF(t_sale.customer_id IN (184330, 186971,186972), t_sale.amount_payment, 0)) AS onl,
                                    SUM(IF(t_sale.customer_id IN (86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.amount_payment, 0)) AS bk,
                                    COUNT(*) AS sum_trx
                                                                                                
                                FROM
                                    t_sale,                     
                                    (SELECT SUM(basket_size) AS tgt_sale FROM target_global WHERE periode = SUBSTR(CURRENT_DATE(),1,7)) AS target

                                WHERE
                                    t_sale.sale_mode = 'S' 
                                    AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(CURRENT_DATE(),1,7)
                                GROUP BY SUBSTR(t_sale.created_at,1,10)
                            ) AS a
                                                                                    
                        UNION ALL

                        SELECT
                            SUBSTR(t_sale.created_at,1,10) AS periode,
                            5 AS company,
                            'Operasional' AS divisi,
                            'Transaksi' AS nama_target,
                            target.target,
                            COUNT(t_sale.sale_id) AS actual
                        FROM
                            t_sale, 
                            (SELECT SUM(trx) AS target FROM target_global WHERE periode = SUBSTR(CURRENT_DATE(),1,7)) AS target
                        WHERE
                            t_sale.sale_mode = 'S' 
                            AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(CURRENT_DATE(),1,7)
                        GROUP BY SUBSTR(t_sale.created_at,1,10)
                                                    
                        UNION ALL

                        SELECT
                            a.periode,
                            5 AS company,
                            'Operasional' AS divisi,
                            'Sales Last' AS nama_target,
                            a.target,
                            COALESCE(a.sale,0) - COALESCE(a.ppn,0) - COALESCE(a.souv,0) - COALESCE(a.onl,0) - COALESCE(a.bk,0) AS actual

                        FROM
                            (
                                SELECT
                                    SUBSTR(t_sale.created_at,1,10) AS periode,
                                    5 AS company,
                                    'Operasional' AS divisi,
                                    'Sales Last' AS nama_target,
                                    target.tgt_sale AS target,
                                    SUM(t_sale.amount_payment) AS sale,
                                    SUM(IF(t_sale.customer_id NOT IN (185955, 184330, 186971,186972, 86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.ppn, 0)) AS ppn,
                                    SUM(IF(t_sale.customer_id IN (185955), t_sale.amount_payment, 0)) AS souv,
                                    SUM(IF(t_sale.customer_id IN (184330, 186971,186972), t_sale.amount_payment, 0)) AS onl,
                                    SUM(IF(t_sale.customer_id IN (86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.amount_payment, 0)) AS bk
                                                                                                
                                FROM
                                    t_sale,                     
                                    (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE periode = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 MONTH),1,7)) AS target

                                WHERE
                                    t_sale.sale_mode = 'S' 
                                    AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 MONTH),1,7)
                                GROUP BY SUBSTR(t_sale.created_at,1,10)
                            ) AS a
                                    
                        UNION ALL

                        SELECT
                            a.periode,
                            5 AS company,
                            'Operasional' AS divisi,
                            'Sales Last Year' AS nama_target,
                            a.target,
                            COALESCE(a.sale,0) - COALESCE(a.ppn,0) - COALESCE(a.souv,0) - COALESCE(a.onl,0) - COALESCE(a.bk,0) AS actual

                        FROM
                            (
                                SELECT
                                    SUBSTR(t_sale.created_at,1,10) AS periode,
                                    5 AS company,
                                    'Operasional' AS divisi,
                                    'Sales Last Year' AS nama_target,
                                    target.tgt_sale AS target,
                                    SUM(t_sale.amount_payment) AS sale,
                                    SUM(IF(t_sale.customer_id NOT IN (185955, 184330, 186971,186972, 86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.ppn, 0)) AS ppn,
                                    SUM(IF(t_sale.customer_id IN (185955), t_sale.amount_payment, 0)) AS souv,
                                    SUM(IF(t_sale.customer_id IN (184330, 186971,186972), t_sale.amount_payment, 0)) AS onl,
                                    SUM(IF(t_sale.customer_id IN (86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.amount_payment, 0)) AS bk
                                                                                                
                                FROM
                                    t_sale,                     
                                    (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE periode = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR),1,7)) AS target

                                WHERE
                                    t_sale.sale_mode = 'S' 
                                    AND SUBSTR(t_sale.created_at,1,7) = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR),1,7)
                                GROUP BY SUBSTR(t_sale.created_at,1,10)
                            ) AS a
                                    
                        UNION ALL

                        SELECT
                            a.periode,
                            5 AS company,
                            'Operasional' AS divisi,
                            'Sales This Year' AS nama_target,
                            a.target,
                            COALESCE(a.sale,0) - COALESCE(a.ppn,0) - COALESCE(a.souv,0) - COALESCE(a.onl,0) - COALESCE(a.bk,0) AS actual

                        FROM
                            (
                                SELECT
                                    SUBSTR(t_sale.created_at,1,10) AS periode,
                                    5 AS company,
                                    'Operasional' AS divisi,
                                    'Sales This Year' AS nama_target,
                                    target.tgt_sale AS target,
                                    SUM(t_sale.amount_payment) AS sale,
                                    SUM(IF(t_sale.customer_id NOT IN (185955, 184330, 186971,186972, 86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.ppn, 0)) AS ppn,
                                    SUM(IF(t_sale.customer_id IN (185955), t_sale.amount_payment, 0)) AS souv,
                                    SUM(IF(t_sale.customer_id IN (184330, 186971,186972), t_sale.amount_payment, 0)) AS onl,
                                    SUM(IF(t_sale.customer_id IN (86868,162311,199618,266597,301885,344361,360833,406818,483755,484928,485034,498234,503268), t_sale.amount_payment, 0)) AS bk
                                                                                                
                                FROM
                                    t_sale,                     
					                (SELECT SUM(sales) AS tgt_sale FROM target_global WHERE SUBSTR(periode,1,4) = SUBSTR(CURRENT_DATE(),1,4)) AS target

                                WHERE
                                    t_sale.sale_mode = 'S' 
                                    AND SUBSTR(t_sale.created_at,1,4) = SUBSTR(CURRENT_DATE(),1,4)
                                GROUP BY SUBSTR(t_sale.created_at,1,10)
                            ) AS a

                    ) AS x
            ");


    $v_ops = array();
    while ($data = mysqli_fetch_array($query_ops)) {
        $v_ops[] = $data;
    }

    // $query_cek = mysqli_query(
    //     $conn,
    //             "SELECT
    //                 SUBSTR(created_at,1,7) AS tgl_cek
    //             FROM grd_m_target_new
    //             WHERE SUBSTR(created_at,1,7) = SUBSTR(CURRENT_DATE(),1,7)
    //             GROUP BY SUBSTR(created_at,1,7)
    //         ");

    // $data_cek = array();
    // while ($data = mysqli_fetch_array($query_cek)) {
    //     $data_cek[] = $data; //data_cek dijadikan array 
    // }

    // $query_cd = mysqli_query(
    //     $conn2,
    //             "SELECT
    //                 SUBSTR(CURRENT_DATE,1,7) AS tgl
    //         ");

    // $data_dt = array();
    // while ($data = mysqli_fetch_array($query_cd)) {
    //     $data_dt[] = $data; //d_dt dijadikan array 
    // }
    
    // // var_dump($v_ops);

    // foreach ($data_dt as $d_dt)
    // {
    //     $tgl        = $d_dt['tgl'];

    //     // echo 'tgl : '.$tgl;
    //     // echo '<br>';

    //     foreach ($data_cek as $dcek)
    //     {
    //         $tgl_cek    = $dcek['tgl_cek'] != 0 ? $dcek['tgl_cek'] : 0;

            // echo 'tgl_cek : '.$tgl_cek;
            // echo '<br>';

            foreach ($v_ops as $ops)
            {

                $periode        = $ops['periode'];
                $company        = $ops['company'];
                $divisi         = $ops['divisi'];
                $nama_target    = $ops['nama_target'];
                $target         = $ops['target'];
                $actual         = $ops['actual'];

                $created_at     = date('Y-m-d H:i:s');
                $created_by     = 1;

                $updated_at     = date('Y-m-d H:i:s');
                $updated_by     = 1;

                $deleted_at     = date('Y-m-d');

                echo 'periode : '.$periode;
                echo '<br>';
                echo 'company : '.$company;
                echo '<br>';
                echo 'divisi : '.$divisi;
                echo '<br>';
                echo 'nama_target : '.$nama_target;
                echo '<br>';
                echo 'target : '.$target;
                echo '<br>';
                echo 'actual : '.$actual;
                echo '<br>';
                echo '--------';
                echo '<br>';

                // echo $tgl_cek;
                // echo '<br>';
                // echo $tgl;
                // echo '<br>';

                // if($tgl != $tgl_cek){
                //     echo 'Tidak Ada';
                // }else{
                //     echo 'Ada';
                // }

                // if($tgl_cek == null || $tgl_cek == 'NULL' || $tgl_cek == ''){
                //     $query 			= "INSERT INTO `hris`.`grd_m_target_new`(`periode`, `company`, `divisi`, `nama_target`, `target`, `actual`, `created_at`, `created_by`) VALUES ('$periode', '$company', '$divisi', '$nama_target', '$target', '$actual', '$created_at', '$created_by')";
                // }else if($tgl == $tgl_cek){
                //     $query          = "UPDATE `hris`.`grd_m_target_new` SET `target` = '$target', `actual` = '$actual', `updated_at` = '$updated_at', `updated_by` = $updated_by WHERE `periode` = '$periode'";
                // }

                // if($tgl != $tgl_cek){
                    $query  = "INSERT INTO `hris`.`grd_m_target_new`(`periode`, `company`, `divisi`, `nama_target`, `target`, `actual`, `created_at`, `created_by`) VALUES ('$periode', '$company', '$divisi', '$nama_target', '$target', '$actual', '$created_at', '$created_by')";
                // }else{
                //     $query          = "UPDATE `hris`.`grd_m_target_new` SET `target` = '$target', `actual` = '$actual', `updated_at` = '$updated_at', `updated_by` = $updated_by WHERE `periode` = '$periode'";
                // }            

                $sql    = mysqli_query($conn, $query);
                if($sql)
                {
                    echo "Sukses ges";
                }else{
                    echo "Ngaco";
                    echo '<br>';
                    echo $query;
                    echo '<br>';
                }


            }

    //     }

    // }


?>
