<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">

            {{-- Alert --}}
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            {{-- Nama Kolam --}}
            <div>
                <h1 class="mb-4 font-bold text-2xl">Kolam {{ $kolam->nama }}</h1>
            </div>

            {{-- Kembali --}}
            <a href="{{ route('kolam.index') }}"
                class="mr-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Daftar Kolam
            </a>




            {{-- Informasi siklus dan kolam --}}
            <div class="grid gap-6 my-8 md:grid-cols-2">
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1 class="text-2xl font-bold mb-1">Siklus</h1>

                    @if ($kolam->siklus->count()>0)
                    {{-- <h2>Pilih Siklus</h2> --}}
                    <select
                        class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2"
                        onchange="location = this.value;">
                        <option value="" selected disabled>Silahkan Pilih Siklus</option>
                        @if ($siklusSaatIni)
                        <option value="{{ route('data_kolam', ['kolam'=>$kolam->id, 'siklus'=>$siklusSaatIni->id]) }}">
                            Siklus Aktif - {{ $siklusSaatIni->tanggal_mulai }}</option>
                        @endif
                        @foreach ($siklusSelesai as $item)
                        <option value="{{ route('data_kolam', [$kolam->id, $item->id]) }}">Siklus {{
                            $item->tanggal_mulai }}</option>
                        @endforeach
                    </select>

                    @if ( $siklusTerpilih || $siklusTerpilih->id == $siklusSaatIni->id)
                    <p>Siklus Mulai : {{ $siklusTerpilih->tanggal_mulai }}</p>
                    <p>Doc : {{ $siklusTerpilih->doc }}</p>
                    <p>Total Tebar : {{ $siklusTerpilih->total_tebar }}</p>
                    @if ($siklusSaatIni == $siklusTerpilih)
                    <form action="{{ route('tutup_siklus', ['kolamId' => $kolam->id]) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="my-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded "
                            onclick="return confirm('Apakah Anda yakin ingin menutup siklus saat ini?')">Tutup
                            Siklus</button>
                    </form>
                    @else
                    <p>Siklus Selesai {{ $siklusTerpilih->tanggal_selesai }}</p>
                    @endif
                    @endif

                    @if ($siklusSaatIni==null)
                    <div class="flex flex-col items-center justify-center border-t-2">
                        <h1 class="text-lg font-bold mb-4">Tidak ada siklus yang berjalan</h1>
                        <a href="{{ route('tambah_siklus', ['kolamId' => $kolam->id]) }}"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Buat Siklus Kolam
                        </a>
                    </div>
                    @endif

                    @else
                    <div class="m-4 flex flex-col items-center justify-center">
                        <h1 class="text-lg font-bold mb-4">Tidak ada siklus yang berjalan</h1>
                        <a href="{{ route('tambah_siklus', ['kolamId' => $kolam->id]) }}"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Buat Siklus Kolam
                        </a>
                    </div>
                    @endif
                </div>
                {{-- Informasi Kolam --}}
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1 class="text-2xl font-bold mb-1">Profil Kolam</h1>
                    <p>Nama Kolam : {{ $kolam->nama }}</p>
                    <p>Lokasi : {{ $kolam->lokasi }}</p>
                    <p>Luas : {{ $kolam->luas }}</p>
                    <p>Kedalaman : {{ $kolam->kedalaman }}</p>
                </div>
            </div>

            {{-- Fitur Manajemen Kolam --}}
            @if ($kolam->siklus->count()>0)
            <h1 class="mb-4 font-bold text-2xl">Fitur Manajemen Kolam</h1>
            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <a href="{{ route('monitoring', ['kolamId' => $kolam->id, 'siklus'=>$siklusTerpilih->id]) }}"
                    class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h1 class="text-2xl font-bold">Monitoring</h1>
                    <div class="grid">
                        @if ($monitoring->isNotEmpty())
                        <div class="grid-cols-3/4">
                            <p>Suhu: {{ $monitoring->last()->suhu }}</p>
                            <p>PH: {{ $monitoring->last()->ph }}</p>
                            <p>DO: {{ $monitoring->last()->do }}</p>
                        </div>
                        @else
                        <p>Belum ada catatan monitoring.</p>
                        @endif
                    </div>
                </a>
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
            @endif
        </div>
    </div>
</x-admin>