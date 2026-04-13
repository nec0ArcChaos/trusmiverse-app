<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class fdk_phone_contact extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library('FormatJson');
    }

    function cek()
    {
        $data = $this->db->query("SELECT
                t_gci.id_gci,
                t_gci.wa_aktif,
                t_gci.wa_terkirim,
                m_konsumen.no_hp AS no_awal,
                REPLACE (
                    REPLACE (
                        REPLACE (
                        IF
                            (
                                SUBSTR( m_konsumen.no_hp, 1, 2 ) != '62',
                                CONCAT(
                                    '62',
                                    SUBSTR(
                                        m_konsumen.no_hp,
                                        3,
                                    LENGTH( m_konsumen.no_hp ))),
                                m_konsumen.no_hp 
                            ),
                            '-',
                            '' 
                        ),
                        '+',
                        '' 
                    ),
                    ' ',
                    '' 
                ) AS no_hp 
            FROM
                t_gci
                JOIN m_konsumen ON t_gci.id_konsumen = m_konsumen.id_konsumen 
            WHERE
                DATE( t_gci.created_at ) > '2024-08-31' 
                AND m_konsumen.no_hp IS NOT NULL 
                AND m_konsumen.no_hp != '' 
                AND LENGTH(m_konsumen.no_hp) > 6
                AND t_gci.wa_aktif IS NULL 
                -- AND t_gci.id_kategori = 1
                -- AND t_gci.id_tanya = 3
            ORDER BY
                t_gci.id_gci DESC 
                LIMIT 150")->result();

        foreach ($data as $row) {
            // URL API
            $api_url = 'https://sender.whatshub.web.id/api/checkNumberStatus?phone=' . $row->no_hp . '&session=customer_rn';

            // Membuat header dengan 'x-api-key'
            $options = [
                'http' => [
                    'header' => "x-api-key: whatshubmaju\r\n"
                ]
            ];

            // Membuat stream context dengan opsi header
            $context = stream_context_create($options);

            // Mengambil data dari API dengan stream context
            $response = file_get_contents($api_url, false, $context);

            if ($response === FALSE) {
                // Tangani kesalahan jika gagal mengambil data
                echo 'Gagal mengambil data dari API';
                return;
            }

            // Decode JSON response
            $data = json_decode($response, true);

            // Periksa jika decoding JSON berhasil
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo 'Gagal decode JSON';
                return;
            }

            $response = array();

            if ($data['numberExists'] == true) {
                $this->db->where('id_gci', $row->id_gci);
                $result['update'] = $this->db->update('t_gci', array('wa_aktif' => 1));
                $response[] = $result;
            } else {
                $this->db->where('id_gci', $row->id_gci);
                $result['update'] = $this->db->update('t_gci', array('wa_aktif' => 0));
                $response[] = $result;
            }



            echo json_encode($response);
        }
    }
}
