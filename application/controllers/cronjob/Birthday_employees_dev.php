<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Birthday_employees_dev extends CI_Controller
{
    protected $noTelpHR;
    protected $birthdayImageUrl;
    protected $defaultPhotoPath;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('BirthdayImage');
        $this->load->library('WAJS_hr');
        $this->load->model('Model_birthday_employees', 'model'); 

        $this->photoPath = $this->config->item('employee_profile_photo_path');

        $this->birthdayImageUrl = 'https://trusmiverse.com/apps/uploads/birthday/generated/';

        // default foto jika tidak ada foto karyawan
        $this->defaultPhotoPath = FCPATH . 'uploads/birthday/tg-logo.png'; 

        $this->noTelpHR = '6281229044211'; // no HR
    }

    public function test() {
        $employees = $this->model->getBirthdayByDate();

        $result['data'] = $employees;

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    /* untuk preview hasil generate image */
    public function preview_birthday()
    {
        $employee = $this->model->getBirthdayByUserId(11219);
        // $employee = $this->model->getBirthdayByUserId(9910);
        // $employee = $this->model->getBirthdayByUserId(10224);
        // $employee = $this->model->getBirthdayByUserId(61);

        if (empty($employee)) {
            echo "Karyawan tidak ditemukan";
            return;
        }

        /* normalisasi & validate phone */
        $rawPhone   = $employee->phone;
        $phone      = $this->normalizePhone($rawPhone);
        $isValid    = $this->isValidPhone($phone);

        /* normalisasi employee name */
        $normalizedName = $this->normalizeEmployeeName($employee->fullname);

        /* generate image */
        $imageUrl = null;
        $imageGenerated = false;

        if (!empty($employee->photo)) {
            $candidatePath = $this->photoPath . $employee->photo;
            $photoFilePath = file_exists($candidatePath) ? $candidatePath : $this->defaultPhotoPath;
        } else {
            $photoFilePath = $this->defaultPhotoPath;
        }

        if (file_exists($photoFilePath)) {
            $filename = $this->birthdayimage->generate(
                $photoFilePath,
                $normalizedName,
                $employee->designation,
                $employee->date_of_birth
            );

            if ($filename) {
                $imageGenerated = true;
                $imageUrl = $this->birthdayImageUrl . $filename;
            }
        }

        /* build message */
        $message = $this->buildBirthdayMessage($employee);

        $result = [
            'employee' => [
                'id'            => $employee->user_id ?? null,
                'name'          => $employee->fullname,
                'designation'   => $employee->designation,
                'gender'        => $employee->gender,
                'birthday'      => $employee->date_of_birth,
            ],
            'phone' => [
                'raw'       => $rawPhone,
                'normalized'=> $phone,
                'is_valid'  => $isValid,
            ],
            'photo' => [
                'original'  => $employee->photo,
                'generated' => $imageGenerated,
                'image_url' => $imageUrl,
            ],
            'whatsapp' => [
                'message'   => $message,
                'will_send' => $isValid,
            ]
        ];
        
        header('Content-Type: application/json');
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    // cron
    public function send_birthday_by_date() {
        $employees = $this->model->getBirthdayByDate();
        
        if (empty($employees)) {
            echo "Tidak ada karyawan ulang tahun hari ini";
            return;
        }

        $payload = [];

        foreach ($employees as $employee) {
            $imageUrl = null;
            $normalizedName = $this->normalizeEmployeeName($employee->fullname);
            
            $photoFilePath = (!empty($employee->photo) && file_exists($this->photoPath . $employee->photo)) 
                            ? $this->photoPath . $employee->photo 
                            : $this->defaultPhotoPath;

            $filename = $this->birthdayimage->generate(
                $photoFilePath, 
                $normalizedName, 
                $employee->designation, 
                $employee->date_of_birth
            );
            
            if ($filename) {
                $imageUrl = $this->birthdayImageUrl . $filename;
            }

            $joinDate = new DateTime($employee->date_of_joining);
            $interval = $joinDate->diff(new DateTime());
            $usiaKerja = $interval->y . " Tahun " . $interval->m . " Bulan";

            $payload[] = [
                'user_id'         => $employee->user_id,
                'fullname'        => $employee->fullname,
                'designation'     => $employee->designation,
                'gender'          => $employee->gender,
                'date_of_birth'   => $employee->date_of_birth,
                'date_of_joining' => $employee->date_of_joining,
                'usia_kerja'      => $usiaKerja,
                'phone'           => $this->normalizePhone($employee->phone),
                'image_url'       => $imageUrl
            ];
        }

        if (!empty($payload)) {
            $this->_triggerN8nGenerator(['data' => $payload]);
        }

        echo "Proses batch trigger n8n selesai (" . count($payload) . " karyawan).";
    }

    public function receive_birthday_callback() {
        $raw_input = file_get_contents('php://input');
        $input = json_decode($raw_input, true);

        log_message('debug', 'N8N Payload: ' . $raw_input);

        if (empty($input)) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Data Kosong']);
            return;
        }

        $dataLog = [
            'user_id'         => $input['user_id'],
            'fullname'        => $input['fullname'],
            'designation'     => $input['designation'],
            'gender'          => $input['gender'],
            'date_of_birth'   => $input['date_of_birth'],
            'date_of_joining' => $input['date_of_joining'], 
            'phone'           => $input['phone'],
            'image_url'       => $input['image_url'],
            'message'         => $input['message']
        ];

        $this->db->insert('birthday_employees_log', $dataLog);

        $this->sendWhatsapp($dataLog['phone'], $dataLog['message'], $dataLog['image_url']);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    }

    // ======================================================
    // HELPER METHOD
    // ======================================================

    // normalisasi no telepon
    protected function normalizePhone($phone)
    {
        if (empty($phone)) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);

        // jika diawali 0 -> ganti 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    // validasi no telepon
    protected function isValidPhone($phone)
    {
        return (
            !empty($phone) &&
            substr($phone, 0, 2) === '62' &&
            strlen($phone) >= 10
        );
    }

    // Normalisasi nama jika terlalu panjang 
    protected function normalizeEmployeeName($fullname, $maxLength = 20)
    {
        $fullname = trim(preg_replace('/\s+/', ' ', $fullname));

        if (mb_strlen($fullname) <= $maxLength) {
            return $fullname;
        }

        // pecah jadi kata
        $parts = explode(' ', $fullname);

        // ambil dua kata pertama saja
        if (count($parts) >= 2) {
            return $parts[0] . ' ' . $parts[1];
        }

        // fallback
        return $parts[0];
    }

    // Kirim whatsapp
    protected function sendWhatsapp($phone, $message, $imageUrl = null)
    {
        $type   = $imageUrl ? 'image' : 'text';
        $domain = 'trusmiverse';

        return $this->wajs_hr->send_wajs_notif_hr(
            $phone,
            $message,
            $type,
            $domain,
            $imageUrl ? $imageUrl : ''
        );
    }

    /* DEV */
    private function _triggerN8nGenerator($payload) {
        // $url = 'https://n8n.trustcore.id/webhook-test/generate-birthday-text'; // test
        $url = 'https://n8n.trustcore.id/webhook/generate-birthday-text'; // production

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_exec($ch);
        curl_close($ch);
    }
}
