<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard_review_system extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->db_hris = $this->load->database('hris', TRUE); // Load database hris
    }

    // Ticket per Divisi
    function dt_ticket_perdivisi($periode)
    {
        $query = "SELECT 
                    dep.department_name AS divisi,
                    com.`name` AS company,
                    COUNT(tt.id_task) AS total_pengajuan, 
                    SUM(CASE WHEN tt.status = 1 THEN 1 ELSE 0 END) AS total_notstarted,
                    SUM(CASE WHEN tt.status = 5 THEN 1 ELSE 0 END) AS total_workingon,
                    SUM(CASE WHEN tt.status = 12 THEN 1 ELSE 0 END) AS total_uat,
                    SUM(CASE WHEN tt.status = 3 THEN 1 ELSE 0 END) AS total_done,
                    SUM(CASE WHEN tt.status = 4 THEN 1 ELSE 0 END) AS total_cancel,
                    SUM(CASE WHEN tt.status = 7 THEN 1 ELSE 0 END) AS total_hold,
                    SUM(CASE WHEN tt.status = 8 THEN 1 ELSE 0 END) AS total_waitinglist,
                    SUM(CASE WHEN tt.status = 3 THEN 1 ELSE 0 END) + SUM(CASE WHEN tt.status = 12 THEN 1 ELSE 0 END) + SUM(CASE WHEN tt.status = 5 THEN 1 ELSE 0 END) AS total_progres
                FROM
                    ticket_task tt
                    JOIN xin_employees emp ON tt.created_by = emp.user_id
                    JOIN xin_departments dep ON dep.department_id = emp.department_id
                    JOIN xin_companies com ON com.company_id = dep.company_id
                WHERE
                    (DATE(tt.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01'))
                    OR (tt.due_date BETWEEN '$periode-01' AND LAST_DAY('$periode-01') AND tt.type IN (1,2))
                GROUP BY dep.department_id, dep.department_name, com.name";

        return $this->db->query($query)->result();
    }

    // Statistik Progres Tiket
    function get_pencapaian_progres_tiket($periode)
    {
        $query = "SELECT 
                    '$periode' AS periode,
                    COUNT(tt.id_task) AS total_tiket,
                    SUM(CASE WHEN tt.status IN(3, 12) THEN 1 ELSE 0 END) AS total_done,
                    ROUND( ( SUM(CASE WHEN tt.status IN(3, 12) THEN 1 ELSE 0 END) / COUNT(tt.id_task) ) * 100, 2 ) AS persen_done,
                    SUM(CASE WHEN tt.status = 5 THEN 1 END) AS total_onprogress,
                    ROUND(SUM(CASE WHEN tt.status = 5 THEN 1 END) / COUNT(tt.id_task) * 100, 2) AS persen_onprogress
                FROM
                    ticket_task tt
                    JOIN xin_employees emp ON tt.created_by = emp.user_id
                    JOIN xin_departments dep ON dep.department_id = emp.department_id
                    JOIN xin_companies com ON com.company_id = dep.company_id
                WHERE
                    (DATE(tt.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01'))
                    OR (tt.due_date BETWEEN '$periode-01' AND LAST_DAY('$periode-01') AND tt.type IN (1,2))";

        return $this->db->query($query)->row();
    }

    // Tracking System Error : Resume
    function get_tracking_system_error($periode)
    {
        $query = "SELECT
                    COUNT(
                    IF
                    ( id_category = 2, id_category, NULL )) eror,
                    COUNT(
                    IF
                    ( id_category = 6, id_category, NULL )) bug,
                    COUNT( id_category ) total,
                    COUNT(
                    IF
                    ( (id_category = 2 OR id_category = 6) AND id_status = 3, id_category, NULL )) total_solved,
                    ROUND(
                        COUNT(IF( (id_category = 2 OR id_category = 6) AND id_status = 3, id_category, NULL )) /
                        COUNT( id_category )
                    , 2) * 100 AS persen_solved
                FROM
                    (
                    SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        DATE_FORMAT( t.created_at, '%d %b %y' ) AS tgl_dibuat,
                        COALESCE ( DATE_FORMAT( t.START, '%d %b %y' ), '' ) AS tgl_diproses,
                        SUBSTR( t.created_at, 12, 5 ) AS jam_dibuat,
                        CONCAT( em.first_name, ' ', em.last_name ) AS owner_name,
                        GROUP_CONCAT(
                        DISTINCT CONCAT( ' ', e.first_name, ' ', e.last_name )) AS pic,
                        t.progress,
                        COALESCE ( SUBSTR( t.START, 1, 10 ), '' ) AS START,
                    COALESCE ( SUBSTR( t.END, 1, 10 ), '' ) AS 
                    END,
                    t.type AS id_type,
                    t.category AS id_category,
                    c.category,
                    o.object,
                    s.STATUS,
                    s.id AS id_status,
                    pic AS id_pic,
                    e.user_id 
                FROM
                    ticket_task t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN ticket_type ty ON ty.id = t.type
                    LEFT JOIN ticket_category c ON c.id = t.category
                    LEFT JOIN ticket_object o ON o.id = t.object
                    LEFT JOIN ticket_status s ON s.id = t.`status`
                    LEFT JOIN ticket_priority p ON p.id = t.priority 
                WHERE
                    t.category IN ( 2, 6 ) 
                    AND t.STATUS != 4 
                    AND ( SUBSTR( t.`end`, 1, 7 ) = '$periode' OR SUBSTR( t.due_date, 1, 7 ) = '$periode' ) 
                GROUP BY
                    t.id_task 
                ORDER BY
                    t.category 
                    ) dt";

        return $this->db->query($query)->row();
    }

    // Tracking System Error : Detail List
    function get_list_ticket_error($periode)
    {
        $query = "SELECT
                    t.task AS bug_error,
                    CONCAT( em.first_name, ' ', em.last_name ) AS `user`,
                    o.object,
                    s.`status`,
                    l.level,
                    pic AS id_pic,
                    GROUP_CONCAT(
                        DISTINCT CONCAT( ' ', e.first_name, ' ', e.last_name )) AS pic,
                    t.created_at,
                    p.priority
                FROM
                    ticket_task t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN ticket_type ty ON ty.id = t.type
                    LEFT JOIN ticket_category c ON c.id = t.category
                    LEFT JOIN ticket_object o ON o.id = t.object
                    LEFT JOIN ticket_status s ON s.id = t.`status`
                    LEFT JOIN ticket_priority p ON p.id = t.priority
                    LEFT JOIN ticket_level l ON l.id = t.level 
                WHERE
                    t.category IN ( 2, 6 ) 
                    -- t.category IN ( 2, 3, 6 ) 
                    AND t.STATUS != 4 
                    AND ( SUBSTR( t.`end`, 1, 7 ) = '$periode' OR SUBSTR( t.due_date, 1, 7 ) = '$periode' ) 
                GROUP BY
                    t.id_task 
                ORDER BY
                    t.category";

        return $this->db->query($query)->result();
    }

    // Resume Ticket by PIC
    function get_resume_ticket_by_pic($periode)
    {
        $query = "SELECT 
                    CONCAT(pic.first_name, ' ', pic.last_name) AS pic,
                    COUNT(tt.id_task) AS total_ticket,
                    COALESCE(SUM(CASE WHEN tt.status = 3 THEN 1 END), 0) AS ticket_done,
                    COALESCE(
                        ROUND(
                            (SUM(CASE WHEN tt.status = 3 THEN 1 END) / COUNT(tt.id_task)) * 100,
                            1
                        )
                    , 0) AS persen_done,

                    -- Ticket Done On-Time
                    SUM(
                        CASE 
                            WHEN tt.status = 3 AND substr(tt.done_date, 1, 10) <= tt.due_date 
                            THEN 1 
                        END
                    ) AS ticket_done_ontime,

                    -- Persentase Leadtime
                    COALESCE(
                        ROUND(
                            (SUM(
                                CASE 
                                    WHEN tt.status = 3 AND substr(tt.done_date, 1, 10) <= tt.due_date 
                                    THEN 1 
                                END
                            ) / NULLIF(SUM(CASE WHEN tt.status = 3 THEN 1 END), 0)) * 100,
                            1
                        )
                    , 0) AS persen_leadtime

                FROM ticket_task tt
                JOIN xin_employees pic 
                    ON tt.pic = pic.user_id
                WHERE
                    pic.department_id = 68
                    -- AND pic.is_active = 1
                    AND (DATE(tt.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01'))
                    OR (tt.due_date BETWEEN '$periode-01' AND LAST_DAY('$periode-01') AND tt.type IN (1,2))
                GROUP BY pic.user_id";

        return $this->db->query($query)->result();
    }

    // Traffic System Overview
    function resume_traffic_system_overview($periode)
    {
        $query = "SELECT
                     'All Divisi' AS divisi,
                     COUNT(*) AS jumlah_sistem,
                     SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
                     ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
                 -- 	COUNT( * ) AS jml_traffic_all,
                     COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
                     ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
                     COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
                     ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
                     COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
                     ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
                 FROM (
                     SELECT 
                         m.*,
                         h.jumlah_traffic,
                         CASE 
                             WHEN jumlah_traffic >= 1000 THEN 'Sering'
                             WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
                             ELSE 'Jarang' 
                         END AS kategori_traffic
                     FROM
                         rsp_project_live.m_menu_rsp m
                         LEFT JOIN(
                             SELECT 
                                 menu,title,link, COUNT(id) AS jumlah_traffic 
                             FROM 
                                 rsp_project_live.history_menu 
                             WHERE
                                 DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
                         ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
                 ) sq_traffic";

        return $this->db->query($query)->result();
    }

     function dt_traffic_system_overview($periode)
    {
        $query = "SELECT
                    divisi,
                    COUNT(*) AS jumlah_sistem,
                    SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
                    ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
                    -- 	COUNT( * ) AS jml_traffic_all,
                    COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
                    ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
                    COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
                    ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
                    COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
                    ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
                FROM (
                    SELECT 
                        m.*,
                        h.jumlah_traffic,
                        CASE 
                            WHEN jumlah_traffic >= 1000 THEN 'Sering'
                            WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
                            ELSE 'Jarang' 
                        END AS kategori_traffic
                    FROM
                        rsp_project_live.m_menu_rsp m
                        LEFT JOIN(
                            SELECT 
                                menu,title,link, COUNT(id) AS jumlah_traffic 
                            FROM 
                                rsp_project_live.history_menu 
                            WHERE
                                DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
                        ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
                ) sq_traffic
                WHERE
	                divisi IS NOT NULL
                GROUP BY divisi";

        return $this->db->query($query)->result();
    }

    // function get_list_traffic_system_overview($periode)
    // {
    //     $query = "SELECT
    //                 divisi,
    //                 COUNT(*) AS jumlah_sistem,
    //                 SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
    //                 ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
    //                 -- 	COUNT( * ) AS jml_traffic_all,
    //                 COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
    //                 COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
    //                 COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
    //             FROM (
    //                 SELECT 
    //                     m.*,
    //                     h.jumlah_traffic,
    //                     CASE 
    //                         WHEN jumlah_traffic >= 1000 THEN 'Sering'
    //                         WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
    //                         ELSE 'Jarang' 
    //                     END AS kategori_traffic
    //                 FROM
    //                     rsp_project_live.m_menu_rsp m
    //                     LEFT JOIN(
    //                         SELECT 
    //                             menu,title,link, COUNT(id) AS jumlah_traffic 
    //                         FROM 
    //                             rsp_project_live.history_menu 
    //                         WHERE
    //                             DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
    //                     ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
    //             ) sq_traffic
    //             WHERE
	//                 divisi IS NOT NULL
    //             GROUP BY divisi

    //             UNION ALL

    //             SELECT
    //                 'All Divisi' AS divisi,
    //                 COUNT(*) AS jumlah_sistem,
    //                 SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) AS jumlah_sistem_digunakan,
    //                 ROUND( SUM( CASE WHEN jumlah_traffic IS NOT NULL THEN 1 END ) / COUNT(*) * 100, 2 ) AS persen_sistem_digunakan,
    //             -- 	COUNT( * ) AS jml_traffic_all,
    //                 COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) AS jml_traffic_sering,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Sering', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_sering,
    //                 COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) AS jml_traffic_jarang,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Jarang', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_jarang,
    //                 COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) AS jml_traffic_tidak_digunakan,
    //                 ROUND( COUNT( IF(kategori_traffic = 'Tidak digunakan', 1, NULL) ) / COUNT(*) * 100, 2 ) AS p_traffic_tidak_digunakan
    //             FROM (
    //                 SELECT 
    //                     m.*,
    //                     h.jumlah_traffic,
    //                     CASE 
    //                         WHEN jumlah_traffic >= 1000 THEN 'Sering'
    //                         WHEN jumlah_traffic IS NULL THEN 'Tidak digunakan'
    //                         ELSE 'Jarang' 
    //                     END AS kategori_traffic
    //                 FROM
    //                     rsp_project_live.m_menu_rsp m
    //                     LEFT JOIN(
    //                         SELECT 
    //                             menu,title,link, COUNT(id) AS jumlah_traffic 
    //                         FROM 
    //                             rsp_project_live.history_menu 
    //                         WHERE
    //                             DATE(accessed_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01') GROUP BY menu,title,link
    //                     ) AS h ON h.menu = m.menu AND h.title = m.title AND h.link = m.link
    //             ) sq_traffic";

    //     return $this->db->query($query)->result();
    // }

    // Progress Review System
    function resume_progress_review_system($periode)
    {
        $query = "SELECT
                    COUNT(*) AS jumlah_sistem,
                    sq_sdh_review.jml_sistem_sudah_direview,
                    ROUND(sq_sdh_review.jml_sistem_sudah_direview / COUNT(*) * 100, 2) AS persen_progres_review,
                    sq_sdh_sesuai.jml_sistem_sudah_sesuai AS sudah_sesuai,
                    sq_tdk_sesuai.jml_sistem_tidak_sesuai + sq_krg_sesuai.jml_sistem_kurang_sesuai AS tidak_sesuai,
                    ROUND(sq_sdh_sesuai.jml_sistem_sudah_sesuai / sq_sdh_review.jml_sistem_sudah_direview * 100) AS persen_sesuai,
                    
                    sq_kepuasan.jml_sudah_puas,
                    ROUND(sq_kepuasan.jml_sudah_puas / sq_sdh_review.jml_sistem_sudah_direview * 100)  AS persen_kepuasan
                FROM
                    review_m_navigation
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_sudah_direview
                        FROM (
                            SELECT
                                id_navigation
                            FROM
                                review_t_menu_item 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_sdh_review ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_sudah_sesuai
                        FROM (
                            SELECT
                                id_navigation, kesesuaian_aplikasi
                            FROM
                                review_t_menu_item
                            WHERE kesesuaian_aplikasi = 'Sesuai' 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_sdh_sesuai ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_tidak_sesuai
                        FROM (
                            SELECT
                                id_navigation, kesesuaian_aplikasi
                            FROM
                                review_t_menu_item
                            WHERE kesesuaian_aplikasi = 'Tidak Sesuai' 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_tdk_sesuai ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sistem_kurang_sesuai
                        FROM (
                            SELECT
                                id_navigation, kesesuaian_aplikasi
                            FROM
                                review_t_menu_item
                            WHERE kesesuaian_aplikasi = 'Kurang Sesuai' 
                            GROUP BY
                                id_navigation
                        ) AS nav
                    ) AS sq_krg_sesuai ON 1 = 1
                    
                    LEFT JOIN (
                        SELECT
                            COUNT(*) AS jml_sudah_puas
                        FROM (
                            SELECT * FROM review_t_menu_item WHERE kepuasan_aplikasi IN(5,4) GROUP BY id_navigation
                        ) AS puas
                    ) AS sq_kepuasan ON 1 = 1";

        return $this->db->query($query)->row();
    }
    
    function dt_system_reviewed($periode)
    {
        $query = "SELECT
                    menu
                FROM (
                    SELECT 
                        link, m.menu, m.sub_menu, m.sub_sub_menu
                    FROM 
                        review_t_menu_item t
                        JOIN review_m_navigation m ON m.id = t.id_navigation
                    GROUP BY id_navigation
                    ORDER BY id_navigation ASC
                ) list_reviewed
                GROUP BY menu";

        return $this->db->query($query)->result();
    }

    function dt_system_not_reviewed($periode)
    {
        $query = "SELECT 
                    menu
                FROM (
                    SELECT menu FROM review_m_navigation GROUP BY menu
                ) sq
                WHERE menu NOT IN (
                    SELECT
                        menu
                    FROM (
                        SELECT 
                            link, m.menu, m.sub_menu, m.sub_sub_menu
                        FROM 
                            review_t_menu_item t
                            JOIN review_m_navigation m ON m.id = t.id_navigation
                        GROUP BY id_navigation
                        ORDER BY id_navigation ASC
                    ) list_reviewed
                    GROUP BY menu
                )";

        return $this->db->query($query)->result();
    }

    function list_kepuasan_pengguna($periode)
    {
        $query = "SELECT CASE 
                    WHEN q.question = 'Saya merasa navigasi dan antarmuka (UI) aplikasi mudah digunakan.' THEN 'UI'
                    WHEN q.question = 'Kecepatan dan stabilitas kinerja aplikasi memuaskan.' THEN 'Kecepatan'
                    WHEN q.question = 'Data yang dihasilkan dari aplikasi akurat' THEN 'Akurasi'
                    WHEN q.question = 'Apakah aplikasi yang ada saat ini sesuai dengan kebutuhan pekerjaan saat ini?' THEN 'Kesesuaian kebutuhan pekerjaan'
                    WHEN q.question = 'Seberapa efektif sistem saat ini dalam meningkatkan produktivitas dan efisiensi pekerjaan Anda?' THEN 'Produktivitas'
                    WHEN q.question = 'Bagaimana Anda menilai kemampuan divisi IT dalam menyediakan solusi yang inovatif dan efisien?' THEN 'Efisien'
                    WHEN q.question = 'Seberapa puas Anda dengan penggunaan aplikasi secara keseluruhan?' THEN 'Rating'
                END AS jenis_pertanyaan,
                SUM(ai.bobot) AS total_bobot, COUNT(ai.bobot) AS jumlah_data,
                ROUND(SUM(ai.bobot) / COUNT(ai.bobot), 2) AS rata_rata
                FROM qna_answer_item ai
                JOIN qna_answer qa ON qa.id_answer = ai.id_answer
                JOIN qna_m_question_item q ON q.id_question_item = ai.id_question_item
                WHERE DATE(qa.created_at) BETWEEN '$periode-01' AND LAST_DAY('$periode-01')
                AND q.question IN (
                    'Saya merasa navigasi dan antarmuka (UI) aplikasi mudah digunakan.',
                    'Kecepatan dan stabilitas kinerja aplikasi memuaskan.',
                    'Data yang dihasilkan dari aplikasi akurat',
                    'Apakah aplikasi yang ada saat ini sesuai dengan kebutuhan pekerjaan saat ini?',
                    'Seberapa efektif sistem saat ini dalam meningkatkan produktivitas dan efisiensi pekerjaan Anda?',
                    'Bagaimana Anda menilai kemampuan divisi IT dalam menyediakan solusi yang inovatif dan efisien?',
                    'Seberapa puas Anda dengan penggunaan aplikasi secara keseluruhan?'
                )
                GROUP BY jenis_pertanyaan";

        return $this->db->query($query)->result();
    }

}
