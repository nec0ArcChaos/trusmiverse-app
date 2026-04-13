<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Ai_assist extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        $this->load->database();
        $this->load->model('model_ai_assist');
        $this->load->library('FormatJson');

        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']  = "Nira AI";
        $data['css']        = "ai_assist/css";
        $data['js']         = "ai_assist/js";
        $data['content']    = "ai_assist/index";

        // $data['help']       = $this->model_ai_assist->get_help()->result();

        $this->load->view('layout/main', $data);
    }

    public function get_help()
    {
        $user_id = $this->session->userdata('user_id');
        $category   = $_POST['category'];
        $content    = $_POST['content'];
        $sessionId    = $_POST['sessionId'];

        $uploadPath = './uploads/trusmigpt/';
        $fileUrl = null;

        // Handle file upload
        if (!empty($_FILES['file']['name'])) {
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
            $config['max_size'] = 2048; // 2MB max
            $config['file_name']     = time() . '_' . $_FILES['file']['name'];
            $config['detect_mime']   = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
                $fileUrl = base_url('uploads/trusmigpt/' . $fileData['file_name']);
            } else {
                echo json_encode(['success' => false, 'error' => $this->upload->display_errors()]);
                return;
            }
        }

        // If no session exists, create a new one
        if ($sessionId == '' || $sessionId == null) {
            $this->db->insert('t_ai_sessions', [
                'user_id' => $user_id,
                'session_name' => "Chat - " . date('Y-m-d H:i'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $session_id = $this->db->insert_id();
        } else {
            $session_id = $sessionId;
        }

        // Call OpenAI API
        $response = $this->ask_openai($content, $fileUrl);

        // $help = $this->model_ai_assist->get_help_category($category, $content);
        $response_formatted = preg_replace_callback('/```\s*(\w+)?\s*\n([\s\S]+?)```/s', function ($matches) {
            $language = !empty($matches[1]) ? trim($matches[1]) : 'plaintext'; // Default to plaintext
            return '<pre><code class="language-' . htmlspecialchars($language) . '">' . htmlspecialchars($matches[2]) . '</code></pre>';
        }, $response);


        // Store user question
        $this->db->insert('t_ai_assist', [
            'session_id' => $session_id,
            'role' => 'user',
            'message' => $content,

            'file_url' => $fileUrl,
            'kategori' => $category,
            'pertanyaan' => $content,
            'jawaban' => $response_formatted,
            'created_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Store AI response_formatted
        $this->db->insert('t_ai_assist', [
            'session_id' => $session_id,
            'role' => 'bot',
            'message' => $response_formatted,

            'kategori' => $category,
            'pertanyaan' => $content,
            'jawaban' => $response_formatted,
            'created_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        if ($response) {
            $text = $response;

            // Ganti Markdown-like bold dengan tag <strong>
            // $formattedText = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);

            // // Ganti daftar bernomor menjadi format HTML <ol><li>
            // $formattedText = preg_replace('/(\d+)\.\s([^0-9]+)/', '<li>$2</li>', $formattedText);

            // // Bungkus item list dengan <ol>
            // $formattedText = preg_replace('/(<li>.*?<\/li>)+/s', '<ol>$0</ol>', $formattedText);

            // // Tambahkan <p> untuk paragraf utama jika tidak ada list
            // if (!preg_match('/<ol>/', $formattedText)) {
            //     $formattedText = "<p>" . preg_replace('/\n\n/', '</p><p>', $formattedText) . "</p>";
            // }

            echo $text;
        } else {
            echo "No response received.";
        }
    }

    private function ask_openai($message, $imageUrl = null)
    {
        $url = 'https://api.openai.com/v1/chat/completions';
        $apiKey = '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';

        // Construct messages array
        $messages = [
            [
                'role' => 'system',
                'content' => 'You are an advanced AI assistant that provides informative, well-structured, and human-like responses. 
                            If possible, perform a web search for the most up-to-date information and provide relevant references. 
                            Structure your answers using lists or easy-to-read paragraphs.
                            Maintain a conversational and engaging tone, while ensuring accuracy and clarity.'
            ],
            // [
            //     'role' => 'user',
            //     'content' => $message . ' If user ask for code example Provide the response in a proper code block in html with the correct programming language.
            //                                 If not, Respond in pure HTML without enclosing it in a code block. Do not start the response with ```html. 
            //                                 And do not use head and body and heading tag, just start from div.'
            // ]
            [
                'role' => 'user',
                'content' => $message . ' If the user asks for a code example, format the response as an code block using <pre><code class="language-[LANG]"> ... </code></pre>. 
                                        Replace [LANG] with the appropriate programming language, such as "dart" for Flutter, "python" for Python, or "javascript" for JavaScript.
                                        Do not use Markdown-style triple backticks (```).
                                        If the user does not ask for a code example, respond in pure HTML without enclosing it in a code block.
                                        Do not use <head>, <body>, or <h1> tags; just start from <div>.'
            ]
        ];

        // If an image is provided, include it in the request
        if ($imageUrl) {
            $messages[] = [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $message],
                    ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]]
                ]
            ];
        }

        $data = [
            'model' => 'gpt-4.1',
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 2048,
            'top_p' => 0.9,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.2
        ];


        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        return $response['choices'][0]['message']['content'] ?? "No response.";
    }

    public function get_chat_sessions()
    {
        $user_id = $this->session->userdata('user_id');

        // $sessions = $this->db->query("
        //     SELECT s.id, s.created_at, s.session_name, s.session_title,
        //         (SELECT a.jawaban FROM t_ai_assist a 
        //             WHERE a.session_id = s.id 
        //             ORDER BY a.created_at DESC LIMIT 1) AS last_message
        //     FROM t_ai_sessions s
        //     WHERE s.user_id = ?
        //     AND s.deleted_at IS NULL
        //     ORDER BY s.created_at DESC
        // ", [$user_id])->result_array();

        $sessions = $this->db->query("
            SELECT 
                s.id, 
                s.created_at, 
                s.session_name, 
                s.session_title,
                a.pertanyaan,
                a.jawaban AS last_message,
                a.created_at AS last_created_at
            FROM t_ai_sessions s
            JOIN (
                SELECT a1.session_id, a1.pertanyaan, a1.jawaban, a1.created_at
                FROM t_ai_assist a1
                WHERE a1.created_at = (
                    SELECT MAX(a2.created_at)
                    FROM t_ai_assist a2
                    WHERE a2.session_id = a1.session_id
                )
            ) a ON a.session_id = s.id
            WHERE s.user_id = ?
            AND s.deleted_at IS NULL
            GROUP BY s.id
            ORDER BY last_created_at DESC
        ", [$user_id])->result_array();

        if (empty($sessions)) {
            echo json_encode(["error" => "No chat sessions found"]);
            return;
        }

        echo json_encode($sessions);
    }

    public function get_chat_messages($session_id)
    {
        $messages = $this->db->select('role, message, file_url, created_at')
            ->from('t_ai_assist')
            ->where('session_id', $session_id)
            ->order_by('created_at', 'ASC')
            ->get()
            ->result_array();

        echo json_encode($messages);
    }

    public function create_new_chat_session()
    {
        $userId = $this->session->userdata('user_id');

        $data = [
            'user_id' => $userId,
            'session_name' => "Chat - " . date('Y-m-d H:i'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('t_ai_sessions', $data);
        $sessionId = $this->db->insert_id();

        echo json_encode(['session_id' => $sessionId]);
    }

    public function delete_chat_session($chatId)
    {
        $this->load->database();

        $session = $this->db->get_where('t_ai_sessions', ['id' => $chatId])->row();
        if (!$session) {
            echo json_encode(['success' => false, 'message' => 'Session not found']);
            return;
        }

        $this->db->where('id', $chatId);
        $this->db->update('t_ai_sessions', ['deleted_at' => date('Y-m-d H:i:s')]);

        echo json_encode(['success' => true, 'message' => 'Session deleted successfully']);
    }

    public function update_chat_title($chat_id)
    {
        header('Content-Type: application/json');

        // Get JSON input
        $data = json_decode(file_get_contents("php://input"), true);
        $new_title = isset($data['title']) ? trim($data['title']) : '';

        // Validate input
        if (empty($new_title)) {
            echo json_encode(["success" => false, "message" => "Title cannot be empty"]);
            return;
        }

        // Update in database
        $this->db->where('id', $chat_id);
        $update = $this->db->update('t_ai_sessions', ['session_title' => $new_title]);

        if ($update) {
            echo json_encode(["success" => true, "message" => "Chat title updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update title"]);
        }
    }
}
