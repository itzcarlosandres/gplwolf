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
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'mp-tailwind', 'https://cdn.tailwindcss.com', array(), $this->version, false );
        wp_enqueue_script( 'mp-admin-js', MARKETPLACE_CONNECT_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( 'mp-admin-js', 'mp_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function display_update_notice() {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $latest_version = get_transient( 'mp_latest_plugin_version' );
        if ( ! $latest_version ) {
            $latest_version = get_option( 'mp_latest_plugin_version' );
        }

        if ( $latest_version && version_compare( $this->version, $latest_version, '<' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible" style="border-left-color: #FF2121; padding: 12px; background: #fff; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">
                <p style="margin: 0; font-size: 14px; color: #1d2327; display: flex; align-items: center; gap: 8px;">
                    <span style="color: #FF2121; font-weight: bold; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">GPLWolf Connector:</span>
                    <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Hay una nueva versión (<strong><?php echo esc_html( $latest_version ); ?></strong>) disponible del plugin oficial (versión actual: <?php echo esc_html( $this->version ); ?>).</span>
                    <a href="https://gplwolf.com/plugin-oficial" target="_blank" style="color: #FF2121; text-decoration: underline; font-weight: bold; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        Descargar última versión
                    </a>
                </p>
            </div>
            <?php
        }
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

        if ( ! $user_info ) {
            $this->display_login_form();
            return;
        }

        $token = get_option('mp_api_token');

        // Fetch products
        $products_data = $this->api->get_products(1, '', 250);
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

        $api_url = defined('MARKETPLACE_API_URL') ? MARKETPLACE_API_URL : 'http://localhost/gplwolf/api/v1';
        $products_json = json_encode($products);
        ?>
        <!-- Load AlpineJS & FontAwesome -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            .bauhaus-card {
                border: 3px solid #1c1c22 !important;
                background: #09090b !important;
                border-radius: 0px !important;
                box-shadow: 6px 6px 0px #1c1c22 !important;
                transition: all 0.2s ease-in-out;
            }
            .bauhaus-card:hover {
                transform: translate(-3px, -3px);
                box-shadow: 9px 9px 0px #FF2121 !important;
                border-color: #FF2121 !important;
            }
            .bauhaus-button {
                border: 2px solid #1c1c22 !important;
                border-radius: 0px !important;
                box-shadow: 3px 3px 0px #1c1c22 !important;
            }
            .bauhaus-button:hover {
                box-shadow: 0px 0px 0px #1c1c22 !important;
                transform: translate(2px, 2px);
            }
            .mp-search-input {
                background: #050505 !important;
                color: #fff !important;
                border: 1px solid rgba(255,255,255,0.1) !important;
                border-radius: 12px !important;
                padding-left: 36px !important;
                padding-right: 16px !important;
                padding-top: 8px !important;
                padding-bottom: 8px !important;
                font-size: 12px !important;
                height: 38px !important;
                width: 100% !important;
                transition: all 0.2s ease-in-out !important;
            }
            .mp-search-input:focus {
                border-color: #ef4444 !important;
                box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
                outline: none !important;
            }
        </style>

        <div class="wrap" x-data="marketplaceApp(<?php echo esc_attr($products_json); ?>, '<?php echo esc_js($token); ?>', '<?php echo esc_js($api_url); ?>')" style="background: #09090b; padding: 28px; border-radius: 28px; color: #fff; min-height: 80vh; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; margin-top: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.3); position: relative; overflow: hidden;">
            <div class="absolute top-0 right-0 w-80 h-80 bg-red-600/5 rounded-full blur-[100px] pointer-events-none"></div>

            <!-- Update Warning Banner -->
            <?php
            $latest_version = get_transient( 'mp_latest_plugin_version' );
            if ( ! $latest_version ) {
                $latest_version = get_option( 'mp_latest_plugin_version' );
            }
            if ( $latest_version && version_compare( $this->version, $latest_version, '<' ) ) :
            ?>
            <div style="background: rgba(245, 158, 11, 0.1); border: 2px solid rgba(245, 158, 11, 0.2); border-radius: 16px; padding: 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; box-sizing: border-box;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 20px; flex-shrink: 0; box-sizing: border-box;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h4 style="color: #fff; font-size: 15px; font-weight: 800; margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">¡Actualización del Plugin Oficial Recomendada!</h4>
                        <p style="color: #d4d4d8; font-size: 12px; margin: 4px 0 0 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Estás usando la versión v<?php echo esc_html($this->version); ?>, pero la versión v<?php echo esc_html($latest_version); ?> está disponible. Descárgala para obtener compatibilidad y mejoras de seguridad.</p>
                    </div>
                </div>
                <div style="flex-shrink: 0;">
                    <a href="https://gplwolf.com/plugin-oficial" target="_blank" style="background: #f59e0b; color: #000; padding: 8px 16px; border-radius: 10px; font-weight: bold; text-decoration: none; font-size: 12px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                        <i class="fas fa-download"></i> Descargar v<?php echo esc_html($latest_version); ?>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Toast Notifications Overlay -->
            <div class="fixed top-8 right-8 z-[9999] space-y-3 pointer-events-none max-w-sm">
                <template x-for="toast in toasts" :key="toast.id">
                    <div x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="translate-y-2 opacity-0 scale-95"
                         x-transition:enter-end="translate-y-0 opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="p-4 bg-zinc-900 border border-white/10 rounded-2xl shadow-2xl flex items-center gap-3 pointer-events-auto">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm shrink-0"
                             :class="toast.type === 'success' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400'">
                            <i class="fas" :class="toast.type === 'success' ? 'fa-check-circle' : 'fa-info-circle'"></i>
                        </div>
                        <div>
                            <p class="text-white text-xs font-bold" x-text="toast.message"></p>
                        </div>
                    </div>
                </template>
            </div>

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
                    <?php 
                    $progressColor = '#10b981'; // Green
                    $progressShadow = 'rgba(16, 185, 129, 0.4)';
                    if (!$isUnlimitedDownloads) {
                        if ($progressPercent >= 50 && $progressPercent < 80) {
                            $progressColor = '#fbbf24'; // Yellow/Amber
                            $progressShadow = 'rgba(251, 191, 36, 0.4)';
                        } elseif ($progressPercent >= 80) {
                            $progressColor = '#ef4444'; // Red
                            $progressShadow = 'rgba(239, 68, 68, 0.4)';
                        }
                    } else {
                        $progressColor = '#10b981';
                    }
                    ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="color: #a1a1aa; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Descargas Hoy</span>
                        <span style="color: <?php echo $progressColor; ?>; font-size: 12px; font-weight: 900; transition: color 0.4s ease;"><?php echo $downloadsToday; ?> / <?php echo $isUnlimitedDownloads ? '∞' : $downloadsMax; ?></span>
                    </div>
                    <?php if(!$isUnlimitedDownloads): ?>
                        <div style="background: rgba(255,255,255,0.06); height: 8px; border-radius: 9999px; overflow: hidden; margin-bottom: 8px;">
                            <div style="background: <?php echo $progressColor; ?>; height: 100%; width: <?php echo min(100, $progressPercent); ?>%; border-radius: 9999px; transition: all 0.4s ease; box-shadow: 0 0 10px <?php echo $progressShadow; ?>;"></div>
                        </div>
                        <p style="color: #52525b; font-size: 10px; margin: 0; font-weight: 600;">Cupo disponible: <strong style="color: <?php echo $progressColor; ?>; transition: color 0.4s ease;"><?php echo max(0, $downloadsMax - $downloadsToday); ?></strong> descargas</p>
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

            <!-- Controls and Redesign Tabs Bar -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8 bg-zinc-950/30 border border-white/5 p-4 rounded-2xl">
                <!-- Search & Filters -->
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search input -->
                    <div class="relative" style="width: 240px;">
                        <span class="dashicons dashicons-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" style="font-size: 16px; width: 16px; height: 16px; line-height: 1; pointer-events: none; z-index: 10;"></span>
                        <input type="text" x-model="searchQuery" placeholder="Buscar plugin o theme..." class="mp-search-input">
                    </div>

                    <!-- Category Tabs -->
                    <div class="flex flex-wrap items-center bg-[#050505] border border-white/10 p-1 rounded-xl gap-1">
                        <button @click="filterTab = 'all'" :class="filterTab === 'all' ? 'bg-red-500 text-white' : 'text-gray-400 hover:text-white'" class="px-3.5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all border-none cursor-pointer">
                            Todos
                        </button>
                        <button @click="filterTab = 'licenses'" :class="filterTab === 'licenses' ? 'bg-amber-500 text-black' : 'text-gray-400 hover:text-white'" class="px-3.5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all border-none cursor-pointer flex items-center gap-1">
                            🔑 Licencias
                        </button>
                        <button @click="filterTab = 'news'" :class="filterTab === 'news' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-white'" class="px-3.5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all border-none cursor-pointer flex items-center gap-1">
                            ✨ Nuevos
                        </button>
                        <template x-for="cat in getCategories()" :key="cat">
                            <button @click="filterTab = cat" :class="filterTab === cat ? 'bg-zinc-700 text-white' : 'text-gray-400 hover:text-white'" class="px-3.5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all border-none cursor-pointer" x-text="cat"></button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Products List Render Area -->
            <div class="min-h-[400px]">
                
                <!-- List Mode Layout (Default & Only Layout) -->
                <div class="space-y-4">
                    <template x-for="product in filteredProducts()" :key="product.id">
                        <div class="bg-zinc-950/40 border border-white/5 hover:border-red-500/20 rounded-2xl p-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 transition-all duration-300">
                            <!-- Left Block: Image & Meta -->
                            <div class="flex items-center gap-4 w-full md:w-3/5">
                                <!-- Selection Checkbox or Placeholder -->
                                <div class="shrink-0 w-5 h-5 flex items-center justify-center">
                                    <template x-if="product.can_download && !product.installed">
                                        <input type="checkbox" :checked="selectedProductIds.includes(product.id)" @change="toggleSelection(product.id)" class="w-5 h-5 text-red-500 bg-black border-white/10 rounded focus:ring-red-500 focus:ring-offset-zinc-950 transition-all cursor-pointer">
                                    </template>
                                </div>

                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-zinc-900 border border-white/5 shrink-0 relative flex items-center justify-center">
                                    <template x-if="product.thumbnail">
                                        <img :src="product.thumbnail" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!product.thumbnail">
                                        <i class="fas fa-box text-lg text-gray-700"></i>
                                    </template>
                                    <span class="absolute bottom-1 right-1 text-[7px] font-black uppercase bg-zinc-950/80 px-1 py-0.5 rounded text-red-500 tracking-wider" x-text="product.type"></span>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-white font-bold text-sm truncate" x-text="product.name"></h4>
                                        <span class="text-[9px] px-1.5 py-0.2 bg-white/5 text-gray-500 rounded border border-white/10 font-mono" x-text="'v' + product.version"></span>
                                        <div class="flex gap-1">
                                            <template x-if="product.is_license">
                                                <span class="text-[7px] font-black uppercase bg-amber-500 text-black px-1 py-0.5 rounded">🔑 Licencia</span>
                                            </template>
                                            <template x-if="product.is_new">
                                                <span class="text-[7px] font-black uppercase bg-blue-600 text-white px-1 py-0.5 rounded">✨ Nuevo</span>
                                            </template>
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-xs mt-1 truncate" x-text="product.short_description"></p>
                                </div>
                            </div>

                            <!-- Right Block: Buttons / License Activation -->
                            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0 md:justify-end">
                                <!-- License link -->
                                <template x-if="product.is_license">
                                    <a :href="ticketUrl" target="_blank" class="px-3 py-2 bg-amber-500/10 border border-amber-500/20 text-amber-500 hover:bg-amber-500 hover:text-black rounded-xl text-[10px] font-black uppercase tracking-wider transition-all text-decoration-none">
                                        🔑 Solicitar Clave
                                    </a>
                                </template>

                                <!-- standard install -->
                                <template x-if="product.can_download">
                                    <button @click="install(product)" :disabled="product.installing || product.installed" :class="product.installed ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500 hover:bg-red-600 text-white'" class="px-5 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all w-full sm:w-auto justify-center cursor-pointer border-none">
                                        <i class="fas" :class="product.installed ? 'fa-check' : (product.installing ? 'fa-sync animate-spin' : 'fa-download')"></i>
                                        <span x-text="product.installed ? '¡Instalado!' : (product.installing ? 'Instalando...' : 'Instalar en WP')"></span>
                                    </button>
                                </template>
                                <template x-if="!product.can_download">
                                    <button class="px-5 py-2.5 bg-zinc-900 border border-white/5 text-gray-500 rounded-xl text-xs font-bold cursor-not-allowed" disabled>
                                        🔒 Requiere Membresía
                                    </button>
                                </template>
                                <template x-if="product.can_download">
                                    <button @click="downloadZip(product)" class="p-2.5 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-xl transition-all cursor-pointer" title="Descargar ZIP">
                                        <i class="fas fa-file-zipper text-xs"></i>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Empty state fallback -->
                <div x-show="filteredProducts().length === 0" class="py-24 text-center bg-zinc-950/20 border border-white/5 rounded-3xl max-w-md mx-auto" style="display: none;">
                    <i class="fas fa-folder-open text-gray-700 text-4xl mb-4"></i>
                    <p class="text-gray-400 font-bold text-sm">No se encontraron productos con estos filtros o búsqueda.</p>
                </div>

            </div>

            <!-- Bulk Installer Action Bar -->
            <div class="flex flex-wrap items-center justify-between gap-4 bg-zinc-950/80 border border-white/5 p-3 rounded-2xl mt-4" x-show="products.filter(p => p.can_download && !p.installed).length > 0">
                <div class="flex items-center gap-3">
                    <button @click="selectAll()" class="px-3.5 py-2 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer">
                        <span x-text="filteredProducts().filter(p => p.can_download && !p.installed).every(p => selectedProductIds.includes(p.id)) ? 'Deseleccionar todo' : 'Seleccionar todo'"></span>
                    </button>
                    <span class="text-xs text-gray-400 font-bold" x-show="selectedProductIds.length > 0">
                        <span class="text-red-500 font-black" x-text="selectedProductIds.length"></span> seleccionado(s) para instalar.
                    </span>
                    <span class="text-xs text-gray-500 font-bold" x-show="selectedProductIds.length === 0">
                        Selecciona uno o más plugins para instalarlos en lote.
                    </span>
                </div>

                <button @click="installSelected()" :disabled="selectedProductIds.length === 0 || bulkInstalling" :class="selectedProductIds.length === 0 || bulkInstalling ? 'bg-zinc-900 text-gray-600 border border-white/5 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600 text-white'" class="px-5 py-2.5 rounded-xl font-bold text-xs flex items-center gap-1.5 transition-all cursor-pointer border-none">
                    <i class="fas fa-cubes"></i>
                    <span x-text="bulkInstalling ? 'Instalando en lote...' : 'Instalar seleccionados'"></span>
                </button>
            </div>

            <!-- Bulk Installation Progress Modal -->
            <div class="fixed bottom-6 right-6 z-[9999] bg-[#0c0c0c] border border-white/10 p-5 rounded-2xl w-80 shadow-2xl transition-all duration-300" x-show="bulkInstalling" x-transition style="display: none;">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-black uppercase tracking-wider text-white">Instalación por Lotes</span>
                    <span class="text-xs font-mono text-red-500 font-black" x-text="bulkProgress + '%'"></span>
                </div>
                <div class="w-full bg-white/5 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-red-500 h-full transition-all duration-500" :style="'width: ' + bulkProgress + '%'"></div>
                </div>
                <div class="mt-3 flex justify-between text-[10px] text-gray-500 font-bold">
                    <span>Procesados: <strong class="text-white" x-text="bulkProcessed"></strong> / <strong class="text-white" x-text="bulkTotal"></strong></span>
                    <span x-show="bulkProgress < 100" class="animate-pulse text-amber-500">Instalando...</span>
                    <span x-show="bulkProgress >= 100" class="text-emerald-500">Completado</span>
                </div>
            </div>
        </div>

        <script>
        function marketplaceApp(initialProducts, apiToken, apiUrl) {
            return {
                filterTab: 'all',
                searchQuery: '',
                toasts: [],
                ticketUrl: '',
                searchTimeout: null,
                selectedProductIds: [],
                bulkInstalling: false,
                bulkTotal: 0,
                bulkProcessed: 0,
                bulkProgress: 0,
                products: initialProducts.map(p => ({
                    ...p,
                    installing: false,
                    installed: false
                })),
                
                init() {
                    this.ticketUrl = this.generateTicketUrl();
                    this.$watch('searchQuery', () => {
                        this.debounceSearch();
                    });
                },

                debounceSearch() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.performSearch();
                    }, 300);
                },

                performSearch() {
                    jQuery.ajax({
                        url: apiUrl + '/products',
                        type: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + apiToken,
                            'Accept': 'application/json'
                        },
                        data: {
                            search: this.searchQuery,
                            per_page: 250
                        },
                        success: (response) => {
                            if (response && response.data) {
                                this.products = response.data.map(p => ({
                                    ...p,
                                    installing: false,
                                    installed: false
                                }));
                            }
                        },
                        error: () => {
                            this.toast('error', 'Error al buscar en el servidor.');
                        }
                    });
                },

                generateTicketUrl() {
                    const parts = new URL(apiUrl);
                    let base = parts.protocol + '//' + parts.host;
                    if (parts.pathname) {
                        const segments = parts.pathname.split('/').filter(s => s && s !== 'api' && s !== 'v1');
                        if (segments.length > 0) {
                            base += '/' + segments.join('/');
                        }
                    }
                    return base + '/support';
                },

                getCategories() {
                    const cats = new Set();
                    this.products.forEach(p => {
                        if (p.category_name) {
                            cats.add(p.category_name);
                        }
                    });
                    return Array.from(cats);
                },

                filteredProducts() {
                    return this.products.filter(p => {
                        // Search filter
                        if (this.searchQuery && !p.name.toLowerCase().includes(this.searchQuery.toLowerCase())) {
                            return false;
                        }
                        
                        // Tab filters
                        if (this.filterTab === 'licenses') return p.is_license;
                        if (this.filterTab === 'news') return p.is_new;
                        
                        // Dynamic category check
                        if (this.filterTab !== 'all') {
                            return p.category_name === this.filterTab;
                        }
                        
                        return true;
                    });
                },
                
                install(product) {
                    product.installing = true;
                    this.toast('success', 'Instalando ' + product.name + ' en WordPress...');
                    
                    jQuery.post(mp_ajax.ajax_url, { 
                        action: 'mp_download_item', 
                        id: product.id, 
                        type: product.type 
                    }, (response) => {
                        product.installing = false;
                        if (response.success) {
                            product.installed = true;
                            this.toast('success', response.data && response.data.message ? response.data.message : '¡Recurso instalado con éxito!');
                            setTimeout(() => { location.reload(); }, 1500);
                        } else {
                            var errMsg = response.data;
                            if (response.data && response.data.message) {
                                  errMsg = response.data.message;
                            }
                            this.toast('error', 'Error: ' + errMsg);
                        }
                    }).fail(() => {
                        product.installing = false;
                        this.toast('error', 'Error de conexión o red.');
                    });
                },

                toggleSelection(productId) {
                    if (this.selectedProductIds.includes(productId)) {
                        this.selectedProductIds = this.selectedProductIds.filter(id => id !== productId);
                    } else {
                        this.selectedProductIds.push(productId);
                    }
                },

                selectAll() {
                    const visibleProducts = this.filteredProducts().filter(p => p.can_download && !p.installed);
                    const visibleIds = visibleProducts.map(p => p.id);
                    const allSelected = visibleIds.every(id => this.selectedProductIds.includes(id));
                    if (allSelected) {
                        this.selectedProductIds = this.selectedProductIds.filter(id => !visibleIds.includes(id));
                    } else {
                        visibleIds.forEach(id => {
                            if (!this.selectedProductIds.includes(id)) {
                                this.selectedProductIds.push(id);
                            }
                        });
                    }
                },

                async installSelected() {
                    if (this.selectedProductIds.length === 0) return;
                    
                    this.bulkInstalling = true;
                    this.bulkTotal = this.selectedProductIds.length;
                    this.bulkProcessed = 0;
                    this.bulkProgress = 0;
                    
                    const idsToInstall = [...this.selectedProductIds];
                    this.selectedProductIds = [];
                    
                    for (let id of idsToInstall) {
                        const product = this.products.find(p => p.id === id);
                        if (!product) continue;
                        
                        product.installing = true;
                        this.toast('success', 'Instalando (' + (this.bulkProcessed + 1) + '/' + this.bulkTotal + '): ' + product.name + '...');
                        
                        try {
                            const result = await new Promise((resolve, reject) => {
                                jQuery.post(mp_ajax.ajax_url, { 
                                    action: 'mp_download_item', 
                                    id: product.id, 
                                    type: product.type 
                                }, (response) => {
                                    resolve(response);
                                }).fail(() => {
                                    reject(new Error('Error de conexión o red.'));
                                });
                            });
                            
                            product.installing = false;
                            if (result.success) {
                                product.installed = true;
                                this.toast('success', '¡Instalado!: ' + product.name);
                            } else {
                                const errMsg = (result.data && result.data.message) ? result.data.message : (result.data || 'Error desconocido.');
                                this.toast('error', 'Error en ' + product.name + ': ' + errMsg);
                            }
                        } catch (err) {
                            product.installing = false;
                            this.toast('error', 'Error en ' + product.name + ': ' + err.message);
                        }
                        
                        this.bulkProcessed++;
                        this.bulkProgress = Math.round((this.bulkProcessed / this.bulkTotal) * 100);
                    }
                    
                    this.toast('success', 'Instalación por lotes finalizada.');
                    setTimeout(() => { location.reload(); }, 2000);
                },
                
                downloadZip(product) {
                    this.toast('success', 'Descargando paquete ZIP de ' + product.name + '...');
                    const url = apiUrl + '/download/' + product.id + '?api_token=' + apiToken;
                    window.location.href = url;
                },
                
                toast(type, message) {
                    const id = Date.now();
                    this.toasts.push({ id, type, message });
                    
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 3500);
                }
            };
        }

        jQuery(document).ready(function($) {
            // Disconnect
            $('#mp-disconnect-btn').click(function() {
                if(!confirm('¿Seguro que quieres desconectar este sitio?')) return;
                $.post(mp_ajax.ajax_url, { action: 'mp_disconnect' }, function() {
                    location.reload();
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

        // Verificar la respuesta del servidor antes de iniciar la instalación de WordPress
        $check_response = wp_safe_remote_head($package_url, array('timeout' => 10));
        if (!is_wp_error($check_response)) {
            $headers = wp_remote_retrieve_headers($check_response);
            $content_type = isset($headers['content-type']) ? $headers['content-type'] : '';
            $response_code = intval(wp_remote_retrieve_response_code($check_response));
            
            if ($response_code >= 400) {
                $get_response = wp_safe_remote_get($package_url, array('timeout' => 15));
                if (!is_wp_error($get_response)) {
                    $body = json_decode(wp_remote_retrieve_body($get_response), true);
                    if (isset($body['message'])) {
                        wp_send_json_error("Error del Servidor: " . $body['message']);
                    }
                }
                wp_send_json_error("El servidor de descargas respondió con un error HTTP {$response_code}.");
            }
            
            if (strpos($content_type, 'application/json') !== false) {
                $get_response = wp_safe_remote_get($package_url, array('timeout' => 15));
                if (!is_wp_error($get_response)) {
                    $body = json_decode(wp_remote_retrieve_body($get_response), true);
                    if (isset($body['message'])) {
                        wp_send_json_error("Error del Servidor: " . $body['message']);
                    }
                }
                wp_send_json_error("El servidor devolvió un error JSON en lugar del archivo ZIP.");
            }
        }

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

            // Track theme in installed resources option
            if ($result && !is_wp_error($result)) {
                $theme_slug = $upgrader->theme_info();
                if ($theme_slug) {
                    $installed = get_option('mp_installed_resources', array());
                    $installed[$theme_slug] = array(
                        'id' => $id,
                        'type' => 'theme',
                        'slug' => $theme_slug,
                        'installed_at' => time()
                    );
                    update_option('mp_installed_resources', $installed);
                }
            }
        } else {
            // plugin, gpl, or premium (Plugin installer)
            $upgrader = new Plugin_Upgrader($skin);
            $result = $upgrader->install($package_url);

            // Auto activate plugin on success & track update slug
            if ($result && !is_wp_error($result)) {
                $plugin_slug = $upgrader->plugin_info();
                if ($plugin_slug) {
                    activate_plugin($plugin_slug);

                    // Track plugin in installed resources option
                    $installed = get_option('mp_installed_resources', array());
                    $installed[$plugin_slug] = array(
                        'id' => $id,
                        'type' => 'plugin',
                        'slug' => $plugin_slug,
                        'installed_at' => time()
                    );
                    update_option('mp_installed_resources', $installed);
                }
            }
        }

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } elseif ($result === null || $result === false) {
            $messages = isset($skin->messages) ? $skin->messages : array();
            $msg = 'La instalación falló. ';
            if (!empty($messages)) {
                $msg .= 'Detalles: ' . implode(' | ', array_map('strip_tags', $messages));
            } else {
                $msg .= 'Verifica los permisos de escritura en tu servidor WordPress.';
            }
            wp_send_json_error($msg);
        } else {
            wp_send_json_success(array('message' => '¡Recurso instalado y activado con éxito en tu WordPress!'));
        }
    }
}
