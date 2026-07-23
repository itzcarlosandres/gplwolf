<?php

class Marketplace_Admin_UI {
    private $plugin_name;
    private $version;
    private $api;

    public function __construct( $plugin_name, $version, $api ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->api = $api;
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'Marketplace Connect', 
            'Marketplace', 
            'manage_options', 
            $this->plugin_name, 
            array( $this, 'display_plugin_dashboard' ), 
            'dashicons-cart', 
            6
        );

        add_submenu_page(
            $this->plugin_name,
            'Ajustes',
            'Ajustes',
            'manage_options',
            'marketplace-connect-settings',
            array($this, 'display_settings_page')
        );
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'mp-admin-css', MARKETPLACE_CONNECT_PLUGIN_URL . 'assets/css/admin.css', array(), $this->version, 'all' );
        // Usar Tailwind CDN para prototipado rápido o estilos propios
        wp_enqueue_style( 'mp-tailwind', 'https://cdn.tailwindcss.com' ); 
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'mp-admin-js', MARKETPLACE_CONNECT_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( 'mp-admin-js', 'mp_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function display_plugin_dashboard() {
        $token = get_option('mp_api_token');
        if (!$token) {
            $this->display_login_form();
        } else {
            $this->display_products_grid();
        }
    }

    public function display_login_form() {
        ?>
        <div class="wrap mp-login-container" style="max-width: 400px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
            <h1 style="text-align: center; margin-bottom: 20px;">Conectar con Marketplace</h1>
            <div id="mp-login-message"></div>
            <form id="mp-login-form">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Email</label>
                    <input type="email" name="email" class="widefat" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Contraseña</label>
                    <input type="password" name="password" class="widefat" required>
                </div>
                <button type="submit" class="button button-primary button-hero" style="width: 100%;">Conectar Sitio</button>
            </form>
        </div>
        <script>
        jQuery(document).ready(function($) {
            $('#mp-login-form').on('submit', function(e) {
                e.preventDefault();
                var data = {
                    action: 'mp_connect_login',
                    email: $('input[name="email"]').val(),
                    password: $('input[name="password"]').val()
                };
                
                $('#mp-login-message').html('<p style="color: blue;">Conectando...</p>');
                
                $.post(mp_ajax.ajax_url, data, function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        $('#mp-login-message').html('<p style="color: red;">' + response.data + '</p>');
                    }
                });
            });
        });
        </script>
        <?php
    }

    public function display_products_grid() {
        $user_info = get_option('mp_user_info');
        // Fetch products page 1
        $products_data = $this->api->get_products();
        $products = $products_data['data'] ?? [];
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Explorador de Recursos</h1>
            <div style="float: right; margin-top: 10px;">
                Bienvenido, <strong><?php echo esc_html($user_info['name']); ?></strong> (<?php echo esc_html($user_info['plan']); ?>) 
                <button id="mp-disconnect-btn" class="button">Desconectar</button>
            </div>
            <hr class="wp-header-end">

            <div class="mp-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
                <?php if (empty($products)): ?>
                    <p>No se encontraron productos o error de conexión.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="mp-card" style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                            <div style="height: 150px; background: #f0f0f1; overflow: hidden;">
                                <?php if($product['thumbnail']): ?>
                                    <img src="<?php echo esc_url($product['thumbnail']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc;">Sin imagen</div>
                                <?php endif; ?>
                            </div>
                            <div style="padding: 15px; flex: 1;">
                                <h3 style="margin: 0 0 10px;"><?php echo esc_html($product['name']); ?> <span style="font-size: 10px; background: #eee; padding: 2px 5px; border-radius: 3px;">v<?php echo esc_html($product['version']); ?></span></h3>
                                <p style="font-size: 13px; color: #666; margin-bottom: 15px;"><?php echo esc_html($product['short_description']); ?></p>
                                
                                <?php if($product['can_download']): ?>
                                    <button class="button button-primary mp-download-btn" data-id="<?php echo $product['id']; ?>" data-type="<?php echo esc_attr($product['type'] ?? 'plugin'); ?>" style="width: 100%;">
                                        <span class="dashicons dashicons-download" style="line-height: 1.3;"></span> Instalar en WordPress
                                    </button>
                                <?php else: ?>
                                    <button class="button" disabled style="width: 100%;">
                                        🔒 Requiere Membresía
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // Disconnect
            $('#mp-disconnect-btn').click(function() {
                if(!confirm('¿Seguro que quieres desconectar?')) return;
                $.post(mp_ajax.ajax_url, { action: 'mp_disconnect' }, function() {
                    location.reload();
                });
            });

            // Download / Auto-Install
            $('.mp-download-btn').click(function() {
                var btn = $(this);
                var id = btn.data('id');
                var type = btn.data('type') || 'plugin';
                
                if (btn.hasClass('button-disabled')) return;
                
                btn.prop('disabled', true).text('Instalando...');

                $.post(mp_ajax.ajax_url, { action: 'mp_download_item', id: id, type: type }, function(response) {
                    if(response.success) {
                        btn.removeClass('button-primary').addClass('button-disabled').text('¡Instalado!');
                        alert(response.data.message || 'Instalado con éxito.');
                    } else {
                        // Display clean API error message or code
                        var errMsg = response.data;
                        if (response.data && response.data.message) {
                            errMsg = response.data.message;
                        }
                        alert('Error: ' + errMsg);
                        btn.prop('disabled', false).html('<span class="dashicons dashicons-download"></span> Instalar de nuevo');
                    }
                });
            });
        });
        </script>
        <?php
    }

    public function display_settings_page() {
        echo '<div class="wrap"><h1>Ajustes de Marketplace Connect</h1><p>Versión: ' . $this->version . '</p></div>';
    }

    // AJAX Handlers
    public function handle_login() {
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        
        $result = $this->api->login($email, $password);

        if ($result['success']) {
            wp_send_json_success();
        } else {
            wp_send_json_error($result['message']);
        }
    }

    public function handle_disconnect() {
        delete_option('mp_api_token');
        delete_option('mp_user_info');
        wp_send_json_success();
    }

    public function handle_download() {
        $id = intval($_POST['id']);
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'plugin';
        
        $token = get_option('mp_api_token');
        if (!$token) {
            wp_send_json_error('No hay sesión activa de API. Conéctate de nuevo.');
        }

        // Build absolute download URL with token
        $api_url = defined('MARKETPLACE_API_URL') ? MARKETPLACE_API_URL : 'http://localhost:8000/api/v1';
        $package_url = $api_url . '/download/' . $id . '?api_token=' . $token;

        // Require necessary files for installation/upgrades
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/theme-install.php';

        if (!class_exists('Automatic_Upgrader_Skin')) {
            require_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';
        }
        $skin = new Automatic_Upgrader_Skin();

        if ($type === 'theme') {
            $upgrader = new Theme_Upgrader($skin);
            $result = $upgrader->install($package_url);
        } else {
            // plugin, gpl, or premium (Plugin installer)
            $upgrader = new Plugin_Upgrader($skin);
            $result = $upgrader->install($package_url);

            // Auto activate plugin on success
            if ($result && !is_wp_error($result)) {
                $plugin_slug = $upgrader->plugin_info();
                if ($plugin_slug) {
                    activate_plugin($plugin_slug);
                }
            }
        }

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } elseif ($result === null || $result === false) {
            wp_send_json_error('La instalación falló. Verifica los permisos de escritura en tu servidor WordPress.');
        } else {
            wp_send_json_success(array('message' => '¡Recurso instalado y activado con éxito en tu WordPress!'));
        }
    }
}
