<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_lock extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->database();
    }

    function get_list_eaf_lock_apv($id_user)
    {

        $id_user = $this->session->userdata('user_id');
        if (
            $this->session->userdata('user_id') == 1 
            || $_SESSION['user_id'] == 1161             
        ){
            $kondisi = "";
        }else {
            $kondisi = "WHERE id_hr = '$id_user'";
        }



        $query = $this->db->query("SELECT * FROM (SELECT
                'Approve EAF' AS tipe,
                approval.created_by AS created_by,
                usr_hr.user_id AS id_hr,
                usr_hr.NAME AS `name`,
                approval.jumlah AS jumlah,
                approval.id AS id,
                trusmi_m_lock.status_lock AS status_lock,
                -- trusmi_m_lock.warning_lock AS warning_lock
                CONCAT(
                    'Anda belum melakukan approve pengajuan EAF (',
                        TRIM(BOTH ',' FROM list_pengajuan),
                    
                    ')') AS warning_lock
            FROM
                ( SELECT e_eaf.e_jenis_biaya.id_user_approval AS id_user_approval FROM e_eaf.e_jenis_biaya GROUP BY e_eaf.e_jenis_biaya.id_user_approval ) usr_approval
                LEFT JOIN ( SELECT emp.user_id AS user_id, concat( emp.first_name, ' ', emp.last_name ) AS NAME FROM xin_employees emp ) usr_hr ON usr_hr.user_id = usr_approval.id_user_approval
                LEFT JOIN (
                SELECT
                    e_approval.id_user_approval AS created_by,
                    e_eaf.e_pengajuan.id_pengajuan AS id_pengajuan,
                    sum(
                    IF
                        (((
                                    timestampdiff(
                                        HOUR,
                                        COALESCE ( appr_ver.update_approve, e_eaf.e_pengajuan.tgl_input ),
                                        now()) - COALESCE ((
                                        SELECT
                                            ( count( y.tgl ) * 24 ) AS total 
                                        FROM
                                            (
                                            SELECT
                                                x.acara AS acara,
                                                x.tgl AS tgl 
                                            FROM
                                                (
                                                SELECT
                                                    trusmi_weekend.weekend_name AS acara,
                                                    trusmi_weekend.weekend_date AS tgl 
                                                FROM
                                                    trusmi_weekend 
                                                WHERE
                                                    ((
                                                            trusmi_weekend.weekend_name = 'Sunday' 
                                                            ) 
                                                        AND (
                                                        LEFT ( trusmi_weekend.weekend_date, 4 ) = LEFT ( curdate(), 4 ))) UNION ALL
                                                SELECT
                                                    xin_holidays.event_name AS event_name,
                                                    xin_holidays.start_date AS start_date 
                                                FROM
                                                    xin_holidays 
                                                WHERE
                                                    (
                                                    LEFT ( xin_holidays.start_date, 4 ) = CONVERT ( LEFT ( curdate(), 4 ) USING utf8mb3 ))) x 
                                            GROUP BY
                                                x.tgl 
                                            ) y 
                                        WHERE
                                            (
                                                y.tgl BETWEEN cast( COALESCE ( appr_ver.update_approve, e_eaf.e_pengajuan.tgl_input ) AS DATE ) 
                                            AND curdate())),
                                        0 
                                    )) > 24 
                                ),
                            1,
                            0 
                        )) AS jumlah,
                    GROUP_CONCAT(
                        IF
                            (((
                                        timestampdiff(
                                            HOUR,
                                            COALESCE ( appr_ver.update_approve, e_eaf.e_pengajuan.tgl_input ),
                                            now()) - COALESCE ((
                                            SELECT
                                                ( count( y.tgl ) * 24 ) AS total 
                                            FROM
                                                (
                                                SELECT
                                                    x.acara AS acara,
                                                    x.tgl AS tgl 
                                                FROM
                                                    (
                                                    SELECT
                                                        trusmi_weekend.weekend_name AS acara,
                                                        trusmi_weekend.weekend_date AS tgl 
                                                    FROM
                                                        trusmi_weekend 
                                                    WHERE
                                                        ((
                                                                trusmi_weekend.weekend_name = 'Sunday' 
                                                                ) 
                                                            AND (
                                                            LEFT ( trusmi_weekend.weekend_date, 4 ) = LEFT ( curdate(), 4 ))) UNION ALL
                                                    SELECT
                                                        xin_holidays.event_name AS event_name,
                                                        xin_holidays.start_date AS start_date 
                                                    FROM
                                                        xin_holidays 
                                                    WHERE
                                                        (
                                                        LEFT ( xin_holidays.start_date, 4 ) = CONVERT ( LEFT ( curdate(), 4 ) USING utf8mb3 ))) x 
                                                GROUP BY
                                                    x.tgl 
                                                ) y 
                                            WHERE
                                                (
                                                    y.tgl BETWEEN cast( COALESCE ( appr_ver.update_approve, e_eaf.e_pengajuan.tgl_input ) AS DATE ) 
                                                AND curdate())),
                                            0 
                                        )) > 24 
                                    ),
                                e_pengajuan.id_pengajuan,
                                '' 
                            )) AS list_pengajuan,
                    5 AS id 
                FROM
                    e_eaf.e_pengajuan
                    JOIN (
                    SELECT
                        e_eaf.e_approval.id_approval AS id_approval,
                        e_eaf.e_approval.id_pengajuan AS id_pengajuan,
                        e_eaf.e_approval.id_user_approval AS id_user_approval,
                        e_eaf.e_approval.STATUS AS STATUS,
                        e_eaf.e_approval.update_approve AS update_approve,
                        e_eaf.e_approval.id_user AS id_user 
                    FROM
                        e_eaf.e_approval 
                    WHERE
                        e_eaf.e_approval.LEVEL = 1 
                        AND e_eaf.e_approval.STATUS IS NULL 
                        AND e_eaf.e_approval.id_user_approval IS NOT NULL 
                    ORDER BY
                        e_eaf.e_approval.id_pengajuan DESC 
                    ) e_approval ON e_approval.id_pengajuan = e_eaf.e_pengajuan.id_pengajuan
                    LEFT JOIN (
                    SELECT
                        e_eaf.e_approval.id_approval AS id_approval,
                        e_eaf.e_approval.id_pengajuan AS id_pengajuan,
                        e_eaf.e_approval.id_user_approval AS id_user_approval,
                        e_eaf.e_approval.STATUS AS STATUS,
                        e_eaf.e_approval.update_approve AS update_approve,
                        e_eaf.e_approval.id_user AS id_user 
                    FROM
                        e_eaf.e_approval 
                    WHERE
                        e_eaf.e_approval.LEVEL = 10 
                        AND e_eaf.e_approval.STATUS = 'Approve' 
                    ) appr_ver ON appr_ver.id_pengajuan = e_eaf.e_pengajuan.id_pengajuan 
                WHERE
                    e_eaf.e_pengajuan.STATUS = 1 
                GROUP BY
                    e_approval.id_user_approval 
                    ) approval ON ((
                        approval.created_by = usr_approval.id_user_approval 
                    ))
                LEFT JOIN trusmi_m_lock ON ((
                        trusmi_m_lock.id_lock = approval.id 
                    ))
                LEFT JOIN xin_attendance_time atd ON (((
                            atd.employee_id = usr_approval.id_user_approval 
                            ) 
                        AND (
                        atd.attendance_date = curdate()))) 
            WHERE
                ((
                        approval.jumlah > 0 
                    ) 
                AND ( atd.attendance_date IS NOT NULL )) ) dt $kondisi");

        $data['data'] = $query->result();
        return $data;
    }

    function get_list_eaf_lock_verif($id_user)
    {

        $id_user = $this->session->userdata('user_id');
        if (
            $this->session->userdata('user_id') == 1 
            || $_SESSION['user_id'] == 1161             
        ) {
            $kondisi = "";
        } else {
                $kondisi = "WHERE id_hr = '$id_user'";
        }



        $query = $this->db->query("SELECT * FROM (SELECT
                    'Verifikasi EAF' AS tipe,
                    approval.created_by AS created_by,
                    usr_approval.id_user_verified AS id_hr,
                    usr_hr.NAME AS NAME,
                    approval.jumlah AS jumlah,
                    approval.id AS id,
                    trusmi_m_lock.status_lock AS status_lock,
                    trusmi_m_lock.warning_lock AS warning_lock 
                FROM
                    ((
                                SELECT
                                    e_eaf.e_jenis_biaya.id_user_verified AS id_user_verified 
                                FROM
                                    e_eaf.e_jenis_biaya 
                                WHERE
                                    e_eaf.e_jenis_biaya.id_user_verified IS NOT NULL 
                                GROUP BY
                                    e_eaf.e_jenis_biaya.id_user_verified UNION
                                SELECT
                                    296 AS id_user_verified UNION
                                SELECT
                                    78 AS id_user_verified 
                                    ) usr_approval
                                JOIN ( SELECT emp.user_id AS user_id, concat( emp.first_name, ' ', emp.last_name ) AS NAME FROM xin_employees emp ) usr_hr ON usr_hr.user_id = usr_approval.id_user_verified
                                LEFT JOIN (
                                SELECT
                                    e_approval.id_user_approval AS created_by,
                                    sum(
                                    IF
                                        (((
                                                    timestampdiff(
                                                        HOUR,
                                                        e_pengajuan.tgl_input,
                                                        now()) - COALESCE ((
                                                        SELECT
                                                            ( count( y.tgl ) * 24 ) AS total 
                                                        FROM
                                                            (
                                                            SELECT
                                                                x.acara AS acara,
                                                                x.tgl AS tgl 
                                                            FROM
                                                                (
                                                                SELECT
                                                                    trusmi_weekend.weekend_name AS acara,
                                                                    trusmi_weekend.weekend_date AS tgl 
                                                                FROM
                                                                    trusmi_weekend 
                                                                WHERE
                                                                    ((
                                                                            trusmi_weekend.weekend_name = 'Sunday' 
                                                                            ) 
                                                                        AND (
                                                                        LEFT ( trusmi_weekend.weekend_date, 4 ) = LEFT ( curdate(), 4 ))) UNION ALL
                                                                SELECT
                                                                    xin_holidays.event_name AS event_name,
                                                                    xin_holidays.start_date AS start_date 
                                                                FROM
                                                                    xin_holidays 
                                                                WHERE
                                                                    (
                                                                    LEFT ( xin_holidays.start_date, 4 ) = CONVERT ( LEFT ( curdate(), 4 ) USING utf8mb3 ))) x 
                                                            GROUP BY
                                                                x.tgl 
                                                            ) y 
                                                        WHERE
                                                            (
                                                                y.tgl BETWEEN cast( e_pengajuan.tgl_input AS DATE ) 
                                                            AND curdate())),
                                                        0 
                                                    )) > 48 
                                                ),
                                            1,
                                            0 
                                        )) AS jumlah,
                                    124 AS id 
                                FROM
                                    e_eaf.e_pengajuan
                                    LEFT JOIN (
                                    SELECT
                                        e_eaf.e_approval.id_approval AS id_approval,
                                        e_eaf.e_approval.id_pengajuan AS id_pengajuan,
                                        e_eaf.e_approval.id_user_approval AS id_user_approval,
                                        e_eaf.e_approval.STATUS AS STATUS,
                                        e_eaf.e_approval.update_approve AS update_approve,
                                        e_eaf.e_approval.id_user AS id_user 
                                    FROM
                                        e_eaf.e_approval 
                                    WHERE
                                        e_eaf.e_approval.`level` = 10 
                                        AND e_eaf.e_approval.STATUS IS NULL 
                                    ) e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan 
                                WHERE
                                    e_pengajuan.`status` = 10 
                                GROUP BY
                                    e_approval.id_user_approval 
                                    
                -- 					UNION ALL
                -- 				admin pajak  cindy1987						
                -- 						 UNION ALL
                -- 				pengeluaran  karnila2410
                                ) approval ON approval.created_by = usr_hr.user_id 
                                    
                            LEFT JOIN trusmi_m_lock ON 
                                    trusmi_m_lock.id_lock = approval.id 
                                
                        LEFT JOIN xin_attendance_time atd ON 
                                    atd.employee_id = usr_hr.user_id
                                    
                                AND 
                                atd.attendance_date = curdate()) 
                WHERE
                    
                            approval.jumlah > 0 
                        
                    AND atd.attendance_date IS NOT NULL ) dt $kondisi");

        $data['data'] = $query->result();
        return $data;
    }


    function get_list_eaf_lock_lpj1($id_user)
    {

        $id_user = $this->session->userdata('user_id');
        if (
            $this->session->userdata('user_id') == 1 
            || $_SESSION['user_id'] == 1161             
        ) {
            $kondisi = "";
        } else {
                $kondisi = "WHERE id_hr = '$id_user'";
        }



        $query = $this->db->query("SELECT * FROM (SELECT
                    'LPJ EAF' AS tipe,
                    lpj.created_by AS created_by,
                    lpj.id_hr AS id_hr,
                    lpj.name AS name,
                    lpj.jumlah AS jumlah,
                    lpj.id AS id,
                    lpj.status_lock AS status_lock,
                    concat( lpj.warning_lock, ' (', lpj.list_eaf, ')' ) AS warning_lock 
                FROM
                    ((
                        SELECT
			aju.id_user AS created_by,
			aju.pengaju AS id_hr,
			concat( usr.first_name, ' ', usr.last_name ) AS name,
			sum((
				CASE
						
						WHEN ((
								aju.id_sub_biaya = 711 
								) 
							AND ( aju.leave_id <> 0 )) THEN
						IF
							(((
										timestampdiff(
											HOUR,
											concat( lv.to_date, ' ', lv.end_time ),
											now()) - COALESCE ((
											SELECT
												( count( y.tgl ) * 24 ) AS total 
											FROM
												(
												SELECT
													x.acara AS acara,
													x.tgl AS tgl 
												FROM
													(
													SELECT
														trusmi_weekend.weekend_name AS acara,
														trusmi_weekend.weekend_date AS tgl 
													FROM
														trusmi_weekend 
													WHERE
														((
																trusmi_weekend.weekend_name = 'Sunday' 
																) 
															AND (
															LEFT ( trusmi_weekend.weekend_date, 4 ) = LEFT ( curdate(), 4 ))) UNION ALL
													SELECT
														xin_holidays.event_name AS event_name,
														xin_holidays.start_date AS start_date 
													FROM
														xin_holidays 
													WHERE
														(
														LEFT ( xin_holidays.start_date, 4 ) = CONVERT ( LEFT ( curdate(), 4 ) USING utf8mb3 ))) x 
												GROUP BY
													x.tgl 
												) y 
											WHERE
												(
													y.tgl BETWEEN lv.to_date 
												AND curdate())),
											0 
										)) > 24 
									),
								1,
								0 
							) ELSE
						IF
							(((
										timestampdiff(
											HOUR,
											apr.update_approve,
											now()) - COALESCE ((
											SELECT
												( count( y.tgl ) * 24 ) AS total 
											FROM
												(
												SELECT
													x.acara AS acara,
													x.tgl AS tgl 
												FROM
													(
													SELECT
														trusmi_weekend.weekend_name AS acara,
														trusmi_weekend.weekend_date AS tgl 
													FROM
														trusmi_weekend 
													WHERE
														((
																trusmi_weekend.weekend_name = 'Sunday' 
																) 
															AND (
															LEFT ( trusmi_weekend.weekend_date, 4 ) = LEFT ( curdate(), 4 ))) UNION ALL
													SELECT
														xin_holidays.event_name AS event_name,
														xin_holidays.start_date AS start_date 
													FROM
														xin_holidays 
													WHERE
														(
														LEFT ( xin_holidays.start_date, 4 ) = CONVERT ( LEFT ( curdate(), 4 ) USING utf8mb3 ))) x 
												GROUP BY
													x.tgl 
												) y 
											WHERE
												(
													y.tgl BETWEEN cast( apr.update_approve AS DATE ) 
												AND curdate())),
											0 
										)) > 48 
									),
								1,
								0 
							) 
						END 
						)) AS jumlah,
					group_concat((
						CASE
								
								WHEN ((
										aju.id_sub_biaya = 711 
										) 
									AND ( aju.leave_id <> 0 )) THEN
								IF
									(((
												timestampdiff(
													HOUR,
													concat( lv.to_date, ' ', lv.end_time ),
													now()) - COALESCE ((
													SELECT
														( count( y.tgl ) * 24 ) AS total 
													FROM
														(
														SELECT
															x.acara AS acara,
															x.tgl AS tgl 
														FROM
															(
															SELECT
																trusmi_weekend.weekend_name AS acara,
																trusmi_weekend.weekend_date AS tgl 
															FROM
																trusmi_weekend 
															WHERE
																((
																		trusmi_weekend.weekend_name = 'Sunday' 
																		) 
																	AND (
																	LEFT ( trusmi_weekend.weekend_date, 4 ) = LEFT ( curdate(), 4 ))) UNION ALL
															SELECT
																xin_holidays.event_name AS event_name,
																xin_holidays.start_date AS start_date 
															FROM
																xin_holidays 
															WHERE
																(
																LEFT ( xin_holidays.start_date, 4 ) = CONVERT ( LEFT ( curdate(), 4 ) USING utf8mb3 ))) x 
														GROUP BY
															x.tgl 
														) y 
													WHERE
														(
															y.tgl BETWEEN lv.to_date 
														AND curdate())),
													0 
												)) > 24 
											),
										aju.id_pengajuan,
									NULL 
									) ELSE
								IF
									(((
												timestampdiff(
													HOUR,
													apr.update_approve,
													now()) - COALESCE ((
													SELECT
														( count( y.tgl ) * 24 ) AS total 
													FROM
														(
														SELECT
															x.acara AS acara,
															x.tgl AS tgl 
														FROM
															(
															SELECT
																trusmi_weekend.weekend_name AS acara,
																trusmi_weekend.weekend_date AS tgl 
															FROM
																trusmi_weekend 
															WHERE
																((
																		trusmi_weekend.weekend_name = 'Sunday' 
																		) 
																	AND (
																	LEFT ( trusmi_weekend.weekend_date, 4 ) = LEFT ( curdate(), 4 ))) UNION ALL
															SELECT
																xin_holidays.event_name AS event_name,
																xin_holidays.start_date AS start_date 
															FROM
																xin_holidays 
															WHERE
																(
																LEFT ( xin_holidays.start_date, 4 ) = CONVERT ( LEFT ( curdate(), 4 ) USING utf8mb3 ))) x 
														GROUP BY
															x.tgl 
														) y 
													WHERE
														(
															y.tgl BETWEEN cast( apr.update_approve AS DATE ) 
														AND curdate())),
													0 
												)) > 48 
											),
										aju.id_pengajuan,
									NULL 
									) 
								END 
								) SEPARATOR ',' 
							) AS list_eaf,
							6 AS id,
							locked.status_lock AS status_lock,
							locked.warning_lock AS warning_lock,
							aju.id_pengajuan AS id_pengajuan,
							aju.leave_id AS leave_id,
							aju.id_sub_biaya AS id_sub_biaya 
						FROM
							((((
											e_eaf.e_pengajuan aju
											JOIN e_eaf.e_approval apr ON (((
														apr.id_pengajuan = aju.id_pengajuan 
														) 
													AND ( apr.id_user_approval = 1709 ) 
												AND ( apr.level = 5 ))))
										LEFT JOIN xin_employees usr ON ((
												usr.user_id = aju.pengaju 
											)))
									JOIN trusmi_m_lock locked ON ((
											locked.id_lock = 6 
										)))
								LEFT JOIN xin_leave_applications lv ON ((
										lv.leave_id = aju.leave_id 
									))) 
						WHERE
							((
									aju.status = 3 
									) 
								AND ((
										aju.temp IS NULL 
										) 
								OR ( LEFT ( aju.temp, 3 ) <> 'LPJ' )) 
							AND ( aju.id_kategori = 18 )) 
						GROUP BY
							aju.pengaju 
							) lpj
						LEFT JOIN xin_attendance_time atd ON (((
									atd.employee_id = lpj.id_hr 
									) 
								AND (
								atd.attendance_date = curdate())))) 
				WHERE
					((
							lpj.jumlah > 0 
							) 
					AND ( atd.attendance_date IS NOT NULL )) 
                    ) dt $kondisi");

        $data['data'] = $query->result();
        return $data;
    }


    function get_list_eaf_lock_lpj2($id_user)
    {

        $id_user = $this->session->userdata('user_id');
        if (
            $this->session->userdata('user_id') == 1 
            || $_SESSION['user_id'] == 1161             
        ) {
            $kondisi = "";
        } else {
                $kondisi = "WHERE id_hr = '$id_user'";
        }



        $query = $this->db->query("SELECT * FROM (SELECT
                            'LPJ Kedua' AS tipe,
                            lpj.id_user AS created_by,
                            aju.pengaju AS id_hr,
                            concat( em.first_name, ' ', em.last_name ) AS name,
                            count( aju.pengaju ) AS jumlah,
                            locked.id_lock AS id,
                            locked.status_lock AS status_lock,
														GROUP_CONCAT(aju.temp) AS list,
                            -- locked.warning_lock AS warning_lock 
                            CONCAT(locked.warning_lock ,' ', GROUP_CONCAT(aju.temp)) AS warning_lock 
                        FROM
                            
                                        e_eaf.e_pengajuan lpj
                                        JOIN e_eaf.e_pengajuan aju ON 
                                                aju.temp = lpj.id_pengajuan 
                                            
                                    JOIN xin_employees em ON 
                                            em.user_id = aju.pengaju 
                                        
                                JOIN trusmi_m_lock locked ON 
                                        locked.id_lock = 66 
                                    
                        WHERE
                            
                                    lpj.status = 6 
                                    
                                AND ( aju.lpj_pertama IS NOT NULL ) 
                                AND ( aju.temp IS NOT NULL ) 
                            AND ( HOUR ( curtime()) > 12 )
                        GROUP BY
                            aju.pengaju
                            
                           
            ) dt $kondisi");

        $data['data'] = $query->result();
        return $data;
    }


    
}