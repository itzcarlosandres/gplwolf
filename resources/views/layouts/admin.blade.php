<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
   
    <!-- Dynamic Favicon -->
    @if(isset($globalSettings['site_favicon']))
        <link rel="icon" href="{{ \Illuminate\Support\Str::startsWith($globalSettings['site_favicon'], 'ui/') ? asset($globalSettings['site_favicon']) : asset('storage/' . $globalSettings['site_favicon']) }}">
    @endif

    <title>Admin Panel - WP Marketplace</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF2121',
                        secondary: '#F51B1B',
                        dark: '#0d0d0d',
                        indigo: { // Mapping indigo to BRAND BLUE to safe-fix existing classes
                            400: '#FF2121',
                            500: '#FF2121',
                            600: '#F51B1B',
                        },
                        purple: { // Mapping purple to DARK BLUE to neutralized purple classes
                           400: '#F51B1B',
                           500: '#F51B1B',
                           600: '#0d0d0d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('{{ 'https://fonts.googleapis.com/css2?family=' . str_replace(' ', '+', $globalSettings['site_font'] ?? 'Inter') . ':wght@300;400;500;600;700&display=swap' }}');
        body { font-family: '{{ $globalSettings['site_font'] ?? 'Inter' }}', sans-serif; }
        .sidebar-gradient { background: linear-gradient(180deg, #0d0d0d 0%, #1e1b4b 100%); }
        .active-link { background: rgba(255, 33, 33, 0.15); border-left: 4px solid #FF2121; position: relative; overflow: hidden; }
        .active-link::after { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(255, 33, 33, 0.1) 0%, transparent 100%); }
        .glass-nav { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        
        @keyframes text-shine-sweep {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .text-shimmer-red-yellow {
            background: linear-gradient(90deg, #FF2121 0%, #f59e0b 50%, #FF2121 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: text-shine-sweep 3s linear infinite;
        }
    </style>
</head>
<body class="bg-[#0d0d0d] text-gray-200">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
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
        <aside :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-0 -translate-x-full lg:w-20 lg:translate-x-0'" class="fixed lg:relative inset-y-0 left-0 bg-[#0c0c0c] border-r border-white/5 text-white transition-all duration-300 flex-shrink-0 flex flex-col z-50 overflow-hidden h-full shadow-2xl lg:shadow-none">
            <!-- Background Glow -->
            <div class="absolute top-0 left-0 w-full h-full bg-[#FF2121]/5 blur-3xl pointer-events-none"></div>
            
            <div class="p-6 flex items-center justify-between relative z-10">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 group" x-show="sidebarOpen">
                    @if(($globalSettings['site_identity_type'] ?? 'logo') === 'logo' && isset($globalSettings['site_logo']))
                        <img src="{{ \Illuminate\Support\Str::startsWith($globalSettings['site_logo'], 'ui/') ? asset($globalSettings['site_logo']) : asset('storage/' . $globalSettings['site_logo']) }}" class="h-8 w-auto object-contain">
                    @else
                        <div class="bg-gradient-to-br from-[#FF2121] to-[#F51B1B] p-2 rounded-xl shadow-lg shadow-[#FF2121]/20 group-hover:scale-110 transition-transform">
                            <i class="{{ $globalSettings['site_icon'] ?? 'fas fa-rocket' }} text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-black tracking-tight text-white group-hover:text-[#FF2121] transition-colors">
                            {!! preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-shimmer-red-yellow">$1</span>', e($globalSettings['site_name'] ?? 'MKTP')) !!}
                        </span>
                    @endif
                </a>
                <!-- Desktop Mini Logo -->
                <a href="{{ route('home') }}" target="_blank" x-show="!sidebarOpen && window.innerWidth >= 1024" class="mx-auto group hidden lg:block">
                    @if(($globalSettings['site_identity_type'] ?? 'logo') === 'logo' && isset($globalSettings['site_logo']))
                        <img src="{{ \Illuminate\Support\Str::startsWith($globalSettings['site_logo'], 'ui/') ? asset($globalSettings['site_logo']) : asset('storage/' . $globalSettings['site_logo']) }}" class="h-8 w-8 object-contain">
                    @else
                        <div class="bg-gradient-to-br from-[#FF2121] to-[#F51B1B] p-2 rounded-xl shadow-lg shadow-[#FF2121]/20 group-hover:scale-110 transition-transform">
                            <i class="{{ $globalSettings['site_icon'] ?? 'fas fa-rocket' }} text-white"></i>
                        </div>
                    @endif
                </a>

                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white" x-show="sidebarOpen">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <nav class="flex-1 mt-4 px-4 space-y-5 relative z-10 overflow-y-auto custom-scrollbar">
                <!-- Principal -->
                <div x-show="sidebarOpen" class="px-4">
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">Principal</span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.dashboard') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-chart-line w-6 {{ request()->routeIs('admin.dashboard') ? 'text-[#FF2121]' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                    </a>
                </div>

                <!-- Catálogo -->
                <div x-show="sidebarOpen" class="px-4 pt-2">
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">Catálogo</span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.products.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-box w-6 {{ request()->routeIs('admin.products.*') ? '' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Productos</span>
                    </a>
                    <a href="{{ route('admin.update-requests.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.update-requests.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-sync-alt w-6 {{ request()->routeIs('admin.update-requests.*') ? 'text-amber-400' : 'group-hover:text-amber-400' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium flex items-center justify-between w-full">
                            Update
                            @php $pendingUpdatesCount = \App\Models\UpdateRequest::where('status', 'pending')->count(); @endphp
                            @if($pendingUpdatesCount > 0)
                                <span class="bg-amber-500 text-black text-[9px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-amber-500/20 animate-pulse">{{ $pendingUpdatesCount }}</span>
                            @endif
                        </span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.categories.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-tags w-6 {{ request()->routeIs('admin.categories.*') ? 'text-[#FF2121]' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Categorías</span>
                    </a>
                    <a href="{{ route('admin.brands.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.brands.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-certificate w-6 {{ request()->routeIs('admin.brands.*') ? 'text-[#FF2121]' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Marcas</span>
                    </a>
                </div>

                <!-- Ventas -->
                <div x-show="sidebarOpen" class="px-4 pt-2">
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">Ventas</span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.membership-plans.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.membership-plans.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-crown w-6 {{ request()->routeIs('admin.membership-plans.*') ? 'text-amber-400' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Planes</span>
                    </a>
                    <a href="{{ route('admin.memberships.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.memberships.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-id-card w-6 {{ request()->routeIs('admin.memberships.*') ? 'text-[#F51B1B]' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Suscripciones</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.orders.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-shopping-cart w-6 {{ request()->routeIs('admin.orders.*') ? 'text-emerald-400' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Órdenes</span>
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.coupons.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-ticket-alt w-6 {{ request()->routeIs('admin.coupons.*') ? 'text-pink-400' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Cupones</span>
                    </a>
                    <a href="{{ route('admin.newsletter.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.newsletter.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-paper-plane w-6 {{ request()->routeIs('admin.newsletter.*') ? 'text-[#FF2121]' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Newsletter</span>
                    </a>
                </div>

                <!-- Usuarios -->
                <div x-show="sidebarOpen" class="px-4 pt-2">
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">Usuarios</span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.users.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-users w-6 {{ request()->routeIs('admin.users.*') ? 'text-[#FF2121]' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Usuarios</span>
                    </a>
                    <a href="{{ route('admin.sites.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.sites.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-globe w-6 {{ request()->routeIs('admin.sites.*') ? 'text-emerald-400' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Sitios</span>
                    </a>
                </div>

                <!-- Soporte -->
                <div x-show="sidebarOpen" class="px-4 pt-2">
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">Soporte</span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('admin.tickets.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.tickets.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-headset w-6 {{ request()->routeIs('admin.tickets.*') ? 'text-[#FF2121]' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium flex items-center justify-between w-full">
                            Tickets
                            @php $openTickets = \App\Models\Ticket::where('status', 'open')->count(); @endphp
                            @if($openTickets > 0)
                                <span class="bg-amber-500 text-[10px] font-black px-1.5 py-0.5 rounded text-white shadow-lg shadow-amber-500/20">{{ $openTickets }}</span>
                            @endif
                        </span>
                    </a>
                </div>

                <!-- Sistema -->
                <div x-show="sidebarOpen" class="px-4 pt-2">
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em]">Sistema</span>
                </div>
                <div class="space-y-1 pb-4">
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 group {{ request()->routeIs('admin.settings.*') ? 'active-link' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-cog w-6 {{ request()->routeIs('admin.settings.*') ? 'text-gray-200' : 'group-hover:text-[#FF2121]' }}"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">Configuraciones</span>
                    </a>
                </div>
            </nav>
            
            <div class="p-6 mt-auto">
                <a href="{{ route('home') }}" class="flex items-center text-gray-400 hover:text-white transition-all duration-200 px-4 py-2 hover:bg-white/5 rounded-lg border border-transparent hover:border-white/10">
                    <i class="fas fa-external-link-alt w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3 text-sm">Ver Sitio Público</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 -z-10 w-[500px] h-[500px] bg-[#F51B1B]/10 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-0 left-0 -z-10 w-[400px] h-[400px] bg-[#F51B1B]/10 blur-[100px] rounded-full"></div>

            <!-- Header -->
            <header class="bg-[#0d0d0d]/80 backdrop-blur-md border-b border-white/5 h-16 flex items-center justify-between px-4 md:px-8 z-20">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white transition-all bg-gray-800/50 p-2 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-align-left text-lg"></i>
                </button>
                
                <div class="flex items-center space-x-4">
                    <!-- Notifications Dropdown -->
                    @php
                        $adminUnreadNotifications = \App\Models\Notification::where('user_id', Auth::id())
                            ->where('is_read', false)
                            ->latest()
                            ->take(5)
                            ->get();
                        $unreadNotifCount = \App\Models\Notification::where('user_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" class="relative p-2 text-gray-400 hover:text-white bg-gray-800/50 hover:bg-gray-800 rounded-xl transition-all">
                            <i class="fas fa-bell text-base"></i>
                            @if($unreadNotifCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-[#FF2121] text-white text-[10px] font-black rounded-full flex items-center justify-center animate-bounce shadow-lg shadow-[#FF2121]/30">
                                    {{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}
                                </span>
                            @endif
                        </button>
                        
                        <div x-show="notifOpen" @click.away="notifOpen = false" x-transition class="absolute right-0 mt-3 w-80 sm:w-96 bg-[#111111] border border-white/10 rounded-2xl shadow-2xl p-4 z-50">
                            <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/10">
                                <h4 class="text-xs font-black uppercase tracking-wider text-white">Notificaciones Admin</h4>
                                @if($unreadNotifCount > 0)
                                    <button @click="
                                        fetch('{{ route('notifications.read-all') }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            }
                                        }).then(() => window.location.reload());
                                    " class="text-[10px] text-amber-400 hover:text-amber-300 font-bold flex items-center gap-1 cursor-pointer">
                                        <i class="fas fa-check-double text-[9px]"></i> Marcar todas leídas
                                    </button>
                                @else
                                    <span class="text-[10px] text-gray-500 font-bold">0 nuevas</span>
                                @endif
                            </div>
                            <div class="space-y-2 max-h-72 overflow-y-auto custom-scrollbar">
                                @forelse($adminUnreadNotifications as $notif)
                                    <div class="flex items-center justify-between gap-2 p-2.5 rounded-xl bg-white/5 hover:bg-white/10 transition-all border border-white/5 group/notif">
                                        <a href="{{ $notif->link ?? route('admin.update-requests.index') }}" 
                                           @click.prevent="
                                               fetch('/notifications/{{ $notif->id }}/read', {
                                                   method: 'POST',
                                                   headers: {
                                                       'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                       'Content-Type': 'application/json'
                                                   }
                                               }).then(() => {
                                                   window.location.href = '{{ $notif->link ?? route('admin.update-requests.index') }}';
                                               });
                                           "
                                           class="flex items-start gap-3 min-w-0 flex-1">
                                            <div class="w-8 h-8 rounded-lg bg-[#FF2121]/20 border border-[#FF2121]/30 flex items-center justify-center text-[#FF2121] text-xs shrink-0">
                                                <i class="fas {{ $notif->icon ?? 'fa-bell' }}"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-xs font-bold text-white truncate group-hover/notif:text-[#FF2121] transition-colors">{{ $notif->title }}</p>
                                                <p class="text-[11px] text-gray-400 leading-snug line-clamp-2 mt-0.5">{{ $notif->message }}</p>
                                                <span class="text-[9px] text-gray-500 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                        <button type="button" 
                                                @click.stop="
                                                    fetch('/notifications/{{ $notif->id }}/read', {
                                                        method: 'POST',
                                                        headers: {
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            'Content-Type': 'application/json'
                                                        }
                                                    }).then(() => window.location.reload());
                                                " 
                                                class="w-7 h-7 rounded-lg bg-white/5 hover:bg-emerald-500/20 hover:text-emerald-400 border border-white/10 text-gray-500 transition-all flex items-center justify-center shrink-0 cursor-pointer" 
                                                title="Marcar como leída">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-500 text-center py-6">Sin notificaciones pendientes</p>
                                @endforelse
                            </div>
                            <div class="pt-3 mt-3 border-t border-white/10 text-center">
                                <a href="{{ route('admin.update-requests.index') }}" class="text-[11px] font-bold text-[#FF2121] hover:underline">Ver Solicitudes de Update →</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 bg-gray-800/40 px-4 py-1.5 rounded-full border border-white/5 shadow-sm">
                        <div class="text-right hidden md:block">
                            <p class="text-xs font-bold text-white uppercase tracking-wider">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-[#FF2121] font-medium tracking-widest uppercase">{{ Auth::user()->role }}</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff&bold=true" class="w-8 h-8 rounded-full ring-2 ring-[#FF2121]/20">
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 custom-scrollbar">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                         x-transition:enter="transform ease-out duration-300 transition"
                         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed top-24 right-6 z-50 max-w-sm w-full bg-[#0d0d0d] border border-emerald-500/20 shadow-2xl rounded-2xl p-4 flex items-center gap-4 backdrop-blur-xl">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-white">¡Éxito!</p>
                            <p class="text-xs text-emerald-400 mt-0.5">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" 
                         x-transition:enter="transform ease-out duration-300 transition"
                         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed top-24 right-6 z-50 max-w-sm w-full bg-[#0d0d0d] border border-rose-500/20 shadow-2xl rounded-2xl p-4 flex items-center gap-4 backdrop-blur-xl">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-rose-500/10 flex items-center justify-center text-rose-400">
                            <i class="fas fa-exclamation-triangle text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-white">Error</p>
                            <p class="text-xs text-rose-400 mt-0.5">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.1); }
        .slide-in { animation: slideIn 0.3s ease-out forwards; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</body>
</html>