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
        // Refresh user info dynamically from API on load
        $fresh_user_info = $this->api->get_user_info();
        $user_info = $fresh_user_info ? $fresh_user_info : get_option('mp_user_info');
        $token = get_option('mp_api_token');

        // Fetch products
        $products_data = $this->api->get_products();
        $products = $products_data['data'] ?? [];

        // Dynamic limits calculations
        $downloadsToday = (int) ($user_info['downloads_today'] ?? 0);
        $downloadsLimit = $user_info['downloads_limit'] ?? 0;
        $isUnlimitedDownloads = ($downloadsLimit === 'Ilimitado' || (int)$downloadsLimit === 0);
        $downloadsMax = $isUnlimitedDownloads ? 999 : (int)$downloadsLimit;
        $progressPercent = $isUnlimitedDownloads ? 0 : ($downloadsMax > 0 ? ($downloadsToday / $downloadsMax) * 100 : 0);

        $sitesConnected = (int) ($user_info['sites_connected'] ?? 0);
        $sitesLimit = $user_info['sites_limit'] ?? 0;
        $isUnlimitedSites = ($sitesLimit === 'Ilimitado' || (int)$sitesLimit === 0);
        ?>
        <div class="wrap" style="background: #09090b; padding: 28px; border-radius: 28px; color: #fff; min-height: 80vh; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; margin-top: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.3);">
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 24px; margin-bottom: 28px;">
                <div>
                    <h1 style="color: #fff; font-size: 30px; font-weight: 900; margin: 0; letter-spacing: -0.03em;">Marketplace Connect</h1>
                    <p style="color: #71717a; font-size: 13px; margin: 6px 0 0 0; font-weight: 500;">Instala y actualiza tus temas y plugins premium en un solo clic.</p>
                </div>
                <div>
                    <button id="mp-disconnect-btn" class="button" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #ef4444; padding: 8px 16px; border-radius: 12px; font-weight: bold; cursor: pointer; transition: all 0.2s; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff'" onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#ef4444'">
                        Desconectar
                    </button>
                </div>
            </div>

            <!-- Stats Banner -->
            <div style="background: linear-gradient(135deg, rgba(239,68,68,0.05) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid rgba(255,255,255,0.06); border-radius: 24px; padding: 28px; margin-bottom: 32px; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 28px; backdrop-filter: blur(12px);">
                <!-- User Profile -->
                <div>
                    <span style="color: #ef4444; font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em; display: block; margin-bottom: 4px;">Cliente VIP</span>
                    <h3 style="color: #fff; font-size: 22px; font-weight: 900; margin: 0; letter-spacing: -0.02em;"><?php echo esc_html($user_info['name']); ?></h3>
                    <p style="color: #a1a1aa; font-size: 12px; margin: 6px 0 0 0; font-weight: 600;">Plan: <strong style="color: #fbbf24;"><?php echo esc_html($user_info['plan']); ?></strong></p>
                    <p style="color: #52525b; font-size: 11px; margin: 4px 0 0 0; font-weight: 500;">Vencimiento: <?php echo esc_html($user_info['expires_at'] ?? 'Nunca'); ?></p>
                </div>

                <!-- Daily Downloads Progress -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="color: #a1a1aa; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Descargas Hoy</span>
                        <span style="color: #fff; font-size: 12px; font-weight: 900;"><?php echo $downloadsToday; ?> / <?php echo $isUnlimitedDownloads ? '∞' : $downloadsMax; ?></span>
                    </div>
                    @if(!$isUnlimitedDownloads)
                        <div style="background: rgba(255,255,255,0.06); height: 8px; border-radius: 9999px; overflow: hidden; margin-bottom: 8px;">
                            <div style="background: #ef4444; height: 100%; width: <?php echo min(100, $progressPercent); ?>%; border-radius: 9999px; transition: width 0.4s ease; box-shadow: 0 0 10px rgba(239,68,68,0.5);"></div>
                        </div>
                        <p style="color: #52525b; font-size: 10px; margin: 0; font-weight: 600;">Cupo disponible: <?php echo max(0, $downloadsMax - $downloadsToday); ?> descargas</p>
                    @else
                        <div style="background: rgba(255,255,255,0.06); height: 8px; border-radius: 9999px; overflow: hidden; margin-bottom: 8px;">
                            <div style="background: linear-gradient(90deg, #10b981, #3b82f6); height: 100%; width: 100%; border-radius: 9999px;"></div>
                        </div>
                        <p style="color: #10b981; font-size: 10px; margin: 0; font-weight: 700;">Descargas ilimitadas activadas</p>
                    @endif
                </div>

                <!-- Connected Sites Progress -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="color: #a1a1aa; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Sitios Conectados</span>
                        <span style="color: #fff; font-size: 12px; font-weight: 900;"><?php echo $sitesConnected; ?> / <?php echo $isUnlimitedSites ? '∞' : $sitesLimit; ?></span>
                    </div>
                    <div style="background: rgba(255,255,255,0.06); height: 8px; border-radius: 9999px; overflow: hidden; margin-bottom: 8px;">
                        <?php
                            $sitesMax = $isUnlimitedSites ? 999 : (int)$sitesLimit;
                            $sitesPercent = $isUnlimitedSites ? 100 : ($sitesMax > 0 ? ($sitesConnected / $sitesMax) * 100 : 0);
                            $sitesColor = $sitesPercent >= 100 ? '#ef4444' : '#3b82f6';
                        ?>
                        <div style="background: <?php echo $sitesColor; ?>; height: 100%; width: <?php echo min(100, $sitesPercent); ?>%; border-radius: 9999px; transition: width 0.4s ease;"></div>
                    </div>
                    <p style="color: #52525b; font-size: 10px; margin: 0; font-weight: 600;">
                        <?php if ($isUnlimitedSites): ?>
                            Conexión ilimitada permitida
                        <?php else: ?>
                            Quedan <?php echo max(0, $sitesMax - $sitesConnected); ?> licencias libres
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Resource Catalog Title -->
            <h2 style="color: #fff; font-size: 22px; font-weight: 900; margin: 0 0 24px 0; display: flex; align-items: center; gap: 10px; letter-spacing: -0.02em;">
                <span style="display: inline-block; width: 4px; height: 22px; background: #ef4444; border-radius: 2px;"></span> Explorador de Recursos Premium
            </h2>

            <!-- Grid -->
            <div class="mp-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 24px;">
                <?php if (empty($products)): ?>
                    <p style="color: #71717a; grid-column: 1 / -1; text-align: center; padding: 60px; font-weight: 600;">No se encontraron recursos premium disponibles.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="mp-card" style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: all 0.3s; box-shadow: 0 4px 20px rgba(0,0,0,0.15);" onmouseover="this.style.borderColor='rgba(239,68,68,0.2)'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.3)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.15)'">
                            <!-- Thumbnail Area -->
                            <div style="height: 160px; background: #121214; overflow: hidden; position: relative;">
                                <?php if($product['thumbnail']): ?>
                                    <img src="<?php echo esc_url($product['thumbnail']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #3f3f46; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Sin miniatura</div>
                                <?php endif; ?>
                                
                                <!-- Category Badge -->
                                <span style="position: absolute; top: 12px; right: 12px; font-size: 8px; font-weight: 900; text-transform: uppercase; background: rgba(9,9,11,0.75); backdrop-filter: blur(4px); padding: 4px 8px; border-radius: 6px; color: #ef4444; border: 1px solid rgba(255,255,255,0.08); letter-spacing: 0.05em;">
                                    <?php echo esc_html($product['type'] ?? 'Plugin'); ?>
                                </span>
                            </div>
                            
                            <!-- Card Body -->
                            <div style="padding: 22px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; gap: 16px;">
                                <div>
                                    <h3 style="margin: 0 0 8px 0; color: #fff; font-size: 16px; font-weight: 800; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                        <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 190px;" title="<?php echo esc_attr($product['name']); ?>"><?php echo esc_html($product['name']); ?></span>
                                        <span style="font-size: 9px; background: rgba(255,255,255,0.06); padding: 2px 6px; border-radius: 4px; color: #a1a1aa; font-weight: bold; white-space: nowrap;">v<?php echo esc_html($product['version']); ?></span>
                                    </h3>
                                    <p style="font-size: 12px; color: #71717a; line-height: 1.5; margin: 0; min-height: 36px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo esc_html($product['short_description']); ?></p>
                                </div>
                                
                                <!-- Actions -->
                                <div style="display: flex; gap: 10px; margin-top: auto;">
                                    <?php if($product['can_download']): ?>
                                        <!-- Install Native in WP -->
                                        <button class="button button-primary mp-download-btn" data-id="<?php echo $product['id']; ?>" data-type="<?php echo esc_attr($product['type'] ?? 'plugin'); ?>" style="flex: 2; background: #ef4444; border: none; color: #fff; padding: 10px; border-radius: 12px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 12px; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                                            <span class="dashicons dashicons-admin-plugins" style="font-size: 16px; width: 16px; height: 16px; line-height: 1;"></span> Instalar en WP
                                        </button>
                                        <!-- Download raw ZIP package -->
                                        <a href="<?php echo esc_url(defined('MARKETPLACE_API_URL') ? MARKETPLACE_API_URL : 'http://localhost:8000/api/v1'); ?>/download/<?php echo $product['id']; ?>?api_token=<?php echo esc_attr($token); ?>" class="button" style="flex: 1; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 8px; border-radius: 12px; font-weight: 700; cursor: pointer; text-decoration: none; display: flex; align-items: center; justify-content: center; font-size: 11px; text-transform: uppercase; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.background='rgba(255,255,255,0.04)'" title="Descargar archivo ZIP de forma directa" download>
                                            <span class="dashicons dashicons-download" style="font-size: 14px; width: 14px; height: 14px; line-height: 1; margin-right: 2px;"></span> ZIP
                                        </a>
                                    <?php else: ?>
                                        <button class="button" disabled style="width: 100%; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.01); color: #3f3f46; padding: 10px; border-radius: 12px; font-weight: 700; cursor: not-allowed; font-size: 12px;">
                                            🔒 Requiere Membresía
                                        </button>
                                    <?php endif; ?>
                                </div>
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
                if(!confirm('¿Seguro que quieres desconectar este sitio?')) return;
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
                        btn.removeClass('button-primary').addClass('button-disabled').text('¡Instalado!').css('background', '#10b981');
                        alert(response.data.message || 'Instalado con éxito.');
                        // Refresh page after a brief delay to update the statistics
                        setTimeout(function() { location.reload(); }, 1200);
                    } else {
                        // Display clean API error message or code
                        var errMsg = response.data;
                        if (response.data && response.data.message) {
                            errMsg = response.data.message;
                        }
                        alert('Error: ' + errMsg);
                        btn.prop('disabled', false).html('<span class="dashicons dashicons-admin-plugins"></span> Instalar en WP');
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
