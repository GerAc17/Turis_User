<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Usuario - Turis Chablekal') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-row gap-4">
                    <form>
                        <input type="hidden" name="nombreUsuario" value="@auth{{ Auth::user()->name }}@endauth">
                        
                        <button hx-post="/api/viajes/get-view"
                            hx-trigger="click"
                            hx-target="#body"
                            hx-swap="innerHTML"
                            class=" hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded basis-1/4"
                        >
                            Ver Viajes 
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="body" class="max-w-7xl mx-auto sm:px-6 lg:px-8"></div>
</x-app-layout>
