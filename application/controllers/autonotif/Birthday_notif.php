<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Birthday_notif extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library('Whatsapp_lib');
		$this->load->database();
	}

	function index()
	{
		echo "Happy Birthday!";
	}

	function notif()
	{
// 		$emp_birthday = $this->db->query("SELECT 
// 	CONCAT(first_name,' ',last_name) AS name,
// 	date_of_birth,
// 	contact_no,
// 	TIMESTAMPDIFF( YEAR, date_of_birth, CURDATE( ) ) AS age
// FROM
//  xin_employees
// WHERE 
// 	DAY(date_of_birth) = DAY(CURDATE()) AND
// 	MONTH(date_of_birth) = MONTH(CURDATE())")->result();

$emp_birthday = $this->db->query("SELECT 
	CONCAT(first_name,' ',last_name) AS name,
	date_of_birth,
	contact_no,
	TIMESTAMPDIFF( YEAR, date_of_birth, CURDATE( ) ) AS age,
	CONCAT(FLOOR(TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE))/12), ' Tahun, ', TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE)) - (FLOOR(TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE))/12)*12), ' Bulan') AS masa_kerja,
	xin_employees.company_id,
	m_dashboard_ultah.text_ultah_wa,
	m_dashboard_ultah.url_image
FROM
 xin_employees
 LEFT JOIN m_dashboard_ultah ON xin_employees.company_id = m_dashboard_ultah.company_id
WHERE 
	user_id = 8257")->result();

		foreach ($emp_birthday as $employee) {

$text = $employee->text_ultah_wa;
$text = str_replace("[nama]", $employee->name, $text);
$text = str_replace("[umur]", $employee->age, $text);
$text = str_replace("[masa_kerja]", $employee->masa_kerja, $text);
$text = str_replace("[emot1]", "🥳🎊", $text);
$text = str_replace("[emot2]", "🤗", $text);
$text = str_replace("[emot3]", "🥂✨", $text);

$this->whatsapp_lib->send_single_image_caption('rsp', $employee->contact_no, $text, $employee->url_image);
			sleep(1);
		}
		echo "Birthday notification sent successfully!";
		
	}

}
