@extends('layouts.user')

@section('title', 'Mis Descargas')

@section('content')
<div class="space-y-10 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-white leading-tight">Mis Descargas</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Accede a todos tus recursos adquiridos.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
            @php $hasUpdate = in_array($product->id, $updatedProductIds); @endphp
            <div class="glass p-8 rounded-[40px] group hover:bg-white/5 transition-all flex flex-col h-full relative overflow-hidden {{ $hasUpdate ? 'border-[#FF2121]/50 shadow-lg shadow-[#FF2121]/20' : 'border-white/5' }}">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#F51B1B]/5 blur-3xl rounded-full -mr-16 -mt-16 group-hover:bg-[#F51B1B]/10 transition-colors"></div>
                
                @if($hasUpdate)
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#FF2121] to-[#F51B1B]"></div>
                <div class="absolute top-4 right-4 animate-bounce">
                    <span class="px-3 py-1 bg-[#F51B1B] text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-[#F51B1B]/40 border border-[#FF2121]">
                        <i class="fas fa-bell mr-1"></i> Actualizado
                    </span>
                </div>
                @endif
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gray-900 rounded-3xl flex items-center justify-center text-3xl shadow-inner border border-white/5 mb-6 overflow-hidden relative">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-box text-gray-700"></i>
                        @endif
                        
                        @if($hasUpdate)
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-gray-900 animate-pulse"></div>
                        @endif
                    </div>
                    
                    <h3 class="text-xl font-black text-white mb-2 group-hover:text-[#FF2121] transition-colors uppercase truncate">
                        {{ $product->name }}
                    </h3>
                    
                    <div class="flex items-center gap-3 mb-8">
                        <span class="px-2 py-0.5 rounded-md bg-white/5 text-[9px] font-black {{ $hasUpdate ? 'text-green-400 border-green-500/30 bg-green-500/10' : 'text-gray-500 border-white/10' }} border uppercase tracking-widest">
                            v{{ $product->version }}
                        </span>
                        @if($hasUpdate)
                            <span class="text-[10px] text-[#FF2121] font-bold animate-pulse">
                                ¡Nueva versión disponible!
                            </span>
                        @endif
                    </div>

                    <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                        <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                            {{ $hasUpdate ? 'Descargar Actualización' : 'Última versión' }}
                        </div>
                        <a href="{{ route('product.download', $product) }}" class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center text-white shadow-xl shadow-[#F51B1B]/20 hover:scale-110 active:scale-95 transition-all relative">
                            <i class="fas fa-download {{ $hasUpdate ? 'animate-bounce' : '' }}"></i>
                            @if($hasUpdate)
                                <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 rounded-full text-white text-[10px] flex items-center justify-center border-2 border-[#030712] font-bold">1</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center">
                <div class="opacity-20 flex flex-col items-center">
                    <i class="fas fa-cloud-download-alt text-7xl mb-6"></i>
                    <p class="text-2xl font-black uppercase tracking-widest">Aún no has descargado nada</p>
                    <a href="{{ route('products.index') }}" class="mt-8 text-[#FF2121] hover:text-white transition font-black uppercase text-xs tracking-widest">Explorar Productos <i class="fas fa-arrow-right ml-2 text-[8px]"></i></a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $products->links() }}
    </div>
</div>
@endsection