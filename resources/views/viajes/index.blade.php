
<div class=" mx-auto mt-5 mb-5 px-4 min-w-full">
    <h1 class="text-3xl font-bold mb-6 text-center">Lista de Viajes</h1>
    <div class="bg-white shadow-md rounded-lg min-w-full grid p-5">
        @if($viajes->isEmpty())
            <div class="p-5 text-center">
                <p class="text-xl text-gray-700">No hay viajes disponibles.</p>
            </div>
        @else
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Destino
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Alimentos
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Inscrito
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($viajes as $viaje)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $viaje->destino }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $viaje->fecha }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <ul class="list-disc pl-5">
                                    @foreach ($viaje->alimentos as $alimento)
                                        <li>{{ $alimento['tipo'] }}: {{ $alimento['cantidad'] }} ({{ $alimento['descripcion'] }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if (collect($viaje->viajeros)->contains('nombre', $nombreUsuario))
                                    <li>Inscrito</li>
                                @else
                                    <li>No inscrito</li>
                                @endif
                            </td>
                            <!-- Aquí puedes agregar botones para editar y eliminar un viaje -->
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm gap-y-2">
                                @if (collect($viaje->viajeros)->contains('nombre', $nombreUsuario))
                                    <button hx-get="/api/viaje/desinscribirse/{{ $viaje->id }}/{{ $nombreUsuario }}"
                                        hx-trigger="click"
                                        hx-target="#body"
                                        hx-swap="innerHTML"
                                        class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 mt-2 rounded focus:outline-none focus:shadow-outline"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>
                                    </button>
                                @else
                                    <button hx-get="/api/viaje/inscribirse/{{ $viaje->id }}"
                                        hx-trigger="click"
                                        hx-target="#body"
                                        hx-swap="innerHTML"
                                        class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>