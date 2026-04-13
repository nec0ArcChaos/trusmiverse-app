<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BirthdayImageTKB
{
    protected $ci;

    /* TEMPLATE */
    protected $canvasWidth  = 1024;
    protected $canvasHeight = 1536;

    /* FOTO KARYAWAN */
    protected $photoX      = 380;
    protected $photoY      = 387;
    protected $photoWidth  = 263;
    protected $photoHeight = 333;

    /* NAMA & JABATAN */
    protected $nameBoxX      = 187;
    protected $nameBoxY      = 739;
    protected $nameBoxWidth  = 655;
    protected $nameBoxHeight = 115;

    protected $nameFontSize  = 28;
    protected $jobFontSize   = 18;
    protected $jobMinFont    = 14;

    protected $nameCenterPull = -6;
    protected $jobCenterPull  = 25;

    /* USIA */
    protected $ageX = 388;
    protected $ageY = 1018; 
    protected $ageFontSize = 16;

    /* MASA KERJA */
    protected $workX = 797;
    protected $workY = 1108;
    protected $workFontSize = 16;

    protected $fontPath;
    protected $templatePath;
    protected $outputPath;

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->fontPath             = FCPATH . 'assets/fonts/Poppins-Bold.ttf';
        $this->fontPathRegular      = FCPATH . 'assets/fonts/Poppins-Regular.ttf';
        $this->templatePath         = FCPATH . 'uploads/birthday_tkb/template.png';
        $this->outputPath           = FCPATH . 'uploads/birthday_tkb/generated/';
    }

    /**
     * Generate birthday image Company TKB
     */
    public function generate(
        $employeePhotoPath,
        $employeeName,
        $employeeJob,
        $age,
        $joinDate
    ) {
        if (!file_exists($this->templatePath)) {
            return null;
        }

        $template = imagecreatefrompng($this->templatePath);

        $photo = $this->loadImage($employeePhotoPath);
        if (!$photo) {
            imagedestroy($template);
            return null;
        }

        $photo = $this->resizeCrop($photo, $this->photoWidth, $this->photoHeight);

        $canvas = imagecreatetruecolor($this->canvasWidth, $this->canvasHeight);
        imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));

        imagecopy(
            $canvas,
            $photo,
            $this->photoX,
            $this->photoY,
            0,
            0,
            imagesx($photo),
            imagesy($photo)
        );

        imagecopy(
            $canvas,
            $template,
            0,
            0,
            0,
            0,
            $this->canvasWidth,
            $this->canvasHeight
        );

        $this->drawEmployeeName($canvas, $employeeName, $employeeJob);
        $this->drawAge($canvas, $age);
        $this->drawWorkDuration($canvas, $joinDate);

        imagedestroy($photo);
        imagedestroy($template);

        return $this->saveImage($canvas);
    }

    /* ================= HELPERS ================= */

    protected function loadImage($path)
    {
        $info = getimagesize($path);
        if (!$info) return null;

        switch ($info['mime']) {
            case 'image/jpeg': return imagecreatefromjpeg($path);
            case 'image/png':  return imagecreatefrompng($path);
            default: return null;
        }
    }

    protected function resizeCrop($src, $dstW, $dstH)
    {
        $srcW = imagesx($src);
        $srcH = imagesy($src);

        $srcRatio = $srcW / $srcH;
        $dstRatio = $dstW / $dstH;

        if ($srcRatio > $dstRatio) {
            $newH = $srcH;
            $newW = $srcH * $dstRatio;
            $srcX = ($srcW - $newW) / 2;
            $srcY = 0;
        } else {
            $newW = $srcW;
            $newH = $srcW / $dstRatio;
            $srcX = 0;
            $srcY = ($srcH - $newH) / 2;
        }

        $dst = imagecreatetruecolor($dstW, $dstH);
        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $dstW, $dstH, $newW, $newH);

        return $dst;
    }

    protected function drawEmployeeName(&$canvas, $name, $job)
    {
        $white = imagecolorallocate($canvas, 255, 255, 255);

        $name = strtoupper($name);
        $job  = strtoupper($job);

        /* AUTO SHRINK JOB */
        $jobSize = $this->jobFontSize;
        do {
            $bbox = imagettfbbox($jobSize, 0, $this->fontPath, $job);
            $width = abs($bbox[4] - $bbox[0]);
            $jobSize--;
        } while ($width > $this->nameBoxWidth && $jobSize > $this->jobMinFont);

        $centerY = $this->nameBoxY + ($this->nameBoxHeight / 2);

        /* NAME */
        $bboxName = imagettfbbox($this->nameFontSize, 0, $this->fontPath, $name);
        $nameWidth = abs($bboxName[4] - $bboxName[0]);
        $nameX = $this->nameBoxX + ($this->nameBoxWidth - $nameWidth) / 2;
        $nameY = $centerY + $this->nameCenterPull;

        imagettftext($canvas, $this->nameFontSize, 0, $nameX, $nameY, $white, $this->fontPath, $name);

        /* JOB */
        $bboxJob = imagettfbbox($jobSize, 0, $this->fontPath, $job);
        $jobWidth = abs($bboxJob[4] - $bboxJob[0]);
        $jobX = $this->nameBoxX + ($this->nameBoxWidth - $jobWidth) / 2;
        $jobY = $centerY + $this->jobCenterPull;

        imagettftext($canvas, $jobSize, 0, $jobX, $jobY, $white, $this->fontPath, $job);
    }

    protected function drawAge(&$canvas, $age)
    {
        $black = imagecolorallocate($canvas, 0, 0, 0);
        imagettftext(
            $canvas,
            $this->ageFontSize,
            0,
            $this->ageX,
            $this->ageY,
            $black,
            $this->fontPathRegular,
            (string)$age
        );
    }

    protected function drawWorkDuration(&$canvas, $joinDate)
    {
        $black = imagecolorallocate($canvas, 0, 0, 0);

        $text = $this->formatWorkDuration($joinDate);

        imagettftext(
            $canvas,
            $this->workFontSize,
            0,
            $this->workX,
            $this->workY,
            $black,
            $this->fontPathRegular,
            $text
        );
    }

    protected function formatWorkDuration($joinDate)
    {
        if (empty($joinDate)) {
            return ' - ';
        }

        $join = new DateTime($joinDate);
        $now  = new DateTime();

        $diff = $join->diff($now);

        if ($diff->y > 0) {
            return $diff->y . ' Tahun';
        }

        if ($diff->m > 0) {
            return $diff->m . ' Bulan';
        }

        $days = $diff->days; 

        if ($days <= 0) {
            return '< 1 Hari';
        }

        return $days . ' Hari';
    }

    protected function saveImage($canvas)
    {
        $filename = 'birthday_tkb_' . time() . '_' . rand(100,999) . '.jpg';
        imagejpeg($canvas, $this->outputPath . $filename, 90);
        imagedestroy($canvas);
        return $filename;
    }
}
