<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_recruitment_liga extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // ── Subquery helpers (reusable) ──

  private function _sub_screening($bulan, $tahun)
  {
    return "(SELECT ja.job_id, COUNT(*) AS total
             FROM xin_job_applications ja
             INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id           -- relasi ke lowongan untuk filter tanggal
             WHERE ja.application_status NOT IN (0,2)                   -- exclude: 0=New/Belum Diproses, 2=Rejected
               AND MONTH(xj.date_of_closing) = '$bulan'                 -- filter bulan closing lowongan
               AND YEAR(xj.date_of_closing) = '$tahun'                  -- filter tahun closing lowongan
             GROUP BY ja.job_id)";
  }

  private function _sub_interview_hr($bulan, $tahun)
  {
    return "(SELECT ja.job_id, COUNT(*) AS total
             FROM xin_job_applications ja
             INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id           -- relasi ke lowongan untuk filter tanggal
             WHERE (ja.application_status IN (1,3,4,5,6,7,10)          -- status: sudah melewati tahap screening
                    OR ja.user_id_emp IS NOT NULL)                      -- atau sudah ter-link ke employee (sudah join)
               AND MONTH(xj.date_of_closing) = '$bulan'                 -- filter bulan closing lowongan
               AND YEAR(xj.date_of_closing) = '$tahun'                  -- filter tahun closing lowongan
             GROUP BY ja.job_id)";
  }

  private function _sub_interview_user($bulan, $tahun)
  {
    return "(SELECT ja.job_id, COUNT(*) AS total
             FROM xin_job_applications ja
             INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id           -- relasi ke lowongan untuk filter tanggal
             WHERE (ja.application_status IN (3,5,6,7)                  -- status: lolos interview HR ke atas
                    OR ja.user_id_emp IS NOT NULL)                      -- atau sudah ter-link ke employee (sudah join)
               AND MONTH(xj.date_of_closing) = '$bulan'                 -- filter bulan closing lowongan
               AND YEAR(xj.date_of_closing) = '$tahun'                  -- filter tahun closing lowongan
             GROUP BY ja.job_id)";
  }

  private function _sub_offering($bulan, $tahun)
  {
    return "(SELECT ja.job_id, COUNT(*) AS total
             FROM xin_job_applications ja
             INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id           -- relasi ke lowongan untuk filter tanggal
             WHERE (ja.application_status IN (5,7)                      -- status: 5=Accepted, 7=Hired (tahap offering)
                    OR ja.user_id_emp IS NOT NULL)                      -- atau sudah ter-link ke employee (sudah join)
               AND MONTH(xj.date_of_closing) = '$bulan'                 -- filter bulan closing lowongan
               AND YEAR(xj.date_of_closing) = '$tahun'                  -- filter tahun closing lowongan
             GROUP BY ja.job_id)";
  }

  private function _sub_join($bulan, $tahun)
  {
    return "(SELECT ja.job_id, COUNT(*) AS total
             FROM xin_job_applications ja
             INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id           -- relasi ke lowongan untuk filter tanggal
             WHERE ja.user_id_emp IS NOT NULL                           -- sudah ter-link ke employee = sudah join/masuk kerja
               AND MONTH(xj.date_of_closing) = '$bulan'                 -- filter bulan closing lowongan
               AND YEAR(xj.date_of_closing) = '$tahun'                  -- filter tahun closing lowongan
             GROUP BY ja.job_id)";
  }

  /**
   * Subquery: Kandidat FRCK Done + Registered
   *  - fp.is_link_expired = 1          → FRCK Done
   *  - JOIN xin_employees (user_id)    → Registered
   *  - ja.application_status IN (5,7)  → Accepted / Hired
   * Filter bulan/tahun berdasarkan fack_personal_details.created_at
   */
  private function _sub_frck_done($bulan, $tahun)
  {
    return "(SELECT ja.job_id, COUNT(*) AS total
             FROM fack_personal_details fp
             INNER JOIN xin_job_applications ja ON ja.application_id = fp.application_id  -- relasi FRCK ke lamaran
             INNER JOIN xin_employees e ON e.user_id = ja.user_id_emp                     -- pastikan sudah terdaftar sebagai karyawan
             INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id                              -- relasi ke lowongan untuk filter tanggal
             WHERE ja.application_status IN (5, 7)                      -- status: 5=Accepted, 7=Hired
               AND fp.is_link_expired = 1                               -- FRCK form sudah selesai diisi (done)
               
             GROUP BY ja.job_id)";
  }

  /**
   * Helper: end of month (LAST_DAY) for date_of_leaving filter
   * PIC yang resign di bulan ini masih dihitung targetnya
   */
  private function _eom($bulan, $tahun)
  {
    return "LAST_DAY('" . $tahun . "-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01')";
  }

  /**
   * Shared WHERE clause for all functions
   * pe = xin_employees alias for PIC
   */
  private function _where_clause($bulan, $tahun, $pe_alias = 'pe', $company_id = '')
  {
    $fom = "'" . $tahun . "-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01'";
    $sql = "
        AND pe.company_id != 3                                          /* exclude PIC dari company_id 3 */
        AND jb.status = 4                                               /* FPK status 4 = Approved HR */
        AND pe.ctm_cutoff = 1                                              /* filter PIC yang termasuk dalam perhitungan (ctm_cutoff=1) */
        AND pe.user_role_id = 11                                              /* filter PIC dengan role Recruiter (user_role_id=11) */
        AND ($pe_alias.date_of_leaving IS NULL                                  /* PIC masih aktif (NULL) */
             OR $pe_alias.date_of_leaving = ''                                  /* PIC masih aktif (empty string) */
             OR $pe_alias.date_of_leaving >= $fom)                              /* ATAU PIC resign di/setelah bulan filter */
        AND MONTH(xj.date_of_closing) = '$bulan'                        /* filter bulan closing lowongan */
        AND YEAR(xj.date_of_closing)  = '$tahun'";
    if (!empty($company_id)) {
      $company_id = intval($company_id);
      $sql .= "
        AND xu.user_id = $company_id                                    /* filter by employer */";
    }
    return $sql;
  }

  /**
   * Daftar Company (untuk dropdown filter)
   * Exclude company_id = 3 (bukan LIGA)
   */
  function get_company_list()
  {
    $query = "SELECT * FROM xin_users WHERE is_active = 1;";
    return $this->db->query($query)->result();
  }

  /**
   * Total FRCK Done per Company (untuk KPI Overview)
   */
  function get_frck_done_summary($bulan, $tahun, $company_id = '')
  {
    $sub_fd = $this->_sub_frck_done($bulan, $tahun);
    $where = $this->_where_clause($bulan, $tahun, 'pe', $company_id);

    return $this->db->query("
      SELECT
        xu.first_name AS unit_bisnis,
        xu.user_id AS employer_id,
        COALESCE(SUM(fd.total), 0) AS total_frck_done                   -- total kandidat FRCK Done per employer
      FROM trusmi_jobs_request jb                                       -- tabel utama: permintaan karyawan (FPK)
      LEFT  JOIN xin_users xu     ON xu.user_id = jb.employer_id       -- relasi employer untuk ambil nama unit bisnis
      LEFT  JOIN xin_employees pe ON pe.user_id = jb.pic               -- data PIC recruiter untuk filter where
      LEFT  JOIN xin_jobs xj      ON xj.reff_job_id = jb.job_id       -- lowongan terpublish dari FPK
      LEFT  JOIN $sub_fd fd        ON fd.job_id = xj.job_id            -- subquery: jumlah FRCK Done per job
      WHERE 1=1
        $where                                                          -- shared filter: employer, status, date_of_leaving, date_of_closing
      GROUP BY xu.user_id, xu.first_name                                -- group per employer
      ORDER BY xu.first_name                                            -- urut alfabet nama employer
    ")->result();
  }

  /**
   * Ringkasan per Company + funnel lengkap
   * Tab: Overview + Funnel & Konversi
   */
  function get_unit_summary($bulan, $tahun, $company_id = '')
  {
    $sub_scr = $this->_sub_screening($bulan, $tahun);
    $sub_ihr = $this->_sub_interview_hr($bulan, $tahun);
    $sub_iu = $this->_sub_interview_user($bulan, $tahun);
    $sub_ofr = $this->_sub_offering($bulan, $tahun);
    $sub_jn = $this->_sub_join($bulan, $tahun);
    $sub_fd = $this->_sub_frck_done($bulan, $tahun);
    $where = $this->_where_clause($bulan, $tahun, 'pe', $company_id);

    return $this->db->query("
      SELECT
        xu.first_name AS unit_bisnis,
        xu.user_id AS employer_id,
        SUM(jb.job_vacancy) AS total_kebutuhan,                         -- total jumlah kebutuhan (vacancy) dari FPK
        COALESCE(SUM(scr.total), 0) AS total_screening,                 -- jumlah kandidat lolos screening
        COALESCE(SUM(ihr.total), 0) AS total_interview_hr,              -- jumlah kandidat masuk interview HR
        COALESCE(SUM(iu.total), 0)  AS total_interview_user,            -- jumlah kandidat masuk interview User
        COALESCE(SUM(ofr.total), 0) AS total_offering,                  -- jumlah kandidat tahap offering
        COALESCE(SUM(jn.total), 0)  AS total_join,                      -- jumlah kandidat yang sudah join (ter-link employee)
        COALESCE(SUM(fd.total), 0)  AS total_frck_done,                 -- jumlah kandidat FRCK Done + Registered (pemenuhan)
        ROUND(LEAST(COALESCE(SUM(fd.total),0) / NULLIF(SUM(jb.job_vacancy),0) * 100, 100), 2) AS pct_pemenuhan, -- persentase pemenuhan (max 100%)
        GREATEST(SUM(jb.job_vacancy) - COALESCE(SUM(fd.total),0), 0) AS gap  -- selisih kebutuhan vs pemenuhan (min 0)
      FROM trusmi_jobs_request jb                                       -- tabel utama: permintaan karyawan (FPK)
      LEFT  JOIN xin_users xu     ON xu.user_id = jb.employer_id       -- relasi employer untuk ambil nama unit bisnis
      LEFT  JOIN xin_jobs xj      ON xj.reff_job_id = jb.job_id       -- lowongan terpublish dari FPK
      LEFT  JOIN $sub_scr scr     ON scr.job_id = xj.job_id            -- subquery: lolos screening per job
      LEFT  JOIN $sub_ihr ihr     ON ihr.job_id = xj.job_id            -- subquery: interview HR per job
      LEFT  JOIN $sub_iu  iu      ON iu.job_id  = xj.job_id            -- subquery: interview User per job
      LEFT  JOIN $sub_ofr ofr     ON ofr.job_id = xj.job_id            -- subquery: offering per job
      LEFT  JOIN $sub_jn  jn      ON jn.job_id  = xj.job_id            -- subquery: join per job
      LEFT  JOIN $sub_fd  fd      ON fd.job_id  = xj.job_id            -- subquery: FRCK Done (pemenuhan) per job
      LEFT  JOIN xin_employees pe ON pe.user_id = jb.pic               -- data PIC recruiter untuk filter where
      WHERE 1=1
        $where                                                          -- shared filter: employer, status, date_of_leaving, date_of_closing
      GROUP BY xu.user_id, xu.first_name                                -- group per employer
      ORDER BY xu.first_name                                            -- urut alfabet nama employer
    ")->result();
  }

  /**
   * Detail Funnel per Posisi, grouped by Company & Level
   * Tab: Funnel & Konversi
   */
  function get_funnel_detail($bulan, $tahun, $company_id = '')
  {
    $sub_scr = $this->_sub_screening($bulan, $tahun);
    $sub_ihr = $this->_sub_interview_hr($bulan, $tahun);
    $sub_iu = $this->_sub_interview_user($bulan, $tahun);
    $sub_ofr = $this->_sub_offering($bulan, $tahun);
    $sub_jn = $this->_sub_join($bulan, $tahun);
    $sub_fd = $this->_sub_frck_done($bulan, $tahun);
    $where = $this->_where_clause($bulan, $tahun, 'pe', $company_id);

    return $this->db->query("
      SELECT
        xu.first_name AS unit_bisnis,
        xu.user_id AS employer_id,
        CASE WHEN ur.role_id = 8 THEN 'Non Staff' ELSE ur.role_name END AS level_name,  -- role_id 8 ditampilkan sebagai 'Non Staff'
        COALESCE(ur.role_id, 0) AS role_id,                             -- default 0 jika role_id NULL
        jb.job_title AS posisi,                                         -- nama posisi dari FPK
        jb.job_vacancy AS kebutuhan,                                    -- jumlah kebutuhan per posisi
        COALESCE(scr.total, 0) AS lolos_screening,                      -- kandidat lolos screening
        COALESCE(ihr.total, 0) AS interview_hr,                         -- kandidat masuk interview HR
        COALESCE(iu.total, 0)  AS interview_user,                       -- kandidat masuk interview User
        COALESCE(ofr.total, 0) AS offering,                             -- kandidat tahap offering
        COALESCE(jn.total, 0)  AS total_join,                           -- kandidat sudah join
        COALESCE(fd.total, 0)  AS pemenuhan                             -- kandidat FRCK Done + Registered
      FROM trusmi_jobs_request jb                                       -- tabel utama: permintaan karyawan (FPK)
      LEFT  JOIN xin_users xu     ON xu.user_id = jb.employer_id       -- relasi employer untuk ambil nama unit bisnis
      LEFT  JOIN xin_jobs xj      ON xj.reff_job_id = jb.job_id       -- lowongan terpublish dari FPK
      LEFT  JOIN xin_user_roles ur ON ur.role_id = jb.position_id      -- level/role posisi (Staff, Non Staff, dll)
      LEFT  JOIN $sub_scr scr     ON scr.job_id = xj.job_id            -- subquery: lolos screening per job
      LEFT  JOIN $sub_ihr ihr     ON ihr.job_id = xj.job_id            -- subquery: interview HR per job
      LEFT  JOIN $sub_iu  iu      ON iu.job_id  = xj.job_id            -- subquery: interview User per job
      LEFT  JOIN $sub_ofr ofr     ON ofr.job_id = xj.job_id            -- subquery: offering per job
      LEFT  JOIN $sub_jn  jn      ON jn.job_id  = xj.job_id            -- subquery: join per job
      LEFT  JOIN $sub_fd  fd      ON fd.job_id  = xj.job_id            -- subquery: FRCK Done (pemenuhan) per job
      LEFT  JOIN xin_employees pe ON pe.user_id = jb.pic               -- data PIC recruiter untuk filter where
      WHERE 1=1
        $where                                                          -- shared filter: employer, status, date_of_leaving, date_of_closing
      ORDER BY xu.first_name,                                           -- urut per unit bisnis
        CASE COALESCE(ur.role_id,0) WHEN 8 THEN 1 WHEN 6 THEN 2 WHEN 7 THEN 3 WHEN 5 THEN 4 ELSE 5 END, -- urut level: Non Staff → Staff → Supervisor → Manager
        jb.job_title ASC                                                -- urut alfabet nama posisi
    ")->result();
  }

  /**
   * Performance per PIC Recruiter
   * Tab: PIC Performance (pemenuhan = FRCK Done)
   */
  function get_pic_performance($bulan, $tahun, $company_id = '')
  {

    $sub_fd = $this->_sub_frck_done($bulan, $tahun);
    $where = $this->_where_clause($bulan, $tahun, 'pe', $company_id);

    return $this->db->query("
      SELECT
        jb.pic AS id_pic,                                               -- ID PIC recruiter
        CONCAT(pe.first_name, ' ', pe.last_name) AS pic_name,          -- nama lengkap PIC
        SUM(jb.job_vacancy) AS kebutuhan,                               -- total kebutuhan yang ditangani PIC
        COALESCE(SUM(fd.total), 0) AS pemenuhan,                        -- total pemenuhan (FRCK Done) oleh PIC
        ROUND(LEAST(COALESCE(SUM(fd.total),0) / NULLIF(SUM(jb.job_vacancy),0) * 100, 100), 2) AS pct, -- persentase pemenuhan (max 100%)
        GREATEST(SUM(jb.job_vacancy) - COALESCE(SUM(fd.total),0), 0) AS gap  -- selisih kebutuhan vs pemenuhan (min 0)
      FROM trusmi_jobs_request jb                                       -- tabel utama: permintaan karyawan (FPK)
      LEFT  JOIN xin_users xu     ON xu.user_id = jb.employer_id       -- relasi employer
      LEFT  JOIN xin_jobs xj      ON xj.reff_job_id = jb.job_id       -- lowongan terpublish dari FPK
      LEFT  JOIN xin_employees pe ON pe.user_id = jb.pic               -- data PIC recruiter
      LEFT  JOIN $sub_fd fd        ON fd.job_id = xj.job_id            -- subquery: FRCK Done (pemenuhan) per job
      WHERE 1=1
        $where                                                          -- shared filter: employer, status, date_of_closing
        
      GROUP BY jb.pic                                                   -- group per PIC recruiter
      ORDER BY pct DESC                                                 -- urut dari persentase tertinggi
    ")->result();
  }



  /**
   * Detail pemenuhan (FRCK Done) per PIC
   * Digunakan untuk hover tooltip kolom Pemenuhan di PIC Detail Table
   */
  function get_pemenuhan_detail_per_pic($bulan, $tahun, $company_id = '')
  {
    $sub_fd = $this->_sub_frck_done($bulan, $tahun);
    $where = $this->_where_clause($bulan, $tahun, 'pe', $company_id);

    return $this->db->query("
      SELECT
        jb.pic AS id_pic,                                               -- ID PIC recruiter
        jb.job_title,                                                   -- nama posisi
        dp.department_name AS department,                                -- nama department
        ur.role_name AS position,                                       -- nama level/role
        ur.role_id AS id_role,                                          -- ID level/role
        COALESCE(fd.total, 0) AS pemenuhan                              -- jumlah pemenuhan (FRCK Done) per posisi
      FROM trusmi_jobs_request jb                                       -- tabel utama: permintaan karyawan (FPK)
      INNER JOIN xin_departments dp ON dp.department_id = jb.department_id  -- relasi department
      LEFT  JOIN xin_users xu     ON xu.user_id = jb.employer_id       -- relasi employer untuk filter
      LEFT  JOIN xin_user_roles ur ON ur.role_id = jb.position_id      -- level/role posisi
      LEFT  JOIN xin_jobs xj      ON xj.reff_job_id = jb.job_id       -- lowongan terpublish dari FPK
      LEFT  JOIN $sub_fd fd        ON fd.job_id = xj.job_id            -- subquery: FRCK Done (pemenuhan) per job
      LEFT  JOIN xin_employees pe ON pe.user_id = jb.pic               -- data PIC recruiter untuk filter where
      WHERE 1=1
        $where                                                          -- shared filter: employer, status, date_of_leaving, date_of_closing
        AND jb.pic IS NOT NULL                                          -- hanya FPK yang punya PIC
        AND COALESCE(fd.total, 0) > 0                                   -- hanya yang punya pemenuhan > 0
      ORDER BY jb.pic ASC, jb.job_title ASC                             -- urut per PIC lalu per posisi
    ")->result();
  }

  /**
   * Detail kebutuhan per PIC (job_title, department, position, job_vacancy)
   * Digunakan untuk hover tooltip di PIC Detail Table
   */
  function get_kebutuhan_detail_per_pic($bulan, $tahun, $company_id = '')
  {
    $where = $this->_where_clause($bulan, $tahun, 'pe', $company_id);

    return $this->db->query("
      SELECT
        jb.pic AS id_pic,                                               -- ID PIC recruiter
        jb.job_title,                                                   -- nama posisi
        dp.department_name AS department,                                -- nama department
        ur.role_name AS position,                                       -- nama level/role
        ur.role_id AS id_role,                                          -- ID level/role
        jb.job_vacancy                                                  -- jumlah kebutuhan per posisi
      FROM trusmi_jobs_request jb                                       -- tabel utama: permintaan karyawan (FPK)
      INNER JOIN xin_departments dp ON dp.department_id = jb.department_id  -- relasi department
      LEFT  JOIN xin_users xu     ON xu.user_id = jb.employer_id       -- relasi employer untuk filter
      LEFT  JOIN xin_user_roles ur ON ur.role_id = jb.position_id      -- level/role posisi
      LEFT  JOIN xin_jobs xj      ON xj.reff_job_id = jb.job_id       -- lowongan terpublish dari FPK
      LEFT  JOIN xin_employees pe ON pe.user_id = jb.pic               -- data PIC recruiter untuk filter where
      WHERE 1=1
        $where                                                          -- shared filter: employer, status, date_of_leaving, date_of_closing
      ORDER BY jb.pic ASC, jb.job_title ASC                             -- urut per PIC lalu per posisi
    ")->result();
  }

  /**
   * Posisi belum terpenuhi + usia posisi
   * Tab: Posisi Terbuka
   * Menggunakan _sub_frck_done agar sinkron dengan overview "Belum Terpenuhi"
   */
  function get_open_positions($bulan, $tahun, $company_id = '')
  {
    $sub_fd = $this->_sub_frck_done($bulan, $tahun);
    $where = $this->_where_clause($bulan, $tahun, 'pe', $company_id);

    return $this->db->query("
      SELECT
        jb.job_id AS no_fpk,                                            -- nomor FPK (ID permintaan karyawan)
        jb.job_vacancy,                                                 -- jumlah vacancy dari FPK
        jb.job_title AS posisi,                                         -- nama posisi yang dibutuhkan
        xu.first_name AS unit_bisnis,                                   -- nama unit bisnis (employer)
        CONCAT(pe.first_name, ' ', pe.last_name) AS pic_name,          -- nama PIC recruiter
        CONCAT(cb.first_name, ' ', cb.last_name) AS created_by_name,   -- nama pembuat FPK
        DATEDIFF(CURDATE(), jb.created_at) AS usia_posisi,              -- usia posisi dalam hari (sejak FPK dibuat)
        jb.job_vacancy AS target,                                       -- jumlah kebutuhan (target rekrut)
        COALESCE(fd.total, 0) AS terpenuhi,                             -- jumlah yang sudah terpenuhi (FRCK Done)
        GREATEST(jb.job_vacancy - COALESCE(fd.total, 0), 0) AS gap     -- sisa kebutuhan belum terpenuhi (min 0)
      FROM trusmi_jobs_request jb                                       -- tabel utama: permintaan karyawan (FPK)
      LEFT  JOIN xin_users xu     ON xu.user_id = jb.employer_id       -- relasi employer untuk ambil nama unit bisnis
      LEFT  JOIN xin_jobs xj      ON xj.reff_job_id = jb.job_id       -- lowongan terpublish dari FPK
      LEFT  JOIN xin_employees pe ON pe.user_id = jb.pic               -- data PIC recruiter
      LEFT  JOIN xin_employees cb ON cb.user_id = jb.created_by        -- data pembuat FPK
      LEFT  JOIN $sub_fd fd        ON fd.job_id = xj.job_id            -- subquery: FRCK Done (pemenuhan) per job
      WHERE 1=1
        $where   
        AND (jb.job_vacancy - COALESCE(fd.total, 0)) > 0               -- hanya tampilkan yang masih ada gap (belum terpenuhi penuh)
      ORDER BY DATEDIFF(CURDATE(), jb.created_at) DESC                  -- urut dari posisi paling lama terbuka
    ")->result();
  }
}