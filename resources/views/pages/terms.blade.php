@extends('layouts.frontend')

@section('title', 'Términos y Condiciones')

@section('content')
<div class="pt-32 pb-20">
    <div class="max-w-4xl mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-black text-white mb-8 tracking-tighter">Términos y <span class="text-[#FF2121]">Condiciones</span></h1>
        
        <div class="glass p-8 md:p-12 rounded-[40px] border border-white/5 space-y-10 text-gray-400 leading-relaxed">
            
            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#F51B1B]/20 flex items-center justify-center text-[#FF2121]"><i class="fas fa-gavel"></i></div>
                    1. Aceptación de los Términos
                </h2>
                <p>
                    Al acceder y utilizar este sitio web, usted acepta estar sujeto a estos términos y condiciones. Si no está de acuerdo con alguno de estos términos, tiene prohibido usar o acceder a este sitio. Los materiales contenidos en este sitio web están protegidos por las leyes de derechos de autor y marcas comerciales aplicables.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#F51B1B]/20 flex items-center justify-center text-[#FF2121]"><i class="fas fa-license"></i></div>
                    2. Licencias de Uso
                </h2>
                <p class="mb-4">
                    Todos los productos digitales disponibles en nuestra plataforma se distribuyen bajo los términos de la Licencia Pública General (GPL). Esto significa que:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-500 marker:text-[#FF2121]">
                    <li>Puede utilizar los productos en tantos sitios web como desee.</li>
                    <li>Puede modificar los productos para adaptarlos a sus necesidades.</li>
                    <li>No proporcionamos claves de licencia (license keys) para actualizaciones automáticas desde los servidores originales del autor, a menos que se especifique claramente lo contrario.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#F51B1B]/20 flex items-center justify-center text-[#FF2121]"><i class="fas fa-headset"></i></div>
                    3. Soporte y Actualizaciones
                </h2>
                <p>
                    Proporcionamos soporte técnico limitado únicamente relacionado con la instalación y el acceso a los archivos descargables. No ofrecemos soporte técnico para la funcionalidad interna, errores de programación del desarrollador original, o compatibilidad con plugins de terceros.
                </p>
            </section>
            
            <div class="p-6 bg-[#F51B1B]/10 rounded-2xl border border-[#F51B1B]/20">
                <p class="text-sm font-bold text-[#FF2121] text-center">
                    Última actualización: {{ date('d/m/Y') }}
                </p>
            </div>

        </div>
    </div>
</div>
@endsection