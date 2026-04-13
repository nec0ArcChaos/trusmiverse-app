<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Birthday_employees_tkb extends CI_Controller
{
    protected $noTelp;
    protected $birthdayImageUrl;
    protected $defaultPhotoPath;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('BirthdayImageTKB');
        $this->load->library('WAJS_hr');
        $this->load->model('Model_birthday_employees_tkb', 'model'); 

        $this->photoPath = $this->config->item('employee_profile_photo_path');
        
        $this->birthdayImageUrl = 'https://trusmiverse.com/apps/uploads/birthday_tkb/generated/';

        // default foto jika tidak ada foto karyawan
        $this->defaultPhotoPath = FCPATH . 'uploads/birthday_tkb/tkb-logo.png'; 

        $this->noTelp = [
            '6282147263082', // bu muni
            '6281363643958', // syaamil
            '6281120041850', // pak angga 1 
            '628112011892', // pak angga 2
        ];
    }

    public function test()
    {
        $employees = $this->model->getBirthdayByUserId(11219);
        // $employees = $this->model->getBirthdayByDate();

        header('Content-Type: application/json');
        echo json_encode($employees);
    }

    /* untuk preview hasil generate image */
    public function preview_birthday()
    {
        $employee = $this->model->getBirthdayByUserId(11219);

        if (empty($employee)) {
            echo "Tidak ada karyawan ulang tahun hari ini";
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
            $filename = $this->birthdayimagetkb->generate(
                $photoFilePath,
                $normalizedName,
                $employee->designation,
                $employee->age,
                $employee->date_of_joining
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
                'id'                => $employee->user_id ?? null,
                'name'              => $employee->fullname,
                'designation'       => $employee->designation,
                'gender'            => $employee->gender,
                'birthday'          => $employee->date_of_birth,
                'age'               => $employee->age,
                'date_of_joining'   => $employee->date_of_joining,
            ],
            'phone' => [
                'raw'               => $rawPhone,
                'normalized'        => $phone,
                'is_valid'          => $isValid,
            ],
            'photo' => [
                'original'          => $photoFilePath,
                'generated'         => $imageGenerated,
                'image_url'         => $imageUrl,
            ],
            'whatsapp' => [
                'message'           => $message,
                'will_send'         => $isValid,
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
                $filename = $this->birthdayimagetkb->generate(
                    $photoFilePath,
                    $normalizedName,
                    $employee->designation,
                    $employee->age,
                    $employee->date_of_joining
                );

                if ($filename) {
                    $imageUrl = $this->birthdayImageUrl . $filename;
                }
            }

            /* build message */
            $message = $this->buildBirthdayMessage($employee);

            /* send WA */ 
            foreach ($this->noTelp as $noTelp) {
                $this->sendWhatsapp($noTelp, $message, $imageUrl);
            }
        }

        echo "Proses kirim pesan ulang tahun karyawan selesai";
    }

    /** 
     * Hit manual by User ID
     * contoh endpoint = GET https://trusmiverse.com/apps/cronjob/birthday_employees_tkb/send_birthday_by_user_id/11219
     * Langsung dikirim ke nomor telepon karyawan terkait
    */ 
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
            $filename = $this->birthdayimagetkb->generate(
                $photoFilePath,
                $normalizedName,
                $employee->designation,
                $employee->age,
                $employee->date_of_joining
            );

            if ($filename) {
                $imageUrl = $this->birthdayImageUrl . $filename;
            }
        }

        /* build message */
        $message = $this->buildBirthdayMessage($employee);

        /* kirim WA */
        $this->sendWhatsapp($phone, $message, $imageUrl);

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
        $age  = $employee->age;

        $workDuration = $this->formatWorkDuration($employee->date_of_joining);

        $day   = date('j');
        $month = date('n');

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $tanggal = $day . ' ' . $namaBulan[$month];

        return "🎉 *Rahajeng Wanti Warsa, {$name}!* 🎂✨\n\n"
            . "Di hari yang istimewa ini, seluruh keluarga besar *The Keranjang Bali* "
            . "mengucapkan selamat ulang tahun kepada Anda. 🌺\n\n"
            . "Semoga usia yang ke *{$age} Tahun* di tanggal *{$tanggal}* ini membawa keberkahan, "
            . "kesehatan, dan kebahagiaan dalam setiap langkahmu. 🙏\n\n"
            . "Kami menghargai segala dedikasi dan kontribusimu bagi perusahaan "
            . "selama *{$workDuration}* ini. 🤝✨\n\n"
            . "Teruslah bersemangat dalam berkarya dan meraih prestasi 🚀. "
            . "Semoga di tahun barumu ini kamu makin sukses, bahagia, "
            . "dan tetap menjadi pribadi yang keren seperti biasanya 😎🌟\n\n"
            . "Nikmati harimu dan jangan lupa untuk selalu bersyukur 🙌. "
            . "Cheers buat tahun baru yang penuh keseruan! 🍻\n\n"
            . "*Salam hangat,*\n"
            . "*The Keranjang Bali Management*";
    }

    // build nilai masa kerja, contoh '2 Tahun 3 Bulan' (jika tahun ada) atau '5 Bulan 25 Hari' (jika masa kerja < 1 tahun)
    protected function formatWorkDuration($joinDate)
    {
        if (empty($joinDate)) {
            return '-';
        }

        $join = new DateTime($joinDate);
        $now  = new DateTime();
        $diff = $join->diff($now);

        $parts = [];

        if ($diff->y > 0) {
            $parts[] = $diff->y . ' Tahun';
        }

        if ($diff->m > 0) {
            $parts[] = $diff->m . ' Bulan';
        }

        // Tampilkan hari jika masa kerja < 1 tahun
        if ($diff->d > 0 && $diff->y == 0) {
            $parts[] = $diff->d . ' Hari';
        }

        // fallback
        if (empty($parts)) {
            return '0 Hari';
        }

        return implode(' ', $parts);
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

}
