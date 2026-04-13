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

    	$deleted_at     = date('Y-m-d');
    
        $query2 = "DELETE FROM `hris`.`grd_m_target_new` WHERE `periode` = '$deleted_at'";
            $sql2   = mysqli_query($conn, $query2);
            
            if($sql2)
            {
                echo "Sukses delete ges";
            }else{
                echo "Ngaco delete";
                echo '<br>';
                echo $query2;
                echo '<br>';
            }

        $deleted_at2 = date('Y-m-d', strtotime('-1 year'));
    
        $query3 = "DELETE FROM `hris`.`grd_m_target_new` WHERE `periode` = '$deleted_at2'";
            $sql4   = mysqli_query($conn, $query3);
            
            if($sql4)
            {
                echo "Sukses delete ges";
            }else{
                echo "Ngaco delete";
                echo '<br>';
                echo $query3;
                echo '<br>';
            }

        $deleted_at2 = date('Y-m-d', strtotime('-1 year'));
    
        $query3 = "DELETE FROM `hris`.`grd_m_target_new` WHERE `periode` = '$deleted_at2'";
            $sql4   = mysqli_query($conn, $query3);
            
            if($sql4)
            {
                echo "Sukses delete ges";
            }else{
                echo "Ngaco delete";
                echo '<br>';
                echo $query3;
                echo '<br>';
            }

        $deleted_at3 = date('Y-m-d', strtotime('-1 month'));
    
        $query4 = "DELETE FROM `hris`.`grd_m_target_new` WHERE `periode` = '$deleted_at3'";
            $sql5   = mysqli_query($conn, $query4);
            
            if($sql5)
            {
                echo "Sukses delete ges";
            }else{
                echo "Ngaco delete";
                echo '<br>';
                echo $query4;
                echo '<br>';
            }


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
                                            AND SUBSTR(t_sale.created_at,1,10) = SUBSTR(CURRENT_DATE(),1,10)
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
                                            AND SUBSTR(t_sale.created_at,1,10) = SUBSTR(CURRENT_DATE(),1,10)
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
                                    AND SUBSTR(t_sale.created_at,1,10) = SUBSTR(CURRENT_DATE(),1,10)
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
                                            AND SUBSTR(t_sale.created_at,1,10) = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 MONTH),1,10)
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
                                            AND SUBSTR(t_sale.created_at,1,10) = SUBSTR(DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR),1,10)
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
                                            AND SUBSTR(t_sale.created_at,1,10) = SUBSTR(CURRENT_DATE(),1,10)
                                        GROUP BY SUBSTR(t_sale.created_at,1,10)
                                    ) AS a

                            ) AS x
                    ");


            $v_ops = array();
            while ($data = mysqli_fetch_array($query_ops)) {
                $v_ops[] = $data;
            }

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

                    $query  = "INSERT INTO `hris`.`grd_m_target_new`(`periode`, `company`, `divisi`, `nama_target`, `target`, `actual`, `created_at`, `created_by`) VALUES ('$periode', '$company', '$divisi', '$nama_target', '$target', '$actual', '$created_at', '$created_by')";
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


?>
