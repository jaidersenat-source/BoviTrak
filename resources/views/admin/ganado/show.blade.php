<x-app-layout>
    <x-slot name="title">Detalles del Animal</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-bovi-dark">
                Perfil del Animal
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full text-white bg-bovi-green-600">
                ID: #{{ $animal->id }}
            </span>
        </div>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Breadcrumb mejorado -->
        <nav class="mb-6 flex items-center space-x-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 transition-colors flex items-center hover:text-bovi-green-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-700 font-medium">Detalles del Animal</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Columna Principal -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Card Header con información principal -->
                <div class="rounded-xl shadow-lg p-8 text-white bg-gradient-bovi-green-v">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h1 class="text-4xl font-bold">
                                    {{ $animal->nombre ?? 'Sin nombre' }}
                                </h1>
                            </div>
                            <p class="text-sm text-bovi-green-200">{{ $animal->raza }} • {{ ucfirst($animal->sexo) }}</p>
                        </div>
                            <span class="px-4 py-2 backdrop-blur-sm rounded-lg text-sm font-semibold bg-white/20">
                                {{ $animal->codigo_nfc }}
                            </span>
                    </div>
                    
                    <!-- Stats rápidas -->
                    <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-white/20">
                        @if($animal->fecha_nacimiento)
                        @php
                            $birth = \Carbon\Carbon::parse($animal->fecha_nacimiento);
                            $diff = $birth->diff(\Carbon\Carbon::now());
                            $years = $diff->y;
                            $months = $diff->m;
                        @endphp
                        <div class="text-center">
                            <p class="text-3xl font-bold">
                                @if($years > 0) {{ $years }} @else {{ $months }} @endif
                            </p>
                            <p class="text-sm mt-1 text-bovi-green-200">
                                @if($years > 0)
                                    {{ $years }} año{{ $years > 1 ? 's' : '' }}@if($months) y {{ $months }} mes{{ $months > 1 ? 'es' : '' }}@endif
                                @else
                                    {{ $months }} mes{{ $months > 1 ? 'es' : '' }}
                                @endif
                            </p>
                        </div>
                        @endif
                        @if($animal->peso_aproximado)
                        <div class="text-center">
                            <p class="text-3xl font-bold">{{ $animal->peso_aproximado }}</p>
                            <p class="text-sm mt-1 text-bovi-green-200">kg</p>
                        </div>
                        @endif
                        <div class="text-center">
                            <p class="text-3xl font-bold">{{ $animal->photos->count() + ($animal->foto_boca ? 1 : 0) + ($animal->foto_general ? 1 : 0) }}</p>
                            <p class="text-sm mt-1 text-bovi-green-200">fotos</p>
                        </div>
                    </div>
                </div>

                <!-- Información Detallada -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Información Detallada
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Código NFC -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Código NFC</label>
                                <div class="flex items-center p-4 rounded-lg border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
                                    <svg class="w-5 h-5 mr-3 text-bovi-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <span class="font-mono text-lg font-bold text-gray-800">{{ $animal->codigo_nfc }}</span>
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Nombre del Animal</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->nombre ?? 'Sin nombre' }}</p>
                                </div>
                            </div>

                            <!-- Raza -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Raza</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->raza }}</p>
                                </div>
                            </div>

                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Sexo</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white {{ $animal->sexo === 'macho' ? 'bg-bovi-green-600' : 'bg-bovi-brown-300' }}">
                                        {{ ucfirst($animal->sexo) }}
                                    </span>
                                </div>
                            </div>

                             <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Propósito</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white {{ $animal->proposito === 'carne, leche, Doble proposito' ? 'bg-bovi-green-600' : 'bg-bovi-brown-300' }}">
                                        {{ ucfirst($animal->proposito) }}
                                    </span>
                                </div>
                            </div>

                             <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Estado del Animal</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white {{ $animal->estado === 'activo' ? 'bg-bovi-green-600' : 'bg-bovi-brown-300' }}">
                                        {{ ucfirst($animal->estado) }}
                                    </span>
                                </div>
                            </div>

                            
                            <!-- Fecha de Nacimiento -->
                            @if($animal->fecha_nacimiento)
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Fecha de Nacimiento</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                        @php
                                            $birth = \Carbon\Carbon::parse($animal->fecha_nacimiento);
                                            $diff = $birth->diff(\Carbon\Carbon::now());
                                            $years = $diff->y;
                                            $months = $diff->m;
                                            $ageText = '';
                                            if ($years > 0) { $ageText .= $years.' año'.($years > 1 ? 's' : ''); }
                                            if ($months > 0) { $ageText .= ($years > 0 ? ' y ' : '') . $months.' mes'.($months > 1 ? 'es' : ''); }
                                            if ($ageText === '') { $ageText = '0 meses'; }
                                        @endphp
                                        <p class="text-lg font-semibold text-gray-800">{{ $birth->format('d/m/Y') }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $ageText }}
                                            </p>
                                </div>
                            </div>
                            @endif

                             @if($animal->fecha_ingreso_hato)
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Fecha de Ingreso al Hato</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                            @php
                                                $entry = \Carbon\Carbon::parse($animal->fecha_ingreso_hato);
                                                $diff_in = $entry->diff(\Carbon\Carbon::now());
                                                $years_in = $diff_in->y;
                                                $months_in = $diff_in->m;
                                                $ageInText = '';
                                                if ($years_in > 0) { $ageInText .= $years_in.' año'.($years_in > 1 ? 's' : ''); }
                                                if ($months_in > 0) { $ageInText .= ($years_in > 0 ? ' y ' : '') . $months_in.' mes'.($months_in > 1 ? 'es' : ''); }
                                                if ($ageInText === '') { $ageInText = '0 meses'; }
                                            @endphp
                                            <p class="text-lg font-semibold text-gray-800">{{ $entry->format('d/m/Y') }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $ageInText }} en el hato
                                            </p>
                                </div>
                            </div>
                            @endif

                            <!-- Peso -->
                            @if($animal->peso_aproximado)
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Peso Aproximado</label>
                                <div class="p-4 rounded-lg border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
                                    <p class="text-2xl font-bold text-gray-800">{{ $animal->peso_aproximado }} <span class="text-sm text-gray-600">kg</span></p>
                                </div>
                            </div>
                            @endif

                            <!-- Color -->
                            @if($animal->color)
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Color</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 transition-colors hover:border-bovi-green-600">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->color }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Fecha de Registro -->
                            <div class="group">
                                <label class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Fecha de Registro</label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-lg font-semibold text-gray-800">{{ $animal->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $animal->created_at->format('H:i') }} hrs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                @if($animal->observaciones)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Observaciones
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $animal->observaciones }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Imágenes -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Galería de Imágenes
                        </h2>
                    </div>

                    <div class="p-6">
                        @if($animal->foto_boca || $animal->foto_general)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Foto de la Boca -->
                                @if($animal->foto_boca)
                                <div class="group">
                                    <div class="relative overflow-hidden rounded-lg shadow-lg transition-transform duration-300 group-hover:scale-105">
                                        <img 
                                            src="{{ asset('storage/' . $animal->foto_boca) }}" 
                                            alt="Foto de la boca" 
                                            class="w-full h-64 object-cover cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_boca) }}')"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4 cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_boca) }}')">
                                            <div class="text-white">
                                                <p class="font-bold text-lg">Foto de la Boca</p>
                                                <p class="text-sm flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                    </svg>
                                                    Click para ampliar
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Foto General -->
                                @if($animal->foto_general)
                                <div class="group">
                                    <div class="relative overflow-hidden rounded-lg shadow-lg transition-transform duration-300 group-hover:scale-105">
                                        <img 
                                            src="{{ asset('storage/' . $animal->foto_general) }}" 
                                            alt="Foto general" 
                                            class="w-full h-64 object-cover cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_general) }}')"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4 cursor-pointer"
                                            onclick="openImageModal('{{ asset('storage/' . $animal->foto_general) }}')">
                                            <div class="text-white">
                                                <p class="font-bold text-lg">Foto General</p>
                                                <p class="text-sm flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                    </svg>
                                                    Click para ampliar
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-400 font-medium">No hay imágenes disponibles</p>
                                <p class="text-gray-400 text-sm mt-1">Agrega fotos para documentar mejor este animal</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ─── Vacunaciones ────────────────────────────────────── -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Vacunaciones
                            <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                {{ $animal->vaccinations->count() }}
                            </span>
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($animal->vaccinations->isNotEmpty())
                            @php $lastVac = $animal->vaccinations->first(); @endphp
                            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-blue-800">Última vacuna: {{ $lastVac->vacuna }}</p>
                                    <p class="text-xs text-blue-600">{{ $lastVac->fecha_vacunacion->format('d/m/Y') }} &mdash; Dosis: {{ $lastVac->dosis }}</p>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Vacuna</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Dosis</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lote</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($animal->vaccinations->take(5) as $vac)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 font-medium text-gray-800">{{ $vac->vacuna }}</td>
                                            <td class="px-3 py-2 text-gray-600">{{ $vac->dosis }}</td>
                                            <td class="px-3 py-2 text-gray-600">{{ $vac->fecha_vacunacion->format('d/m/Y') }}</td>
                                            <td class="px-3 py-2 text-gray-500">{{ $vac->lote ?? '—' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($animal->vaccinations->count() > 5)
                            <p class="text-xs text-gray-400 mt-2 text-right">Mostrando 5 de {{ $animal->vaccinations->count() }} registros</p>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p class="text-gray-400 font-medium">Sin registros de vacunación</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ─── Registro Sanitario ──────────────────────────────── -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Registro Sanitario
                            <span class="ml-2 bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                {{ $animal->healthRecords->count() }}
                            </span>
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($animal->healthRecords->isNotEmpty())
                            @php $lastHealth = $animal->healthRecords->first(); @endphp
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                @if($lastHealth->fecha_lavado)
                                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                                    <p class="text-xs font-semibold text-emerald-700 uppercase mb-1">Último Lavado Antiparasitario</p>
                                    <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($lastHealth->fecha_lavado)->format('d/m/Y') }}</p>
                                    @if($lastHealth->producto_lavado)
                                    <p class="text-xs text-gray-600 mt-1">{{ $lastHealth->producto_lavado }}</p>
                                    @endif
                                </div>
                                @endif
                                @if($lastHealth->fecha_purga)
                                <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                    <p class="text-xs font-semibold text-amber-700 uppercase mb-1">Última Purga</p>
                                    <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($lastHealth->fecha_purga)->format('d/m/Y') }}</p>
                                    @if($lastHealth->tipo_purgante)
                                    <p class="text-xs text-gray-600 mt-1">{{ $lastHealth->tipo_purgante }}</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                            @if($lastHealth->observaciones)
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700">
                                <span class="font-semibold text-gray-500 text-xs uppercase">Observaciones: </span>{{ $lastHealth->observaciones }}
                            </div>
                            @endif
                            @if($animal->healthRecords->count() > 1)
                            <p class="text-xs text-gray-400 mt-2 text-right">{{ $animal->healthRecords->count() }} registros sanitarios en total</p>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <p class="text-gray-400 font-medium">Sin registros sanitarios</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ─── Historial de Pesos ──────────────────────────────── -->
                @if($animal->weights->isNotEmpty())
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                            Historial de Pesos
                        </h2>
                    </div>
                    <div class="p-6">
                        @php
                            $weights = $animal->weights;
                            $lastWeight = $weights->first();
                            $firstWeight = $weights->last();
                            $diffPeso = ($firstWeight && $weights->count() >= 2)
                                ? round($lastWeight->peso - $firstWeight->peso, 1)
                                : null;
                        @endphp
                        @if(!is_null($diffPeso))
                        <div class="mb-4 flex items-center gap-2 p-3 rounded-lg {{ $diffPeso >= 0 ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            <svg class="w-5 h-5 {{ $diffPeso >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $diffPeso >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"></path>
                            </svg>
                            <p class="text-sm font-semibold {{ $diffPeso >= 0 ? 'text-green-800' : 'text-red-800' }}">
                                Variación: {{ $diffPeso >= 0 ? '+' : '' }}{{ $diffPeso }} kg (último vs. primero registrado)
                            </p>
                        </div>
                        @endif
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peso (kg)</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nota</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($weights as $w)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($w->measured_at)->format('d/m/Y') }}</td>
                                        <td class="px-3 py-2 font-bold text-gray-800">{{ number_format($w->peso, 1) }}</td>
                                        <td class="px-3 py-2 text-gray-500 text-xs">{{ $w->nota ?? '—' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- ─── Registros Reproductivos ─────────────────────────── -->
                @if($animal->reproductiveRecords->isNotEmpty())
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Registros Reproductivos
                            <span class="ml-2 bg-pink-100 text-pink-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                {{ $animal->reproductiveRecords->count() }}
                            </span>
                        </h2>
                    </div>
                    <div class="p-6">
                        @php $lastRepro = $animal->reproductiveRecords->first(); @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                            @if($lastRepro->tipo_proceso)
                            <div class="p-3 bg-pink-50 border border-pink-200 rounded-lg">
                                <p class="text-xs font-semibold text-pink-700 uppercase mb-1">Tipo de Proceso</p>
                                <p class="text-sm font-bold text-gray-800">{{ ucfirst(str_replace('_', ' ', $lastRepro->tipo_proceso)) }}</p>
                                @if($lastRepro->fecha_prenez)
                                <p class="text-xs text-gray-600 mt-1">Preñez: {{ \Carbon\Carbon::parse($lastRepro->fecha_prenez)->format('d/m/Y') }}</p>
                                @endif
                            </div>
                            @endif
                            @if($lastRepro->fecha_estimada_parto)
                            @php
                                $parto = \Carbon\Carbon::parse($lastRepro->fecha_estimada_parto);
                                $diasParto = (int) now()->diffInDays($parto, false);
                            @endphp
                            <div class="p-3 {{ $diasParto > 0 ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }} border rounded-lg">
                                <p class="text-xs font-semibold {{ $diasParto > 0 ? 'text-blue-700' : 'text-gray-500' }} uppercase mb-1">
                                    {{ $diasParto > 0 ? 'Parto Estimado' : 'Parto (pasado)' }}
                                </p>
                                <p class="text-sm font-bold text-gray-800">{{ $parto->format('d/m/Y') }}</p>
                                <p class="text-xs mt-1 {{ $diasParto > 0 ? 'text-blue-600' : 'text-gray-400' }}">
                                    {{ $diasParto > 0 ? "En $diasParto días" : abs($diasParto).' días atrás' }}
                                </p>
                            </div>
                            @endif
                        </div>
                        @if($lastRepro->palpacion && $lastRepro->fecha_palpacion)
                        <div class="text-sm text-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Palpación realizada: {{ \Carbon\Carbon::parse($lastRepro->fecha_palpacion)->format('d/m/Y') }}
                        </div>
                        @endif
                        @if($lastRepro->observaciones)
                        <div class="mt-3 p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700">
                            <span class="font-semibold text-gray-500 text-xs uppercase">Observaciones: </span>{{ $lastRepro->observaciones }}
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ─── Producción de Leche ─────────────────────────────── -->
                @if(in_array($animal->proposito, ['leche', 'doble_proposito']) || $animal->milkProductions->isNotEmpty())
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Producción de Leche
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($animal->milkProductions->isNotEmpty())
                            @php
                                $milks    = $animal->milkProductions;
                                $lastMilk = $milks->first();
                                $avgLitros= round($milks->avg('liters'), 1);
                                $totalLitros = round($milks->sum('liters'), 1);
                            @endphp
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <div class="text-center p-3 bg-sky-50 border border-sky-200 rounded-lg">
                                    <p class="text-2xl font-bold text-sky-700">{{ number_format($lastMilk->liters, 1) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Último registro<br>{{ \Carbon\Carbon::parse($lastMilk->date)->format('d/m/Y') }}</p>
                                </div>
                                <div class="text-center p-3 bg-sky-50 border border-sky-200 rounded-lg">
                                    <p class="text-2xl font-bold text-sky-700">{{ $avgLitros }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Promedio L<br>({{ $milks->count() }} reg.)</p>
                                </div>
                                <div class="text-center p-3 bg-sky-50 border border-sky-200 rounded-lg">
                                    <p class="text-2xl font-bold text-sky-700">{{ $totalLitros }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Total litros<br>registrados</p>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Litros</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Turno</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mastitis</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($milks->take(5) as $milk)
                                        <tr class="hover:bg-gray-50 {{ $milk->mastitis ? 'bg-red-50' : '' }}">
                                            <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($milk->date)->format('d/m/Y') }}</td>
                                            <td class="px-3 py-2 font-bold text-gray-800">{{ number_format($milk->liters, 1) }} L</td>
                                            <td class="px-3 py-2 text-gray-500">{{ $milk->shift ?? '—' }}</td>
                                            <td class="px-3 py-2">
                                                @if($milk->mastitis)
                                                <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Sí</span>
                                                @else
                                                <span class="text-xs text-gray-400">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($milks->count() > 5)
                            <p class="text-xs text-gray-400 mt-2 text-right">Mostrando 5 de {{ $milks->count() }} registros</p>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="text-gray-400 font-medium">Sin registros de producción de leche</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ─── Descendencia ──────────────────────────────────────── -->
                @php
                    $crias = $animal->sexo === 'macho' ? $animal->asPadre : $animal->asMadre;
                @endphp
                @if($crias->isNotEmpty() || ($animal->parentage && ($animal->parentage->padre || $animal->parentage->madre)))
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Descendencia
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Padres del animal -->
                        @if($animal->parentage && ($animal->parentage->padre || $animal->parentage->madre))
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Padres de este animal</p>
                            <div class="grid grid-cols-2 gap-3">
                                @if($animal->parentage->padre)
                                <div class="p-3 bg-bovi-green-50 border border-bovi-green-200 rounded-lg text-center">
                                    <p class="text-xs text-gray-500 mb-1">Padre (Toro)</p>
                                    <a href="{{ route('admin.ganado.show', $animal->parentage->padre_id) }}" class="text-sm font-bold text-bovi-green-800 hover:underline">
                                        {{ $animal->parentage->padre->nombre ?? $animal->parentage->padre->codigo_nfc }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $animal->parentage->padre->codigo_nfc }}</p>
                                </div>
                                @endif
                                @if($animal->parentage->madre)
                                <div class="p-3 bg-bovi-brown-50 border border-bovi-brown-200 rounded-lg text-center">
                                    <p class="text-xs text-gray-500 mb-1">Madre (Vaca)</p>
                                    <a href="{{ route('admin.ganado.show', $animal->parentage->madre_id) }}" class="text-sm font-bold text-bovi-brown-600 hover:underline">
                                        {{ $animal->parentage->madre->nombre ?? $animal->parentage->madre->codigo_nfc }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $animal->parentage->madre->codigo_nfc }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <!-- Crías -->
                        @if($crias->isNotEmpty())
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">
                                Crías registradas ({{ $crias->count() }})
                            </p>
                            <div class="space-y-2">
                                @foreach($crias->take(5) as $cria)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg border border-gray-200 hover:border-bovi-green-400 transition-colors">
                                    <div>
                                        <a href="{{ route('admin.ganado.show', $cria->animal_id) }}" class="text-sm font-semibold text-bovi-green-800 hover:underline">
                                            {{ $cria->animal->nombre ?? $cria->animal->codigo_nfc }}
                                        </a>
                                        <p class="text-xs text-gray-500">{{ $cria->animal->codigo_nfc }}</p>
                                    </div>
                                    @if($cria->fecha_nacimiento)
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($cria->fecha_nacimiento)->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                @endforeach
                                @if($crias->count() > 5)
                                <p class="text-xs text-gray-400 text-right">+{{ $crias->count() - 5 }} crías más</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar Derecho -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 space-y-6 max-h-[calc(100vh-3rem)] overflow-y-auto pr-2 custom-scrollbar">
                
                    <!-- Acciones Rápidas -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-bovi-dark">Acciones Rápidas</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a 
                            href="{{ route('admin.ganado.edit', $animal->id) }}" 
                            class="flex items-center justify-center w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 bg-bovi-green-600 hover:bg-bovi-green-700"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Animal
                        </a>
                        
                        <button 
                            onclick="openDeleteModal({{ $animal->id }}, '{{ $animal->codigo_nfc }}')" 
                            class="flex items-center justify-center w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar Animal
                        </button>
                    </div>
                </div>

                <!-- URL Pública -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b bg-gradient-to-r from-bovi-green-50 to-bovi-green-25 border-b-bovi-green-600">
                        <h3 class="text-lg font-bold flex items-center text-bovi-dark">
                            <svg class="w-5 h-5 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            Enlace Público
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Comparte este enlace para que otros puedan ver la información del animal sin necesidad de cuenta.
                        </p>
                        <div class="space-y-3">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    value="{{ route('public.animal.show', $animal->public_token) }}" 
                                    readonly 
                                    class="input-bovi w-full text-sm pr-10"
                                    id="publicUrl"
                                >
                                <button 
                                    onclick="copyPublicUrl()" 
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 transition-colors hover:text-bovi-green-800"
                                    title="Copiar URL"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <button 
                                    onclick="copyPublicUrl()" 
                                    class="flex items-center justify-center text-white px-4 py-2 rounded-lg font-medium transition-all text-sm shadow-sm hover:shadow-md bg-bovi-brown-600 hover:bg-bovi-brown-800"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copiar
                                </button>
                                <a 
                                    href="{{ route('public.animal.show', $animal->public_token) }}" 
                                    target="_blank"
                                    class="flex items-center justify-center text-white px-4 py-2 rounded-lg font-medium transition-all text-sm shadow-sm hover:shadow-md bg-bovi-green-800 hover:bg-bovi-green-600"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Abrir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-md p-6 border border-gray-200">
                    <h3 class="text-sm font-bold mb-4 flex items-center text-bovi-dark">
                        <svg class="w-4 h-4 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información del Registro
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs uppercase text-bovi-brown-600">Fecha de Registro</span>
                            <span class="font-semibold text-gray-800">{{ $animal->created_at->format('d/m/Y H:i') }}</span>
                            <span class="text-xs text-gray-500">{{ $animal->created_at->diffForHumans() }}</span>
                        </div>
                        
                        @if($animal->created_at != $animal->updated_at)
                        <div class="flex flex-col gap-1 pt-3 border-t border-gray-300">
                            <span class="text-xs uppercase text-bovi-brown-600">Última Modificación</span>
                            <span class="font-semibold text-gray-800">{{ $animal->updated_at->format('d/m/Y H:i') }}</span>
                            <span class="text-xs text-gray-500">{{ $animal->updated_at->diffForHumans() }}</span>
                        </div>
                        @endif
                        
                        <div class="flex flex-col gap-1 pt-3 border-t border-gray-300">
                            <span class="text-xs uppercase text-bovi-brown-600">ID del Registro</span>
                            <span class="font-mono font-semibold text-gray-800">#{{ str_pad($animal->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="flex flex-col gap-1 pt-3 border-t border-gray-300">
                            <span class="text-xs uppercase text-bovi-brown-600">Token Público</span>
                            <code class="font-mono text-xs text-gray-700 bg-white px-2 py-1 rounded break-all">{{ $animal->public_token }}</code>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>

        <!-- Formulario oculto para eliminar -->
        <form id="delete-form-{{ $animal->id }}" action="{{ route('admin.ganado.destroy', $animal->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>

    <!-- Estilos personalizados -->
    <style>
        /* Scrollbar personalizado para el sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>

    <!-- Modal de Confirmación de Eliminación Mejorado -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95" id="modalContent">
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <div class="bg-red-100 rounded-full p-4 animate-pulse">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 text-center mb-2">
                    ¿Eliminar animal?
                </h3>
                <p class="text-gray-600 text-center mb-2">
                    Estás a punto de eliminar permanentemente el animal:
                </p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                    <p class="text-center font-mono font-bold text-red-700" id="animalCode"></p>
                </div>
                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <p class="text-sm text-amber-800">
                            Esta acción <strong>no se puede deshacer</strong>. Todos los datos asociados se eliminarán permanentemente.
                        </p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button 
                        onclick="closeDeleteModal()" 
                        class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition-all duration-200"
                    >
                        Cancelar
                    </button>
                    <button 
                        onclick="confirmDelete()" 
                        class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold py-3 px-4 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg"
                    >
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver imagen en grande Mejorado -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black/95 backdrop-blur-sm z-50 flex items-center justify-center px-4" onclick="closeImageModal()">
        <button class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors z-10 bg-black/50 rounded-full p-2 hover:bg-black/70" onclick="closeImageModal()">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="max-w-6xl w-full" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Imagen ampliada" class="w-full rounded-lg shadow-2xl">
        </div>
    </div>

    <script>
        let deleteFormId = null;

        function openDeleteModal(animalId, codigoNfc) {
            deleteFormId = animalId;
            document.getElementById('animalCode').textContent = codigoNfc;
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                deleteFormId = null;
            }, 300);
        }

        function confirmDelete() {
            if (deleteFormId) {
                document.getElementById('delete-form-' + deleteFormId).submit();
            }
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('deleteModal').classList.contains('hidden')) {
                    closeDeleteModal();
                }
                if (!document.getElementById('imageModal').classList.contains('hidden')) {
                    closeImageModal();
                }
            }
        });

        function copyPublicUrl() {
            const input = document.getElementById('publicUrl');
            input.select();
            input.setSelectionRange(0, 99999);
            
            navigator.clipboard.writeText(input.value).then(function() {
                // Crear notificación
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center transform translate-x-full transition-transform duration-300';
                notification.style.backgroundColor = '#1F4D2B';
                notification.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    URL copiada al portapapeles
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 10);
                
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }).catch(function() {
                // Fallback para navegadores antiguos
                document.execCommand('copy');
                alert('URL copiada al portapapeles');
            });
        }

        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            const modal = document.getElementById('imageModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Animación de entrada
            setTimeout(() => {
                modal.style.opacity = '1';
            }, 10);
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.style.opacity = '0';
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        // Mejorar experiencia de carga de imágenes
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[onclick^="openImageModal"]');
            images.forEach(img => {
                img.style.cursor = 'zoom-in';
            });
        });
    </script>

</x-app-layout>
