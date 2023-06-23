<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
      Tambak Udang
    </a>
    <ul class="mt-6">
      <li class="relative px-6 py-3">
        @if (request()->routeIs('dashboard'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class=" {{ request()->routeIs('dashboard') ? 'text-gray-800 dark:text-gray-100' : ''  }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('dashboard') }}">
          <i class="fa-solid fa-house"></i>
          <span class=" ml-4">Dashboard</span>
        </a>
      </li>
    </ul>
    <ul>
      @can('aksesPengguna')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('users.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('users.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
          href="{{ route('users.index') }}">
          <i class="fa-solid fa-key"></i>
          <span class="ml-4">Manajemen Akun</span>
        </a>
      </li>
      @endcan

      @can('aksesKaryawan')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('karyawan.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('karyawan.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('karyawan.index') }}">
          <i class="fa-solid fa-users"></i>
          <span class="ml-4">Manajemen Karyawan</span>
        </a>
      </li>
      @endcan

      @can('aksesFinansial')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('finansial.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('finansial.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('finansial.index') }}">
          <i class="fa-solid fa-money-bill"></i>
          <span class="ml-4">Manajemen Finansial</span>
        </a>
      </li>
      @endcan

      @can('aksesInventarisKolamPeralatan')
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="">
          <i class="fa-solid fa-warehouse fa-sm"></i>
          <span class="ml-4">Manajemen Inventaris</span>
        </a>
      </li>
      @endcan

      @can('aksesInventarisKolamPeralatan')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('kolam.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('kolam.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('kolam.index') }}">
          <i class="fa-solid fa-shrimp"></i>
          <span class="ml-4">Manajemen Tambak Udang</span>
        </a>
      </li>
      @endcan

      @can('aksesInventarisKolamPeralatan')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('peralatan.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('peralatan.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('peralatan.index') }}">
          <i class="fa-solid fa-wrench"></i>
          <span class="ml-4">Manajemen Peralatan</span>
        </a>
      </li>
      @endcan
    </ul>
  </div>
</aside>
<!-- Mobile sidebar -->

<!-- Backdrop -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
  x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
  x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>

<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
  x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
  x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
  x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0 transform -translate-x-20" @keydown.escape="closeSideMenu">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
      Tambak Udang
    </a>
    <ul class="mt-6">
      <li class="relative px-6 py-3">
        {{-- <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
          aria-hidden="true"></span> --}}
        @if (request()->routeIs('dashboard'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('dashboard') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('dashboard') }}">
          <i class="fa-solid fa-house"></i>
          <span class="ml-4">Dashboard</span>
        </a>
      </li>
    </ul>
    <ul>
      @can('aksesPengguna')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('users.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('users.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('users.index') }}">
          <i class="fa-solid fa-key"></i>
          <span class="ml-4">Manajemen User</span>
        </a>
      </li>
      @endcan

      @can('aksesKaryawan')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('karyawan.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('karyawan.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('karyawan.index') }}">
          <i class="fa-solid fa-users"></i>
          <span class="ml-4">Manajemen Karyawan</span>
        </a>
      </li>
      @endcan

      @can('aksesFinansial')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('finansial.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('finansial.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('finansial.index') }}">
          <i class="fa-solid fa-money-bill"></i>
          <span class="ml-4">Manajemen Finansial</span>
        </a>
      </li>
      @endcan

      @can('aksesInventarisKolamPeralatan')
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="buttons.html">
          <i class="fa-solid fa-warehouse fa-sm"></i>
          <span class="ml-4">Manajemen Inventaris</span>
        </a>
      </li>
      @endcan

      @can('aksesInventarisKolamPeralatan')
      <li class="relative px-6 py-3">
        @if (request()->routeIs('kolam.index'))
        <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="{{ request()->routeIs('kolam.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="{{ route('kolam.index') }}">
          <i class="fa-solid fa-shrimp"></i>
          <span class="ml-4">Manajemen Tambak Udang</span>
        </a>
      </li>
      @endcan

      @can('aksesInventarisKolamPeralatan')
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          href="tables.html">
          <i class="fa-solid fa-wrench"></i>
          <span class="ml-4">Manajemen Peralatan</span>
        </a>
      </li>
      @endcan
    </ul>
  </div>
</aside>