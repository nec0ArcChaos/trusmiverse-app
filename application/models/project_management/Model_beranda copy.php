<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_beranda extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function get_gantt_projects($start_date = null, $end_date = null, $user_id = null)
    {
        $this->db->select('p.*, c.alias as company_name, c.style as company_style, s.status_name, s.color as status_color, s.status_icon, s.style as status_style, (SELECT COUNT(id) FROM t_pm_evidence e WHERE e.project_id = p.id) as evidence_count');
        $this->db->from('t_pm_projects p');
        $this->db->join('xin_companies c', 'p.company_id = c.company_id', 'left');
        $this->db->join('m_pm_status s', 'p.status = s.id', 'left');

        if ($user_id) {
            $this->db->group_start();
            $this->db->where("FIND_IN_SET('$user_id', p.product_owner)");
            $this->db->or_where("FIND_IN_SET('$user_id', p.spv)");
            $this->db->or_where("FIND_IN_SET('$user_id', p.pm)");
            $this->db->or_where("p.id IN (SELECT DISTINCT project_id FROM t_pm_tasklist WHERE FIND_IN_SET('$user_id', pic))");
            $this->db->group_end();
        }
        
        if ($start_date && $end_date) {
            $this->db->group_start();
            $this->db->where("DATE(p.start_date) <=", $end_date);
            $this->db->or_where('p.start_date IS NULL');
            $this->db->group_end();

            $this->db->group_start();
            $this->db->where("DATE(p.deadline) >=", $start_date);
            $this->db->or_where('p.deadline IS NULL');
            $this->db->group_end();
        }

        $this->db->order_by('p.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_gantt_tasks($project_id, $start_date = null, $end_date = null, $user_id = null)
    {
        $this->db->select('t.*, s.status_name, s.color as status_color, s.status_icon, s.style as status_style, cat.category as category_name, cat.style as category_style, (SELECT COUNT(id) FROM t_pm_evidence e WHERE e.task_id = t.id) as evidence_count');
        $this->db->from('t_pm_tasklist t');
        $this->db->join('m_pm_status s', 't.status = s.id', 'left');
        $this->db->join('m_pm_categories cat', 't.category = cat.id', 'left');
        $this->db->where('t.project_id', $project_id);
        
        if ($user_id) {
            $this->db->where("FIND_IN_SET('$user_id', t.pic)");
        }
        
        if ($start_date && $end_date) {
            $this->db->group_start();
            $this->db->where("DATE(t.start_date) <=", $end_date);
            $this->db->or_where('t.start_date IS NULL');
            $this->db->group_end();

            $this->db->group_start();
            $this->db->where("DATE(t.deadline) >=", $start_date);
            $this->db->or_where('t.deadline IS NULL');
            $this->db->group_end();
        }

        $this->db->order_by('t.id', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_employee_initials($user_ids_string)
    {
        if (empty($user_ids_string)) return '';

        $user_ids = array_filter(explode(',', $user_ids_string));
        if (empty($user_ids)) return '';

        $this->db->select('first_name, last_name');
        $this->db->from('xin_employees');
        $this->db->where_in('user_id', $user_ids);
        $query = $this->db->get();
        $results = $query->result_array();

        $initials = [];
        foreach ($results as $row) {
            $f = substr(trim($row['first_name']), 0, 1);
            $l = !empty($row['last_name']) ? substr(trim($row['last_name']), 0, 1) : '';
            $initials[] = strtoupper($f . $l);
        }

        return implode(', ', $initials);
    }
    public function insert_project($data)
    {
        $this->db->insert('t_pm_projects', $data);
        return $this->db->insert_id();
    }

    public function update_project($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('t_pm_projects', $data);
    }

    public function insert_task($data)
    {
        $this->db->insert('t_pm_tasklist', $data);
        return $this->db->insert_id();
    }

    public function update_task($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('t_pm_tasklist', $data);
    }

    public function delete_item($id, $type)
    {
        if ($type == 'project') {
            $this->db->where('id', $id);
            $this->db->delete('t_pm_projects');
            
            $this->db->where('project_id', $id);
            $this->db->delete('t_pm_tasklist');
        } else {
            $this->db->where('id', $id);
            $this->db->delete('t_pm_tasklist');
        }
    }

    public function resolve_company_id($name)
    {
        $this->db->select('company_id');
        $this->db->from('xin_companies');
        $this->db->where('alias', $name);
        $res = $this->db->get()->row();
        return $res ? $res->company_id : null;
    }

    public function resolve_status_id($name)
    {
        $this->db->select('id');
        $this->db->from('m_pm_status');
        $this->db->where('status_name', $name);
        $res = $this->db->get()->row();
        return $res ? $res->id : null;
    }

    public function resolve_category_id($name)
    {
        $this->db->select('id');
        $this->db->from('m_pm_categories');
        $this->db->where('category', $name);
        $res = $this->db->get()->row();
        return $res ? $res->id : null;
    }

    public function get_lookup_options()
    {
        return [
            'companies' => $this->db->where('alias IS NOT NULL')->get('xin_companies')->result_array(),
            'statuses' => $this->db->get('m_pm_status')->result_array(),
            'categories' => $this->db->get('m_pm_categories')->result_array(),
            'employees' => $this->db->select('user_id, first_name, last_name, profile_picture')
            ->group_start()
            ->where('designation_id IN (405,459,570,984,1431)')
            ->or_where('department_id IN (68)')
            ->group_end()
            ->where('is_active', 1)
            ->get('xin_employees')->result_array(),
            'product_owners' => $this->db->select('user_id, first_name, last_name, profile_picture')
            ->where('user_role_id > 2')
            ->where('user_role_id IS NOT NULL')
            ->where('is_active', 1)
            ->get('xin_employees')->result_array()
        ];
    }

    public function get_evidence($id, $type) {
        if ($type == 'project') {
            $this->db->where('project_id', $id);
        } else {
            $this->db->where('task_id', $id);
        }
        return $this->db->get('t_pm_evidence')->result_array();
    }

    public function insert_evidence($data) {
        $this->db->insert('t_pm_evidence', $data);
        return $this->db->insert_id();
    }

    public function get_evidence_by_id($id) {
        return $this->db->where('id', $id)->get('t_pm_evidence')->row();
    }

    public function delete_evidence($id) {
        $this->db->where('id', $id)->delete('t_pm_evidence');
    }

    public function get_gantt_view($user_id) {
        return $this->db->where('user_id', $user_id)->get('t_pm_gantt_view')->row_array();
    }

    public function save_gantt_view($user_id, $data) {
        $data['user_id'] = $user_id;
        $existing = $this->db->where('user_id', $user_id)->get('t_pm_gantt_view')->row();
        if ($existing) {
            $this->db->where('user_id', $user_id)->update('t_pm_gantt_view', $data);
        } else {
            $this->db->insert('t_pm_gantt_view', $data);
        }
    }

    public function get_dashboard_stats($start_date, $end_date)
    {
        $this->db->select('id, start_date, deadline, end_date, status');
        $this->db->from('t_pm_tasklist');
        $this->db->where("DATE(start_date) >=", $start_date);
        $this->db->where("DATE(start_date) <=", $end_date);
        $tasks = $this->db->get()->result_array();

        $stats = [
            'weeks' => [],
            'statuses' => [
                'not_started' => 0,
                'progress' => 0,
                'done' => 0,
                'qa' => 0,
                'cancelled' => 0,
                'need_data' => 0
            ],
            'ontime' => 0,
            'late' => 0
        ];

        // Ensure week 1 to 4 exist by default
        for ($i = 1; $i <= 4; $i++) {
            $stats['weeks']["W$i"] = ['total' => 0, 'done' => 0];
        }

        $today = date('Y-m-d H:i:s');

        foreach ($tasks as $t) {
            $st = (int)$t['status'];
            if ($st === 1) $stats['statuses']['not_started']++;
            elseif ($st === 2) $stats['statuses']['progress']++;
            elseif ($st === 3) $stats['statuses']['done']++;
            elseif ($st === 4) $stats['statuses']['qa']++;
            elseif ($st === 5) $stats['statuses']['need_data']++;
            elseif ($st === 6) $stats['statuses']['cancelled']++;

            if ($st === 3) {
                if (!empty($t['end_date']) && !empty($t['deadline']) && $t['end_date'] <= $t['deadline']) {
                    $stats['ontime']++;
                } else {
                    $stats['late']++;
                }
            } else {
                if (!empty($t['deadline']) && $t['deadline'] < $today) {
                    $stats['late']++;
                } else {
                    $stats['ontime']++;
                }
            }

            if (!empty($t['start_date'])) {
                $t_start = new DateTime($t['start_date']);
                $wk = !empty($t['week']) ? $t['week'] : $this->_calculate_week_num($t['start_date']);
                
                if (!isset($stats['weeks'][$wk])) {
                    $stats['weeks'][$wk] = ['total' => 0, 'done' => 0];
                }
                
                $stats['weeks'][$wk]['total']++;
                if ($st === 3) {
                    $stats['weeks'][$wk]['done']++;
                }
            }
        }

        $weeks_array = [];
        foreach (['W1', 'W2', 'W3', 'W4'] as $wk) {
            if (isset($stats['weeks'][$wk])) {
                $weeks_array[] = ['name' => $wk, 'total' => $stats['weeks'][$wk]['total'], 'done' => $stats['weeks'][$wk]['done']];
            }
        }
        $stats['weeks'] = $weeks_array;

        return $stats;
    }

    private function _calculate_week_num($dateString) 
    {
        if (empty($dateString)) return 'W1';
        $d = new DateTime($dateString);
        $year = (int)$d->format('Y');
        $month = (int)$d->format('n');
        
        $calcW = function($dateObj) use ($year, $month) {
            $firstDay = new DateTime("$year-$month-01");
            $dayNum = (int)$dateObj->format('j');
            $firstDayOfWeek = (int)$firstDay->format('w');
            return ceil(($dayNum + $firstDayOfWeek) / 7);
        };
        
        $lastDay = new DateTime($d->format('Y-m-t'));
        $totalWeeks = $calcW($lastDay);
        $rawW = $calcW($d);
        
        if ($totalWeeks <= 4) return "W" . $rawW;
        
        $getWorkDays = function($w) use ($year, $month, $lastDay, $calcW) {
            $count = 0;
            $max_day = (int)$lastDay->format('j');
            for ($i = 1; $i <= $max_day; $i++) {
                $curr = new DateTime("$year-$month-$i");
                if ($calcW($curr) == $w && (int)$curr->format('w') != 0) {
                    $count++;
                }
            }
            return $count;
        };
        
        $resW = 1;
        if ($totalWeeks == 5) {
            $wd1 = $getWorkDays(1);
            $wd5 = $getWorkDays(5);
            if ($wd1 < $wd5) {
                if ($rawW <= 2) $resW = 1;
                elseif ($rawW == 3) $resW = 2;
                elseif ($rawW == 4) $resW = 3;
                elseif ($rawW == 5) $resW = 4;
            } else {
                if ($rawW == 1) $resW = 1;
                elseif ($rawW == 2) $resW = 2;
                elseif ($rawW == 3) $resW = 3;
                elseif ($rawW >= 4) $resW = 4;
            }
        } else {
            if ($rawW <= 2) $resW = 1;
            elseif ($rawW == 3) $resW = 2;
            elseif ($rawW == 4) $resW = 3;
            elseif ($rawW >= 5) $resW = 4;
        }
        return "W" . min(4, max(1, $resW));
    }
}