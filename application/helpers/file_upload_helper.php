<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Custom Upload File Helper untuk CodeIgniter 3
 * File: file_upload_helper.php (untuk menghindari konflik dengan upload_helper bawaan CI)
 * 
 * @param array $config Konfigurasi upload
 * @return array Response upload (status, message, data)
 */
if (!function_exists('do_upload_file')) {
    function do_upload_file($config = [])
    {
        $CI = &get_instance();

        // Validasi parameter wajib
        if (empty($config['file_input'])) {
            return [
                'status' => false,
                'message' => 'Parameter file_input wajib diisi',
                'data' => null
            ];
        }

        if (empty($config['upload_path'])) {
            return [
                'status' => false,
                'message' => 'Parameter upload_path wajib diisi',
                'data' => null
            ];
        }

        // Default configuration
        $default_config = [
            'file_input'    => '',
            'upload_path'   => '',
            'prefix'        => null, // null = tanpa prefix, string = dengan prefix
            'allowed_types' => '*',
            'max_size'      => 10240, // 10MB
            'max_width'     => 0,
            'max_height'    => 0,
            'encrypt_name'  => true,
            'remove_spaces' => true,
            'overwrite'     => false
        ];

        // Merge config
        $config = array_merge($default_config, $config);

        // Validasi file upload
        if (empty($_FILES[$config['file_input']]['name'])) {
            return [
                'status' => false,
                'message' => 'Tidak ada file yang diupload',
                'data' => null
            ];
        }

        // Normalisasi upload path
        $upload_path = rtrim($config['upload_path'], '/') . '/';

        // Buat direktori jika belum ada
        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0775, true)) {
                return [
                    'status' => false,
                    'message' => 'Gagal membuat direktori upload',
                    'data' => null
                ];
            }
        }

        // Load library upload
        $CI->load->library('upload');

        // Konfigurasi upload CI
        $upload_config = [
            'upload_path'   => $upload_path,
            'allowed_types' => $config['allowed_types'],
            'max_size'      => $config['max_size'],
            'encrypt_name'  => $config['encrypt_name'],
            'remove_spaces' => $config['remove_spaces'],
            'overwrite'     => $config['overwrite']
        ];

        // Tambahan config untuk image
        if ($config['max_width'] > 0) {
            $upload_config['max_width'] = $config['max_width'];
        }
        if ($config['max_height'] > 0) {
            $upload_config['max_height'] = $config['max_height'];
        }

        // Initialize upload
        $CI->upload->initialize($upload_config);

        // Lakukan upload
        if (!$CI->upload->do_upload($config['file_input'])) {
            return [
                'status' => false,
                'message' => strip_tags($CI->upload->display_errors()),
                'data' => null
            ];
        }

        // Ambil data upload
        $upload_data = $CI->upload->data();

        // Rename file dengan prefix jika prefix tidak null/kosong
        if ($config['prefix'] !== null && $config['prefix'] !== '') {
            $old_file = $upload_data['full_path'];
            $extension = $upload_data['file_ext'];

            // Generate random name
            $random_name = bin2hex(random_bytes(8));
            $new_filename = $config['prefix'] . '_' . $random_name . $extension;
            $new_file = $upload_path . $new_filename;

            // Rename file
            if (rename($old_file, $new_file)) {
                $upload_data['file_name'] = $new_filename;
                $upload_data['full_path'] = $new_file;
            }
        } elseif ($config['prefix'] === null || $config['prefix'] === '') {
            // Jika prefix null atau kosong, rename dengan random name saja (tanpa prefix)
            $old_file = $upload_data['full_path'];
            $extension = $upload_data['file_ext'];

            // Generate random name tanpa prefix
            $random_name = bin2hex(random_bytes(8));
            $new_filename = $random_name . $extension;
            $new_file = $upload_path . $new_filename;

            // Rename file
            if (rename($old_file, $new_file)) {
                $upload_data['file_name'] = $new_filename;
                $upload_data['full_path'] = $new_file;
            }
        }

        // Siapkan response data
        $response_data = [
            'file_name' => $upload_data['file_name'],
            'file_type' => $upload_data['file_type'],
            'file_size' => $upload_data['file_size'],
            'file_ext'  => $upload_data['file_ext'],
            'full_path' => $upload_data['full_path'],
            'raw_name'  => $upload_data['raw_name'],
            'orig_name' => $upload_data['orig_name'],
            'client_name' => $upload_data['client_name'],
            'relative_path' => str_replace(FCPATH, '', $upload_data['full_path'])
        ];

        // Tambahan info untuk image
        if ($upload_data['is_image']) {
            $response_data['is_image'] = true;
            $response_data['image_width'] = $upload_data['image_width'];
            $response_data['image_height'] = $upload_data['image_height'];
            $response_data['image_type'] = $upload_data['image_type'];
        }

        return [
            'status' => true,
            'message' => 'File berhasil diupload',
            'data' => $response_data
        ];
    }
}

/**
 * Hapus file yang sudah diupload
 * 
 * @param string $file_path Path file yang akan dihapus
 * @return array Response delete
 */
if (!function_exists('delete_uploaded_file')) {
    function delete_uploaded_file($file_path)
    {
        if (empty($file_path)) {
            return [
                'status' => false,
                'message' => 'Path file tidak boleh kosong'
            ];
        }

        // Cek apakah file ada
        if (!file_exists($file_path)) {
            return [
                'status' => false,
                'message' => 'File tidak ditemukan'
            ];
        }

        // Hapus file
        if (unlink($file_path)) {
            return [
                'status' => true,
                'message' => 'File berhasil dihapus'
            ];
        }

        return [
            'status' => false,
            'message' => 'Gagal menghapus file'
        ];
    }
}

/**
 * Validasi tipe file upload
 * 
 * @param string $file_input Nama input file
 * @param array $allowed_types Array tipe file yang diizinkan
 * @return array Response validasi
 */
if (!function_exists('validate_file_type')) {
    function validate_file_type($file_input, $allowed_types = [])
    {
        if (empty($_FILES[$file_input]['name'])) {
            return [
                'status' => false,
                'message' => 'File tidak ditemukan'
            ];
        }

        if (empty($allowed_types)) {
            return [
                'status' => true,
                'message' => 'Valid'
            ];
        }

        $file_ext = strtolower(pathinfo($_FILES[$file_input]['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_types)) {
            return [
                'status' => false,
                'message' => 'Tipe file tidak diizinkan. Hanya ' . implode(', ', $allowed_types) . ' yang diperbolehkan'
            ];
        }

        return [
            'status' => true,
            'message' => 'Valid'
        ];
    }
}
