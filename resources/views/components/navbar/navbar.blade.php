<header class="bg-gray-50 z-10">
  <div class="flex items-center justify-between h-16 px-4 md:px-6">
      <!-- Mobile menu button -->
      <div class="md:hidden">
          <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
              <span class="sr-only">Open main menu</span>
              <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
          </button>
      </div>
      
      <!-- Page title -->
      <div class="flex-1">
          <div class="flex flex-col">
              <h1 class="text-black text-xl font-semibold">
                  @yield('page-title', 'Dashboard')
              </h1>
              @hasSection('page-subtitle')
                  <p class="text-gray-500 text-sm font-normal mt-1">
                      @yield('page-subtitle')
                  </p>
              @endif
          </div>
      </div>
      
      <!-- Profile section -->
      <div class="flex items-center space-x-3">
          <!-- Notification icon -->
          <button class="p-1 rounded-full text-gray-400 hover:text-gray-600 focus:outline-none">
              <span class="sr-only">View notifications</span>
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
          </button>

          <!-- User Profile -->
          <div x-data="{ open: false }" class="relative">
              <div>
                  @auth
                    <button type="button" class="relative flex items-center rounded-lg bg-[#F9F9F9] px-3 py-2 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-transparent focus:outline-none" @click="open = !open" :aria-expanded="open" aria-haspopup="true">
                      <span class="absolute -inset-1.5"></span>
                      <span class="sr-only">Open user menu</span>
                      <!-- Ikon Profil Default -->
                      <div class="size-8 rounded-full bg-gray-300 flex items-center justify-center">
                        <svg class="h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                      </div>
                      <div class="ml-2 flex flex-col items-start">
                        <span class="text-gray-900 font-medium text-sm">{{ Auth::user()->nama_user }}</span>
                        <span class="text-gray-500 text-xs">{{ Auth::user()->role->nama_role }}</span>
                      </div>
                      <svg class="ml-2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                    </button>
                  @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Login</a>
                  @endauth
      
                  <!-- Dropdown menu -->
                  <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg focus:outline-none" @click.outside="open = false" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    @auth
                      <div class="px-4 py-2 border-b border-opacity-5">
                        <p class="text-gray-900 font-medium">{{ Auth::user()->nama_user }}</p>
                        <p class="text-gray-500 text-sm">{{ Auth::user()->role->nama_role }}</p>
                      </div>
                      <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
                        <svg class="mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                      </a>
                      <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    @endauth
                  </div>
                </div>
          </div>
      </div>
  </div>
</header>