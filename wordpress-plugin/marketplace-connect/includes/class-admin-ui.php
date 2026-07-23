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
        <style>
        @keyframes mp_pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 20px rgba(239, 68, 68, 0.2); }
            50% { transform: scale(1.03); box-shadow: 0 0 30px rgba(239, 68, 68, 0.4); }
        }
        @keyframes mp_grid_move {
            0% { background-position: center, 0px 0px, 0px 0px; }
            100% { background-position: center, 40px 40px, 40px 40px; }
        }
        @keyframes mp_scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }
        .mp-login-wrapper {
            position: relative;
            background-color: #06060a;
            background-image: 
                radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.15) 0%, transparent 65%),
                linear-gradient(to right, rgba(239, 68, 68, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(239, 68, 68, 0.05) 1px, transparent 1px);
            background-size: 100% 100%, 40px 40px, 40px 40px;
            animation: mp_grid_move 8s linear infinite;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            box-sizing: border-box;
            border-radius: 28px;
            margin-top: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            overflow: hidden;
        }
        .mp-login-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(239, 68, 68, 0.1) 50%, transparent);
            pointer-events: none;
            animation: mp_scanline 6s linear infinite;
        }
        .mp-login-card {
            background: rgba(255, 255, 255, 0.01) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 24px !important;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            padding: 36px !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        }
        .mp-login-input {
            background: rgba(0, 0, 0, 0.45) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            width: 100% !important;
            font-size: 14px !important;
            outline: none !important;
            transition: all 0.3s !important;
            box-sizing: border-box !important;
            height: auto !important;
        }
        .mp-login-input:focus {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
            background: rgba(0, 0, 0, 0.6) !important;
        }
        .mp-login-label {
            display: block !important;
            font-weight: 700 !important;
            margin-bottom: 8px !important;
            color: #a1a1aa !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }
        .mp-message-box {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            display: none;
        }
        .mp-message-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #34d399;
        }
        .mp-message-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
        }
        .mp-message-loading {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }
        </style>

        <div class="mp-login-wrapper">
            <div class="mp-login-card">
                <!-- Brand logo/intro -->
                <div style="text-align: center; margin-bottom: 28px;">
                    <div style="width: 68px; height: 68px; background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; animation: mp_pulse 2.5s infinite; box-sizing: border-box;">
                        <!-- SVG Wolf Shield Logo -->
                        <svg style="width: 32px; height: 32px; fill: #ef4444;" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12c0 3.06 1.38 5.8 3.58 7.65L12 22l6.42-2.35C20.62 17.8 22 15.06 22 12c0-5.52-4.48-10-10-10zm0 18.09l-4.58-1.68C6.1 16.91 5 14.58 5 12c0-3.87 3.13-7 7-7s7 3.13 7 7c0 2.58-1.1 4.91-2.42 6.41L12 20.09zM11 7h2v2h-2zm0 4h2v6h-2z"/>
                        </svg>
                    </div>
                    <h2 style="color: #fff; font-size: 26px; font-weight: 900; margin: 0; letter-spacing: -0.03em;">GPLWOLF</h2>
                    <p style="color: #71717a; font-size: 12px; margin: 8px 0 0 0; line-height: 1.5; font-weight: 500;">
                        Conecta este sitio con tu cuenta de GPLWolf para sincronizar e instalar temas y plugins premium.
                    </p>
                </div>

                <!-- Messages -->
                <div id="mp-login-message" class="mp-message-box"></div>

                <!-- Form -->
                <form id="mp-login-form" style="margin: 0;">
                    <div style="margin-bottom: 18px;">
                        <label class="mp-login-label">Correo Electrónico</label>
                        <input type="email" name="email" class="mp-login-input" placeholder="ejemplo@correo.com" required autocomplete="email">
                    </div>
                    
                    <div style="margin-bottom: 24px;">
                        <label class="mp-login-label">Contraseña</label>
                        <input type="password" name="password" class="mp-login-input" placeholder="••••••••" required autocomplete="current-password">
                    </div>

                    <button type="submit" class="button" style="width: 100%; background: #ef4444; border: none; color: #fff; padding: 12px; border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; transition: all 0.2s; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);" onmouseover="this.style.background='#dc2626'; this.style.boxShadow='0 4px 20px rgba(239, 68, 68, 0.35)'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#ef4444'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.15)'; this.style.transform='translateY(0)'">
                        Conectar Sitio
                    </button>
                </form>
            </div>
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
                
                var msgBox = $('#mp-login-message');
                msgBox.removeClass('mp-message-success mp-message-error')
                      .addClass('mp-message-loading')
                      .html('<span class="dashicons dashicons-update spin" style="font-size: 16px; width: 16px; height: 16px; line-height: 1; margin-right: 6px; display: inline-block; vertical-align: middle;"></span> Conectando sitio...')
                      .fadeIn();
                
                $.post(mp_ajax.ajax_url, data, function(response) {
                    if(response.success) {
                        msgBox.removeClass('mp-message-loading mp-message-error')
                              .addClass('mp-message-success')
                              .html('¡Conectado! Redireccionando...');
                        setTimeout(function() {
                            location.reload();
                        }, 800);
                    } else {
                        var errMsg = response.data || 'Error desconocido';
                        msgBox.removeClass('mp-message-loading mp-message-success')
                              .addClass('mp-message-error')
                              .html(errMsg);
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
                    <?php if(!$isUnlimitedDownloads): ?>
                        <div style="background: rgba(255,255,255,0.06); height: 8px; border-radius: 9999px; overflow: hidden; margin-bottom: 8px;">
                            <div style="background: #ef4444; height: 100%; width: <?php echo min(100, $progressPercent); ?>%; border-radius: 9999px; transition: width 0.4s ease; box-shadow: 0 0 10px rgba(239,68,68,0.5);"></div>
                        </div>
                        <p style="color: #52525b; font-size: 10px; margin: 0; font-weight: 600;">Cupo disponible: <?php echo max(0, $downloadsMax - $downloadsToday); ?> descargas</p>
                    <?php else: ?>
                        <div style="background: rgba(255,255,255,0.06); height: 8px; border-radius: 9999px; overflow: hidden; margin-bottom: 8px;">
                            <div style="background: linear-gradient(90deg, #10b981, #3b82f6); height: 100%; width: 100%; border-radius: 9999px;"></div>
                        </div>
                        <p style="color: #10b981; font-size: 10px; margin: 0; font-weight: 700;">Descargas ilimitadas activadas</p>
                    <?php endif; ?>
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
                <?php if (isset($products_data['success']) && !$products_data['success']): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.15); border-radius: 20px; color: #fff;">
                        <span class="dashicons dashicons-lock" style="font-size: 36px; width: 36px; height: 36px; color: #ef4444; margin-bottom: 12px;"></span>
                        <p style="font-size: 16px; font-weight: bold; margin: 0 0 10px 0; color: #ef4444;"><?php echo esc_html($products_data['message']); ?></p>
                        <p style="font-size: 13px; color: #a1a1aa; margin: 0 0 16px 0;">Tu plan de membresía actual (Gratis) no tiene permisos de descarga activos o tu membresía ha vencido.</p>
                        <a href="http://localhost/gplwolf/public/membresias" target="_blank" style="color: #fff; background: #ef4444; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: bold; font-size: 13px; display: inline-block; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Adquirir Membresía</a>
                    </div>
                <?php elseif (empty($products)): ?>
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
