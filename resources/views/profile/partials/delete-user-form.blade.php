
<section class="space-y-6">
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex">
            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="flex-1">
                <p class="text-sm text-red-800 leading-relaxed">
                    {{ __('Una vez eliminada su cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar.') }}
                </p>
            </div>
        </div>
    </div>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        {{ __('Eliminar Cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center mb-4">
                <div class="bg-red-100 rounded-full p-3 mr-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">
                    {{ __('¿Está seguro de que desea eliminar su cuenta?') }}
                </h2>
            </div>

            <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                {{ __('Una vez eliminada su cuenta, todos sus recursos y datos se eliminarán permanentemente. Por favor, ingrese su contraseña para confirmar que desea eliminar su cuenta de forma permanente.') }}
            </p>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ __('Contraseña') }}
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="input-bovi w-full @error('password', 'userDeletion') border-red-500 bg-red-50 @enderror"
                    placeholder="{{ __('Ingrese su contraseña') }}"
                />
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all duration-200"
                >
                    {{ __('Cancelar') }}
                </button>
                <button
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200"
                >
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
