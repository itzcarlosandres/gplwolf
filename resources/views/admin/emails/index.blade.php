<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vistas Previas de Correos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selecciona un correo para visualizar:</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($previews as $key => $name)
                        <a href="{{ route('admin.emails.preview.show', $key) }}" target="_blank" 
                           class="block p-6 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-[#FF2121]/30 transition-all duration-200 group">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 group-hover:text-[#F51B1B]">
                                {{ $name }}
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">
                                Click para abrir vista previa en nueva pestaña.
                            </p>
                        </a>
                        @endforeach
                    </div>

                    <div class="mt-8 p-4 bg-[#FF2121]/5 border-l-4 border-[#FF2121] text-[#F51B1B]">
                        <p class="font-bold">Nota:</p>
                        <p>Estas son vistas previas con datos de demostración. No se envían correos reales al hacer click aquí.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>