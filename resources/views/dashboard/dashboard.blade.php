<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto mb-8 px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="font-bold text-3xl">Hai, {{ Auth::user()->name }}</h1>
            </div>
        </div>
        {{-- <div class="max-w-7xl mx-auto mb-8 px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>You're logged in! Welcome {{ Auth::user()->name }}</h1>
                </div>
            </div>
        </div> --}}

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="px-6 pb-6 text-gray-900 dark:text-gray-100">
                <h1 class="font-bold text-xl">Overview</h1>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Card -->
                <a @can('aksesInventarisKolamPeralatan') href="{{ route('kolam.index') }}" @endcan
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <i class="fa-solid fa-shrimp"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Kolam Aktif
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $kolamAktif }}
                        </p>
                    </div>
                </a>
                <!-- Card -->
                <a @can('aksesFinansial') href="{{ route('finansial.index') }}" @endcan
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Jumlah Saldo
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            Rp. {{ $saldo }}
                        </p>
                    </div>
                </a>
                <!-- Card -->
                <a @can('aksesKaryawan') href="{{ route('karyawan.index') }}" @endcan
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Karyawan
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $karyawan }}
                        </p>
                    </div>
                </a>
                <!-- Card -->
                <a @can('aksesInventarisKolamPeralatan') href="{{ route('inventaris.index') }}" @endcan
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Item Inventaris
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $itemInventaris }}
                        </p>
                    </div>
                </a>
                <!-- Card -->
                <a @can('aksesInventarisKolamPeralatan') href="{{ route('peralatan.index') }}" @endcan
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Peralatan Maintenace
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $maintenance }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-admin>