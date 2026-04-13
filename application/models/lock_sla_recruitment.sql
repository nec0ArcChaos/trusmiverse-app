-- ============================================================================
-- LOCK SLA RECRUITMENT - STORED PROCEDURES
-- ============================================================================
-- Database    : hris
-- Author      : julia
-- Description : Kumpulan stored procedure untuk mekanisme LOCK berdasarkan
--               SLA (Service Level Agreement) pada setiap tahap proses
--               recruitment. Lock diaktifkan jika SLA terlewati dan waktu
--               sudah lewat jam 13:00 WIB.
--
-- RECRUITMENT JOURNEY (5 Steps):
--   Step 1: Approval HR         (id_lock=343) → FPK menunggu approval HR
--   Step 2: Posting              (id_lock=344) → FPK sudah approved, belum diposting
--   Step 3: Screening CV         (id_lock=345) → Ada pelamar baru, belum di-screening
--   Step 4: Interview HR         (id_lock=346) → Kandidat lolos screening, menunggu interview HR
--   Step 5: Interview User/Fbk   (id_lock=347) → Kandidat sudah interview HR, menunggu feedback user
--
-- FILTER DOCUMENTATION (berlaku di semua procedure):
-- ┌──────────────────────────────────────────────────────────────────────────┐
-- │ FILTER                  │ KETERANGAN                                    │
-- ├──────────────────────────────────────────────────────────────────────────┤
-- │ dp.company_id != 3      │ Exclude PT TKB (company_id = 3)              │
-- │ CURTIME() > '13:00:00'  │ Lock hanya aktif setelah jam 13:00 WIB       │
-- │ sla.is_active = 1       │ Hanya SLA yang aktif                         │
-- │ m_lock.is_active = 1    │ Hanya konfigurasi lock yang aktif             │
-- │ MONTH/YEAR filter       │ Data hanya bulan & tahun berjalan             │
-- │ DATEDIFF > sla.sla_days │ SLA sudah terlewati (hari kerja > batas)     │
-- │ e.user_id = p_user_id   │ Filter berdasarkan user yang sedang dicek    │
-- └──────────────────────────────────────────────────────────────────────────┘
--
-- FILTER SPESIFIK PER STEP:
-- ┌──────────────────────────────────────────────────────────────────────────┐
-- │ STEP              │ STATUS │ TANGGAL ACUAN     │ KONDISI TAMBAHAN       │
-- ├──────────────────────────────────────────────────────────────────────────┤
-- │ approval_hr       │ jb.status=2  │ jb.verified_at    │ FIND_IN_SET user di  │
-- │                   │              │ (First Lvl Appr)  │ trusmi_m_lock.usr_id │
-- │                   │              │                   │ + verified_at NOT NULL│
-- ├──────────────────────────────────────────────────────────────────────────┤
-- │ posting           │ jb.status=4  │ jb.approved_at    │ NOT EXISTS job posting│
-- │                   │              │ (HR Approval)     │ di xin_jobs           │
-- ├──────────────────────────────────────────────────────────────────────────┤
-- │ screening_cv      │ jb.status=4  │ ja.created_at     │ ja.application_status │
-- │                   │              │ (pelamar masuk)   │ = 0 (belum diproses)  │
-- ├──────────────────────────────────────────────────────────────────────────┤
-- │ interview_hr      │ (any)        │ COALESCE(         │ ja.application_status │
-- │                   │              │  manual_screening  │ IN (1,10) = lolos     │
-- │                   │              │  _at, updated_at)  │ screening             │
-- ├──────────────────────────────────────────────────────────────────────────┤
-- │ interview_user_   │ jb.status=4  │ COALESCE(         │ ja.application_status │
-- │ feedback          │              │  update_interview  │ = 3 + status_interview│
-- │                   │              │  _hr_at,updated_at)│ IS NULL (no feedback) │
-- └──────────────────────────────────────────────────────────────────────────┘
-- ============================================================================


-- ============================================================================
-- STEP 1: APPROVAL HR (id_lock = 343)
-- ============================================================================
-- Cek apakah HR (p_user_id) memiliki FPK yang sudah First Level Approval
-- (status=2) tapi belum di-approve HR, dan SLA sudah terlewati.
-- PIC: HR user yang terdaftar di trusmi_m_lock.usr_id
-- Tanggal acuan SLA: jb.verified_at (tanggal First Level Approval)
-- ============================================================================

CREATE DEFINER=`julia`@`%` PROCEDURE `hris`.`lock_sla_recruitment_approval_hr`(IN p_user_id INT)
BEGIN
    SELECT
        jb.job_id                                       AS no_fpk,
        e.user_id                                       AS created_by,
        e.user_id                                       AS id_hr,
        CONCAT(e.first_name, ' ', e.last_name)          AS username,
        COUNT(jb.job_id)                                AS jumlah,
        m_lock.id_lock                                  AS id_lock,
        m_lock.status_lock                              AS status_lock,
        m_lock.warning_lock                             AS warning_lock
    FROM trusmi_jobs_request jb
    -- [JOIN] Department untuk filter company
    INNER JOIN xin_departments dp
        ON dp.department_id = jb.department_id
    -- [JOIN] Employee = HR user yang sedang dicek
    INNER JOIN xin_employees e
        ON e.user_id = p_user_id
    -- [JOIN] Role untuk mapping SLA per posisi
    INNER JOIN xin_user_roles ur
        ON ur.role_id = jb.position_id
    -- [JOIN] SLA config untuk step 'approval_hr'
    INNER JOIN trusmi_m_sla_recruitment sla
        ON sla.step_code = 'approval_hr'
        AND sla.role_id = ur.role_id
        AND sla.is_active = 1
    -- [JOIN] Lock config (id_lock=343) + daftar usr_id yang terdaftar
    INNER JOIN (
        SELECT id_lock, status_lock, warning_lock, usr_id
        FROM trusmi_m_lock
        WHERE id_lock = 343 AND is_active = 1
    ) m_lock
        ON m_lock.id_lock = 343
    WHERE
        -- FILTER 1: Exclude company TKB
        dp.company_id != 3

        -- FILTER 2: User harus terdaftar sebagai HR Approval di m_lock.usr_id
        AND FIND_IN_SET(p_user_id, m_lock.usr_id) > 0

        -- FILTER 3: FPK sudah First Level Approval (status=2), menunggu HR
        AND jb.status = 2
        AND jb.verified_at IS NOT NULL

        -- FILTER 4: SLA terlewati → hari sejak First Level Approval > batas SLA
        AND DATEDIFF(CURDATE(), DATE(jb.verified_at)) > sla.sla_days

        -- FILTER 5: Lock hanya aktif setelah jam 13:00 WIB
        AND CURTIME() > '13:00:00'

        -- FILTER 6: Data hanya bulan & tahun berjalan (berdasarkan verified_at)
        AND MONTH(jb.verified_at) = MONTH(CURDATE())
        AND YEAR(jb.verified_at) = YEAR(CURDATE())

        -- FILTER 7: Data hanya bulan & tahun berjalan (berdasarkan created_at)
        AND MONTH(jb.created_at) = MONTH(CURDATE())
        AND YEAR(jb.created_at) = YEAR(CURDATE())
    GROUP BY
        e.user_id;
END;


-- ============================================================================
-- STEP 2: POSTING (id_lock = 344)
-- ============================================================================
-- Cek apakah TA Recruiter (p_user_id = jb.pic) memiliki FPK yang sudah
-- diapprove HR (status=4) tapi belum ada job posting, dan SLA terlewati.
-- PIC: TA Recruiter (jb.pic)
-- Tanggal acuan SLA: jb.approved_at (tanggal HR Approval)
-- ============================================================================

CREATE DEFINER=`julia`@`%` PROCEDURE `hris`.`lock_sla_recruitment_posting`(IN p_user_id INT)
BEGIN
    SELECT
        jb.job_id                                       AS no_fpk,
        e.user_id                                       AS created_by,
        e.user_id                                       AS id_hr,
        CONCAT(e.first_name, ' ', e.last_name)          AS username,
        COUNT(jb.job_id)                                AS jumlah,
        m_lock.id_lock                                  AS id_lock,
        m_lock.status_lock                              AS status_lock,
        m_lock.warning_lock                             AS warning_lock
    FROM trusmi_jobs_request jb
    -- [JOIN] Department untuk filter company
    INNER JOIN xin_departments dp
        ON dp.department_id = jb.department_id
    -- [JOIN] Employee = TA Recruiter (PIC)
    INNER JOIN xin_employees e
        ON e.user_id = jb.pic
    -- [JOIN] Role untuk mapping SLA per posisi
    INNER JOIN xin_user_roles ur
        ON ur.role_id = jb.position_id
    -- [JOIN] SLA config untuk step 'posting'
    INNER JOIN trusmi_m_sla_recruitment sla
        ON sla.step_code = 'posting'
        AND sla.role_id = ur.role_id
        AND sla.is_active = 1
    -- [JOIN] Lock config (id_lock=344)
    INNER JOIN (
        SELECT id_lock, status_lock, warning_lock
        FROM trusmi_m_lock
        WHERE id_lock = 344 AND is_active = 1
    ) m_lock
        ON m_lock.id_lock = 344
    WHERE
        -- FILTER 1: Hanya untuk user (TA Recruiter) yang sedang dicek
        e.user_id = p_user_id

        -- FILTER 2: Exclude company TKB
        AND dp.company_id != 3

        -- FILTER 3: FPK sudah diapprove HR (status=4)
        AND jb.status = 4
        AND jb.approved_at IS NOT NULL

        -- FILTER 4: Belum ada job posting untuk FPK ini
        AND NOT EXISTS (
            SELECT 1
            FROM xin_jobs xj
            WHERE xj.reff_job_id = jb.job_id
        )

        -- FILTER 5: SLA terlewati → hari sejak HR Approval > batas SLA
        AND DATEDIFF(CURDATE(), DATE(jb.approved_at)) > sla.sla_days

        -- FILTER 6: Lock hanya aktif setelah jam 13:00 WIB
        AND CURTIME() > '13:00:00'

        -- FILTER 7: Data hanya bulan & tahun berjalan (berdasarkan approved_at)
        AND MONTH(jb.approved_at) = MONTH(CURDATE())
        AND YEAR(jb.approved_at) = YEAR(CURDATE())
    GROUP BY
        e.user_id;
END;


-- ============================================================================
-- STEP 3: SCREENING CV (id_lock = 345)
-- ============================================================================
-- Cek apakah TA Recruiter (p_user_id = jb.pic) memiliki pelamar yang
-- sudah masuk (application_status=0) tapi belum di-screening, dan SLA terlewati.
-- PIC: TA Recruiter (jb.pic)
-- Tanggal acuan SLA: ja.created_at (tanggal pelamar masuk/apply)
-- ============================================================================

CREATE DEFINER=`julia`@`%` PROCEDURE `hris`.`lock_sla_recruitment_screening_cv`(IN p_user_id INT)
BEGIN
    SELECT
        jb.job_id                                       AS no_fpk,
        e.user_id                                       AS created_by,
        e.user_id                                       AS id_hr,
        CONCAT(e.first_name, ' ', e.last_name)          AS username,
        COUNT(DISTINCT jb.job_id)                       AS jumlah,
        m_lock.id_lock                                  AS id_lock,
        m_lock.status_lock                              AS status_lock,
        m_lock.warning_lock                             AS warning_lock
    FROM trusmi_jobs_request jb
    -- [JOIN] Department untuk filter company
    INNER JOIN xin_departments dp
        ON dp.department_id = jb.department_id
    -- [JOIN] Employee = TA Recruiter (PIC)
    INNER JOIN xin_employees e
        ON e.user_id = jb.pic
    -- [JOIN] Role untuk mapping SLA per posisi
    INNER JOIN xin_user_roles ur
        ON ur.role_id = jb.position_id
    -- [JOIN] SLA config untuk step 'screening'
    INNER JOIN trusmi_m_sla_recruitment sla
        ON sla.step_code = 'screening'
        AND sla.role_id = ur.role_id
        AND sla.is_active = 1
    -- [JOIN] Job posting yang sudah ada untuk FPK ini
    INNER JOIN xin_jobs xj
        ON xj.reff_job_id = jb.job_id
    -- [JOIN] Data pelamar (applicant)
    INNER JOIN xin_job_applications ja
        ON ja.job_id = xj.job_id
    -- [JOIN] Lock config (id_lock=345)
    INNER JOIN (
        SELECT id_lock, status_lock, warning_lock
        FROM trusmi_m_lock
        WHERE id_lock = 345 AND is_active = 1
    ) m_lock
        ON m_lock.id_lock = 345
    WHERE
        -- FILTER 1: Hanya untuk user (TA Recruiter) yang sedang dicek
        e.user_id = p_user_id

        -- FILTER 2: Exclude company TKB
        AND dp.company_id != 3

        -- FILTER 3: FPK sudah approved (status=4)
        AND jb.status = 4

        -- FILTER 4: Pelamar baru, belum diproses (application_status=0)
        AND ja.application_status = 0

        -- FILTER 5: SLA terlewati → hari sejak pelamar masuk > batas SLA
        AND DATEDIFF(CURDATE(), DATE(ja.created_at)) > sla.sla_days

        -- FILTER 6: Lock hanya aktif setelah jam 13:00 WIB
        AND CURTIME() > '13:00:00'

        -- FILTER 7: Data hanya bulan & tahun berjalan (berdasarkan ja.created_at)
        AND MONTH(DATE(ja.created_at)) = MONTH(CURDATE())
        AND YEAR(DATE(ja.created_at)) = YEAR(CURDATE())
    GROUP BY
        e.user_id;
END;


-- ============================================================================
-- STEP 4: INTERVIEW HR (id_lock = 346)
-- ============================================================================
-- Cek apakah TA Recruiter (p_user_id = jb.pic) memiliki kandidat yang
-- sudah lolos screening (application_status IN (1,10)) tapi belum
-- dijadwalkan interview HR, dan SLA terlewati.
-- PIC: TA Recruiter (jb.pic)
-- Tanggal acuan SLA: COALESCE(ja.manual_screening_at, ja.updated_at)
-- ============================================================================

CREATE DEFINER=`julia`@`%` PROCEDURE `hris`.`lock_sla_recruitment_interview_hr`(IN p_user_id INT)
BEGIN
    SELECT
        jb.job_id                                       AS no_fpk,
        e.user_id                                       AS created_by,
        e.user_id                                       AS id_hr,
        CONCAT(e.first_name, ' ', e.last_name)          AS username,
        COUNT(DISTINCT ja.application_id)               AS jumlah,
        m_lock.id_lock                                  AS id_lock,
        m_lock.status_lock                              AS status_lock,
        m_lock.warning_lock                             AS warning_lock
    FROM xin_job_applications ja
    -- [JOIN] Job posting
    LEFT JOIN xin_jobs xj
        ON xj.job_id = ja.job_id
    -- [JOIN] Kategori job (informational)
    LEFT JOIN xin_job_categories xjc
        ON xjc.category_id = xj.category_id
    -- [JOIN] Status hasil (informational)
    LEFT JOIN trusmi_status_hasil tsh
        ON tsh.id_status = ja.application_status
    -- [JOIN] Employee yang melakukan screening (informational)
    LEFT JOIN xin_employees scemp
        ON scemp.user_id = ja.manual_screening_by
    -- [JOIN] Role untuk mapping SLA per posisi
    INNER JOIN xin_user_roles ur
        ON ur.role_id = xj.position_id
    -- [JOIN] FPK request
    INNER JOIN trusmi_jobs_request jb
        ON jb.job_id = xj.reff_job_id
    -- [JOIN] Department untuk filter company
    INNER JOIN xin_departments dp
        ON dp.department_id = jb.department_id
    -- [JOIN] Employee = TA Recruiter (PIC)
    INNER JOIN xin_employees e
        ON e.user_id = jb.pic
    -- [JOIN] SLA config untuk step 'interview_hr'
    INNER JOIN trusmi_m_sla_recruitment sla
        ON sla.step_code = 'interview_hr'
        AND sla.role_id = ur.role_id
        AND sla.is_active = 1
    -- [JOIN] Lock config (id_lock=346)
    INNER JOIN (
        SELECT id_lock, status_lock, warning_lock
        FROM trusmi_m_lock
        WHERE id_lock = 346 AND is_active = 1
    ) m_lock
        ON m_lock.id_lock = 346
    WHERE
        -- FILTER 1: Hanya untuk user (TA Recruiter) yang sedang dicek
        e.user_id = p_user_id

        -- FILTER 2: Exclude company TKB
        AND dp.company_id != 3

        -- FILTER 3: Kandidat lolos screening, menunggu interview HR
        -- application_status = 1 (lolos screening manual)
        -- application_status = 10 (lolos screening otomatis)
        AND ja.application_status IN (1, 10)

        -- FILTER 4: SLA terlewati → hari sejak screening > batas SLA
        -- Prioritas: manual_screening_at, fallback ke updated_at
        AND DATEDIFF(CURDATE(), DATE(COALESCE(ja.manual_screening_at, ja.updated_at))) > sla.sla_days

        -- FILTER 5: Lock hanya aktif setelah jam 13:00 WIB
        AND CURTIME() > '13:00:00'

        -- FILTER 6: Data hanya bulan & tahun berjalan (berdasarkan ja.created_at)
        AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
        AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE())
    GROUP BY
        e.user_id;
END;


-- ============================================================================
-- STEP 5: INTERVIEW USER / FEEDBACK (id_lock = 347)
-- ============================================================================
-- Cek apakah User pembuat FPK (p_user_id = jb.created_by) memiliki
-- kandidat yang sudah interview HR (application_status=3) tapi belum
-- memberikan feedback, dan SLA terlewati.
-- PIC: User pembuat FPK (jb.created_by) — BUKAN TA Recruiter!
-- Tanggal acuan SLA: COALESCE(ja.update_interview_hr_at, ja.updated_at)
-- ============================================================================

CREATE DEFINER=`julia`@`%` PROCEDURE `hris`.`lock_sla_recruitment_interview_user_feedback`(IN p_user_id INT)
BEGIN
    SELECT
        jb.job_id                                       AS no_fpk,
        e.user_id                                       AS created_by,
        e.user_id                                       AS id_hr,
        CONCAT(e.first_name, ' ', e.last_name)          AS username,
        COUNT(DISTINCT ja.application_id)               AS jumlah,
        m_lock.id_lock                                  AS id_lock,
        m_lock.status_lock                              AS status_lock,
        m_lock.warning_lock                             AS warning_lock
    FROM xin_job_applications ja
    -- [JOIN] Job posting
    LEFT JOIN xin_jobs xj
        ON xj.job_id = ja.job_id
    -- [JOIN] Kategori job (informational)
    LEFT JOIN xin_job_categories xjc
        ON xjc.category_id = xj.category_id
    -- [JOIN] Status hasil (informational)
    LEFT JOIN trusmi_status_hasil tsh
        ON tsh.id_status = ja.application_status
    -- [JOIN] Role untuk mapping SLA per posisi
    INNER JOIN xin_user_roles ur
        ON ur.role_id = xj.position_id
    -- [JOIN] FPK request
    INNER JOIN trusmi_jobs_request jb
        ON jb.job_id = xj.reff_job_id
    -- [JOIN] Department untuk filter company
    INNER JOIN xin_departments dp
        ON dp.department_id = jb.department_id
    -- [JOIN] Employee = User pembuat FPK (BUKAN TA Recruiter)
    INNER JOIN xin_employees e
        ON e.user_id = jb.created_by
    -- [JOIN] SLA config untuk step 'interview_user_feedback'
    INNER JOIN trusmi_m_sla_recruitment sla
        ON sla.step_code = 'interview_user_feedback'
        AND sla.role_id = ur.role_id
        AND sla.is_active = 1
    -- [JOIN] Lock config (id_lock=347)
    INNER JOIN (
        SELECT id_lock, status_lock, warning_lock
        FROM trusmi_m_lock
        WHERE id_lock = 347 AND is_active = 1
    ) m_lock
        ON m_lock.id_lock = 347
    WHERE
        -- FILTER 1: Hanya untuk user (pembuat FPK) yang sedang dicek
        e.user_id = p_user_id

        -- FILTER 2: Exclude company TKB
        AND dp.company_id != 3

        -- FILTER 3: FPK sudah approved (status=4)
        AND jb.status = 4

        -- FILTER 4: Kandidat di stage Interview User tapi belum ada feedback
        AND ja.application_status = 3
        AND ja.status_interview IS NULL

        -- FILTER 5: SLA terlewati → hari sejak interview HR selesai > batas SLA
        -- Prioritas: update_interview_hr_at, fallback ke updated_at
        AND DATEDIFF(CURDATE(), DATE(COALESCE(ja.update_interview_hr_at, ja.updated_at))) > sla.sla_days

        -- FILTER 6: Lock hanya aktif setelah jam 13:00 WIB
        AND CURTIME() > '13:00:00'

        -- FILTER 7: Data hanya bulan & tahun berjalan (berdasarkan ja.created_at)
        AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
        AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE())
    GROUP BY
        e.user_id;
END;


-- ============================================================================
-- ============================================================================
--
--   BAGIAN 2: QUERY SCENARIO BY JOURNEY
--
--   Simulasi data per tahap recruitment untuk testing.
--   Gunakan query ini untuk membuat data yang akan ter-LOCK di setiap step.
--
-- ============================================================================
-- ============================================================================


-- ============================================================================
-- SCENARIO JOURNEY STEP 1: APPROVAL HR
-- ============================================================================
-- Kondisi: FPK sudah First Level Approval (status=2), verified_at di bulan
--          berjalan, SLA terlewati, user HR terdaftar di m_lock.usr_id
-- ============================================================================

-- 1a. Pastikan konfigurasi lock aktif
SELECT * FROM trusmi_m_lock WHERE id_lock = 343;

-- 1b. Pastikan SLA untuk step 'approval_hr' aktif
SELECT * FROM trusmi_m_sla_recruitment WHERE step_code = 'approval_hr' AND is_active = 1;

-- 1c. Cari FPK yang sedang menunggu HR Approval (status=2) bulan ini
SELECT
    jb.job_id,
    jb.status,
    jb.verified_at,
    jb.created_at,
    jb.department_id,
    dp.company_id,
    jb.position_id,
    DATEDIFF(CURDATE(), DATE(jb.verified_at)) AS days_since_verified
FROM trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE jb.status = 2
  AND jb.verified_at IS NOT NULL
  AND dp.company_id != 3
  AND MONTH(jb.verified_at) = MONTH(CURDATE())
  AND YEAR(jb.verified_at) = YEAR(CURDATE())
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE())
ORDER BY jb.verified_at ASC;

-- 1d. Simulasi: buat FPK yang akan memicu lock Step 1
--     (Ubah @sla_days sesuai konfigurasi SLA aktif)
SET @sla_days = 2; -- contoh: SLA 2 hari
SET @target_date = DATE_SUB(CURDATE(), INTERVAL (@sla_days + 1) DAY);

-- Scenario: Update FPK agar verified_at melebihi SLA
/*
UPDATE trusmi_jobs_request
SET status = 2,
    verified_at = @target_date
WHERE job_id = <JOB_ID_TARGET>
  AND MONTH(created_at) = MONTH(CURDATE())
  AND YEAR(created_at) = YEAR(CURDATE());
*/

-- 1e. Verifikasi: panggil procedure untuk user HR tertentu
-- CALL hris.lock_sla_recruitment_approval_hr(<USER_ID_HR>);


-- ============================================================================
-- SCENARIO JOURNEY STEP 2: POSTING
-- ============================================================================
-- Kondisi: FPK sudah approved HR (status=4), approved_at di bulan berjalan,
--          BELUM ada job posting (xin_jobs), SLA terlewati, PIC = TA Recruiter
-- ============================================================================

-- 2a. Pastikan konfigurasi lock aktif
SELECT * FROM trusmi_m_lock WHERE id_lock = 344;

-- 2b. Pastikan SLA untuk step 'posting' aktif
SELECT * FROM trusmi_m_sla_recruitment WHERE step_code = 'posting' AND is_active = 1;

-- 2c. Cari FPK yang sudah approved tapi belum ada posting
SELECT
    jb.job_id,
    jb.status,
    jb.approved_at,
    jb.pic,
    dp.company_id,
    DATEDIFF(CURDATE(), DATE(jb.approved_at)) AS days_since_approved,
    (SELECT COUNT(1) FROM xin_jobs xj WHERE xj.reff_job_id = jb.job_id) AS posting_count
FROM trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE jb.status = 4
  AND jb.approved_at IS NOT NULL
  AND dp.company_id != 3
  AND NOT EXISTS (SELECT 1 FROM xin_jobs xj WHERE xj.reff_job_id = jb.job_id)
  AND MONTH(jb.approved_at) = MONTH(CURDATE())
  AND YEAR(jb.approved_at) = YEAR(CURDATE())
ORDER BY jb.approved_at ASC;

-- 2d. Simulasi: buat FPK yang akan memicu lock Step 2
/*
UPDATE trusmi_jobs_request
SET status = 4,
    approved_at = DATE_SUB(CURDATE(), INTERVAL (@sla_days + 1) DAY)
WHERE job_id = <JOB_ID_TARGET>;

-- Pastikan tidak ada record di xin_jobs untuk job_id ini
DELETE FROM xin_jobs WHERE reff_job_id = <JOB_ID_TARGET>;
*/

-- 2e. Verifikasi
-- CALL hris.lock_sla_recruitment_posting(<USER_ID_TA>);


-- ============================================================================
-- SCENARIO JOURNEY STEP 3: SCREENING CV
-- ============================================================================
-- Kondisi: FPK sudah approved (status=4), sudah ada job posting,
--          ada pelamar dengan application_status=0 (baru), SLA terlewati
-- ============================================================================

-- 3a. Pastikan konfigurasi lock aktif
SELECT * FROM trusmi_m_lock WHERE id_lock = 345;

-- 3b. Pastikan SLA untuk step 'screening' aktif
SELECT * FROM trusmi_m_sla_recruitment WHERE step_code = 'screening' AND is_active = 1;

-- 3c. Cari pelamar baru yang belum di-screening
SELECT
    jb.job_id       AS no_fpk,
    xj.job_id       AS posting_id,
    ja.application_id,
    ja.application_status,
    ja.created_at   AS applicant_date,
    jb.pic,
    DATEDIFF(CURDATE(), DATE(ja.created_at)) AS days_since_applied
FROM trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
INNER JOIN xin_jobs xj ON xj.reff_job_id = jb.job_id
INNER JOIN xin_job_applications ja ON ja.job_id = xj.job_id
WHERE jb.status = 4
  AND dp.company_id != 3
  AND ja.application_status = 0
  AND MONTH(DATE(ja.created_at)) = MONTH(CURDATE())
  AND YEAR(DATE(ja.created_at)) = YEAR(CURDATE())
ORDER BY ja.created_at ASC;

-- 3d. Simulasi: buat pelamar yang akan memicu lock Step 3
/*
INSERT INTO xin_job_applications (job_id, application_status, created_at)
VALUES (<JOB_ID_POSTING>, 0, DATE_SUB(CURDATE(), INTERVAL (@sla_days + 1) DAY));
*/

-- 3e. Verifikasi
-- CALL hris.lock_sla_recruitment_screening_cv(<USER_ID_TA>);


-- ============================================================================
-- SCENARIO JOURNEY STEP 4: INTERVIEW HR
-- ============================================================================
-- Kondisi: Kandidat lolos screening (application_status IN (1,10)),
--          belum dijadwalkan interview HR, SLA terlewati dari tanggal screening
-- ============================================================================

-- 4a. Pastikan konfigurasi lock aktif
SELECT * FROM trusmi_m_lock WHERE id_lock = 346;

-- 4b. Pastikan SLA untuk step 'interview_hr' aktif
SELECT * FROM trusmi_m_sla_recruitment WHERE step_code = 'interview_hr' AND is_active = 1;

-- 4c. Cari kandidat lolos screening yang menunggu interview HR
SELECT
    jb.job_id       AS no_fpk,
    ja.application_id,
    ja.application_status,
    ja.manual_screening_at,
    ja.manual_screening_by,
    ja.updated_at,
    COALESCE(ja.manual_screening_at, ja.updated_at) AS sla_ref_date,
    DATEDIFF(CURDATE(), DATE(COALESCE(ja.manual_screening_at, ja.updated_at))) AS days_since_screening,
    jb.pic
FROM xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE ja.application_status IN (1, 10)
  AND dp.company_id != 3
  AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
  AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE())
ORDER BY sla_ref_date ASC;

-- 4d. Simulasi: ubah status pelamar menjadi lolos screening
/*
UPDATE xin_job_applications
SET application_status = 1,
    manual_screening_at = DATE_SUB(CURDATE(), INTERVAL (@sla_days + 1) DAY),
    manual_screening_by = <USER_ID_SCREENER>
WHERE application_id = <APPLICATION_ID_TARGET>;
*/

-- 4e. Verifikasi
-- CALL hris.lock_sla_recruitment_interview_hr(<USER_ID_TA>);


-- ============================================================================
-- SCENARIO JOURNEY STEP 5: INTERVIEW USER / FEEDBACK
-- ============================================================================
-- Kondisi: Kandidat sudah interview HR (application_status=3),
--          status_interview IS NULL (belum ada feedback dari user),
--          SLA terlewati dari tanggal interview HR
-- PIC: User pembuat FPK (jb.created_by)
-- ============================================================================

-- 5a. Pastikan konfigurasi lock aktif
SELECT * FROM trusmi_m_lock WHERE id_lock = 347;

-- 5b. Pastikan SLA untuk step 'interview_user_feedback' aktif
SELECT * FROM trusmi_m_sla_recruitment WHERE step_code = 'interview_user_feedback' AND is_active = 1;

-- 5c. Cari kandidat yang menunggu feedback user
SELECT
    jb.job_id       AS no_fpk,
    ja.application_id,
    ja.application_status,
    ja.status_interview,
    ja.update_interview_hr_at,
    ja.updated_at,
    COALESCE(ja.update_interview_hr_at, ja.updated_at) AS sla_ref_date,
    DATEDIFF(CURDATE(), DATE(COALESCE(ja.update_interview_hr_at, ja.updated_at))) AS days_since_interview_hr,
    jb.created_by   AS pic_user
FROM xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE ja.application_status = 3
  AND ja.status_interview IS NULL
  AND dp.company_id != 3
  AND jb.status = 4
  AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
  AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE())
ORDER BY sla_ref_date ASC;

-- 5d. Simulasi: ubah status pelamar menjadi sudah interview HR tanpa feedback
/*
UPDATE xin_job_applications
SET application_status = 3,
    status_interview = NULL,
    update_interview_hr_at = DATE_SUB(CURDATE(), INTERVAL (@sla_days + 1) DAY)
WHERE application_id = <APPLICATION_ID_TARGET>;
*/

-- 5e. Verifikasi
-- CALL hris.lock_sla_recruitment_interview_user_feedback(<USER_ID_PEMBUAT_FPK>);


-- ============================================================================
-- ============================================================================
--
--   BAGIAN 3: QUERY RESET DATA KE START JOURNEY
--
--   Gunakan query ini untuk mengembalikan data ke posisi awal (sebelum lock),
--   misalnya setelah testing scenario di atas.
--
--   ⚠️ PERINGATAN: Jalankan dengan hati-hati! Backup data terlebih dahulu.
--
-- ============================================================================
-- ============================================================================


-- ============================================================================
-- RESET STEP 5 → STEP 4 (Interview User/Feedback → Interview HR)
-- ============================================================================
-- Kembalikan kandidat dari stage Interview User (status=3, no feedback)
-- ke stage pasca-screening (status=1), seolah belum interview HR.
-- ============================================================================
/*
UPDATE xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
SET
    ja.application_status = 1,              -- kembali ke lolos screening
    ja.status_interview = NULL,             -- hapus feedback
    ja.update_interview_hr_at = NULL        -- hapus timestamp interview HR
WHERE ja.application_status = 3
  AND ja.status_interview IS NULL
  AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
  AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE());
*/


-- ============================================================================
-- RESET STEP 4 → STEP 3 (Interview HR → Screening CV)
-- ============================================================================
-- Kembalikan kandidat dari stage lolos screening (status IN (1,10))
-- ke stage belum diproses (status=0), seolah belum di-screening.
-- ============================================================================
/*
UPDATE xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
SET
    ja.application_status = 0,              -- kembali ke pelamar baru
    ja.manual_screening_at = NULL,          -- hapus timestamp screening
    ja.manual_screening_by = NULL           -- hapus screener
WHERE ja.application_status IN (1, 10)
  AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
  AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE());
*/


-- ============================================================================
-- RESET STEP 3 → STEP 2 (Screening CV → Posting)
-- ============================================================================
-- Hapus semua pelamar (applications) dan job posting untuk FPK tertentu,
-- sehingga kembali ke kondisi "belum ada posting".
-- ============================================================================
/*
-- Hapus applications terlebih dahulu (child records)
DELETE ja
FROM xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
WHERE jb.status = 4
  AND MONTH(DATE(ja.created_at)) = MONTH(CURDATE())
  AND YEAR(DATE(ja.created_at)) = YEAR(CURDATE());

-- Kemudian hapus job posting
DELETE xj
FROM xin_jobs xj
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
WHERE jb.status = 4
  AND MONTH(jb.approved_at) = MONTH(CURDATE())
  AND YEAR(jb.approved_at) = YEAR(CURDATE());
*/


-- ============================================================================
-- RESET STEP 2 → STEP 1 (Posting → Approval HR)
-- ============================================================================
-- Kembalikan FPK dari status=4 (approved HR) ke status=2 (menunggu HR),
-- hapus approved_at, sehingga kembali ke tahap Approval HR.
-- ============================================================================
/*
UPDATE trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
SET
    jb.status = 2,                          -- kembali ke menunggu HR Approval
    jb.approved_at = NULL                   -- hapus tanggal approval
WHERE jb.status = 4
  AND dp.company_id != 3
  AND MONTH(jb.approved_at) = MONTH(CURDATE())
  AND YEAR(jb.approved_at) = YEAR(CURDATE());
*/


-- ============================================================================
-- RESET STEP 1 → AWAL (Approval HR → Sebelum First Level Approval)
-- ============================================================================
-- Kembalikan FPK dari status=2 (menunggu HR) ke status=1 (baru dibuat),
-- hapus verified_at, sehingga kembali ke kondisi awal sebelum proses apapun.
-- ============================================================================
/*
UPDATE trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
SET
    jb.status = 1,                          -- kembali ke status awal
    jb.verified_at = NULL                   -- hapus tanggal verifikasi
WHERE jb.status = 2
  AND dp.company_id != 3
  AND jb.verified_at IS NOT NULL
  AND MONTH(jb.verified_at) = MONTH(CURDATE())
  AND YEAR(jb.verified_at) = YEAR(CURDATE())
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE());
*/


-- ============================================================================
-- FULL RESET: KEMBALIKAN SEMUA DATA KE POSISI AWAL (JOURNEY START)
-- ============================================================================
-- Jalankan reset secara berurutan dari Step 5 → Step 1 (reverse order)
-- untuk menghindari constraint violation.
--
-- Urutan eksekusi:
--   1. Reset Step 5 → 4  (interview feedback → post-screening)
--   2. Reset Step 4 → 3  (post-screening → new applicant)
--   3. Reset Step 3 → 2  (delete applications & postings)
--   4. Reset Step 2 → 1  (approved → waiting HR)
--   5. Reset Step 1 → 0  (waiting HR → initial)
-- ============================================================================

/*
-- ============= START FULL RESET =============
START TRANSACTION;

-- [1/5] Reset Step 5 → 4: Kandidat interview user → lolos screening
UPDATE xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
SET ja.application_status = 1, ja.status_interview = NULL, ja.update_interview_hr_at = NULL
WHERE ja.application_status = 3 AND ja.status_interview IS NULL
  AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
  AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE());

-- [2/5] Reset Step 4 → 3: Kandidat lolos screening → pelamar baru
UPDATE xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
SET ja.application_status = 0, ja.manual_screening_at = NULL, ja.manual_screening_by = NULL
WHERE ja.application_status IN (1, 10)
  AND MONTH(SUBSTR(ja.created_at, 1, 10)) = MONTH(CURDATE())
  AND YEAR(SUBSTR(ja.created_at, 1, 10)) = YEAR(CURDATE());

-- [3/5] Reset Step 3 → 2: Hapus applications & job postings
DELETE ja
FROM xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
WHERE jb.status = 4
  AND MONTH(DATE(ja.created_at)) = MONTH(CURDATE())
  AND YEAR(DATE(ja.created_at)) = YEAR(CURDATE());

DELETE xj
FROM xin_jobs xj
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
WHERE jb.status = 4
  AND MONTH(jb.approved_at) = MONTH(CURDATE())
  AND YEAR(jb.approved_at) = YEAR(CURDATE());

-- [4/5] Reset Step 2 → 1: FPK approved → menunggu HR
UPDATE trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
SET jb.status = 2, jb.approved_at = NULL
WHERE jb.status = 4 AND dp.company_id != 3
  AND MONTH(jb.approved_at) = MONTH(CURDATE())
  AND YEAR(jb.approved_at) = YEAR(CURDATE());

-- [5/5] Reset Step 1 → 0: FPK menunggu HR → status awal
UPDATE trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
SET jb.status = 1, jb.verified_at = NULL
WHERE jb.status = 2 AND dp.company_id != 3
  AND jb.verified_at IS NOT NULL
  AND MONTH(jb.verified_at) = MONTH(CURDATE())
  AND YEAR(jb.verified_at) = YEAR(CURDATE())
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE());

COMMIT;
-- ============= END FULL RESET =============
*/


-- ============================================================================
-- ============================================================================
--
--   BAGIAN 4: DELETE DATA TESTING FPK
--
--   Hapus PERMANEN data FPK beserta seluruh data turunannya (job posting &
--   applications) yang dibuat selama testing, agar TIDAK mempengaruhi
--   pencapaian (achievement/KPI) di production.
--
--   ⚠️ PERINGATAN:
--     - Query ini melakukan DELETE permanen, BUKAN reset status!
--     - Pastikan job_id yang dimasukkan benar-benar data testing.
--     - BACKUP data terlebih dahulu sebelum menjalankan.
--     - Jalankan dalam TRANSACTION agar bisa di-ROLLBACK jika salah.
--
--   Urutan delete (child → parent):
--     1. Delete xin_job_applications  (data pelamar / kandidat)
--     2. Delete xin_jobs              (job posting)
--     3. Delete trusmi_jobs_request   (FPK)
--
-- ============================================================================
-- ============================================================================


-- ============================================================================
-- OPSI A: DELETE FPK TESTING BERDASARKAN JOB_ID TERTENTU (RECOMMENDED)
-- ============================================================================
-- Gunakan opsi ini jika kamu tahu persis job_id FPK yang dipakai testing.
-- Ganti <JOB_ID_1>, <JOB_ID_2>, ... dengan job_id yang benar.
-- ============================================================================

/*
-- ============= START DELETE FPK TESTING (BY JOB_ID) =============
START TRANSACTION;

-- [1/3] Hapus data pelamar (applications) terkait FPK testing
DELETE ja
FROM xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
WHERE jb.job_id IN (<JOB_ID_1>, <JOB_ID_2>);

-- [2/3] Hapus job posting terkait FPK testing
DELETE xj
FROM xin_jobs xj
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
WHERE jb.job_id IN (<JOB_ID_1>, <JOB_ID_2>);

-- [3/3] Hapus FPK testing itu sendiri
DELETE FROM trusmi_jobs_request
WHERE job_id IN (<JOB_ID_1>, <JOB_ID_2>);

-- Verifikasi sebelum commit (pastikan count = 0)
SELECT 'Sisa applications' AS cek, COUNT(1) AS total
FROM xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
WHERE xj.reff_job_id IN (<JOB_ID_1>, <JOB_ID_2>)
UNION ALL
SELECT 'Sisa job postings', COUNT(1)
FROM xin_jobs WHERE reff_job_id IN (<JOB_ID_1>, <JOB_ID_2>)
UNION ALL
SELECT 'Sisa FPK', COUNT(1)
FROM trusmi_jobs_request WHERE job_id IN (<JOB_ID_1>, <JOB_ID_2>);

-- Jika hasil verifikasi semua 0, jalankan COMMIT
-- Jika ada yang salah, jalankan ROLLBACK
COMMIT;
-- ROLLBACK;
-- ============= END DELETE FPK TESTING (BY JOB_ID) =============
*/


-- ============================================================================
-- OPSI B: DELETE SEMUA FPK TESTING BULAN INI (BULK DELETE)
-- ============================================================================
-- Gunakan opsi ini untuk menghapus SEMUA data FPK bulan & tahun berjalan
-- yang dibuat saat testing. Pastikan tidak ada data production yang ikut
-- terhapus — cek dulu dengan query SELECT di bawah sebelum DELETE.
--
-- SAFETY: Exclude company TKB (company_id != 3), filter bulan/tahun berjalan
-- ============================================================================

-- Preview: Lihat dulu FPK mana saja yang akan dihapus
SELECT
    jb.job_id,
    jb.status,
    jb.created_at,
    jb.verified_at,
    jb.approved_at,
    jb.pic,
    jb.created_by,
    dp.company_id,
    dp.department_name,
    (SELECT COUNT(1) FROM xin_jobs xj WHERE xj.reff_job_id = jb.job_id) AS total_posting,
    (SELECT COUNT(1)
     FROM xin_job_applications ja
     INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
     WHERE xj.reff_job_id = jb.job_id) AS total_applicant
FROM trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE dp.company_id != 3
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE())
ORDER BY jb.created_at DESC;

/*
-- ============= START DELETE FPK TESTING (BULK BULAN INI) =============
START TRANSACTION;

-- [1/3] Hapus semua applications dari FPK bulan ini
DELETE ja
FROM xin_job_applications ja
INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE dp.company_id != 3
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE());

-- [2/3] Hapus semua job postings dari FPK bulan ini
DELETE xj
FROM xin_jobs xj
INNER JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE dp.company_id != 3
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE());

-- [3/3] Hapus semua FPK testing bulan ini
DELETE jb
FROM trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE dp.company_id != 3
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE());

-- Verifikasi
SELECT 'Sisa FPK bulan ini' AS cek, COUNT(1) AS total
FROM trusmi_jobs_request jb
INNER JOIN xin_departments dp ON dp.department_id = jb.department_id
WHERE dp.company_id != 3
  AND MONTH(jb.created_at) = MONTH(CURDATE())
  AND YEAR(jb.created_at) = YEAR(CURDATE());

-- Jika hasil verifikasi sesuai harapan, jalankan COMMIT
-- Jika ada yang salah, jalankan ROLLBACK
COMMIT;
-- ROLLBACK;
-- ============= END DELETE FPK TESTING (BULK BULAN INI) =============
*/
