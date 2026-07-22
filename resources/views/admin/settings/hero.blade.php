<form action="{{ route('admin.settings.hero.update') }}" method="POST">
    @csrf
    
    <div class="glass p-8 rounded-3xl border-white/5 relative overflow-hidden">
        <!-- Background Icon -->
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <i class="fas fa-magic text-9xl text-white"></i>
        </div>

        <!-- Header -->
        <h2 class="text-2xl font-black text-white mb-8 flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-[#FF2121]/20 flex items-center justify-center text-[#FF2121]">
                <i class="fas fa-heading"></i>
            </span>
            Hero Section
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Column: Settings -->
            <div class="space-y-6">
                 <!-- Hero Style -->
                 <div>
                     <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Estilo del Hero</label>
                    <select name="hero_style" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-bold appearance-none">
                        <option value="circles" {{ ($settings['hero_style'] ?? 'circles') == 'circles' ? 'selected' : '' }}>Circles (Órbita de Círculos Flotantes)</option>
                        <option value="aurora" {{ ($settings['hero_style'] ?? '') == 'aurora' ? 'selected' : '' }}>Aurora (Glass & Fluido)</option>
                        <option value="stark" {{ ($settings['hero_style'] ?? '') == 'stark' ? 'selected' : '' }}>Stark (Minimalista & Corporativo)</option>
                        <option value="cyber" {{ ($settings['hero_style'] ?? '') == 'cyber' ? 'selected' : '' }}>Cyber (Bento Grid & Moderno)</option>
                        <option value="split" {{ ($settings['hero_style'] ?? '') == 'split' ? 'selected' : '' }}>Split (2 Columnas + Code Block)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Título Principal</label>
                    <textarea name="hero_title" rows="3" required 
                        class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-bold text-lg leading-tight placeholder-gray-600">{{ $settings['hero_title'] ?? "Themes & Plugins\n[G]Premium WP[/G]" }}</textarea>
                    <p class="text-[10px] text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Usa <code class="bg-gray-700 px-1 rounded text-white">[G]texto[/G]</code> para degradado.
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Descripción</label>
                    <textarea name="hero_description" rows="3" required 
                        class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all text-sm leading-relaxed placeholder-gray-600">{{ $settings['hero_description'] ?? 'Impulsa tus proyectos con los mejores recursos digitales.' }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tamaño del Título</label>
                    <select name="hero_title_size" class="w-full bg-gray-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-[#FF2121]/50 transition-all font-bold appearance-none">
                        <option value="text-xl" {{ ($settings['hero_title_size'] ?? '') == 'text-xl' ? 'selected' : '' }}>XL (Muy Pequeño)</option>
                        <option value="text-2xl" {{ ($settings['hero_title_size'] ?? '') == 'text-2xl' ? 'selected' : '' }}>2XL (Pequeño)</option>
                        <option value="text-3xl" {{ ($settings['hero_title_size'] ?? '') == 'text-3xl' ? 'selected' : '' }}>3XL (Normal)</option>
                        <option value="text-4xl" {{ ($settings['hero_title_size'] ?? '') == 'text-4xl' ? 'selected' : '' }}>4XL (Mediano)</option>
                        <option value="text-5xl" {{ ($settings['hero_title_size'] ?? '') == 'text-5xl' ? 'selected' : '' }}>5XL (Grande)</option>
                        <option value="text-6xl" {{ ($settings['hero_title_size'] ?? '') == 'text-6xl' ? 'selected' : '' }}>Grande (6XL)</option>
                        <option value="text-7xl" {{ ($settings['hero_title_size'] ?? 'text-8xl') == 'text-7xl' ? 'selected' : '' }}>Extra Grande (7XL)</option>
                        <option value="text-8xl" {{ ($settings['hero_title_size'] ?? 'text-8xl') == 'text-8xl' ? 'selected' : '' }}>Gigante (8XL)</option>
                    </select>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#FF2121] to-[#F51B1B] hover:from-[#FF2121] hover:to-[#F51B1B] text-white font-black rounded-2xl shadow-lg shadow-[#F51B1B]/20 transform hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>

            <!-- Right Column: Preview -->
            <div class="bg-[#0c0c0c] border border-white/5 rounded-2xl p-8 relative overflow-hidden flex flex-col items-center justify-center min-h-[400px]">
                <div class="absolute inset-0 bg-[#F51B1B]/5 blur-[80px] rounded-full"></div>
                
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-6 relative z-10">Vista Previa Estilizada</h4>
                
                <div class="relative z-10 text-center max-w-sm">
                     @php
                        $previewTitle = $settings['hero_title'] ?? "Themes & Plugins\n[G]Premium WP[/G]";
                        $previewTitle = preg_replace('/\[G\](.*?)\[\/G\]/i', '<span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF2121] to-[#F51B1B]">$1</span>', e($previewTitle));
                        $previewTitle = nl2br($previewTitle);
                    @endphp
                    <h1 class="font-black text-white tracking-tight mb-4 leading-[1.1] text-4xl lg:text-5xl">
                        {!! $previewTitle !!}
                    </h1>
                    <p class="text-gray-400 text-sm font-medium leading-relaxed">
                        {{ $settings['hero_description'] ?? 'Impulsa tus proyectos con los mejores recursos digitales.' }}
                    </p>
                </div>

                <p class="text-[10px] text-gray-600 mt-8 relative z-10">
                    * La vista real puede variar según la resolución.
                </p>
            </div>
        </div>
    </div>
</form>