<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_jadwal_shift extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_user_shift($department_id, $cutoff)
  {
      $query = "SELECT
              e.user_id,
              e.office_shift_id,
              CONCAT(e.first_name,' ',e.last_name) AS full_name,
              e.username,
              e.company_id,
              c.name AS company_name,
              e.department_id,
              d.department_name,
              e.designation_id,
              ds.designation_name,
              '' AS shift
          FROM xin_employees e
          LEFT JOIN xin_companies c 
              ON c.company_id = e.company_id
          LEFT JOIN xin_departments d 
              ON d.department_id = e.department_id
          LEFT JOIN xin_designations ds 
              ON ds.designation_id = e.designation_id
           LEFT JOIN xin_office_shift xos 
              ON xos.office_shift_id = e.office_shift_id
          WHERE e.is_active = 1
          AND ds.trusmi_shift IS NOT NULL 
          AND xos.trusmi_shift IS NOT NULL
          AND e.department_id = '$department_id'
        AND e.ctm_cutoff = '$cutoff'

      ";

    // $data = $this->db->query($query)->result();

      return $this->db->query($query)->result();
  }

    // public function get_shift()
    // {
    //     $this->db->select('office_shift_id, shift_name');
    //     $this->db->from('xin_office_shift');
    //     return $this->db->get()->result();
    // }

    public function get_shift($designationListString)
    {
        $query = $this->db->query("SELECT
                b.shift AS nama_grup,
                a.shift_name,
                GROUP_CONCAT(DISTINCT c.designation_name) AS designation_list,
                a.office_shift_id,
                a.trusmi_shift AS id_grup,

                CONCAT(a.monday_in_time, ' - ', a.monday_out_time) AS senin,
                CONCAT(a.tuesday_in_time, ' - ', a.tuesday_out_time) AS selasa,
                CONCAT(a.wednesday_in_time, ' - ', a.wednesday_out_time) AS rabu,
                CONCAT(a.thursday_in_time, ' - ', a.thursday_out_time) AS kamis,
                CONCAT(a.friday_in_time, ' - ', a.friday_out_time) AS jumat,
                CONCAT(a.saturday_in_time, ' - ', a.saturday_out_time) AS sabtu,
                CONCAT(a.sunday_in_time, ' - ', a.sunday_out_time) AS minggu

            FROM xin_office_shift a
            LEFT JOIN trusmi_shift b 
                ON a.trusmi_shift = b.id_trusmi_shift
            LEFT JOIN xin_designations c 
                ON a.trusmi_shift = c.trusmi_shift
            WHERE a.trusmi_shift IS NOT NULL
            AND c.designation_id IN ($designationListString)
            GROUP BY a.trusmi_shift, a.office_shift_id
            ORDER BY a.trusmi_shift
        ");

        return $query->result();
    }

    public function data_jadwal_shift($department_id, $periode, $cutoff)
    {
        $query = "SELECT
                t.id,
                t.tanggal,
                DATE_FORMAT(t.tanggal,'%W') AS day_name,
                
                e.user_id,
                e.username,
                CONCAT(e.first_name,' ',e.last_name) AS full_name,
                CONCAT(e2.first_name,' ',e2.last_name) AS input_by,
                e.ctm_cutoff AS cutoff,


                c.name AS company_name,
                d.department_name,
                ds.designation_name,
                e.designation_id,


                s.office_shift_id,
                s.shift_name,

                CASE DAYNAME(t.tanggal)
                    WHEN 'Monday' THEN s.monday_in_time
                    WHEN 'Tuesday' THEN s.tuesday_in_time
                    WHEN 'Wednesday' THEN s.wednesday_in_time
                    WHEN 'Thursday' THEN s.thursday_in_time
                    WHEN 'Friday' THEN s.friday_in_time
                    WHEN 'Saturday' THEN s.saturday_in_time
                    WHEN 'Sunday' THEN s.sunday_in_time
                END AS shift_in,

                CASE DAYNAME(t.tanggal)
                    WHEN 'Monday' THEN s.monday_out_time
                    WHEN 'Tuesday' THEN s.tuesday_out_time
                    WHEN 'Wednesday' THEN s.wednesday_out_time
                    WHEN 'Thursday' THEN s.thursday_out_time
                    WHEN 'Friday' THEN s.friday_out_time
                    WHEN 'Saturday' THEN s.saturday_out_time
                    WHEN 'Sunday' THEN s.sunday_out_time
                END AS shift_out,
                t.created_at

            FROM t_jadwal_shift t
            LEFT JOIN xin_employees e
                ON e.user_id = t.user_id
            LEFT JOIN xin_employees e2
                ON e2.user_id = t.created_by
            LEFT JOIN xin_office_shift s
                ON s.office_shift_id = t.office_shift_id
            LEFT JOIN xin_companies c 
              ON c.company_id = e.company_id
            LEFT JOIN xin_departments d 
                ON d.department_id = e.department_id
            LEFT JOIN xin_designations ds 
                ON ds.designation_id = e.designation_id

            
            WHERE e.is_active = 1            
            AND e.department_id = '$department_id'
            AND t.periode = '$periode'
            AND e.ctm_cutoff = '$cutoff'
            ORDER BY e.first_name ASC;
        ";

        // $data = $this->db->query($query)->result();

        return $this->db->query($query)->result();
    }

    public function cek_jam_shift($department_id)
    {
        $query = "SELECT	
                b.shift AS nama_grup,	
                a.shift_name,	
                GROUP_CONCAT(DISTINCT c.designation_name) AS designation_list,	
                    
                a.office_shift_id, a.trusmi_shift AS id_grup,	
                a.monday_in_time, a.monday_out_time,
                a.tuesday_in_time, a.tuesday_out_time,
                a.wednesday_in_time, a.wednesday_out_time,
                a.thursday_in_time, a.thursday_out_time,
                a.friday_in_time, a.friday_out_time,
                a.saturday_in_time, a.saturday_out_time,
                a.sunday_in_time, a.sunday_out_time
                    
                FROM xin_office_shift a	
                LEFT JOIN trusmi_shift b ON a.trusmi_shift = b.id_trusmi_shift	
                LEFT JOIN xin_designations c ON a.trusmi_shift = c.trusmi_shift	
                WHERE a.trusmi_shift IS NOT NULL	
                GROUP BY a.trusmi_shift, a.office_shift_id	
                ORDER BY a.trusmi_shift	
                ";

        // $data = $this->db->query($query)->result();

        return $this->db->query($query)->result();
    }
}
