<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_autodrive extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

   public function check_nomor_multi($numbers = [])
{
    if (empty($numbers)) return null;

    // ==========================
    //  QUERY UTAMA: BOOKING
    // ==========================
    $this->db->select("
        CONCAT(xe.first_name, ' ', xe.last_name) AS full_name,
        xe.contact_no,

        -- TARGET
        CASE 
            WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) >= 12 THEN 4
            WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 3
            WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 2
            WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 1
            ELSE 1
        END AS target,

        COUNT(gci.id_gci) AS booking,

        -- SISA
        (
            CASE 
                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) >= 12 THEN 4
                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 3
                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 2
                WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 1
                ELSE 1
            END - COALESCE(COUNT(gci.id_gci), 0)
        ) AS sisa,

        -- ACHIEVE
        ROUND(
            (
                COUNT(gci.id_gci) /
                (
                    CASE 
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) >= 12 THEN 4
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 6 AND 11 THEN 3
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 3 AND 5 THEN 2
                        WHEN TIMESTAMPDIFF(MONTH, xe.date_of_joining, CURDATE()) BETWEEN 1 AND 2 THEN 1
                        ELSE 1
                    END
                )
            ) * 100
        ) AS achieve
    ", FALSE);

    $this->db->from("xin_employees xe");
    $this->db->join("rsp_project_live.`user` usr", "usr.join_hr = xe.user_id", "left");

    $this->db->join("rsp_project_live.t_gci gci", "
        LEFT(gci.created_at, 7) = LEFT(CURDATE(), 7)
        AND gci.created_by = usr.id_user
        AND gci.id_kategori IN (3,4)
    ", "left");

    $this->db->join("rsp_project_live.m_konsumen konsumen", "konsumen.id_konsumen = gci.id_konsumen", "left");
    $this->db->join("rsp_project_live.m_project project", "project.id_project = gci.id_project", "left");

    $this->db->where("xe.is_active", 1);
    $this->db->where("xe.wa_notif_reg", 1);

    $this->db->group_start();
    foreach ($numbers as $num) {
        $this->db->or_where("xe.contact_no", $num);
    }
    $this->db->group_end();

    $this->db->group_by("xe.user_id");

    $query = $this->db->get();

    if ($query->num_rows() == 0) return null;

    $result = $query->row_array();


    // ====================================
    //   LIST BOOKING PER SALES
    // ====================================
    $this->db->select("konsumen.nama_konsumen, project.project, gci.blok");
    $this->db->from("rsp_project_live.t_gci gci");
    $this->db->join("rsp_project_live.m_konsumen konsumen", "konsumen.id_konsumen = gci.id_konsumen", "left");
    $this->db->join("rsp_project_live.m_project project", "project.id_project = gci.id_project", "left");
    $this->db->join("rsp_project_live.`user` usr", "usr.id_user = gci.created_by", "left");
    $this->db->join("xin_employees xe", "xe.user_id = usr.join_hr", "left");

    $this->db->where("xe.contact_no", '6287779818672');
    $this->db->where("LEFT(gci.created_at,7) = LEFT(CURDATE(),7)");
    $this->db->where_in("gci.id_kategori", [3, 4]);

    $q2 = $this->db->get()->result_array();

    if (count($q2) > 0) {
        $list = "";
        $no = 1;

        foreach ($q2 as $row) {
            $list .= "   $no. {$row['nama_konsumen']} - {$row['project']} - {$row['blok']}\n";
            $no++;
        }

        $result['list_booking'] = $list;

    } else {
        $result['list_booking'] = "Belum ada booking bulan ini.";
    }


    // ====================================
    //   ACTIVITY HARI INI
    // ====================================
    $this->db->select("
        kel.kelurahan,
        act.jam,
        act.longitude,
        act.latitude,
        CONCAT('https://www.google.com/maps?q=', act.latitude, ',', act.longitude) AS link
    ");
    $this->db->from("xin_employees xe");
    $this->db->join("rsp_project_live.`user` usr", "usr.join_hr = xe.user_id", "left");
    $this->db->join("rsp_project_live.t_activity_marketing mkt", "mkt.id_mkt = usr.id_user", "left");
    $this->db->join("rsp_project_live.t_activity act", "act.id_activity = mkt.id_activity AND DATE(act.tanggal) = CURDATE()", "left");
    $this->db->join("rsp_project_live.r_kelurahan_new kel", "kel.id_kelurahan = act.kelurahan", "left");

    // FIX: pakai nomor dari result, bukan hardcode
    $this->db->where("xe.contact_no", $result['contact_no']);

    $act = $this->db->get()->row_array();

    if ($act && $act['kelurahan'] != null) {
        $result['activity_today'] = $act;
    } else {
        $result['activity_today'] = [
            "kelurahan" => "-",
            "jam"       => "-",
            "longitude" => "-",
            "latitude"  => "-",
            "link"      => "-"
        ];
    }

    // ====================================
//   POI RADIUS 1 KM DARI ACTIVITY
// ====================================

// 1. Ambil longitude & latitude dari activity hari ini
$this->db->select("
    act.longitude,
    act.latitude
");
$this->db->from("xin_employees xe");
$this->db->join("rsp_project_live.`user` usr", "usr.join_hr = xe.user_id", "left");
$this->db->join("rsp_project_live.t_activity_marketing mkt", "mkt.id_mkt = usr.id_user", "left");
$this->db->join("rsp_project_live.t_activity act", "act.id_activity = mkt.id_activity AND DATE(act.tanggal) = CURDATE()", "left");

$this->db->where("xe.contact_no", $result['contact_no']);
$this->db->limit(1);

$lokasi = $this->db->get()->row_array();

if ($lokasi && $lokasi['latitude'] != null && $lokasi['longitude'] != null) {

    $lat = $lokasi['latitude'];
    $lng = $lokasi['longitude'];

    // 2. Query POI Radius 1 KM
    $sql_poi = "
        SELECT 
            poi.id,
            poi.category,
            poi.subcategory,
            poi.poi_name,
            poi.latitude,
            poi.longitude,
            (
                6371 * ACOS(
                    COS(RADIANS($lat)) *
                    COS(RADIANS(poi.latitude)) *
                    COS(RADIANS(poi.longitude) - RADIANS($lng)) +
                    SIN(RADIANS($lat)) *
                    SIN(RADIANS(poi.latitude))
                )
            ) AS distance_km
        FROM rsp_project_live.m_poi AS poi
        HAVING distance_km <= 1
        ORDER BY distance_km ASC
    ";

    $poi = $this->db->query($sql_poi)->result_array();

    if (!empty($poi)) {
        $result['poi_nearby'] = $poi;
    } else {
        $result['poi_nearby'] = [];
    }

} else {

    // Tidak ada lokasi → POI otomatis kosong
    $result['poi_nearby'] = [];
}

    return $result;
}


}
