<nav x-data="{ open: false }">
    <div class="flex">
        <!-- Botón hamburguesa visible en móvil (si el sidebar está fuera) -->
        <button x-show="!open" x-cloak @click="open = !open" class="absolute top-4 left-4 sm:hidden z-50 p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition duration-200">
            <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Sidebar -->
        <aside :class="{'-translate-x-full': !open, 'translate-x-0': open}" class="fixed z-40 inset-y-0 left-0 w-64 bg-white border-r border-gray-200 shadow-lg transform transition-transform duration-200 ease-in-out sm:translate-x-0 sm:fixed sm:inset-y-0 sm:left-0 sm:z-40 sm:shadow-none flex flex-col h-screen">
            <div class="flex items-center justify-between h-20 px-6 border-b border-gray-100">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <x-application-logo class="h-12 w-12 transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <div class="hidden md:block">
                        <span class="nav-brand-text font-bold text-lg">BoviTrack</span>
                        <p class="text-xs text-gray-500 -mt-1">Gestión Ganadera</p>
                    </div>
                </a>
                <button @click="open = !open" class="sm:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition duration-200">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 flex flex-col py-6 px-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-bovi-green-100 text-bovi-green-800 font-bold' : 'text-gray-700 hover:bg-bovi-green-50 hover:text-bovi-green-700' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Panel Principal
                </a>

                <a href="{{ route('admin.ganado.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.ganado.index') ? 'bg-bovi-brown-100 text-bovi-brown-800 font-bold' : 'text-gray-700 hover:bg-bovi-brown-50 hover:text-bovi-brown-700' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    Ganado
                </a>

                
                <a href="{{ route('admin.lotes.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.lotes.index') ? 'bg-bovi-brown-100 text-bovi-brown-800 font-bold' : 'text-gray-700 hover:bg-bovi-brown-50 hover:text-bovi-brown-700' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M3 3h8v8H3V3zM13 3h8v8h-8V3zM3 13h8v8H3v-8zM13 13h8v8h-8v-8z" fill="currentColor" />
                    </svg>
                    Lotes
                </a>

                <a href="{{ route('admin.historial.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.historial.*') ? 'bg-bovi-brown-100 text-bovi-brown-800 font-bold' : 'text-gray-700 hover:bg-bovi-brown-50 hover:text-bovi-brown-700' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11h8M8 15h8M8 19h5" />
                    </svg>
                    Historial Administrativo
                </a>

               

                <div class="flex items-center px-4 py-2 mt-4 bg-bovi-green-50 rounded-lg">
                    <svg class="w-5 h-5 mr-2 text-bovi-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">{{ \App\Models\Animal::count() }} <span class="text-gray-500">animales</span></span>
                </div>
            </div>

            <div class="mt-auto px-4 pb-6">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="avatar-bovi-lg">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="font-semibold text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Mi Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Overlay para móvil -->
        <div x-show="open" @click="open = false" class="fixed inset-0 bg-black bg-opacity-30 z-30 sm:hidden" x-cloak></div>
    </div>
    </nav>