@extends('layouts.frontend')

@section('title', 'Demo en Vivo — 5 Diseños de Hero')

@section('content')
    <!-- Demo Sticky Switcher Bar -->
    <div class="sticky top-20 z-50 bg-[#0a0a0a]/90 backdrop-blur-xl border-b border-[#FF2121]/30 py-4 px-6 shadow-2xl shadow-black/80">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-[#FF2121] flex items-center justify-center text-white text-sm font-black shadow-md shadow-[#FF2121]/40 animate-pulse">
                    <i class="fas fa-palette"></i>
                </div>
                <div>
                    <h2 class="text-sm font-black text-white uppercase tracking-wider">Demo en Vivo de Heroes</h2>
                    <p class="text-[10px] text-gray-400 font-medium">Selecciona una variante para previsualizar el diseño en tiempo real.</p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-wrap justify-center">
                <a href="{{ route('hero.demos', ['hero' => 'circles']) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-black transition-all duration-300 flex items-center gap-1.5 {{ $activeHero === 'circles' ? 'bg-[#FF2121] text-white shadow-lg shadow-[#FF2121]/40 scale-105 border border-red-400/40' : 'bg-white/5 text-gray-300 hover:bg-white/10 hover:text-white border border-white/10' }}">
                    <i class="fas fa-[#circle] fa-dot-circle text-[10px]"></i>
                    <span>1. Marcas en Círculos</span>
                </a>

                <a href="{{ route('hero.demos', ['hero' => 'aurora']) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-black transition-all duration-300 flex items-center gap-1.5 {{ $activeHero === 'aurora' ? 'bg-[#FF2121] text-white shadow-lg shadow-[#FF2121]/40 scale-105 border border-red-400/40' : 'bg-white/5 text-gray-300 hover:bg-white/10 hover:text-white border border-white/10' }}">
                    <i class="fas fa-gem text-[10px]"></i>
                    <span>2. Aurora Red</span>
                </a>

                <a href="{{ route('hero.demos', ['hero' => 'cyber']) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-black transition-all duration-300 flex items-center gap-1.5 {{ $activeHero === 'cyber' ? 'bg-[#FF2121] text-white shadow-lg shadow-[#FF2121]/40 scale-105 border border-red-400/40' : 'bg-white/5 text-gray-300 hover:bg-white/10 hover:text-white border border-white/10' }}">
                    <i class="fas fa-terminal text-[10px]"></i>
                    <span>3. Cyber Tech</span>
                </a>

                <a href="{{ route('hero.demos', ['hero' => 'stark']) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-black transition-all duration-300 flex items-center gap-1.5 {{ $activeHero === 'stark' ? 'bg-[#FF2121] text-white shadow-lg shadow-[#FF2121]/40 scale-105 border border-red-400/40' : 'bg-white/5 text-gray-300 hover:bg-white/10 hover:text-white border border-white/10' }}">
                    <i class="fas fa-[#minus] fa-font text-[10px]"></i>
                    <span>4. Minimalist Stark</span>
                </a>

                <a href="{{ route('hero.demos', ['hero' => 'split']) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-black transition-all duration-300 flex items-center gap-1.5 {{ $activeHero === 'split' ? 'bg-[#FF2121] text-white shadow-lg shadow-[#FF2121]/40 scale-105 border border-red-400/40' : 'bg-white/5 text-gray-300 hover:bg-white/10 hover:text-white border border-white/10' }}">
                    <i class="fas fa-[#columns] fa-code text-[10px]"></i>
                    <span>5. Split Code</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Active Hero Rendering -->
    <main class="min-h-screen">
        @if($activeHero === 'circles')
            @includeIf('partials.heroes.circles')
        @elseif($activeHero === 'aurora')
            @includeIf('partials.heroes.aurora')
        @elseif($activeHero === 'cyber')
            @includeIf('partials.heroes.cyber')
        @elseif($activeHero === 'stark')
            @includeIf('partials.heroes.stark')
        @elseif($activeHero === 'split')
            @includeIf('partials.heroes.split')
        @else
            @includeIf('partials.heroes.circles')
        @endif
    </main>
@endsection