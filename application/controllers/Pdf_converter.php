<?php
// require_once APPPATH . 'libraries/PdfToImage/src/Pdf.php';
// require_once APPPATH . 'libraries/PdfToImage/src/Exceptions/PdfDoesNotExist.php';
// require_once APPPATH . 'libraries/PdfToImage/src/Exceptions/InvalidLayerMethod.php';
// require_once APPPATH . 'libraries/Symfony_process/Process.php';
// require_once APPPATH . 'libraries/Symfony_process/Exception/ExceptionInterface.php';
// require_once APPPATH . 'libraries/Symfony_process/Exception/LogicException.php';
// require_once APPPATH . 'libraries/Symfony_process/Exception/ProcessFailedException.php';
// require_once APPPATH . 'libraries/Symfony_process/Exception/ProcessSignaledException.php';
// require_once APPPATH . 'libraries/Symfony_process/Exception/ProcessTimedOutException.php';
use Spatie\PdfToImage\Pdf;
class Pdf_converter
{
    public function convertToImages($pdfPath, $outputPath)
    {
        // Pastikan folder output ada
        if (!is_dir($outputPath)) {
            mkdir($outputPath, 0777, true);
        }

        try {
            // Inisialisasi library Spatie
            $pdf = new Pdf($pdfPath);
            $totalPages = $pdf->getNumberOfPages();
            $imageUrls = [];

            // Loop setiap halaman dan simpan sebagai gambar
            for ($page = 1; $page <= $totalPages; $page++) {
                $imageName = pathinfo($pdfPath, PATHINFO_FILENAME) . '-page-' . $page . '.jpg';
                $imageOutputPath = $outputPath . $imageName;

                // Cek jika gambar sudah ada (untuk caching)
                if (!file_exists($imageOutputPath)) {
                    $pdf->setPage($page)->saveImage($imageOutputPath);
                }

                // Hapus FCPATH dari path untuk membuat URL
                $urlPath = str_replace(FCPATH, '', $imageOutputPath);
                $imageUrls[] = base_url($urlPath);
            }

            return $imageUrls;

        } catch (Exception $e) {
            log_message('error', 'PDF Conversion Failed: ' . $e->getMessage());
            return []; // Kembalikan array kosong jika gagal
        }
    }
}
?>