<?php

class Marketplace_API_Client {

    private $api_url;

    public function __construct() {
        $this->api_url = defined('MARKETPLACE_API_URL') ? MARKETPLACE_API_URL : 'http://localhost:8000/api/v1';
    }

    public function login($email, $password) {
        $response = wp_remote_post($this->api_url . '/login', array(
            'body' => array(
                'email' => $email,
                'password' => $password,
                'site_url' => get_site_url(), // Domain Locking
            ),
            'timeout' => 15,
        ));

        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        $code = wp_remote_retrieve_response_code($response);

        if ($code === 200 && isset($data['token'])) {
            update_option('mp_api_token', $data['token']);
            update_option('mp_user_info', $data['user']);
            return array('success' => true, 'data' => $data);
        } else {
            return array('success' => false, 'message' => $data['message'] ?? 'Error desconocido');
        }
    }

    public function get_products($page = 1, $search = '', $per_page = 12) {
        $token = get_option('mp_api_token');
        if (!$token) return false;

        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ),
            'timeout' => 15,
        );

        $url = $this->api_url . '/products?page=' . $page . '&per_page=' . $per_page;
        if($search) $url .= '&search=' . urlencode($search);

        $response = wp_remote_get($url, $args);

        if (is_wp_error($response)) {
            return false;
        }

        $code = wp_remote_retrieve_response_code($response);
        if ($code === 401 || $code === 403) {
            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($body['code']) && in_array($body['code'], ['UNAUTHENTICATED', 'SITE_DISCONNECTED'])) {
                delete_option('mp_api_token');
                delete_option('mp_user_info');
            }
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public function download_product($id) {
        $token = get_option('mp_api_token');
        if (!$token) return new WP_Error('no_token', 'No hay sesión activa');

        // URL de descarga directa
        $url = $this->api_url . '/download/' . $id;

        // Requiere Filesystem de WP para guardar archivos
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        WP_Filesystem();
        global $wp_filesystem;

        // Crear carpeta temporal
        $upload_dir = wp_upload_dir();
        $temp_dir = $upload_dir['basedir'] . '/mp_temp/';
        if (!file_exists($temp_dir)) {
            wp_mkdir_p($temp_dir);
        }

        // Descargar archivo usando wp_remote_get y streaming (o simple get si el archivo no es gigante)
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token,
            ),
            'timeout' => 300,
            'stream' => true,
            'filename' => $temp_dir . 'product-' . $id . '.zip'
        );

        $response = wp_remote_get($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $file_path = $response['filename'];
        
        return $file_path; // Retorna la ruta del ZIP descargado
    }

    public function get_user_info() {
        $token = get_option('mp_api_token');
        if (!$token) return false;

        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ),
            'timeout' => 15,
        );

        $response = wp_remote_get($this->api_url . '/user', $args);

        if (is_wp_error($response)) {
            return false;
        }

        $code = wp_remote_retrieve_response_code($response);
        if ($code === 401 || $code === 403) {
            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($body['code']) && in_array($body['code'], ['UNAUTHENTICATED', 'SITE_DISCONNECTED'])) {
                delete_option('mp_api_token');
                delete_option('mp_user_info');
            }
            return false;
        }

        if ($code !== 200) {
            return false;
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);
        if ($data) {
            update_option('mp_user_info', $data);
            return $data;
        }
        return false;
    }
}
