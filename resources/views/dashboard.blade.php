<x-app-layout>
    <x-slot name="title">Panel Principal</x-slot>
    
   

    <div class="py-6 px-4 max-w-7xl mx-auto">

        <!-- Mensaje de éxito simple (para otras acciones) -->
        @if(session('success') && !session('animal_saved'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Botón Registrar Ganado -->
        <div class="mb-6">
            <a href="{{ route('admin.ganado.create') }}" class="btn-bovi-primary block text-center w-full py-4 px-6 rounded-xl shadow-lg hover:shadow-xl">
                <span class="inline-flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-lg">Registrar Nuevo Animal</span>
                </span>
            </a>
        </div>

        <!-- Buscador -->
        <div class="mb-6 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <form method="GET" action="{{ route('dashboard') }}" class="p-4">
                <div class="flex gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar por código NFC, raza o nombre..."
                            class="input-bovi w-full pl-12 pr-4 py-3"
                        >
                    </div>
                    <button type="submit" class="btn-bovi-brown-gradient px-6 py-3 rounded-lg shadow-md hover:shadow-lg">
                        <span class="hidden sm:inline">Buscar</span>
                        <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('dashboard') }}" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Listado de Ganado -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($animals as $animal)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-200 overflow-hidden border-l-4 border-l-bovi-brown-600">
                    <!-- Header de la Card -->
                    <div class="p-4 border-t-4 border-t-bovi-green-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-bovi-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-sm font-medium text-bovi-green-800">ID: #{{ str_pad($animal->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold text-white bg-bovi-green-600">
                                {{ ucfirst($animal->sexo) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <!-- Código NFC -->
                        <div class="mb-4">
                            <p class="text-xs font-semibold uppercase tracking-wider mb-2 block text-bovi-brown-600">Código NFC</p>
                            <div class="flex items-center p-3 rounded-lg border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
                                <svg class="w-5 h-5 mr-2 text-bovi-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <span class="font-mono text-lg font-bold text-gray-800">{{ $animal->codigo_nfc }}</span>
                            </div>
                        </div>

                        <!-- Raza y Nombre -->
                        <div class="mb-4 space-y-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider mb-1 block text-bovi-brown-600">Raza</p                                    >
                                <p class="text-gray-800 font-semibold">{{ $animal->raza }}</p>
                            </div>
                            @if($animal->nombre)
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider mb-1 block text-bovi-brown-600">Nombre</p>
                                <p class="text-gray-800 font-semibold">{{ $animal->nombre }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- URL Pública -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                            <p class="text-xs font-semibold text-green-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Enlace Público
                            </p>
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    value="{{ route('public.animal.show', $animal->public_token) }}" 
                                    readonly 
                                    class="flex-1 text-xs px-2 py-1 bg-white border border-green-300 rounded font-mono text-gray-600"
                                    id="url-{{ $animal->id }}"
                                >
                                <button 
                                    onclick="copyToClipboard('url-{{ $animal->id }}')" 
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded transition-colors"
                                    type="button"
                                    title="Copiar URL"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="px-5 pb-5 space-y-2">
                        <a href="{{ route('admin.ganado.show', $animal->id) }}" class="btn-bovi-secondary block text-center w-full py-2.5 px-4 rounded-lg shadow-md hover:shadow-lg">
                            <span class="inline-flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Detalles
                            </span>
                        </a>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.ganado.edit', $animal->id) }}" class="block text-center text-white font-semibold py-2 px-3 rounded-lg transition-colors duration-200 text-sm bg-bovi-green-600 hover:bg-bovi-green-700">
                                <span class="inline-flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Editar
                                </span>
                            </a>
                            <button 
                                type="button"
                                onclick="event.preventDefault(); event.stopPropagation(); openDeleteModal({{ $animal->id }}, '{{ $animal->codigo_nfc }}')" 
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-3 rounded-lg transition-colors duration-200 text-sm"
                            >
                                <span class="inline-flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Formulario oculto para eliminar -->
                    <form id="delete-form-{{ $animal->id }}" action="{{ route('admin.ganado.destroy', $animal->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="mb-6">
                                <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">No hay ganado registrado</h3>
                            <p class="text-gray-500 mb-6">Comienza agregando tu primer animal al sistema</p>
                            <a href="{{ route('admin.ganado.create') }}" class="btn-bovi-primary inline-flex items-center gap-2 py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Registrar Primer Animal
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse

        </div>

        <!-- Paginación -->
        @if($animals->hasPages())
            <div class="mt-8">
                {{ $animals->links() }}
            </div>
        @endif

    </div>

    <!-- Modal de Éxito al Guardar - Mejorado -->
    @if(session('animal_saved'))
    <div id="successModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center px-4" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 animate-fade-in" id="successModalContent">
            <div class="p-8 text-center">
                <!-- Icono de éxito animado -->
                <div class="mb-6">
                    <div class="success-checkmark mx-auto">
                        <div class="check-icon">
                            <span class="icon-line line-tip"></span>
                            <span class="icon-line line-long"></span>
                            <div class="icon-circle"></div>
                            <div class="icon-fix"></div>
                        </div>
                    </div>
                </div>

                <!-- Título -->
                <h3 class="text-3xl font-bold text-gray-800 mb-3">
                    ¡Registro Exitoso!
                </h3>

                <!-- Mensaje -->
                <p class="text-gray-600 mb-6">
                    El animal ha sido registrado correctamente en el sistema.
                </p>

                <!-- Información del animal -->
                <div class="rounded-lg p-4 mb-6 border-l-4 bg-bovi-green-50 border-l-bovi-green-800">
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Código NFC</p>
                            <p class="font-bold text-gray-800">{{ session('animal_saved')['codigo_nfc'] }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Raza</p>
                            <p class="font-bold text-gray-800">{{ session('animal_saved')['raza'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="space-y-3">
                    <a href="{{ route('admin.ganado.show', session('animal_saved')['id']) }}" class="btn-bovi-secondary flex items-center justify-center gap-2 w-full py-3 px-4 rounded-lg shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver Detalles
                    </a>
                    <a href="{{ route('admin.ganado.create') }}" class="btn-bovi-primary flex items-center justify-center gap-2 w-full py-3 px-4 rounded-lg shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Registrar Otro Animal
                    </a>
                    <button onclick="closeSuccessModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                        Volver al Panel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @endif

    <!-- Modal de Confirmación de Eliminación - Mejorado -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95" id="deleteModalContent">
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
                        <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <script>
        let deleteFormId = null;

        // Mostrar modal de éxito automáticamente si existe
        document.addEventListener('DOMContentLoaded', function() {
            const successModalEl = document.getElementById('successModal');
            if (successModalEl) {
                showSuccessModal();
            }
        });

        // Funciones del modal de éxito
        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            const modalContent = document.getElementById('successModalContent');
            
            modal.style.display = 'flex';
            modal.classList.add('animate-fade-in');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            const modalContent = document.getElementById('successModalContent');
            
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Funciones del modal de eliminación
        function openDeleteModal(animalId, codigoNfc) {
            deleteFormId = animalId;
            document.getElementById('animalCode').textContent = codigoNfc;
            
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('animate-fade-in');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('deleteModalContent');
            
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                deleteFormId = null;
            }, 300);
        }

        function confirmDelete() {
            if (deleteFormId) {
                document.getElementById('delete-form-' + deleteFormId).submit();
            }
        }

        // Cerrar modales al hacer clic fuera de ellos
        document.addEventListener('click', function(e) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteModalContent = document.getElementById('deleteModalContent');
            
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });

        // Función para copiar al portapapeles
        function copyToClipboard(elementId) {
            const input = document.getElementById(elementId);
            input.select();
            input.setSelectionRange(0, 99999);
            
            // Usar el API moderno de clipboard si está disponible
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(input.value).then(() => {
                    showToast('URL copiada al portapapeles');
                });
            } else {
                // Fallback para navegadores antiguos
                document.execCommand('copy');
                showToast('URL copiada al portapapeles');
            }
        }

        // Función para mostrar notificaciones toast
        function showToast(message) {
            const toastHTML = `
                <div class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-2xl flex items-center gap-3 animate-fade-in z-50" id="toast">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            
            const toastEl = document.createRange().createContextualFragment(toastHTML).firstElementChild;
            document.body.appendChild(toastEl);
            
            setTimeout(() => {
                toastEl.style.opacity = '0';
                toastEl.style.transform = 'translateY(10px)';
                toastEl.style.transition = 'all 0.3s ease-out';
                setTimeout(() => toastEl.remove(), 300);
            }, 2000);
        }
    </script>
</x-app-layout>
