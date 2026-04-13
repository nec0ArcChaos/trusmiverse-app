<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_refreshment extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function list_onboarding($periode){
        $query = "WITH 
                AllSales AS (
                    SELECT
                        mkt.id_user,
                        mkt.username,
                        mkt.employee_name,
                        gm.id_gm,
                        gm.employee_name AS head,
                        CASE 
                            WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) >= 12 THEN 5
                            WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 4
                            WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 3
                            WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 2
                            ELSE 1
                        END AS id_usia
                    FROM
                        `user` mkt
                        LEFT JOIN `user` gm ON mkt.id_gm = gm.id_user
                        LEFT JOIN hris.xin_employees emp ON emp.user_id = mkt.join_hr
                    WHERE
                        emp.date_of_joining IS NOT NULL 
                        AND gm.id_user IS NOT NULL
                        AND emp.is_active = 1
                        AND emp.designation_id IN (731, 1690, 926)
                ),
                BookingData AS (
                    SELECT
                        id_gci,
                        id_user,
                        id_gm
                    FROM
                        t_gci
                    WHERE
                        id_kategori in (3,4)
                        AND LEFT(created_at, 7) = '2026-03'
                ),
                -- Jadikan query utama sebelumnya sebagai CTE bernama ResultAchieve
                ResultAchieve AS (
                    SELECT
                        s.id_user,
                        s.username,
                        s.employee_name,
                        mtu.booking AS target,
                        COUNT(b.id_user) AS actual,
                        COALESCE(ROUND((COUNT(b.id_user) / mtu.booking) * 100, 2), 0) AS achieve
                    FROM
                        AllSales s
                        LEFT JOIN BookingData b ON s.id_user = b.id_user
                        LEFT JOIN m_target_usia mtu ON mtu.id = s.id_usia
                    GROUP BY
                        s.id_user,
                        s.username,
                        s.employee_name,
                        mtu.booking
                    HAVING 
                        achieve < 75
                )
            -- Terakhir, hitung total baris dari CTE ResultAchieve
            SELECT 
                COUNT(*) AS total_underperform 
            FROM 
                ResultAchieve;";
        return $this->db->query($query)->result();
    }
    public function resume($periode) {
    $query = "SELECT 
            -- 1. Total seluruh materi di bulan tersebut
            COUNT(DISTINCT mat.id) AS jumlah_materi,
            
            -- 2. Prepare
            COUNT(DISTINCT CASE 
                    WHEN mat.pic_approval IS NOT NULL AND mat.pic_approval != '' AND mat.status_approval IS NULL 
                    THEN mat.id 
            END) AS prepare,
            
            -- 3. Approved
            COUNT(DISTINCT CASE 
                    WHEN mat.status_approval = '1' 
                    THEN mat.id 
            END) AS approved,
            
            -- 4. Implement
            COUNT(DISTINCT CASE 
                    WHEN ws.status = 'Plan' 
                    THEN mat.id 
            END) AS implement,
            
            -- 5. Complete
            COUNT(DISTINCT CASE 
                    WHEN ws.status = 'Terlaksana' 
                    THEN mat.id 
            END) AS complete,
            
            -- 6. Total Underperform (Subquery Pengganti WITH)
            (
                SELECT COUNT(*) 
                FROM (
                    SELECT 
                        s.id_user,
                        COALESCE(ROUND((COUNT(b.id_user) / mtu.booking) * 100, 2), 0) AS achieve
                    FROM (
                        -- Subquery AllSales
                        SELECT 
                            mkt.id_user,
                            CASE 
                                WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) >= 12 THEN 5
                                WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 4
                                WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 3
                                WHEN TIMESTAMPDIFF(MONTH, emp.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 2
                                ELSE 1
                            END AS id_usia
                        FROM rsp_project_live.user mkt
                        LEFT JOIN rsp_project_live.user gm ON mkt.id_gm = gm.id_user
                        LEFT JOIN hris.xin_employees emp ON emp.user_id = mkt.join_hr
                        WHERE emp.date_of_joining IS NOT NULL 
                          AND gm.id_user IS NOT NULL
                          AND emp.is_active = 1
                          AND emp.designation_id IN (731, 1690, 926)
                    ) s
                    LEFT JOIN (
                        -- Subquery BookingData
                        SELECT id_user
                        FROM rsp_project_live.t_gci
                        WHERE id_kategori IN (3,4) 
                          AND LEFT(created_at, 7) = '$periode'
                    ) b ON s.id_user = b.id_user
                    LEFT JOIN rsp_project_live.m_target_usia mtu ON mtu.id = s.id_usia
                    GROUP BY 
                        s.id_user, 
                        mtu.booking
                    HAVING 
                        achieve < 75
                ) AS ResultAchieve
            ) AS total_under
            
        FROM
            hris.trusmi_materi_training mat
            LEFT JOIN hris.workshop_task ws ON ws.title_id = mat.id
        WHERE 
            LEFT(mat.created_at, 7) = '$periode';
    ";
    
    return $this->db->query($query)->row_object();
}
    public function upcoming($periode){
        $query = "SELECT
                ws.workshop_id,
                typ.`name` AS tipe,
                dep.department_name AS department_name,
                GROUP_CONCAT(DISTINCT pdes.designation_name) AS designation,
                GROUP_CONCAT(DISTINCT prol.role_name) AS role,
                ws.title_name,
                ws.workshop_place,
                ws.workshop_at,
                ws.workshop_time,
                -- To avoid duplication issues, count the distinct items in the set or use a subquery/calculation as shown previously
                (LENGTH(ws.participant_plan) - LENGTH(REPLACE(ws.participant_plan, ',', '')) + 1) AS plan_peserta,
                (LENGTH(ws.participant_actual) - LENGTH(REPLACE(ws.participant_actual, ',', '')) + 1) AS actual_peserta,
                CONCAT('https://trusmiverse.com/apps/uploads/workshop/', ws.documentation) AS documentation,
                ws.commitment,
                CONCAT(trai.first_name, ' ', trai.last_name) AS trainer

                FROM
                `workshop_task` ws
                JOIN workshop_type typ ON typ.type_id = ws.type_id
                LEFT JOIN xin_departments dep ON dep.department_id = ws.department_id
                LEFT JOIN xin_employees pst ON FIND_IN_SET(pst.user_id, ws.participant_plan) > 0
                LEFT JOIN xin_designations pdes ON pdes.designation_id = pst.designation_id
                LEFT JOIN xin_user_roles prol ON prol.role_id = pst.user_role_id
                LEFT JOIN xin_employees trai ON trai.user_id = ws.trainer_id
                WHERE
                LEFT(ws.created_at, 7) = '$periode'
                GROUP BY
                ws.workshop_id";
        return $this->db->query($query)->result();
    }
    function data_monitoring($periode){
        $query = "WITH 
                    -- 1. Aggregate Pretest and Posttest scores per workshop
                    TestScores AS (
                        SELECT 
                            pre.id_training,
                            ws.workshop_id,
                            -- Average of pretest scores. CAST to ensure numeric calculation if stored as string.
                            AVG(CAST(NULLIF(pre.nilai_pretest, '') AS DECIMAL(10,2))) AS avg_pretest,
                            
                            -- Average of the MAXIMUM posttest score per employee. 
                            -- Assuming the final score is the highest among posttest, posttest2, posttest3.
                            AVG(
                                GREATEST(
                                    COALESCE(CAST(NULLIF(pre.nilai_posttest, '') AS DECIMAL(10,2)), 0),
                                    COALESCE(CAST(NULLIF(pre.nilai_posttest2, '') AS DECIMAL(10,2)), 0),
                                    COALESCE(CAST(NULLIF(pre.nilai_posttest3, '') AS DECIMAL(10,2)), 0)
                                )
                            ) AS avg_posttest
                        FROM trusmi_pretest pre
                        -- Join to workshop_task to link tests to specific workshops if possible. 
                        -- Based on your schema, trusmi_pretest has a workshop_id column.
                        JOIN workshop_task ws ON pre.workshop_id = ws.workshop_id
                        GROUP BY ws.workshop_id, pre.id_training
                    ),
                    
                    -- 2. Aggregate Feedback Ratings from trusmi_feedback_training
                    FeedbackTrusmi AS (
                        SELECT 
                            pre.workshop_id,
                            AVG(CAST(NULLIF(fed.rating, '') AS DECIMAL(10,2))) AS avg_rating_trusmi
                        FROM trusmi_feedback_training fed
                        JOIN trusmi_pretest pre ON fed.id_test = pre.id_test
                        GROUP BY pre.workshop_id
                    ),

                    -- 3. Aggregate Feedback Ratings from workshop_feedback_training
                    FeedbackWorkshop AS (
                        SELECT 
                            wsfed.workshop_id,
                            AVG(CAST(NULLIF(wsfed.rating, '') AS DECIMAL(10,2))) AS avg_rating_workshop
                        FROM workshop_feedback_training wsfed
                        GROUP BY wsfed.workshop_id
                    )

                SELECT
                ws.workshop_id,
                typ.`name` AS tipe,
                'In Class Training' AS metode_training,
                'In Class Training' AS metode_training,
                'Internal Training' AS training_kategori,
                dep.department_name AS department_name,
                GROUP_CONCAT(DISTINCT pdes.designation_name) AS designation,
                GROUP_CONCAT(DISTINCT prol.role_name) AS role,
                ws.title_name,
                ws.workshop_place,
                CASE WHEN ws.workshop_at < CURDATE() THEN 'Plan'
                WHEN ws.workshop_at = CURDATE() THEN 'Progres'
                WHEN ws.workshop_at > CURDATE() THEN 'Done'
                 ELSE 'N/A' END AS status,
                ws.workshop_at,
                ws.workshop_time,
                -- MIN(mat.created_at) AS actual_workshop_at,
                ws.workshop_end,
                
                -- To avoid duplication issues, count the distinct items in the set or use a subquery/calculation as shown previously
                (LENGTH(ws.participant_plan) - LENGTH(REPLACE(ws.participant_plan, ',', '')) + 1) AS plan_peserta,
                (LENGTH(ws.participant_actual) - LENGTH(REPLACE(ws.participant_actual, ',', '')) + 1) AS actual_peserta,
                
                CONCAT('https://trusmiverse.com/apps/uploads/workshop/',ws.documentation) AS documentation,
                ws.commitment,
                CONCAT(trai.first_name,' ',trai.last_name) AS trainer,
                ws.trainer_name,
                mat.training,
                mat.objective,
                mat.outline,
                mat.waktu,
                
                -- Formatted Average Scores
                COALESCE(ROUND(ts.avg_pretest, 2), 0) AS avg_pretest,
                COALESCE(ROUND(ts.avg_posttest, 2), 0) AS avg_posttest,
                COALESCE(ROUND(ft.avg_rating_trusmi, 2), 0) AS avg_rating_trusmi,
                COALESCE(ROUND(fw.avg_rating_workshop, 2), 0) AS avg_rating_workshop

                FROM
                `workshop_task` ws
                JOIN workshop_type typ ON typ.type_id = ws.type_id
                LEFT JOIN xin_departments dep ON dep.department_id = ws.department_id
                LEFT JOIN xin_employees pst ON FIND_IN_SET(pst.user_id, ws.participant_plan) > 0
                LEFT JOIN xin_designations pdes ON pdes.designation_id = pst.designation_id
                LEFT JOIN xin_user_roles prol ON prol.role_id = pst.user_role_id
                LEFT JOIN xin_employees trai ON trai.user_id = ws.trainer_id
                LEFT JOIN trusmi_materi_training mat ON mat.id = ws.title_id
                
                -- Join the aggregated subqueries
                LEFT JOIN TestScores ts ON ts.workshop_id = ws.workshop_id
                LEFT JOIN FeedbackTrusmi ft ON ft.workshop_id = ws.workshop_id
                LEFT JOIN FeedbackWorkshop fw ON fw.workshop_id = ws.workshop_id

                WHERE LEFT(ws.created_at, 7) = '$periode'
                GROUP BY 
                ws.workshop_id";
        return $this->db->query($query)->result();
    }

}
