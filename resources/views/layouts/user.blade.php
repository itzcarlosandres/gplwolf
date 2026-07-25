<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic Favicon -->
    @if(isset($globalSettings['site_favicon']))
        <link rel="icon" href="{{ \Illuminate\Support\Str::startsWith($globalSettings['site_favicon'], 'ui/') ? asset($globalSettings['site_favicon']) : asset('storage/' . $globalSettings['site_favicon']) }}">
    @endif

    <title>@yield('title') | Panel de Usuario WP Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('{{ 'https://fonts.googleapis.com/css2?family=' . str_replace(' ', '+', $globalSettings['site_font'] ?? 'Outfit') . ':wght@200;400;700;800;900&display=swap' }}');
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF2121',
                        secondary: '#F51B1B',
                        dark: '#030712',
                        indigo: { // Mapping indigo to BRAND BLUE to safe-fix existing classes
                            400: '#FF2121',
                            500: '#FF2121',
                            600: '#F51B1B',
                        },
                         blue: {
                            500: '#FF2121',
                            600: '#F51B1B',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: '{{ $globalSettings['site_font'] ?? 'Outfit' }}', sans-serif; background-color: #030712; color: white; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .gradient-bg { background: linear-gradient(135deg, #FF2121 0%, #F51B1B 100%); }
        .active-link { background: rgba(255, 33, 33, 0.15); border-left: 3px solid #FF2121; color: white; }
        .active-link i { color: #FF2121; }
    </style>
</head>
<body class="bg-[#050505] overflow-x-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
    <!-- Toast Notifications Container -->
    <div id="notification-container" class="fixed top-8 right-8 z-[9999] space-y-4 max-w-md pointer-events-none"></div>
    
    <script>
        // Sonido de notificación
        function playNotificationSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                if (audioContext.state === 'suspended') {
                    audioContext.resume();
                }
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 800;
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.3);
                
                setTimeout(() => {
                    const osc2 = audioContext.createOscillator();
                    const gain2 = audioContext.createGain();
                    osc2.connect(gain2);
                    gain2.connect(audioContext.destination);
                    osc2.frequency.value = 1000;
                    osc2.type = 'sine';
                    gain2.gain.setValueAtTime(0.2, audioContext.currentTime);
                    gain2.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
                    osc2.start(audioContext.currentTime);
                    osc2.stop(audioContext.currentTime + 0.2);
                }, 100);
            } catch (e) {
                console.warn('Audio play failed', e);
            }
        }

        // Sistema de notificaciones
        let lastNotificationId = 0;
        // Cargar notificaciones mostradas del localStorage
        let shownNotifications = new Set(JSON.parse(localStorage.getItem('shown_notifications') || '[]'));

        function showToast(notification) {
            // Verificar si ya se mostró esta notificación (en esta sesión o previo guardado)
            if (shownNotifications.has(notification.id)) return;
            
            // Marcar como mostrada y guardar en localStorage
            shownNotifications.add(notification.id);
            localStorage.setItem('shown_notifications', JSON.stringify([...shownNotifications]));

            let container = document.getElementById('notification-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notification-container';
                container.className = 'fixed top-8 right-8 z-[9999] space-y-4 max-w-md pointer-events-none';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto transform transition-all duration-300 ease-out';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(400px)';
            
            toast.innerHTML = `
                <div class="glass p-6 rounded-3xl shadow-2xl border-l-4 border-[#FF2121] backdrop-blur-xl">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#FF2121] to-[#F51B1B] rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-[#F51B1B]/30">
                            <i class="fas ${notification.icon} text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-sm font-black text-white">${notification.title}</h4>
                                <button onclick="this.closest('.transform').remove()" class="text-gray-500 hover:text-white transition ml-2">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mb-3">${notification.message}</p>
                            <div class="flex gap-2">
                                ${notification.link ? `
                                    <a href="${notification.link}" class="px-4 py-2 bg-[#F51B1B] hover:bg-[#F51B1B] text-white text-xs font-bold rounded-xl transition-all">
                                        Ver Ahora
                                    </a>
                                ` : ''}
                                <button onclick="markAsRead(${notification.id}, this)" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white text-xs font-bold rounded-xl transition-all">
                                    Marcar como leída
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateX(0)';
            }, 10);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 300);
            }, 8000);
        }

        function markAsRead(notificationId, button) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                button.closest('.transform').style.opacity = '0';
                button.closest('.transform').style.transform = 'translateX(400px)';
                setTimeout(() => button.closest('.transform').remove(), 300);
            });
        }

        function checkForNewNotifications() {
            fetch('/notifications/unread')
                .then(response => response.json())
                .then(data => {
                    if (data.notifications && data.notifications.length > 0) {
                        // Filtrar notificaciones que ya se han mostrado localmente
                        const trulyNewNotifications = data.notifications.filter(n => !shownNotifications.has(n.id));
                        
                        if (trulyNewNotifications.length > 0) {
                            playNotificationSound();
                            trulyNewNotifications.forEach((notification, index) => {
                                setTimeout(() => {
                                    showToast(notification);
                                }, index * 300);
                            });
                            
                            // Mostrar badge rojo
                            const badge = document.getElementById('notification-badge');
                            if(badge) badge.classList.remove('hidden');

                            if (data.notifications.length > 0) {
                                lastNotificationId = Math.max(...data.notifications.map(n => n.id));
                            }
                        }
                    } else {
                         // Opcional: Ocultar badge si no hay no leídas (depende de la lógica del backend 'unread')
                         // const badge = document.getElementById('notification-badge');
                         // if(badge && data.count === 0) badge.classList.add('hidden');
                    }
                    
                })
                .catch(e => console.error('Error checking notifications', e));
        }

        document.addEventListener('DOMContentLoaded', () => {
             checkForNewNotifications();
             setInterval(checkForNewNotifications, 30000);
        });
    </script>
    
    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 lg:hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen" 
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 w-72 glass border-r border-white/5 z-50 flex flex-col pt-8">
        
        <div class="px-8 mb-12 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter text-white flex items-center gap-2 group">
                @if(($globalSettings['site_identity_type'] ?? 'logo') === 'logo' && isset($globalSettings['site_logo']))
                    <img src="{{ \Illuminate\Support\Str::startsWith($globalSettings['site_logo'], 'ui/') ? asset($globalSettings['site_logo']) : asset('storage/' . $globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'WP Marketplace' }}" class="h-8 w-auto hover:scale-105 transition-transform">
                @else
                    <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center shadow-lg shadow-[#F51B1B]/40 group-hover:scale-110 transition-transform">
                        <i class="{{ $globalSettings['site_icon'] ?? 'fas fa-rocket' }} text-white text-sm"></i>
                    </div>
                    <span class="group-hover:text-[#FF2121] transition-colors">{{ $globalSettings['site_name'] ?? 'WP Market' }}</span>
                @endif
            </a>
            <!-- Close Sidebar Mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <p class="px-4 text-[10px] font-black text-gray-600 uppercase tracking-[0.2em] mb-4">Principal</p>
            
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-r-xl transition-all {{ request()->routeIs('dashboard') ? 'active-link' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-th-large w-6"></i>
                <span class="ml-3 font-bold">Dashboard</span>
            </a>

            <a href="{{ route('user.downloads') }}" class="flex items-center px-4 py-3 rounded-r-xl transition-all {{ request()->routeIs('user.downloads') ? 'active-link' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-download w-6"></i>
                <span class="ml-3 font-bold">Mis Descargas</span>
            </a>

            <a href="{{ route('user.licenses') }}" class="flex items-center px-4 py-3 rounded-r-xl transition-all {{ request()->routeIs('user.licenses') ? 'active-link' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-key w-6"></i>
                <span class="ml-3 font-bold">Mis Licencias</span>
            </a>

            <a href="{{ route('user.orders') }}" class="flex items-center px-4 py-3 rounded-r-xl transition-all {{ request()->routeIs('user.orders') ? 'active-link' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-shopping-bag w-6"></i>
                <span class="ml-3 font-bold">Mis Compras</span>
            </a>

            <a href="{{ route('user.support.index') }}" class="flex items-center px-4 py-3 rounded-r-xl transition-all {{ request()->routeIs('user.support.*') ? 'active-link' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-headset w-6"></i>
                <span class="ml-3 font-bold">Soporte</span>
            </a>

            <a href="{{ route('user.rewards') }}" class="flex items-center px-4 py-3 rounded-r-xl transition-all {{ request()->routeIs('user.rewards') ? 'active-link' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-gift w-6"></i>
                <span class="ml-3 font-bold">Mis Recompensas</span>
            </a>

            <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-3 rounded-r-xl transition-all {{ request()->routeIs('user.profile') ? 'active-link' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fas fa-user-circle w-6"></i>
                <span class="ml-3 font-bold">Mi Perfil</span>
            </a>

            @php
                $pluginShowMenu = \App\Models\Setting::where('key', 'plugin_show_menu')->value('value');
            @endphp
            
            @if($pluginShowMenu)
            <a href="{{ route('user.sites.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.sites.*') ? 'bg-[#F51B1B] text-white shadow-lg shadow-[#F51B1B]/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <i class="fab fa-wordpress w-6"></i>
                <span class="ml-3 font-bold">Sitios Conectados</span>
            </a>
            @endif

            <div class="my-8 border-t border-white/5 mx-4"></div>
            
            <p class="px-4 text-[10px] font-black text-gray-600 uppercase tracking-[0.2em] mb-4">Cuenta</p>

            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl transition-all text-gray-400 hover:text-white hover:bg-white/5">
                <i class="fas fa-user-circle w-6"></i>
                <span class="ml-3 font-bold">Perfil</span>
            </a>

            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all text-amber-500 hover:bg-amber-500/10">
                <i class="fas fa-shield-halved w-6"></i>
                <span class="ml-3 font-bold">Panel Admin</span>
            </a>
            @endif
        </nav>

        <div class="p-4 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-gray-500 hover:text-rose-500 hover:bg-rose-500/10 transition-all font-bold">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span class="ml-3">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main :class="sidebarOpen ? 'lg:ml-72' : 'ml-0'" class="transition-all duration-300 min-h-screen">
        <!-- Top Nav -->
        <header class="h-16 lg:h-20 glass border-b border-white/5 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-40 backdrop-blur-xl">
            <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:text-white transition-all">
                <i class="fas fa-bars-staggered"></i>
            </button>

            <div class="flex items-center gap-4 lg:gap-6">
                <!-- Notifications Bell -->
                <a href="{{ route('notifications.index') }}" class="text-gray-400 hover:text-white relative transition-colors group">
                    <i class="fas fa-bell text-xl group-hover:scale-110 transition-transform"></i>
                    <span id="notification-badge" class="absolute -top-1 -right-1 flex h-3 w-3 {{ auth()->user()->notifications()->where('is_read', false)->count() > 0 ? '' : 'hidden' }}">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </a>

                <!-- Streak Badge -->
                <a href="{{ route('user.rewards') }}" class="hidden md:flex items-center gap-2 bg-gradient-to-r from-orange-500/10 to-red-500/10 border border-orange-500/20 px-3 py-1.5 rounded-xl hover:bg-white/5 transition-all group">
                    <i class="fas fa-fire text-orange-500 group-hover:scale-110 transition-transform"></i>
                    <span class="text-xs font-black text-orange-400">
                        {{ Auth::user()->dailyLogin?->current_streak ?? 0 }}
                    </span>
                </a>

                <div class="flex items-center gap-3 bg-white/5 pl-2 pr-4 py-1.5 rounded-2xl border border-white/5">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2862eb&color=fff&bold=true" class="w-8 h-8 rounded-xl">
                    <span class="text-xs font-black text-white uppercase tracking-wider hidden md:block">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-10 max-w-7xl mx-auto">
            @if (session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-sm font-bold flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>