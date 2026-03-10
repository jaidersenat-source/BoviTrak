<x-app-layout>
    <x-slot name="title">Mi Perfil</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-bovi-dark">
                <svg class="inline-block w-8 h-8 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Mi Perfil
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Información del Perfil -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 bg-gradient-bovi-green">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información del Perfil
                    </h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Actualizar Contraseña -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 bg-gradient-to-r from-bovi-green-600 to-bovi-green-700">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Seguridad de la Cuenta
                    </h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Eliminar Cuenta -->
            <div class="bg-white rounded-xl shadow-lg border border-red-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Zona Peligrosa
                    </h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
