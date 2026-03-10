<x-slot name="title">Perfil</x-slot>
<section>
    <header class="mb-6">
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ __("Actualice la información del perfil y la dirección de correo electrónico de su cuenta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                {{ __('Nombre') }}
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="input-bovi w-full @error('name') border-red-500 bg-red-50 @enderror" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
            />
            @error('name')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-2 text-bovi-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                {{ __('Correo electrónico') }}
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="input-bovi w-full @error('email') border-red-500 bg-red-50 @enderror" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
            />
            @error('email')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-amber-50 border-l-4 border-amber-400 p-3 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-amber-800">
                                {{ __('Su dirección de correo electrónico no está verificada.') }}
                            </p>
                            <button 
                                form="send-verification" 
                                class="mt-2 text-sm font-semibold text-amber-700 hover:text-amber-900 underline"
                            >
                                {{ __('Haga clic aquí para reenviar el correo de verificación.') }}
                            </button>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm font-medium text-green-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="btn-bovi-gradient font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
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
                    {{ __('Cambios guardados correctamente.') }}
                </p>
            @endif
        </div>
    </form>
</section>
