<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="font-sans antialiased">
        <!-- Toast Notifications Container -->
        <div id="notification-container" class="fixed top-8 right-8 z-[9999] space-y-4 max-w-md pointer-events-none"></div>

        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @auth
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
            let shownNotifications = new Set();

            function showToast(notification) {
                if (shownNotifications.has(notification.id)) return;
                shownNotifications.add(notification.id);

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
                    <div class="bg-white p-6 rounded-xl shadow-2xl border-l-4 border-[#F51B1B] ring-1 ring-black/5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-[#FF2121]/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas ${notification.icon} text-[#F51B1B]"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-gray-900">${notification.title}</h4>
                                    <button onclick="this.closest('.transform').remove()" class="text-gray-400 hover:text-gray-600 transition ml-2">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-600 mb-3">${notification.message}</p>
                                <div class="flex gap-2">
                                    ${notification.link ? `
                                        <a href="${notification.link}" class="px-3 py-1.5 bg-[#F51B1B] hover:bg-[#F51B1B] text-white text-xs font-bold rounded-lg transition-all">
                                            Ver Ahora
                                        </a>
                                    ` : ''}
                                    <button onclick="markAsRead(${notification.id}, this)" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-lg transition-all">
                                        Marcar leída
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
                            const newNotifications = data.notifications.filter(n => n.id > lastNotificationId);
                            
                            if (newNotifications.length > 0) {
                                playNotificationSound();
                                newNotifications.forEach((notification, index) => {
                                    setTimeout(() => {
                                        showToast(notification);
                                    }, index * 300);
                                });
                                lastNotificationId = Math.max(...data.notifications.map(n => n.id));
                            }
                        }
                    })
                    .catch(e => console.error('Error checking notifications', e));
            }

            document.addEventListener('DOMContentLoaded', () => {
                 checkForNewNotifications();
                 setInterval(checkForNewNotifications, 30000);
            });
        </script>
        @endauth
    </body>
</html>