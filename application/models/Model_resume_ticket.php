<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_resume_ticket extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // function dt_resume_tiket_dev_done($pic)
    // {
    //     $sql = "SELECT
    //                 emp.user_id,
    //                 CONCAT(emp.first_name, ' ', emp.last_name) AS employee_name,
    //                 COUNT(id_task) AS total_dev_done
    //             FROM
    //                 ticket_task
    //                 JOIN xin_employees emp ON ticket_task.pic = emp.user_id 
    //             WHERE
    //                 pic LIKE '%$pic%'
    //                 AND type = 1
    //                 AND category IN (9,10,11,12,13,14,15,49,50,64)
    //                 AND `status` = 3
    //                 AND development IS NULL";
    //     return $this->db->query($sql)->row();
    // }

    function dt_resume_tiket($group_pic, $start = "2024-12-23", $end = "2024-12-23")
    {
        $sql = "WITH SplitTask AS (
                    -- Pecah kolom `pic` menjadi baris per user_id
                    SELECT
                            ticket_task.id_task,
                            TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(ticket_task.pic, ',', numbers.n), ',', -1)) AS user_id,
                            ticket_task.category,
                            ticket_task.type,
                            ticket_task.status,
                            ticket_task.development,
                            ticket_task.created_at,
							ticket_task.due_date
                    FROM 
                            (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) numbers -- Sesuaikan jumlah dengan maksimal user_id per row
                    CROSS JOIN ticket_task
                    WHERE numbers.n <= 1 + LENGTH(ticket_task.pic) - LENGTH(REPLACE(ticket_task.pic, ',', ''))
            ),
            -- Tiket Dev Komit
            DevKomitTarget AS (
                    -- Target Tiket Komit Development
                    SELECT
                            user_id,
                            COUNT(id_task) AS total_target_komit
                    FROM SplitTask
                    WHERE type = 1
        -- 			AND category IN (9,10,11,12,13,14,15,49,50,64)
                    AND development IS NOT NULL
                    AND (
                        DATE(created_at) BETWEEN '$start' AND '$end' OR (DATE(due_date) BETWEEN '$start' AND '$end')
                    )
                    GROUP BY user_id
            ),
            DevKomitActual AS (
                    -- Actual/Done Tiket Komit Development
                    SELECT
                            user_id,
                            COUNT(id_task) AS total_actual_komit
                    FROM SplitTask
                    WHERE type = 1
                    AND `status` = 3
                    AND development IS NOT NULL
                    AND (
                       DATE(created_at) BETWEEN '$start' AND '$end' OR (DATE(due_date) BETWEEN '$start' AND '$end')
                    )
                    GROUP BY user_id
            ),
        
            -- Tiket dev dan tiket biasa	
            DevDone AS (
                    -- Tiket Development yang Done
                    SELECT
                            user_id,
                            COUNT(id_task) AS total_dev_done
                    FROM SplitTask
                    WHERE type = 1
                    AND category IN (9,10,11,12,13,14,15,49,50,64)
                    AND status = 3
                    AND development IS NULL
                    AND (
                       DATE(created_at) BETWEEN '$start' AND '$end' OR (DATE(due_date) BETWEEN '$start' AND '$end')
                    )
                    GROUP BY user_id
            ),
            NonDevDone AS (
                    -- Tiket Non Development yang Done
                    SELECT
                            user_id,
                            COUNT(id_task) AS total_tiket_done
                    FROM SplitTask
                    WHERE type = 1
                    AND category IN (1,2,3,4,5,6,7,8,16,17,18,48)
                    AND status = 3
                    AND development IS NULL
                    AND (
                       DATE(created_at) BETWEEN '$start' AND '$end' OR (DATE(due_date) BETWEEN '$start' AND '$end')
                    )
                    GROUP BY user_id
            ),
            Undone AS (
                    -- Tiket All yang Undone
                    SELECT
                            user_id,
                            COUNT(id_task) AS total_all_tiket_undone
                    FROM SplitTask
                    WHERE type = 1
                    AND status != 3 AND status != 4
                    AND development IS NULL
                    AND (
                        DATE(created_at) BETWEEN '$start' AND '$end' OR (DATE(due_date) BETWEEN '$start' AND '$end')
                    )
                    GROUP BY user_id
            )
            -- Gabungkan hasilnya
            SELECT 
                    emp.user_id,
                    emp.profile_picture,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS employee_name,
                    xin_designations.designation_name AS jabatan,
                    -- Tiket Dev Komit
                    COALESCE(dev_komit_target.total_target_komit, 0) AS total_target_komit,
                    COALESCE(dev_komit_actual.total_actual_komit, 0) AS total_actual_komit,
                    -- Achievement Komit
                    CASE
                            WHEN COALESCE(dev_komit_target.total_target_komit, 0) = 0 THEN 0
                            ELSE ROUND((COALESCE(dev_komit_actual.total_actual_komit, 0) / COALESCE(dev_komit_target.total_target_komit, 0)) * 100, 2)
                    END AS achievement_komit,
                    -- Tiket dev dan tiket biasa	
                    COALESCE(dev_done.total_dev_done, 0) AS total_dev_done,
                    COALESCE(non_dev_done.total_tiket_done, 0) AS total_tiket_done,
                    COALESCE(undone.total_all_tiket_undone, 0) AS total_all_tiket_undone
            FROM xin_employees emp
            LEFT JOIN xin_designations ON emp.designation_id = xin_designations.designation_id
            -- Tiket Dev Komit
            LEFT JOIN DevKomitTarget dev_komit_target ON emp.user_id = dev_komit_target.user_id
            LEFT JOIN DevKomitActual dev_komit_actual ON emp.user_id = dev_komit_actual.user_id
            -- Tiket dev dan tiket biasa	
            LEFT JOIN DevDone dev_done ON emp.user_id = dev_done.user_id
            LEFT JOIN NonDevDone non_dev_done ON emp.user_id = non_dev_done.user_id
            LEFT JOIN Undone undone ON emp.user_id = undone.user_id
            WHERE
                emp.designation_id IN (307,308,309,886,1167)
                AND emp.is_active = 1
                AND emp.user_id IN ($group_pic)
                AND emp.user_id NOT IN (1,4121)";

        return $this->db->query($sql)->result();
    }
} // End of class
