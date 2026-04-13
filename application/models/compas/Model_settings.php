<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_settings extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_brands()
    {
        // left join find in set by company_id and group_concat company_name
        $this->db->select('m_cmp_brand.brand_id, m_cmp_brand.brand_name, m_cmp_brand.brand_desc, m_cmp_brand.company_id, GROUP_CONCAT(xin_companies.name) AS company_name, m_cmp_brand.is_active');
        $this->db->from('m_cmp_brand');
        $this->db->join('xin_companies', 'FIND_IN_SET(xin_companies.company_id, m_cmp_brand.company_id)', 'left');
        $this->db->group_by('m_cmp_brand.brand_id');
        $this->db->order_by('m_cmp_brand.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_company()
    {
        $this->db->select('company_id, name AS company_name');
        $this->db->from('xin_companies');
        $this->db->order_by('name', 'ASC');
        return $this->db->get()->result();
    }

    public function insert_brand($data)
    {
        return $this->db->insert('m_cmp_brand', $data);
    }

    public function update_brand($brand_id, $data)
    {
        $this->db->where('brand_id', $brand_id);
        return $this->db->update('m_cmp_brand', $data);
    }

    public function delete_brand($brand_id)
    {
        $this->db->where('brand_id', $brand_id);
        return $this->db->delete('m_cmp_brand');
    }

    // Content Pillar CRUD
    public function get_content_pillars()
    {
        $this->db->select('m_cmp_content_pillar.*, GROUP_CONCAT(m_cmp_brand.brand_name) AS brand_names');
        $this->db->from('m_cmp_content_pillar');
        $this->db->join('m_cmp_brand', 'FIND_IN_SET(m_cmp_brand.brand_id, m_cmp_content_pillar.brand_id)', 'left');
        $this->db->group_by('m_cmp_content_pillar.cp_id');
        $this->db->order_by('m_cmp_content_pillar.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function insert_content_pillar($data)
    {
        return $this->db->insert('m_cmp_content_pillar', $data);
    }

    public function update_content_pillar($id, $data)
    {
        $this->db->where('cp_id', $id);
        return $this->db->update('m_cmp_content_pillar', $data);
    }

    public function delete_content_pillar($id)
    {
        $this->db->where('cp_id', $id);
        return $this->db->delete('m_cmp_content_pillar');
    }

    // Objective CRUD
    public function get_objectives()
    {
        $this->db->select('m_cmp_objective.*, GROUP_CONCAT(m_cmp_brand.brand_name) AS brand_names');
        $this->db->from('m_cmp_objective');
        $this->db->join('m_cmp_brand', 'FIND_IN_SET(m_cmp_brand.brand_id, m_cmp_objective.brand_id)', 'left');
        $this->db->group_by('m_cmp_objective.objective_id');
        $this->db->order_by('m_cmp_objective.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function insert_objective($data)
    {
        return $this->db->insert('m_cmp_objective', $data);
    }

    public function update_objective($id, $data)
    {
        $this->db->where('objective_id', $id);
        return $this->db->update('m_cmp_objective', $data);
    }

    public function delete_objective($id)
    {
        $this->db->where('objective_id', $id);
        return $this->db->delete('m_cmp_objective');
    }

    // Generated Content CRUD
    public function get_generated_contents()
    {
        $this->db->select('m_cmp_content_generated.*, GROUP_CONCAT(m_cmp_brand.brand_name) AS brand_names');
        $this->db->from('m_cmp_content_generated');
        $this->db->join('m_cmp_brand', 'FIND_IN_SET(m_cmp_brand.brand_id, m_cmp_content_generated.brand_id)', 'left');
        $this->db->group_by('m_cmp_content_generated.cg_id');
        $this->db->order_by('m_cmp_content_generated.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function insert_generated_content($data)
    {
        return $this->db->insert('m_cmp_content_generated', $data);
    }

    public function update_generated_content($id, $data)
    {
        $this->db->where('cg_id', $id);
        return $this->db->update('m_cmp_content_generated', $data);
    }

    public function delete_generated_content($id)
    {
        $this->db->where('cg_id', $id);
        return $this->db->delete('m_cmp_content_generated');
    }

    // Content Format CRUD
    public function get_content_formats()
    {
        $this->db->select('m_cmp_content_format.*, GROUP_CONCAT(m_cmp_brand.brand_name) AS brand_names');
        $this->db->from('m_cmp_content_format');
        $this->db->join('m_cmp_brand', 'FIND_IN_SET(m_cmp_brand.brand_id, m_cmp_content_format.brand_id)', 'left');
        $this->db->group_by('m_cmp_content_format.cf_id');
        $this->db->order_by('m_cmp_content_format.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function insert_content_format($data)
    {
        return $this->db->insert('m_cmp_content_format', $data);
    }

    public function update_content_format($id, $data)
    {
        $this->db->where('cf_id', $id);
        return $this->db->update('m_cmp_content_format', $data);
    }

    public function delete_content_format($id)
    {
        $this->db->where('cf_id', $id);
        return $this->db->delete('m_cmp_content_format');
    }
}