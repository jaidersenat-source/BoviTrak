<x-guest-layout>
    <x-slot name="title">Iniciar Sesión</x-slot>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                id="email" 
                class="input-bovi block w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="tu@email.com"
                required 
                autofocus 
                autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                id="password" 
                class="input-bovi block w-full"
                type="password"
                name="password"
                placeholder="••••••••"
                required 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="checkbox-bovi" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Acuérdate de mí') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a 
                    class="text-sm text-gray-600 transition-colors duration-200 underline-offset-4 hover:underline hover:text-bovi-green-800" 
                    href="{{ route('password.request') }}"
                >
                    {{ __('Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button class="btn-bovi-primary w-full justify-center py-3 text-base font-semibold transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                {{ __('Acceso') }}
            </x-primary-button>
        </div>

        <!-- Register Link (opcional) -->
        @if (Route::has('register'))
            <div class="text-center pt-2">
                <p class="text-sm text-gray-600">
                    ¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="font-semibold transition-colors duration-200 text-bovi-green-800 hover:text-bovi-green-600">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
