<?php

class Marketplace_Connect {

    protected $plugin_name;
    protected $version;
    protected $api_client;

    public function __construct() {
        if ( defined( 'MARKETPLACE_CONNECT_VERSION' ) ) {
            $this->version = MARKETPLACE_CONNECT_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'marketplace-connect';

        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies() {
        require_once MARKETPLACE_CONNECT_PLUGIN_DIR . 'includes/class-api-client.php';
        require_once MARKETPLACE_CONNECT_PLUGIN_DIR . 'includes/class-admin-ui.php';
        require_once MARKETPLACE_CONNECT_PLUGIN_DIR . 'includes/class-update-manager.php';

        $this->api_client = new Marketplace_API_Client();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Marketplace_Admin_UI( $this->get_plugin_name(), $this->get_version(), $this->api_client );

        add_action( 'admin_menu', array( $plugin_admin, 'add_plugin_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );
        add_action( 'admin_notices', array( $plugin_admin, 'display_update_notice' ) );
        
        // AJAX Actions
        add_action( 'wp_ajax_mp_connect_login', array( $plugin_admin, 'handle_login' ) );
        add_action( 'wp_ajax_mp_disconnect', array( $plugin_admin, 'handle_disconnect' ) );
        add_action( 'wp_ajax_mp_download_item', array( $plugin_admin, 'handle_download' ) );

        // Initialize Update Manager to handle native theme & plugin updates
        new Marketplace_Update_Manager( $this->api_client );
    }

    public function run() {
        // Hooks de carga
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }

}
