<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormatJson
{
	protected static $ci;

	public function __construct()
	{
        self::$ci =& get_instance();
	}

	public static function listdata($tbl=null, $showActive=TRUE, $filter=null)
	{
		$tbl = self::$ci->db->dbprefix . str_replace(self::$ci->db->dbprefix, "", $tbl);
		$fields = self::$ci->db->query("SHOW COLUMNS FROM ". $tbl)->result();
		$fieldname = array();
		$foundIsActive = FALSE;
		
		foreach ($fields as $field) {
			$fieldname[] = $field->Field;
			if ($field->Field=="IsActive") {
			 	$foundIsActive = TRUE;
			 } 
		}

		if ($showActive && $foundIsActive) {
			$tbl .= " WHERE IsActive=1 ";

			if (isset($filter)) {
				$tbl .= "AND ". $filter;
			}
		}else{
			if (isset($filter)) {
				$tbl .= $filter;
			}
		}

		$list = self::$ci->db->query("SELECT * FROM ". $tbl)->result();

		$data = array();
        $no = 0;
        foreach ($list as $ls) {
            $no++;
            $row = array();
            $row["No"] = $no;
            for ($i = 0; $i < count($fieldname); $i++) {
            	$fieldnm = $fieldname[$i];
            	$row["$fieldname[$i]"] = $ls->$fieldnm;
            }
            $data[] = $row;
        }

        $output['data'] = array('item' => $data);
        echo json_encode($output);
	}

}

/* End of file FormatJson.php */
/* Location: ./application/libraries/FormatJson.php */
