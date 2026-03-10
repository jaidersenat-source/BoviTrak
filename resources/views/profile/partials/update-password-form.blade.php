<section>
    <header class="mb-6">
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ __('Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantener su seguridad.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-bovi-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                {{ __('Contraseña actual') }}
            </label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="input-bovi w-full @error('current_password', 'updatePassword') border-red-500 bg-red-50 @enderror" 
                autocomplete="current-password"
            />
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-bovi-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                {{ __('Nueva contraseña') }}
            </label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="input-bovi w-full @error('password', 'updatePassword') border-red-500 bg-red-50 @enderror" 
                autocomplete="new-password"
            />
            @error('password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-bovi-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('Confirmar contraseña') }}
            </label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="input-bovi w-full @error('password_confirmation', 'updatePassword') border-red-500 bg-red-50 @enderror" 
                autocomplete="new-password"
            />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="btn-bovi-gradient font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                {{ __('Actualizar Contraseña') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-green-600 flex items-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Contraseña actualizada correctamente.') }}
                </p>
            @endif
        </div>
    </form>
</section>
