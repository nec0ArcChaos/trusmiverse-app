<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_revisi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function update_duedate()
    {
        $this->load->database();
        $sql = "
            UPDATE td_task
            JOIN (
                SELECT
                    id_task,
                    MAX(`end`) AS due_date_sub_task
                FROM td_sub_task
                GROUP BY id_task
            ) AS sub_max ON td_task.id_task = sub_max.id_task
            SET td_task.due_date = sub_max.due_date_sub_task
            WHERE sub_max.due_date_sub_task > td_task.due_date
        ";

        $result = $this->db->query($sql);
        echo "<pre>";
        print_r ($result);
        echo "</pre>";
    }
}
