<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Load extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function _remap($method, $params = array())
    {
        // Check if the method exists in the controller (e.g. 'index')
        // If the URL is just /load, method is 'index'.
        // If the URL is /load/campaign, method is 'campaign'.
        // We want 'campaign' to be treated as a parameter for index(), unless we actually define a function named campaign().

        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }

        // Otherwise, assume the method segment is actually the load name
        $tab_name = isset($params[0]) ? $params[0] : '';
        $this->index($method, $tab_name);
    }

    public function index($group_tab = 'menus', $tab_name = 'campaign')
    {
        // Security check: only allow alphanumeric and underscores
        $tab_name = preg_replace('/[^a-z0-9_]/i', '', $tab_name);
        if (empty($tab_name)) {
            $tab_name = 'campaign';
        }

        $view_path = "compas/$group_tab/$tab_name";
        $modal_path = "compas/$group_tab/{$tab_name}_modal";
        // var_dump($modal_path);
        // die();

        // Define asset paths
        $css_url = base_url("assets/compas/css/$group_tab/$tab_name.css");
        $js_url = base_url("assets/compas/js/$group_tab/$tab_name.js");

        // Verify if view exists
        if (!file_exists(APPPATH . "views/compas/$group_tab/$tab_name.php")) {
            // Handle 404 for tab
            $response = [
                'html' => '<div class="alert alert-warning">Content not found: ' . htmlspecialchars($tab_name) . '</div>',
                'styles' => [],
                'scripts' => []
            ];
        } else {
            // Check if assets exist on disk
            $css_path = FCPATH . "assets/compas/css/$group_tab/$tab_name.css";
            $js_path = FCPATH . "assets/compas/js/$group_tab/$tab_name.js";

            $styles = [];
            if (file_exists($css_path)) {
                $styles[] = $css_url;
            }

            $scripts = [];
            if (file_exists($js_path)) {
                $scripts[] = $js_url;
            }

            // Render view to string
            $html = $this->load->view($view_path, [], TRUE);
            if (file_exists(APPPATH . "views/$modal_path.php")) {
                $modal = $this->load->view($modal_path, [], TRUE);
            } else {
                $modal = NULL;
            }

            $response = [
                'html' => $html,
                'styles' => $styles,
                'scripts' => $scripts,
                'modal' => $modal
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
