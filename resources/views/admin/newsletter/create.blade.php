@extends('layouts.admin')

@section('title', 'Redactar Boletín')

@section('content')
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.newsletter.index') }}" class="w-10 h-10 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl flex items-center justify-center text-white transition-all">
        <i class="fas fa-arrow-left text-xs"></i>
    </a>
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Redactar Boletín</h1>
        <p class="text-gray-500 text-sm mt-1">Crea y diseña una nueva campaña u oferta con bloques y editor enriquecido.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ searchQuery: '' }">
    <!-- Main Editor -->
    <div class="lg:col-span-2">
        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6">
            <form action="{{ route('admin.newsletter.send-mail') }}" method="POST" id="newsletter-compose-form" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Asunto del Correo</label>
                    <input type="text" name="subject" required placeholder="Ej: ¡Exclusivo! 3 Nuevos Plugins añadidos hoy a GPLWolf" class="w-full bg-[#08080a] border border-white/[0.08] rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-[#FF2121]/50 focus:ring-2 focus:ring-[#FF2121]/10 transition-all font-bold placeholder-gray-700 text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1 font-sans">Contenido del Correo</label>
                    <!-- Textarea for CKEditor -->
                    <textarea name="content" id="editor" required></textarea>
                </div>

                <button type="submit" class="w-full bg-[#F51B1B] hover:bg-[#FF2121] text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-lg shadow-[#F51B1B]/20">
                    Enviar Boletín a {{ $subscribersCount }} Suscriptores
                </button>
            </form>
        </div>
    </div>

    <!-- Product Widget Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-black uppercase text-white tracking-wider">Insertar Productos</h3>
                <span class="text-[10px] font-black text-amber-500 bg-amber-500/10 px-2 py-0.5 rounded">Widget</span>
            </div>
            
            <!-- Search bar -->
            <div class="relative mb-4">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" x-model="searchQuery" placeholder="Buscar productos..." class="w-full bg-[#08080a] border border-white/[0.08] rounded-xl pl-9 pr-4 py-2.5 text-xs text-white focus:outline-none focus:border-[#FF2121]/50 transition-all font-bold placeholder-gray-700">
            </div>

            <!-- Products List -->
            <div class="space-y-3 max-h-[420px] overflow-y-auto pr-1">
                @foreach($products as $product)
                <div x-show="searchQuery === '' || '{{ strtolower($product->name) }}'.includes(searchQuery.toLowerCase())"
                     class="bg-[#08080a] border border-white/[0.04] p-3 rounded-xl flex items-center justify-between gap-3 group hover:border-white/10 transition-all">
                    <div class="min-w-0">
                        <span class="text-[8px] font-black text-[#FF2121] uppercase tracking-wider block">{{ $product->type }}</span>
                        <h4 class="text-white text-xs font-bold truncate mt-0.5">{{ $product->name }}</h4>
                        <span class="text-[10px] text-gray-500 font-mono">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <button type="button" 
                            onclick="insertProductWidget('{{ addslashes($product->name) }}', '{{ $product->type }}', '{{ $product->version }}', '{{ number_format($product->price, 2) }}', '{{ route('products.show', $product->slug) }}', '{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://placehold.co/100x100?text=GPLWolf' }}')"
                            class="px-2.5 py-1.5 bg-white/5 hover:bg-[#FF2121] hover:text-white text-gray-400 rounded-lg text-[10px] font-black uppercase transition-all shrink-0">
                        + Añadir
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-[#111111] border border-white/[0.06] rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white mb-3">Consejo de Diseño</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Escribe tu mensaje en el editor y haz clic en **+ Añadir** en cualquier producto de la derecha. El producto se insertará como una tarjeta HTML enriquecida que se adaptará de forma responsiva a todos los clientes de correo electrónico.
            </p>
        </div>
    </div>
</div>

<script>
    // Initialize CKEditor
    CKEDITOR.replace('editor', {
        height: 400,
        allowedContent: true, // Allow all HTML tags, classes, and styles
        removePlugins: 'elementspath',
        resize_enabled: false,
    });

    // Populate initial text
    CKEDITOR.on('instanceReady', function(evt) {
        evt.editor.setData('<p>Hola suscriptor,</p><p>Tenemos excelentes ofertas y novedades para ti en GPLWolf hoy:</p><p><br></p>');
    });

    // Insert Product Widget into CKEditor at cursor
    function insertProductWidget(name, type, version, price, url, image) {
        // Email-safe Inline Styled Table for the Product Card
        var widgetHtml = `
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #0c0c0e; border: 1px solid #1f1f23; border-radius: 16px; margin: 15px auto; overflow: hidden; max-width: 480px; font-family: sans-serif; text-align: left;">
                <tr>
                    <td style="padding: 16px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="60" valign="top" style="vertical-align: top;">
                                    <img src="${image}" width="50" height="50" style="border-radius: 8px; display: block; border: 1px solid #1f1f23; object-fit: cover;">
                                </td>
                                <td style="padding-left: 12px; vertical-align: top;" valign="top">
                                    <span style="font-size: 8px; font-weight: bold; color: #ef4444; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">${type}</span>
                                    <h4 style="font-size: 13px; font-weight: bold; color: #ffffff; margin: 0 0 2px 0; line-height: 1.2;">${name}</h4>
                                    <p style="font-size: 10px; color: #71717a; margin: 0;">Versión ${version}</p>
                                </td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 12px; border-top: 1px solid #1f1f23; padding-top: 12px;">
                            <tr>
                                <td style="vertical-align: middle;">
                                    <span style="font-size: 14px; font-weight: 800; color: #ffffff;">$${price}</span>
                                </td>
                                <td align="right" style="vertical-align: middle;">
                                    <a href="${url}" target="_blank" style="background-color: #ef4444; color: #ffffff; padding: 6px 12px; border-radius: 6px; font-size: 10px; font-weight: bold; text-decoration: none; display: inline-block;">Ver Recurso</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <p><br></p>
        `;

        CKEDITOR.instances['editor'].insertHtml(widgetHtml);
    }
</script>
@endsection
