<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Birthday_employees extends CI_Controller
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
        $employee = $this->model->getBirthdayByUserId(11219);
        
        if (!$employee) {
            echo "Data karyawan tidak ditemukan.";
            return;
        }

        $aiResponse = $this->_generateAiBirthdayMessage($employee);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'sent_data' => $employee,
            'n8n_output' => $aiResponse
        ], JSON_PRETTY_PRINT);
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
    public function send_birthday_by_date()
    {
        $employees = $this->model->getBirthdayByDate();

        if (empty($employees)) {
            echo "Tidak ada karyawan ulang tahun hari ini";
            return;
        }

        foreach ($employees as $employee) {

            /* normalisasi nama untuk image */
            $normalizedName = $this->normalizeEmployeeName($employee->fullname);

            /* generate image */
            $imageUrl = null;

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
                    $imageUrl = $this->birthdayImageUrl . $filename;
                }
            }

            /* build message */
            $message = $this->buildBirthdayMessage($employee);

            /* send WA */ 
            $this->sendWhatsapp($this->noTelpHR, $message, $imageUrl);
        
        }

        echo "Proses kirim pesan ulang tahun karyawan selesai";
    }

    // Hit manual by User ID
    // contoh endpoint = GET https://trusmiverse.com/apps/cronjob/birthday_employees/send_birthday_by_user_id/11219
    public function send_birthday_by_user_id($user_id = null)
    {
        if (empty($user_id)) {
            echo "User ID tidak ditemukan";
            return;
        }

        $employee = $this->model->getBirthdayByUserId($user_id);

        if (empty($employee)) {
            echo "Data karyawan tidak ditemukan";
            return;
        }

        /* normalisasi & validate phone */
        $rawPhone = $employee->phone;
        $phone = $this->normalizePhone($rawPhone);
        $isValidPhone = $this->isValidPhone($phone);

        /* skip jika phone tidak valid */
        if (!$isValidPhone) {
            echo "Nomor telepon tidak valid";
            return;
        }

        /* normalisasi nama untuk image */
        $normalizedName = $this->normalizeEmployeeName($employee->fullname);

        /* generate image */
        $imageUrl = null;

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
                $imageUrl = $this->birthdayImageUrl . $filename;
            }
        }

        /* build message */
        $message = $this->buildBirthdayMessage($employee);

        /* kirim WA */
        $this->sendWhatsapp($this->noTelpHR, $message, $imageUrl);

        echo "Berhasil mengirim pesan whatsapp ulang tahun untuk user ID: {$user_id}";
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

    // Build pesan ulang tahun
    protected function buildBirthdayMessage($employee)
    {
        $name = $employee->fullname;

        return
            "🎉 *Selamat Ulang Tahun {$name}!* 🎉\n\n" .
            "Semoga di usia yang baru ini, {$name} selalu diberi kesehatan 💪, " .
            "kelancaran dalam bekerja 💼, dan kesuksesan dalam setiap langkah ⭐.\n\n" .
            "Terima kasih atas kontribusi dan dedikasi yang selalu diberikan 🙏.\n" .
            "Semoga semakin semangat dan produktif ke depannya! 🚀✨\n\n" .
            "*_Salam Hangat,_*\n" .
            "*_Trusmi Group_*";
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
    // private function _generateAiBirthdayMessage($employee) {
    //     // Hitung Usia Kerja
    //     $joinDate = new DateTime($employee->date_of_joining);
    //     $today = new DateTime();
    //     $interval = $joinDate->diff($today);
    //     $usiaKerja = $interval->y . " Tahun " . $interval->m . " Bulan";

    //     $payload = [
    //         'nama' => $employee->fullname,
    //         'usia_kerja' => $usiaKerja,
    //         'jabatan' => $employee->designation
    //     ];

    //     $n8nWebhookUrl = 'https://n8n.trustcore.id/webhook/generate-birthday-text';

    //     $ch = curl_init($n8nWebhookUrl);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
    //     // Sabar menunggu AI berpikir (60 detik)
    //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    //     $response = curl_exec($ch);
        
    //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);

    //     $fallback = "Selamat Ulang Tahun, {$employee->fullname}! Sukses selalu bersama Trusmi Group. 🎉";

    //     if ($httpCode === 200) {
    //         $result = json_decode($response, true);
            
    //         if (isset($result['message']) && !empty(trim($result['message']))) {
    //             return $result['message'];
    //         }
    //     }

    //     return $fallback;
    // }

    private function _generateAiBirthdayMessage($employee) {
        // 1. Kalkulasi Usia Kerja
        $joinDate = new DateTime($employee->date_of_joining);
        $today = new DateTime();
        $interval = $joinDate->diff($today);
        $usiaKerja = $interval->y . " Tahun " . $interval->m . " Bulan";

        $payload = [
            'nama' => $employee->fullname,
            'usia_kerja' => $usiaKerja,
            'jabatan' => $employee->designation
        ];

        $n8nWebhookUrl = 'https://n8n.trustcore.id/webhook/generate-birthday-text';

        // 2. Inisialisasi cURL
        $ch = curl_init($n8nWebhookUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        // Setting Timeout yang lebih sabar
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); 

        // WAJIB: Matikan verifikasi SSL jika menggunakan server lokal/lama
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

        // 3. Eksekusi
        $response = curl_exec($ch);
        
        // CEK ERROR CURL (Sangat Penting)
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            // Jika error, kita kembalikan fallback tapi log error-nya (opsional)
            return "Selamat Ulang Tahun, {$employee->fullname}! (Curl Error: $error)";
        }

        // AMBIL HTTP CODE
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $fallback = "Selamat Ulang Tahun, {$employee->fullname}! Sukses selalu bersama Trusmi Group. 🎉";

        // 4. Cek Jika Berhasil (200 OK)
        if ($httpCode === 200) {
            $result = json_decode($response, true);
            if (isset($result['message']) && !empty(trim($result['message']))) {
                return $result['message'];
            }
        }

        return $fallback;
    }
}
