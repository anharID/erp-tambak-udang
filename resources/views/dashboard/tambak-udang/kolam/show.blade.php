<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-2xl">Kolam {{ $kolam->nama }}</h1>
            @if ($siklusSaatIni)
            <span class="p-1 bg-blue-300 text-sm rounded-lg dark:bg-blue-500">DoC : {{ $docSaatIni }}</span>
            <div class="my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full p-6">

                    {{-- Alert  --}}
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif


                    <h3>Siklus Saat Ini</h3>
                    <p>Tanggal Mulai: {{ $siklusSaatIni->tanggal_mulai }}</p>
                    <p>Doc : {{ $docSaatIni }}</p>
                </div>
            </div>

            <h1 class="mb-4 font-bold text-2xl">Fitur Manajemen Kolam</h1>
            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <a href="" class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1 class="text-2xl font-bold">Pakan</h1>
                    <div class="grid">
                        <div class="grid-cols-3/4">
                            <p>Waktu pemberian pakan terakhir</p>
                            <p>Pakan terpakai hari ini</p>
                            <p>Pakan terpakai Komulatif</p>

                        </div>
                    </div>
                </a>
                <a href="{{ route('monitoring', ['kolamId' => $kolam->id]) }}" class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1 class="text-2xl font-bold">Monitoring</h1>
                    <div class="grid">
                        @if ($kolam->monitoring->isNotEmpty())
                        <div class="grid-cols-3/4">
                            <p>Suhu: {{ $kolam->monitoring->last()->suhu }}</p>
                            <p>PH: {{ $kolam->monitoring->last()->ph }}</p>
                            <p>DO: {{ $kolam->monitoring->last()->do }}</p>
                        </div>
                        @else
                        <p>Belum ada catatan monitoring.</p>
                        @endif
                    </div>
                </a>
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1>Sampling</h1>
                </div>
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1>Perlakuan</h1>
                </div>
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1>Panen</h1>
                </div>
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h1>Energi</h1>
                </div>
            </div>

            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full p-6">
                    <div class="m-4 flex flex-col items-center justify-center">
                        <h1 class="text-lg font-bold mb-4">Tidak ada siklus yang berjalan</h1>
                        <a href="{{ route('tambah_siklus', ['kolamId' => $kolam->id]) }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Buat Siklus Kolam
                        </a>
                    </div>
                </div>
            </div>


            @endif
        </div>
    </div>
</x-admin>
