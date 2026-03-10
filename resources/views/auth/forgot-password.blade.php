<x-guest-layout>
    <x-slot name="title">Recuperar Contraseña</x-slot>
    
    <!-- Título y descripción -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-3">
            {{ __('¿Olvidaste tu contraseña?') }}
        </h2>
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ __('No hay problema. Indícanos tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                id="email" 
                class="block w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-gray-400" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="tu@email.com"
                required 
                autofocus 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                {{ __('Enviar enlace de restablecimiento') }}
            </x-primary-button>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center pt-2">
            <a 
                href="{{ route('login') }}" 
                class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200 group"
            >
                <svg class="w-4 h-4 mr-2 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Volver al inicio de sesión') }}
            </a>
        </div>
    </form>
</x-guest-layout>
