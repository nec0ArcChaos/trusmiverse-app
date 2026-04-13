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
	$servername2    = "127.0.0.1:6030";
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

    $query_ops = mysqli_query(
        $conn2,
                "SELECT
                    a.periode,
                    a.company,
                    a.divisi,
                    a.nama_target,
                    a.target,
                    a.actual
                FROM
                    (
                        SELECT
                            SUBSTR(CURRENT_DATE(),1,7) AS periode,
                            5 AS company,
                            'Produksi' AS divisi,
                            'Safety Stok' AS nama_target,
                            100 AS target,
                            ROUND(AVG(realisasi),1) AS actual
                        FROM
                            (
                                SELECT 
                                    tipe,
                                    dtrs.category_id,
                                    category, 
                                    'Safety Stok' AS category_v,
                                    SUM(CASE WHEN dtrs.tipe = 0 THEN NULL ELSE COALESCE(ROUND((COALESCE(bobot,0) * stok_aman_p) / 100), bobot) END) AS realisasi
                                    
                                FROM
                                    (
                                        SELECT
                                            nb.tipe, 
                                            nb.category_v,
                                            nb.bobot,
                                            nb.id_category AS category_id,
                                            nb.category,
                                            stok_aman_p
                                        FROM
                                            (
                                                SELECT
                                                    a.tipe, 
                                                    CASE
                                                        WHEN tipe = 0 THEN CONVERT(category USING utf8)
                                                    ELSE category_v
                                                    END AS category_v,
                                                    id_category,
                                                    category,
                                                    bobot
                                                FROM
                                                    (
                                                        SELECT 1 AS tipe, '100 Priority' AS category_v, 50 AS bobot UNION ALL
                                                        SELECT 2 AS tipe, '100 -200 Priority' AS category_v, 30 AS bobot UNION ALL
                                                        SELECT 3 AS tipe, 'UP 200 Priority' AS category_v, 20 AS bobot
                                                    ) a,
                                                    (
                                                        SELECT
                                                            id_category,
                                                            category
                                                        FROM m_category
                                                        WHERE id_category IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                    ) cat
                                            ) nb
                                        LEFT JOIN
                                            (
                                                SELECT 
                                                    category_id,
                                                    category,
                                                    tipe,
                                                    
                                                    CASE
                                                        WHEN tipe = 1 THEN '100 Priority' 
                                                        WHEN tipe = 2 THEN '101-200 Priority' 
                                                        WHEN tipe = 3 THEN '>200 Priority' 
                                                    ELSE NULL
                                                    END AS category_v,
                                                    
                                                    CASE
                                                        WHEN tipe = 1 THEN '50' 
                                                        WHEN tipe = 2 THEN '30' 
                                                        WHEN tipe = 3 THEN '20' 
                                                    ELSE NULL
                                                    END AS bobot,
                                                    
                                                    ROUND((COALESCE(COUNT(IF(stok_status = 'safe', item_number, NULL)),0) / COUNT(item_number)) * 100) AS stok_aman_p
                                                FROM
                                                    (
                                                        SELECT
                                                            rank,
                                                            tipe,
                                                            item_number,
                                                            `name`,
                                                            category_id,
                                                            category,
                                                            stok_all,
                                                            sale_month_avg,
                                                            
                                                            CASE
                                                                WHEN first_display IS NULL THEN 'safe'
                                                                WHEN COALESCE(stok_all,0) >= COALESCE(minimum_stock,0) AND (COALESCE(stok_all,0) > 0) THEN 'safe' 
                                                                WHEN COALESCE(stok_all,0) >= COALESCE(minimum_stock,0) AND (COALESCE(sale_month_avg, 0) > 0) THEN 'safe' 
                                                                WHEN COALESCE(stok_all,0) < COALESCE(minimum_stock,0) AND (COALESCE(stok_all,0) > 0 AND COALESCE(sale_month_avg, 0) <= 0) THEN 'danger' 
                                                            ELSE 'danger'
                                                            END AS stok_status
                                                            
                                                        FROM
                                                            (
                                                                SELECT
                                                                    rank,
                                                                    dtr2.tipe,
                                                                    item_number,
                                                                    `name`,
                                                                    dtr2.category_id,
                                                                    category,
                                                                    stok_all,
                                                                    first_display,
                                                                    sale_month_avg,
                                                                        
                                                                    CASE 
                                                                        WHEN dtr2.tipe = 1 AND dtr2.item_number IN (8997001280871, 8997001290870, 8997001300876, 9230422, 9230423, 9230421, 9230420, 9230419, 9230656, 9230536, 9230068, 9230069, 9230210, 9230159, 9230160, 91932041, 9230495, 9210005, 9210006) THEN COALESCE(buffer1 / 2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 1 THEN COALESCE(buffer1,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 2 AND dtr2.item_number IN (8997001280871, 8997001290870, 8997001300876, 9230422, 9230423, 9230421, 9230420, 9230419, 9230656, 9230536, 9230068, 9230069, 9230210, 9230159, 9230160, 91932041, 9230495, 9210005, 9210006) THEN COALESCE(buffer2 / 2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 2 THEN COALESCE(buffer2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 3 AND dtr2.item_number IN (8997001280871, 8997001290870, 8997001300876, 9230422, 9230423, 9230421, 9230420, 9230419, 9230656, 9230536, 9230068, 9230069, 9230210, 9230159, 9230160, 91932041, 9230495, 9210005, 9210006) THEN COALESCE(buffer3 / 2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 3 THEN COALESCE(buffer3,0) * COALESCE(sale_month_avg, 0)
                                                                    ELSE 0 END AS minimum_stock
                                                                        
                                                                FROM
                                                                    (
                                                                        SELECT
                                                                            rank,
                                                                            CASE 
                                                                                WHEN rank < 101 THEN 1
                                                                                WHEN rank > 100 AND rank < 201 THEN 2
                                                                                WHEN rank > 200  THEN 3
                                                                            ELSE 0
                                                                            END AS tipe,
                                                                            item_number,
                                                                            `name`,
                                                                            category_id,
                                                                            category,
                                                                            stok_all,
                                                                            first_display,
                                                                            sale_month_avg
                                                                        FROM
                                                                            (
                                                                                SELECT
                                                                                    (@rank := if(@rn = category_id, @rank + 1,if(@rn := category_id, 1, 1))) AS rank,
                                                                                    dta.item_number,
                                                                                    dta.`name`,
                                                                                    dta.category_id,
                                                                                    category,
                                                                                    stok_all,
                                                                                    first_display,
                                                                                    sale_month_avg
                                                                                FROM
                                                                                    (
                                                                                        SELECT 
                                                                                            a.item_number,
                                                                                            a.`name`,
                                                                                            a.category_id,
                                                                                            c.category,
                                                                                            ROUND((COALESCE(sale_month_7,0) + COALESCE(sale_month_6,0) + COALESCE(sale_month_5,0) + COALESCE(sale_month_4,0) + COALESCE(sale_month_3,0) + COALESCE(sale_month_2, 0)) / bulan_display) sale_month_avg,
                                                                                            COALESCE(a.quantity, 0) + COALESCE(a.qty_wh,0) + COALESCE(b.qty, 0) + COALESCE(dtrcvgr.rcv_blm_gr, 0) + COALESCE(scmotw.stok_dis_otw, 0) AS stok_all,
                                                                                            first_display
                                                                                        FROM pos_batik.m_product a
                                                                                        LEFT JOIN purchasing_crb.t_stock_dis b ON b.id_produk = a.item_number AND b.id_dis IN (1,14)
                                                                                        LEFT JOIN pos_batik.m_category c ON c.id_category = a.category_id
                                                                                        LEFT JOIN purchasing_crb.`user` d ON d.id_user = a.id_pic
                                                                                        LEFT JOIN
                                                                                            (
                                                                                                SELECT
                                                                                                    item_id,
                                                                                                    MIN(created_at) AS first_display, 
                                                                                                    CASE
                                                                                                        WHEN period_diff(date_format(now(), '%Y%m'), date_format(created_at, '%Y%m')) > 6 THEN 6
                                                                                                    ELSE period_diff(date_format(now(), '%Y%m'), date_format(created_at, '%Y%m'))
                                                                                                    END AS bulan_display
                                                                                                FROM pos_batik.t_purchase_item
                                                                                                GROUP BY item_id
                                                                                            ) display ON display.item_id = a.item_id
                                                                                        LEFT JOIN
                                                                                            (
                                                                                                SELECT
                                                                                                    h_sales_6m.item_id,
                                                                                                    s6 AS sale_month_7,
                                                                                                    s5 AS sale_month_6,
                                                                                                    s4 AS sale_month_5,
                                                                                                    s3 AS sale_month_4,
                                                                                                    s2 AS sale_month_3,
                                                                                                    s1 AS sale_month_2
                                                                                                FROM pos_batik.h_sales_6m
                                                                                                WHERE periode = SUBSTR(CURRENT_DATE, 1, 7)
                                                                                                GROUP BY h_sales_6m.item_id
                                                                                            ) AS sales ON sales.item_id = a.item_id
                                                                                        LEFT JOIN
                                                                                            (
                                                                                                SELECT * FROM
                                                                                                (
                                                                                                    SELECT
                                                                                                        a.no_po,
                                                                                                        a.id_dis,
                                                                                                        b.id_produk, 
                                                                                                        SUM(COALESCE(b.qty)) AS po_qty,
                                                                                                        SUM(COALESCE ( c.rcv_qty, 0 ) ) AS rcv_qty,
                                                                                                        SUM(COALESCE ( c.rcv_na, 0 ) ) AS rcv_na,
                                                                                                        SUM(COALESCE ( d.gr_qty, 0 )) AS gr_qty,
                                                                                                        SUM(COALESCE ( d.gr_rjt, 0 )) AS gr_rjt,
                                                                                                        CASE
                                                                                                            WHEN (SUM(COALESCE ( c.rcv_qty, 0 ) ) ) - (SUM(COALESCE ( d.gr_qty, 0 )) + SUM(COALESCE ( d.gr_rjt, 0 ))) < 0 THEN 0
                                                                                                        ELSE (SUM(COALESCE ( c.rcv_qty, 0 ) ) ) -  (SUM(COALESCE ( d.gr_qty, 0 )) + SUM(COALESCE ( d.gr_rjt, 0 )))
                                                                                                        END AS rcv_blm_gr
                                                                                                    FROM
                                                                                                        (
                                                                                                            SELECT
                                                                                                                a.no_po,
                                                                                                                a.id_dis
                                                                                                            FROM purchasing_crb.t_purchase_order a
                                                                                                            WHERE a.id_dis IN (1,14)
                                                                                                            AND `status` = 2
                                                                                                        ) a
                                                                                                    LEFT JOIN
                                                                                                        (
                                                                                                            SELECT
                                                                                                                no_po,
                                                                                                                id_produk,
                                                                                                                qty
                                                                                                            FROM purchasing_crb.t_purchase_order_item
                                                                                                            WHERE `status` IS NULL
                                                                                                            AND kategori IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                                        ) b ON b.no_po = a.no_po
                                                                                                    LEFT JOIN
                                                                                                        (
                                                                                                            SELECT
                                                                                                                no_po,
                                                                                                                id_produk,
                                                                                                                SUM(COALESCE(qty_receive,0)) AS rcv_qty,
                                                                                                                SUM(COALESCE(na_supplier,0)) AS rcv_na 
                                                                                                            FROM purchasing_crb.t_receive_item
                                                                                                            WHERE kategori IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                                            GROUP BY no_po, id_produk
                                                                                                        ) c ON b.no_po = c.no_po AND b.id_produk = c.id_produk
                                                                                                    LEFT JOIN
                                                                                                        (
                                                                                                            SELECT
                                                                                                                t_receive_order.no_po,
                                                                                                                id_produk,
                                                                                                                SUM(COALESCE(qty_gr, 0)) AS gr_qty,
                                                                                                                SUM(COALESCE(reject, 0)) AS gr_rjt
                                                                                                            FROM purchasing_crb.t_good_receive_item 
                                                                                                            LEFT JOIN purchasing_crb.t_receive_order ON t_good_receive_item.no_receive = t_receive_order.no_receive
                                                                                                            WHERE	kategori IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                                            GROUP BY no_po, id_produk
                                                                                                        ) d ON a.no_po = d.no_po AND b.id_produk = d.id_produk
                                                                                                    GROUP BY b.id_produk
                                                                                                ) aa WHERE rcv_blm_gr > 0
                                                                                            ) AS dtrcvgr ON dtrcvgr.id_produk = a.item_number
                                                                                        LEFT JOIN
                                                                                            (
                                                                                                SELECT
                                                                                                    t_distribusi.no_dis, 
                                                                                                    m_destinasi.id_des,
                                                                                                    m_destinasi.destinasi, 
                                                                                                    t_distribusi_item.id_produk,
                                                                                                    t_distribusi_item.nama_produk,
                                                                                                    SUM(COALESCE(t_distribusi_item.qty, 0)) AS stok_dis_otw,
                                                                                                    SUBSTR(t_distribusi.created_at,1,10) AS tgl_distribusi,
                                                                                                    t_distribusi.keterangan,
                                                                                                    SUBSTR(t_distribusi.ceklis_at,1,10) AS tgl_ceklis,
                                                                                                    t_distribusi.pic_at,
                                                                                                    t_distribusi.pic_wh
                                                                                                FROM purchasing_crb.t_distribusi
                                                                                                LEFT JOIN purchasing_crb.t_distribusi_item ON t_distribusi_item.no_dis = t_distribusi.no_dis
                                                                                                JOIN purchasing_crb.m_destinasi ON m_destinasi.id_des = t_distribusi.destination
                                                                                                LEFT JOIN purchasing_crb.t_wh_receive ON t_distribusi.no_dis = t_wh_receive.no_dis
                                                                                                WHERE SUBSTR(t_distribusi.created_at,1,10) > '2023-04-01'
                                                                                                AND t_wh_receive.no_dis IS NULL
                                                                                                AND (t_distribusi.destination IN (1,14))
                                                                                                GROUP BY t_distribusi_item.id_produk
                                                                                            ) AS scmotw ON scmotw.id_produk = a.item_number
                                                                                        WHERE active = 0 
                                                                                        AND SUBSTR(a.item_number, 1, 1) != 'X'
                                                                                        AND SUBSTR(a.item_number, 1, 2) != 'C-'
                                                                                        AND SUBSTR(a.`name`, 1, 3) != 'DP '
                                                                                        AND SUBSTR(a.`name`, 1, 5) != '(Disc'
                                                                                        AND SUBSTR(a.`name`, 1, 5) != 'JAHIT'
                                                                                        AND SUBSTR(a.`name`, 1, 3) != 'CAS'
                                                                                        AND SUBSTR(a.`item_number`, 1, 2) != 'V-'
                                                                                        AND SUBSTR(a.`name`, 1, 4) != 'CKL-'
                                                                                        AND SUBSTR(a.item_number, 1, 4) != 'CKL-'
                                                                                        AND SUBSTR(a.`name`, 1, 4) != 'Demo'
                                                                                        AND SUBSTR(a.`name`, 1, 4) != 'PDL-'
                                                                                        AND SUBSTR(a.item_number, 1, 2) != 'D-'
                                                                                        AND SUBSTR(a.`name`, 1, 5) != 'PROMO '
                                                                                        AND SUBSTR(a.item_number, 1, 3) != 'OP-'
                                                                                        AND SUBSTR(a.`name`, 1, 3) != 'SP '
                                                                                        AND a.NAME != 'LOGO BORDIR' 

                                                                                        AND a.category_id IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                    ) dta,
                                                                                    ( SELECT @rank := 0,
                                                                                            @rn := NULL ) num 
                                                                                    ORDER BY category_id, sale_month_avg DESC, dta.item_number
                                                                            ) dtr
                                                                        ) dtr2
                                                                    LEFT JOIN
                                                                        (
                                                                            SELECT 
                                                                                `id`,
                                                                                CASE WHEN category_id = 73 THEN ROUND(buffer1 / 2, 1) ELSE buffer1 END AS buffer1,
                                                                                CASE WHEN category_id = 73 THEN ROUND(buffer2 / 2, 1) ELSE buffer2 END AS buffer2,
                                                                                CASE WHEN category_id = 73 THEN ROUND(buffer3 / 2, 1) ELSE buffer3 END AS buffer3,
                                                                                `created_at`,
                                                                                `tipe`,
                                                                                `category_id`,
                                                                                `ym` 
                                                                            FROM pos_batik.m_min_stock
                                                                            WHERE SUBSTR(ym, 1, 7) = SUBSTR(CURRENT_DATE, 1, 7)
                                                                        ) b ON b.category_id = dtr2.category_id
                                                            ) dtr3
                                                    ) dtf
                                                GROUP BY category_id, tipe
                                                                                            
                                                UNION ALL
                                                
                                                SELECT 
                                                    category_id,
                                                    category,
                                                    0 AS tipe,
                                                    category AS category_v,
                                                    0 AS bobot,
                                                    ROUND((COALESCE(COUNT(IF(stok_status = 'safe', item_number, NULL)),0) / COUNT(item_number)) * 100) AS stok_aman_p

                                                FROM
                                                    (
                                                        SELECT
                                                            rank,
                                                            tipe,
                                                            item_number,
                                                            `name`,
                                                            category_id,
                                                            category,
                                                            stok_all,
                                                            CASE  
                                                                WHEN first_display IS NULL THEN 'safe'
                                                                WHEN COALESCE(stok_all,0) >= COALESCE(minimum_stock,0) AND (COALESCE(stok_all,0) > 0) THEN 'safe' 
                                                                WHEN COALESCE(stok_all,0) >= COALESCE(minimum_stock,0) AND (COALESCE(sale_month_avg, 0) > 0) THEN 'safe' 
                                                                WHEN COALESCE(stok_all,0) < COALESCE(minimum_stock,0) AND (COALESCE(stok_all,0) > 0 AND COALESCE(sale_month_avg, 0) <= 0)  THEN 'danger' 
                                                            ELSE 'danger'
                                                            END AS stok_status
                                                        FROM
                                                            (
                                                                SELECT
                                                                    rank,
                                                                    dtr2.tipe,
                                                                    item_number,
                                                                    `name`,
                                                                    dtr2.category_id,
                                                                    category,
                                                                    stok_all,
                                                                    sale_month_avg,
                                                                    CASE 
                                                                        WHEN dtr2.tipe = 1 AND dtr2.item_number IN (8997001280871, 8997001290870, 8997001300876, 9230422, 9230423, 9230421, 9230420, 9230419, 9230656, 9230536, 9230068, 9230069, 9230210, 9230159, 9230160, 91932041, 9230495, 9210005, 9210006) THEN COALESCE(buffer1 / 2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 1 THEN COALESCE(buffer1,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 2 AND dtr2.item_number IN (8997001280871, 8997001290870, 8997001300876, 9230422, 9230423, 9230421, 9230420, 9230419, 9230656, 9230536, 9230068, 9230069, 9230210, 9230159, 9230160, 91932041, 9230495, 9210005, 9210006) THEN COALESCE(buffer2 / 2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 2 THEN COALESCE(buffer2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 3 AND dtr2.item_number IN (8997001280871, 8997001290870, 8997001300876, 9230422, 9230423, 9230421, 9230420, 9230419, 9230656, 9230536, 9230068, 9230069, 9230210, 9230159, 9230160, 91932041, 9230495, 9210005, 9210006) THEN COALESCE(buffer3 / 2,0) * COALESCE(sale_month_avg, 0)
                                                                        WHEN dtr2.tipe = 3 THEN COALESCE(buffer3,0) * COALESCE(sale_month_avg, 0)
                                                                    ELSE 0
                                                                    END AS minimum_stock,
                                                                    first_display
                                                                FROM
                                                                    (
                                                                        SELECT
                                                                            rank,
                                                                            CASE 
                                                                                WHEN rank < 101 THEN 1
                                                                                WHEN rank > 100 AND rank < 201 THEN 2
                                                                                WHEN rank > 200 THEN 3
                                                                                ELSE 0
                                                                            END AS tipe,
                                                                            item_number,
                                                                            `name`,
                                                                            category_id,
                                                                            category,
                                                                            stok_all,
                                                                            sale_month_avg,
                                                                            first_display
                                                                        FROM
                                                                            (
                                                                                SELECT
                                                                                    (@rank := if(@rn = category_id, @rank + 1,
                                                                                            if(@rn := category_id, 1, 1)
                                                                                            )
                                                                                    ) AS rank,
                                                                                    dta.item_number,
                                                                                    dta.`name`,
                                                                                    dta.category_id,
                                                                                    category,
                                                                                    stok_all,
                                                                                    sale_month_avg,
                                                                                    first_display
                                                                                FROM
                                                                                    (
                                                                                        SELECT 
                                                                                            a.item_number,
                                                                                            a.`name`,
                                                                                            a.category_id,
                                                                                            c.category,
                                                                                            COALESCE(a.quantity, 0) + COALESCE(a.qty_wh,0) + COALESCE(b.qty, 0) + COALESCE(dtrcvgr.rcv_blm_gr, 0) + COALESCE(scmotw.stok_dis_otw, 0) AS stok_all,
                                                                                            ROUND((COALESCE(sale_month_7,0) + COALESCE(sale_month_6,0) + COALESCE(sale_month_5,0) + COALESCE(sale_month_4,0) + COALESCE(sale_month_3,0) + COALESCE(sale_month_2, 0)) / bulan_display) sale_month_avg,
                                                                                            unit_price, discount, cost_price, cost_price - COALESCE(discount, 0) AS discount_price,
                                                                                            first_display
                                                                                        FROM
                                                                                            pos_batik.m_product a
                                                                                        LEFT JOIN purchasing_crb.t_stock_dis b ON b.id_produk = a.item_number AND b.id_dis IN (1,14)
                                                                                        LEFT JOIN pos_batik.m_category c ON c.id_category = a.category_id
                                                                                        LEFT JOIN purchasing_crb.`user` d ON d.id_user = a.id_pic
                                                                                        LEFT JOIN
                                                                                            (
                                                                                                SELECT
                                                                                                    item_id,
                                                                                                    MIN(created_at) AS first_display, 
                                                                                                    CASE
                                                                                                        WHEN period_diff(date_format(now(), '%Y%m'), date_format(created_at, '%Y%m')) > 6 THEN 6
                                                                                                    ELSE period_diff(date_format(now(), '%Y%m'), date_format(created_at, '%Y%m'))
                                                                                                    END AS bulan_display
                                                                                                FROM pos_batik.t_purchase_item
                                                                                                GROUP BY item_id
                                                                                            ) AS display ON display.item_id = a.item_id
                                                                                        LEFT JOIN
                                                                                            (
                                                                                                SELECT
                                                                                                    h_sales_6m.item_id,
                                                                                                    s6 AS sale_month_7,
                                                                                                    s5 AS sale_month_6,
                                                                                                    s4 AS sale_month_5,
                                                                                                    s3 AS sale_month_4,
                                                                                                    s2 AS sale_month_3,
                                                                                                    s1 AS sale_month_2
                                                                                                FROM pos_batik.h_sales_6m
                                                                                                WHERE periode = SUBSTR(CURRENT_DATE, 1, 7)
                                                                                                GROUP BY h_sales_6m.item_id
                                                                                            ) AS sales ON sales.item_id = a.item_id
                                                                                        LEFT JOIN
                                                                                            (
                                                                                                SELECT * FROM
                                                                                                (
                                                                                                    SELECT
                                                                                                        a.no_po,
                                                                                                        a.id_dis,
                                                                                                        b.id_produk, 
                                                                                                        SUM(COALESCE(b.qty)) AS po_qty,
                                                                                                        SUM(COALESCE ( c.rcv_qty, 0 ) ) AS rcv_qty,
                                                                                                        SUM(COALESCE ( c.rcv_na, 0 ) ) AS rcv_na,
                                                                                                        SUM(COALESCE ( d.gr_qty, 0 )) AS gr_qty,
                                                                                                        SUM(COALESCE ( d.gr_rjt, 0 )) AS gr_rjt,
                                                                                                        CASE
                                                                                                            WHEN (SUM(COALESCE ( c.rcv_qty, 0 ) ) ) - (SUM(COALESCE ( d.gr_qty, 0 )) + SUM(COALESCE ( d.gr_rjt, 0 ))) < 0 THEN 0
                                                                                                        ELSE (SUM(COALESCE ( c.rcv_qty, 0 ) ) ) -  (SUM(COALESCE ( d.gr_qty, 0 )) + SUM(COALESCE ( d.gr_rjt, 0 )))
                                                                                                        END AS rcv_blm_gr
                                                                                                    FROM
                                                                                                        (
                                                                                                            SELECT
                                                                                                                a.no_po,
                                                                                                                a.id_dis
                                                                                                            FROM purchasing_crb.t_purchase_order a
                                                                                                            WHERE a.id_dis IN (1,14) AND `status` = 2
                                                                                                        ) a
                                                                                                    LEFT JOIN
                                                                                                        (
                                                                                                            SELECT
                                                                                                                no_po,
                                                                                                                id_produk,
                                                                                                                qty
                                                                                                            FROM purchasing_crb.t_purchase_order_item
                                                                                                            WHERE `status` IS NULL
                                                                                                            AND kategori IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                                        ) b ON b.no_po = a.no_po
                                                                                                    LEFT JOIN
                                                                                                        (
                                                                                                            SELECT
                                                                                                                no_po,
                                                                                                                id_produk,
                                                                                                                SUM(COALESCE(qty_receive,0)) AS rcv_qty,
                                                                                                                SUM(COALESCE(na_supplier,0)) AS rcv_na 
                                                                                                            FROM purchasing_crb.t_receive_item
                                                                                                            WHERE kategori IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                                            GROUP BY no_po, id_produk
                                                                                                        ) c ON b.no_po = c.no_po AND b.id_produk = c.id_produk
                                                                                                    LEFT JOIN
                                                                                                        (
                                                                                                            SELECT
                                                                                                                t_receive_order.no_po,
                                                                                                                id_produk,
                                                                                                                SUM(COALESCE(qty_gr, 0)) AS gr_qty,
                                                                                                                SUM(COALESCE(reject, 0)) AS gr_rjt
                                                                                                            FROM purchasing_crb.t_good_receive_item 
                                                                                                            LEFT JOIN purchasing_crb.t_receive_order ON t_good_receive_item.no_receive = t_receive_order.no_receive
                                                                                                            WHERE	kategori IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                                            GROUP BY no_po, id_produk
                                                                                                        ) d ON a.no_po = d.no_po AND b.id_produk = d.id_produk
                                                                                                    GROUP BY b.id_produk
                                                                                                ) AS aa
                                                                                            WHERE rcv_blm_gr > 0
                                                                                        ) AS dtrcvgr ON dtrcvgr.id_produk = a.item_number
                                                                                    LEFT JOIN
                                                                                        (
                                                                                            SELECT
                                                                                                t_distribusi.no_dis, 
                                                                                                m_destinasi.id_des,
                                                                                                m_destinasi.destinasi, 
                                                                                                t_distribusi_item.id_produk,
                                                                                                t_distribusi_item.nama_produk,
                                                                                                SUM(COALESCE(t_distribusi_item.qty, 0)) AS stok_dis_otw,
                                                                                                SUBSTR(t_distribusi.created_at,1,10) AS tgl_distribusi,
                                                                                                t_distribusi.keterangan,
                                                                                                SUBSTR(t_distribusi.ceklis_at,1,10) AS tgl_ceklis,
                                                                                                t_distribusi.pic_at,
                                                                                                t_distribusi.pic_wh
                                                                                            FROM purchasing_crb.t_distribusi
                                                                                            LEFT JOIN purchasing_crb.t_distribusi_item ON t_distribusi_item.no_dis = t_distribusi.no_dis
                                                                                            JOIN purchasing_crb.m_destinasi ON m_destinasi.id_des = t_distribusi.destination
                                                                                            LEFT JOIN purchasing_crb.t_wh_receive ON t_distribusi.no_dis = t_wh_receive.no_dis
                                                                                            WHERE SUBSTR(t_distribusi.created_at,1,10) > '2023-04-01'
                                                                                            AND t_wh_receive.no_dis IS NULL AND (t_distribusi.destination IN (1,14))
                                                                                            GROUP BY t_distribusi_item.id_produk
                                                                                        ) AS scmotw ON scmotw.id_produk = a.item_number
                                                                                    WHERE active = 0 
                                                                                    AND SUBSTR(a.item_number, 1, 1) != 'X'
                                                                                    AND SUBSTR(a.item_number, 1, 2) != 'C-'
                                                                                    AND SUBSTR(a.`name`, 1, 3) != 'DP '
                                                                                    AND SUBSTR(a.`name`, 1, 5) != '(Disc'
                                                                                    AND SUBSTR(a.`name`, 1, 5) != 'JAHIT'
                                                                                    AND SUBSTR(a.`name`, 1, 3) != 'CAS'
                                                                                    AND SUBSTR(a.`item_number`, 1, 2) != 'V-'
                                                                                    AND SUBSTR(a.`name`, 1, 4) != 'CKL-'
                                                                                    AND SUBSTR(a.item_number, 1, 4) != 'CKL-'
                                                                                    AND SUBSTR(a.`name`, 1, 4) != 'Demo'
                                                                                    AND SUBSTR(a.`name`, 1, 4) != 'PDL-'
                                                                                    AND SUBSTR(a.item_number, 1, 2) != 'D-'
                                                                                    AND SUBSTR(a.`name`, 1, 5) != 'PROMO '
                                                                                    AND SUBSTR(a.item_number, 1, 3) != 'OP-'
                                                                                    AND SUBSTR(a.`name`, 1, 3) != 'SP '
                                                                                    AND a.NAME != 'LOGO BORDIR' 
                                                                                    AND a.category_id IN (46,63,64,65,66,67,68,78,69,70,71,72,73)
                                                                                ) dta,
                                                                                ( SELECT @rank := 0,
                                                                                        @rn := NULL ) num 
                                                                                ORDER BY category_id, sale_month_avg DESC, dta.item_number
                                                                            ) dtr
                                                                        ) dtr2
                                                                    LEFT JOIN
                                                                        (
                                                                            SELECT 
                                                                                `id`,
                                                                                CASE WHEN category_id = 73 THEN ROUND(buffer1 / 2, 1) ELSE buffer1 END AS buffer1,
                                                                                CASE WHEN category_id = 73 THEN ROUND(buffer2 / 2, 1) ELSE buffer2 END AS buffer2,
                                                                                CASE WHEN category_id = 73 THEN ROUND(buffer3 / 2, 1) ELSE buffer3 END AS buffer3,
                                                                                `created_at`,
                                                                                `tipe`,
                                                                                `category_id`,
                                                                                `ym` 
                                                                            FROM pos_batik.m_min_stock WHERE SUBSTR(ym, 1, 7) = SUBSTR(CURRENT_DATE, 1, 7)
                                                                        ) b ON b.category_id  = dtr2.category_id
                                                                    ) dtr3
                                                                ) dtf
                                                            GROUP BY category_id
                                                        ) dtrss ON dtrss.tipe = nb.tipe AND dtrss.category_id = nb.id_category     
                                            ) dtrs
                                        GROUP BY category_id
                                ) dtfix
                    ) AS a
                    
                UNION ALL

                SELECT
                    a.periode,
                    a.company,
                    a.divisi,
                    a.nama_target,
                    a.target,
                    a.actual
                FROM
                    (
                        SELECT
                            SUBSTR(CURRENT_DATE(),1,7) AS periode,
                            5 AS company,
                            'Produksi' AS divisi,
                            'Leadtime PO' AS nama_target,
                            100 AS target,
                            AVG(x.p_rcv_ontime) AS actual
                        FROM
                            (
                                SELECT
                                    week,
                                    CASE 
                                        WHEN 1 = 1 AND `week` = '01' THEN 'Jan' 
                                        WHEN 1 = 1 AND `week` = '02' THEN 'Feb' 
                                        WHEN 1 = 1 AND `week` = '03' THEN 'Mar' 
                                        WHEN 1 = 1 AND `week` = '04' THEN 'Apr'
                                        WHEN 1 = 1 AND `week` = '05' THEN 'Mei' 
                                        WHEN 1 = 1 AND `week` = '06' THEN 'Jun' 
                                        WHEN 1 = 1 AND `week` = '07' THEN 'Jul' 
                                        WHEN 1 = 1 AND `week` = '08' THEN 'Agu' 
                                        WHEN 1 = 1 AND `week` = '09' THEN 'Sep' 
                                        WHEN 1 = 1 AND `week` = '10' THEN 'Okt' 
                                        WHEN 1 = 1 AND `week` = '11' THEN 'Nov' 
                                        WHEN 1 = 1 AND `week` = '12' THEN 'Des'
                                    ELSE `week`
                                    END AS week2, 
                                    COALESCE(ROUND(SUM(p_rcv_ontime) / (100*COUNT(username)) * 100, 2), '0.00') AS p_rcv_ontime,
                                    COALESCE(ROUND(SUM(p_rcv_late) / (100*COUNT(username)) * 100, 2), '0.00') AS p_rcv_late
                                FROM
                                    (
                                        SELECT
                                            x2.created_by,
                                            x2.username,
                                            x2.`week`,
                                            COALESCE(x2.p_rcv_ontime, '0.00') AS p_rcv_ontime,
                                            COALESCE(x2.p_rcv_late, '0.00') AS p_rcv_late
                                        FROM
                                            (
                                                SELECT
                                                    x.created_by,
                                                    x.username,
                                                    x.`week`,
                                                    x.p_rcv_ontime,
                                                    x.p_rcv_late,
                                                    CASE
                                                        WHEN x.po <= 10 THEN 1
                                                        WHEN x.po >10 AND x.po < 26 THEN 2
                                                        WHEN x.po >25 AND x.po < 51 THEN 3
                                                        WHEN x.po >50 AND x.po < 101 THEN 4
                                                        WHEN x.po >100 THEN 5
                                                    END AS id_bobot
                                                FROM
                                                    (
                                                        SELECT
                                                            t_purchase_order.created_by,
                                                            `user`.employee_name AS username,
                                                            COUNT( IF(SUBSTR(m_supplier_new.supplier,1,7) != 'RETURAN',1,NULL) ) AS po,
                                                            (WEEK(SUBSTR(t_purchase_order.deadline,1, 10), 4) + 1) - WEEK(DATE_SUB(SUBSTR(t_purchase_order.deadline,1, 10), INTERVAL DAYOFMONTH(SUBSTR(t_purchase_order.deadline,1, 10)) - 1 DAY), 4) AS `week`,
                                                            COALESCE(ROUND( (( SUM( IF(DATEDIFF(SUBSTR(rcv.tgl_rcv,1,10),t_purchase_order.deadline) BETWEEN -3 AND 0 AND stt != 'Partial Receive',rcv.qty_receive, 0 ) ) + SUM( IF(DATEDIFF(SUBSTR(rcv.tgl_rcv,1,10),t_purchase_order.deadline) < -3 AND stt != 'Partial Receive',rcv.qty_receive, 0 ) ) ) * 100 ) / (SUM( IF((DATEDIFF(SUBSTR(rcv.tgl_rcv,1,10),t_purchase_order.deadline) IS NOT NULL AND stt != 'Partial Receive') OR (CURRENT_DATE > t_purchase_order.deadline AND stt = 'Partial Receive'),rcv.qty_receive, 0 ) )),2 ), 0) AS p_rcv_ontime,
                                                            ROUND( (SUM( IF(DATEDIFF(SUBSTR(rcv.tgl_rcv,1,10),t_purchase_order.deadline) >= 1 OR (CURRENT_DATE > t_purchase_order.deadline AND stt = 'Partial Receive'),rcv.qty_receive, 0 ) )) / (SUM( IF((DATEDIFF(SUBSTR(rcv.tgl_rcv,1,10),t_purchase_order.deadline) IS NOT NULL AND stt != 'Partial Receive') OR (CURRENT_DATE > t_purchase_order.deadline AND stt = 'Partial Receive'),rcv.qty_receive, 0 ) ))*100,2 ) AS p_rcv_late,
                                                            SUM(if (na!=0, na, 0)) as na,
                                                            '' AS rata2
                                                        FROM
                                                            purchasing_crb.t_purchase_order_item
                                                        JOIN purchasing_crb.t_purchase_order ON t_purchase_order.no_po = t_purchase_order_item.no_po
                                                        JOIN purchasing_crb.m_supplier_new ON m_supplier_new.id_supplier = t_purchase_order.id_supplier
                                                        LEFT JOIN
                                                            (
                                                                SELECT
                                                                    no_po, id_produk, na, qty_receive, qty_po, created_by,
                                                                    CASE 
                                                                        WHEN qty_receive + na >= qty_po THEN 'Receive'
                                                                        WHEN qty_receive > 0 AND qty_receive + na != qty_po THEN 'Partial Receive'
                                                                    ELSE NULL
                                                                    END AS stt,
                                                                    CASE
                                                                        WHEN qty_receive + na >= qty_po THEN tgl_rcv
                                                                        WHEN qty_receive + na < qty_po AND qty_receive > 0 THEN tgl_rcv
                                                                    ELSE NULL
                                                                    END AS tgl_rcv
                                                                FROM
                                                                    (
                                                                        SELECT
                                                                            t_receive_order.no_po,
                                                                            SUBSTR( MAX(t_receive_order.created_at),1,10 ) AS tgl_rcv,
                                                                            t_receive_item.id_produk,
                                                                            qty_receive, na, qty_po,
                                                                            t_receive_order.created_by
                                                                        FROM
                                                                            (
                                                                                SELECT
                                                                                    no_po, id_produk, SUM(qty_receive) AS qty_receive,
                                                                                    COALESCE ( SUM( na_supplier ), 0 ) na, COALESCE ( qty_po, 0 ) AS qty_po
                                                                                    FROM purchasing_crb.t_receive_item GROUP BY no_po, id_produk
                                                                            ) AS t_receive_item
                                                                        JOIN purchasing_crb.t_receive_order ON t_receive_item.no_po = t_receive_order.no_po
                                                                        JOIN purchasing_crb.t_purchase_order ON t_purchase_order.no_po=t_receive_order.no_po
                                                                        JOIN purchasing_crb.t_purchase_request ON t_purchase_order.no_pr = t_purchase_request.no_pr
                                                                        JOIN purchasing_crb.`user` ON `user`.id_user = t_purchase_order.created_by
                                                                        WHERE SUBSTR( t_receive_order.deadline,1,10 ) = SUBSTR(CURRENT_DATE(),1,10)
                                                                        GROUP BY t_receive_order.no_po, t_receive_item.id_produk
                                                                    ) rcv 
                                                            ) AS rcv ON rcv.no_po = t_purchase_order.no_po AND rcv.id_produk = t_purchase_order_item.id_produk
                                                        JOIN purchasing_crb.`user` ON `user`.id_user = t_purchase_order.created_by
                                                        WHERE SUBSTR( t_purchase_order.deadline,1,10 ) = SUBSTR(CURRENT_DATE(),1,10)
                                                        AND t_purchase_order.`status` != 3
                                                        GROUP BY (WEEK(SUBSTR(t_purchase_order.deadline,1, 10), 4) + 1) - WEEK(DATE_SUB(SUBSTR(t_purchase_order.deadline,1, 10), INTERVAL DAYOFMONTH(SUBSTR(t_purchase_order.deadline,1, 10)) - 1 DAY), 4),						
                                                        t_purchase_order.created_by
                                                    ) x
                                                ORDER BY x.created_by, x.`week`
                                            ) x2 
                                            JOIN
                                                (
                                                    SELECT
                                                        id_bobot_repeater, nrcv1,nrcv2,nrcv3,nrcv4,nrcv5,nrcv6,nrcv7,
                                                        bobot1, bobot2, bobot3, bobot4, bobot5, bobot6, bobot7
                                                    FROM purchasing_crb.m_bobot_nrcv
                                                ) AS bobot_nrcv ON bobot_nrcv.id_bobot_repeater = x2.id_bobot
                                            ORDER BY x2.created_by, x2.`week`
                                    ) getgrafikp
                                WHERE week != 13
                                GROUP BY week
                            ) AS x
                    ) AS a
            ");

    $v_ops = array();
    while ($data = mysqli_fetch_array($query_ops)) {
        $v_ops[] = $data; //v_ops dijadikan array 
    }
    
    // var_dump($v_ops);

    foreach ($v_ops as $ops)
    {

        $sum_trx    = $ops['sum_trx'];
        $sale       = $ops['sale'];
        $sale_trx   = $ops['sale_trx'];
        
        $tgt_sale   = $ops['tgt_sale'];
        $tgt_basket = $ops['tgt_basket'];
        $tgt_trx    = $ops['tgt_trx'];
        
        $m_sale     = $ops['m_sale'];
        $m_tgt_sale = $ops['m_tgt_sale'];

        echo 'sum_trx : '.$sum_trx;
        echo '<br>';
        echo 'sale : '.$sale;
        echo '<br>';
        echo 'sale_trx : '.$sale_trx;
        echo '<br>';
        echo 'tgt_sale : '.$tgt_sale;
        echo '<br>';
        echo 'tgt_basket : '.$tgt_basket;
        echo '<br>';
        echo 'tgt_trx : '.$tgt_trx;
        echo '<br>';
        echo 'm_sale : '.$m_sale;
        echo '<br>';
        echo 'm_tgt_sale : '.$m_tgt_sale;
        echo '<br>';
        echo '--------';
        echo '<br>';

        $query 			= "INSERT INTO `hris`.`grd_m_target`(`periode`, `company`, `divisi`, `nama_target`, `target`, `actual`, `created_at`, `created_by`) VALUES ('$periode', '$company', '$divisi', '$nama_target', '$target', '$actual', '$created_at', '$created_by')";

        $sql 			= mysqli_query($conn, $query);

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
