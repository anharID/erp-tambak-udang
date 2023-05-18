<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-xl">Kolam {{ $kolam->nama }}</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full p-6">

                    {{-- Alert  --}}
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    {{-- Tambah Siklus --}}
                    {{-- @if ($kolam->siklus->isEmpty() || $kolam->siklus->whereNull('tanggal_selesai')->isEmpty())
                    
                    @endif --}}

                    @if ($siklusSaatIni)
                    <h3>Siklus Saat Ini</h3>
                    <p>Tanggal Mulai: {{ $siklusSaatIni->tanggal_mulai }}</p>
                    @else
                    <div class="m-4 flex flex-col items-center justify-center">
                        <h1 class="text-lg font-bold mb-4">Tidak ada siklus yang berjalan</h1>
                        <a href="{{ route('tambah_siklus', ['kolamId' => $kolam->id]) }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Buat Siklus Kolam
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-admin>
