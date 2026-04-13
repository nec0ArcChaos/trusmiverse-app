<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Anniversary_notif extends CI_Controller
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
		echo "Happy Anniversary!";
	}


	function notif()
	{
// 		$emp_birthday = $this->db->query("SELECT 
// 	CONCAT(first_name,' ',last_name) AS name,
// 	date_of_joining,
// 	contact_no,
// 	TIMESTAMPDIFF( YEAR, date_of_joining, CURDATE( ) ) AS age_joining
// FROM
//  xin_employees
// WHERE 
// 	DAY(date_of_joining) = DAY(CURDATE()) AND
// 	MONTH(date_of_joining) = MONTH(CURDATE()) AND 
// 	TIMESTAMPDIFF( YEAR, date_of_joining, CURDATE( ) ) > 0")->result();

$emp_birthday = $this->db->query("SELECT 
	CONCAT(first_name,' ',last_name) AS name,
	date_of_joining,
	contact_no,
	TIMESTAMPDIFF( YEAR, date_of_joining, CURDATE( ) ) AS age_joining,
	company_id
FROM
 xin_employees
WHERE 
	user_id = 8257")->result();

		foreach ($emp_birthday as $employee) {
			$msg = "🎉 *Happy Work Anniversary!* 🎉

Selamat merayakan hari jadi kerjamu, *".$employee->name."*! 🥳🎊
*".$employee->age_joining."* tahun penuh kerja keras, dedikasi, dan pencapaian luar biasa! 💪✨
Semoga kariermu terus bersinar dan membawa lebih banyak kesuksesan di masa depan! 🚀🌟

Terima kasih sudah jadi bagian penting dalam tim ini 🙌
Tetap semangat dan terus berkarya! 💼🔥

🎈Cheers untuk perjalanan yang luar biasa ini! 🥂🎁";

$this->whatsapp_lib->send_single_image_caption('rsp', $employee->contact_no, $msg, "https://trusmiverse.com/apps/assets/emp/happy-aniv.jpg");
sleep(1);
		}
		echo "Work Anniversary notification sent successfully!";
		
	}

}
