<?php

class Marketplace_Update_Manager {

    private $api;

    public function __construct( $api ) {
        $this->api = $api;
        
        // Register update filters
        add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_plugin_updates' ) );
        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_theme_updates' ) );
    }

    public function check_plugin_updates( $transient ) {
        if ( empty( $transient->checked ) ) {
            return $transient;
        }

        $installed = get_option('mp_installed_resources', array());
        if ( empty( $installed ) ) {
            return $transient;
        }

        $api_products = $this->get_cached_api_products();
        if ( ! $api_products ) {
            return $transient;
        }

        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        foreach ( $installed as $plugin_file => $info ) {
            if ( ! isset( $info['type'] ) || $info['type'] !== 'plugin' ) {
                continue;
            }

            $prod_id = $info['id'];
            if ( ! isset( $api_products[$prod_id] ) ) {
                continue;
            }

            $latest_prod = $api_products[$prod_id];
            $plugin_path = WP_PLUGIN_DIR . '/' . $plugin_file;

            if ( ! file_exists( $plugin_path ) ) {
                continue; // Plugin was deleted
            }

            $plugin_data = get_plugin_data( $plugin_path );
            $local_version = $plugin_data['Version'];
            $remote_version = $latest_prod['version'];

            if ( version_compare( $local_version, $remote_version, '<' ) ) {
                $token = get_option('mp_api_token');
                $api_url = defined('MARKETPLACE_API_URL') ? MARKETPLACE_API_URL : 'http://localhost/gplwolf/public/api/v1';
                $download_url = $api_url . '/download/' . $prod_id . '?api_token=' . $token;

                $update = new stdClass();
                $update->slug = dirname( $plugin_file );
                $update->plugin = $plugin_file;
                $update->new_version = $remote_version;
                $update->package = $download_url;
                $update->url = ''; // Can point to changelog/info page if needed

                $transient->response[$plugin_file] = $update;
            }
        }

        return $transient;
    }

    public function check_theme_updates( $transient ) {
        if ( empty( $transient->checked ) ) {
            return $transient;
        }

        $installed = get_option('mp_installed_resources', array());
        if ( empty( $installed ) ) {
            return $transient;
        }

        $api_products = $this->get_cached_api_products();
        if ( ! $api_products ) {
            return $transient;
        }

        foreach ( $installed as $theme_slug => $info ) {
            if ( ! isset( $info['type'] ) || $info['type'] !== 'theme' ) {
                continue;
            }

            $prod_id = $info['id'];
            if ( ! isset( $api_products[$prod_id] ) ) {
                continue;
            }

            $latest_prod = $api_products[$prod_id];
            $theme = wp_get_theme( $theme_slug );

            if ( ! $theme->exists() ) {
                continue; // Theme deleted
            }

            $local_version = $theme->get('Version');
            $remote_version = $latest_prod['version'];

            if ( version_compare( $local_version, $remote_version, '<' ) ) {
                $token = get_option('mp_api_token');
                $api_url = defined('MARKETPLACE_API_URL') ? MARKETPLACE_API_URL : 'http://localhost/gplwolf/public/api/v1';
                $download_url = $api_url . '/download/' . $prod_id . '?api_token=' . $token;

                $update = array(
                    'theme'       => $theme_slug,
                    'new_version' => $remote_version,
                    'package'     => $download_url,
                    'url'         => '',
                );

                $transient->response[$theme_slug] = $update;
            }
        }

        return $transient;
    }

    private function get_cached_api_products() {
        $api_cache = get_transient('mp_api_updates_cache');
        if ( false === $api_cache ) {
            // Fetch products list using the new per_page parameter (up to 1000 items)
            $response = $this->api->get_products(1, '', 1000);
            if ( $response && isset($response['data']) && is_array($response['data']) ) {
                $api_cache = array();
                foreach ( $response['data'] as $prod ) {
                    $api_cache[$prod['id']] = $prod;
                }
                set_transient('mp_api_updates_cache', $api_cache, 4 * HOUR_IN_SECONDS);
            }
        }
        return $api_cache;
    }
}
