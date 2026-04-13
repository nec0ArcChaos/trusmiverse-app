<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class BirthdayImage {
    protected $ci;
    protected $canvasWidth = 1240;
    protected $canvasHeight = 1748;

    /* FOTO KARYAWAN */
    protected $photoX = 153.14;
    protected $photoY = 369.67;
    protected $photoWidth = 776.91;
    protected $photoHeight = 1012.73;
    protected $photoAngle = -8;
    protected $photoHorizontalAdjust = 60; 
    protected $photoVerticalAdjust = 45; 

    /* NAMA & JABATAN */
    protected $nameX = 627.75;
    protected $nameY = 1110.00;
    protected $nameBoxWidth = 618.34;
    protected $nameAngle = -5;
    protected $nameFontSize = 32;
    protected $jobFontSizeDefault = 20; 
    protected $jobFontSizeSmall = 17;

    /* TANGGAL ULANG TAHUN */
    protected $dateX = 661.19;
    protected $dateY = 1460.00;
    protected $dateAngle = -8;
    protected $dateFontSize = 24;

    protected $fontPath;
    protected $templatePath;
    protected $outputPath;

    public function __construct() {
        $this->ci =& get_instance();
        $this->fontPath = FCPATH . 'assets/fonts/Poppins-Bold.ttf';
        $this->templatePath = FCPATH . 'uploads/birthday/template.png';
        $this->outputPath = FCPATH . 'uploads/birthday/generated/';
        
        if (!is_dir($this->outputPath)) {
            mkdir($this->outputPath, 0777, true);
        }
    }

    public function generate($employeePhotoPath, $employeeName, $employeeJob, $employeeBirthdate) {
        if (!file_exists($this->templatePath)) return null;

        $canvas = imagecreatetruecolor($this->canvasWidth, $this->canvasHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);

        $photo = $this->loadImage($employeePhotoPath);
        if ($photo) {
            $photo = $this->resizeCrop($photo, $this->photoWidth, $this->photoHeight);
            $photo = $this->rotatePhoto($photo, $this->photoAngle);
            
            $newWidth = imagesx($photo);
            $newHeight = imagesy($photo);
            
            $offsetX = ($newWidth - $this->photoWidth) / 2;
            $offsetY = ($newHeight - $this->photoHeight) / 2;

            $finalPhotoX = ($this->photoX + $this->photoHorizontalAdjust) - $offsetX;
            $finalPhotoY = ($this->photoY + $this->photoVerticalAdjust) - $offsetY;

            imagecopy($canvas, $photo, $finalPhotoX, $finalPhotoY, 0, 0, $newWidth, $newHeight);
            imagedestroy($photo);
        }

        $template = imagecreatefrompng($this->templatePath);
        imagecopy($canvas, $template, 0, 0, 0, 0, $this->canvasWidth, $this->canvasHeight);
        imagedestroy($template);

        // Teruskan data tanggal ke method drawText
        $this->drawText($canvas, $employeeName, $employeeJob, $employeeBirthdate);

        return $this->saveImage($canvas);
    }


    /* --- HELPERS --- */

    // konversi format tanggal
    protected function dateFormat($dateString) {
        $timestamp = strtotime($dateString);
        if (!$timestamp) return '';

        $day = date('d', $timestamp);
        $monthNum = date('n', $timestamp);
        $currentYear = date('Y');

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return $day . ' ' . $months[$monthNum] . ' ' . $currentYear;
    }

    protected function drawText(&$canvas, $name, $job, $birthdate) {
        $color = imagecolorallocate($canvas, 255, 255, 255);
        $blueColor = imagecolorallocate($canvas, 1, 84, 172); 
        
        /* --- RENDER NAMA & JABATAN --- */
        $name = strtoupper($name);
        $job = strtoupper($job);

        $centerX = $this->nameX + ($this->nameBoxWidth / 2);
        $centerY = $this->nameY + 107; 
        
        $angleDeg = -$this->nameAngle; 
        $angleRad = deg2rad($angleDeg);

        $nameBox = imagettfbbox($this->nameFontSize, $angleDeg, $this->fontPath, $name);
        $nameWidth = abs($nameBox[4] - $nameBox[0]);
        $halfNameWidth = $nameWidth / 2;

        $drawNameX = $centerX - ($halfNameWidth * cos($angleRad));
        $drawNameY = $centerY + ($halfNameWidth * sin($angleRad));

        imagettftext($canvas, $this->nameFontSize, $angleDeg, $drawNameX, $drawNameY, $color, $this->fontPath, $name);

        $currentJobFontSize = (strlen($job) > 35) ? $this->jobFontSizeSmall : $this->jobFontSizeDefault;
        $fixedLineSpacing = 45; 

        $jobCenterX = $centerX + ($fixedLineSpacing * sin($angleRad));
        $jobCenterY = $centerY + ($fixedLineSpacing * cos($angleRad));

        $jobBox = imagettfbbox($currentJobFontSize, $angleDeg, $this->fontPath, $job);
        $jobWidth = abs($jobBox[4] - $jobBox[0]);
        $halfJobWidth = $jobWidth / 2;

        $drawJobX = $jobCenterX - ($halfJobWidth * cos($angleRad));
        $drawJobY = $jobCenterY + ($halfJobWidth * sin($angleRad));

        imagettftext($canvas, $currentJobFontSize, $angleDeg, $drawJobX, $drawJobY, $color, $this->fontPath, $job);

        /* --- RENDER TANGGAL ULANG TAHUN --- */
        if (!empty($birthdate)) {
            $formattedDate = $this->dateFormat($birthdate);
            
            imagettftext(
                $canvas, 
                $this->dateFontSize, 
                -$this->dateAngle, 
                (int)$this->dateX, 
                (int)$this->dateY, 
                $blueColor, 
                $this->fontPath, 
                $formattedDate
            );
        }
    }

    protected function loadImage($path) {
        if (!file_exists($path)) return null;
        $info = @getimagesize($path);
        if (!$info) return null;
        switch ($info['mime']) {
            case 'image/jpeg': return imagecreatefromjpeg($path);
            case 'image/png': return imagecreatefrompng($path);
            default: return null;
        }
    }

    protected function resizeCrop($src, $dstW, $dstH) {
        $srcW = imagesx($src); $srcH = imagesy($src);
        $srcRatio = $srcW / $srcH; $dstRatio = $dstW / $dstH;
        if ($srcRatio > $dstRatio) {
            $newH = $srcH; $newW = $srcH * $dstRatio;
            $srcX = ($srcW - $newW) / 2; $srcY = 0;
        } else {
            $newW = $srcW; $newH = $srcW / $dstRatio;
            $srcX = 0; $srcY = ($srcH - $newH) / 2;
        }
        $dst = imagecreatetruecolor($dstW, $dstH);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $dstW, $dstH, $newW, $newH);
        imagedestroy($src);
        return $dst;
    }

    protected function rotatePhoto($photo, $angle) {
        $transparent = imagecolorallocatealpha($photo, 0, 0, 0, 127);
        $rotated = imagerotate($photo, -$angle, $transparent);
        imagealphablending($rotated, true);
        imagesavealpha($rotated, true);
        return $rotated;
    }

    protected function saveImage($canvas) {
        $filename = 'birthday_' . time() . '_' . rand(100,999) . '.jpg';
        $path = $this->outputPath . $filename;
        imagejpeg($canvas, $path, 95);
        imagedestroy($canvas);
        return $filename;
    }
}