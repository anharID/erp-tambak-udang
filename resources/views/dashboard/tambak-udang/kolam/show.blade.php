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

            {{-- Kembali --}}
            <div class="mt-4">
                <a href="{{ route('kolam.index') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Daftar Kolam
                </a>
            </div>


            {{-- Nama Kolam --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
                <div class="col-span-1 md:col-span-2">
                    <h1 class="font-bold text-2xl">Kolam {{ $kolam->nama }}</h1>
                </div>
                <div class="col-span-1">
                    @if ($kolam->siklus->count()>0)
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
                    @endif
                </div>
            </div>

            @if ($kolam->siklus->count()>0)

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="col-span-1 md:col-span-2">
                    {{-- Fitur Manajemen Kolam --}}
                    <div class="grid grid-cols-1 gap-6 mb-8">
                        <a href="{{ route('monitoring.index', ['kolamId' => $kolam->id, 'siklus'=>$siklusTerpilih->id]) }}"
                            class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold">Monitoring</h1>
                            @if ($monitoring->isNotEmpty())
                            <p class="text-sm italic">Terakhir ditambahkan {{
                                $monitoring->last()->created_at->diffForHumans() }}
                            </p>
                            <div class="min-w-0 p-2 mt-2 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
                                <p>Suhu: {{ $monitoring->last()->suhu }} &deg;C</p>
                                <p>PH: {{ $monitoring->last()->ph }}</p>
                                <p>DO: {{ $monitoring->last()->do }}</p>
                            </div>
                            @else
                            <p class="text-sm italic">Belum ada catatan monitoring.</p>
                            @endif
                        </a>
                        <a href="{{ route('pakan.index', ['kolamId' => $kolam->id, 'siklus'=>$siklusTerpilih->id]) }}"
                            class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold">Pakan</h1>
                            @if ($pakan->isNotEmpty())
                            <p class="text-sm italic">Terakhir ditambahkan {{
                                $pakan->last()->created_at->diffForHumans() }}
                            </p>
                            <div class="min-w-0 p-2 mt-2 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
                                <p>Pakan terpakai hari ini {{ $jumlahPakanTerpakaiHariIni }} kg</p>
                                <p>Pakan terpakai Komulatif {{ $pakan->sum('jumlah_kg') }} kg</p>
                            </div>
                            @else
                            <p class="text-sm italic">Belum ada catatan pakan.</p>
                            @endif
                        </a>
                        <a href="{{ route('sampling.index', ['kolamId' => $kolam->id, 'siklus'=>$siklusTerpilih->id]) }}"
                            class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold">Sampling</h1>
                            @if ($sampling->isNotEmpty())
                            <p class="text-sm italic">Terakhir ditambahkan {{
                                $sampling->last()->created_at->diffForHumans() }}</p>
                            <div class="min-w-0 p-2 mt-2 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
                                <p>ADG : {{ $sampling->last()->adg }} gram</p>
                                <p>SR : {{ $sampling->last()->sr }} %</p>
                            </div>
                            @else
                            <p class="text-sm italic">Belum ada catatan sampling.</p>
                            @endif
                        </a>
                        <a href="{{ route('perlakuan.index', ['kolamId' => $kolam->id, 'siklus'=>$siklusTerpilih->id]) }}"
                            class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold">Perlakuan</h1>
                            @if ($perlakuan->isNotEmpty())
                            <p class="text-sm italic">Terakhir ditambahkan {{
                                $perlakuan->last()->created_at->diffForHumans() }}</p>
                            <div class="min-w-0 p-2 mt-2 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
                                <p>{!! nl2br(e($perlakuan->last()->catatan)) !!}</p>
                            </div>
                            @else
                            <p class="text-sm italic">Belum ada catatan perlakuan.</p>
                            @endif
                        </a>
                        <a href="{{ route('panen.index', ['kolamId' => $kolam->id, 'siklus'=>$siklusTerpilih->id]) }}"
                            class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold">Panen</h1>
                            @if ($panen->isNotEmpty())
                            <p class="text-sm italic">Terakhir ditambahkan {{
                                $panen->last()->created_at->diffForHumans() }}</p>
                            <div class="min-w-0 p-2 mt-2 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
                                <p>Status Panen : {{ $panen->last()->status }}</p>
                                <p>Tonase Panen : {{ $panen->last()->tonase_jumlah }} Kg</p>
                            </div>
                            @else
                            <p class="text-sm italic">Belum ada catatan Panen.</p>
                            @endif

                        </a>

                        <a href="{{ route('energi.index', ['kolamId' => $kolam->id, 'siklus'=>$siklusTerpilih->id]) }}"
                            class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold">Energi</h1>
                            @if ($energi->isNotEmpty())
                            <p class="text-sm italic">Terakhir ditambahkan {{
                                $energi->last()->created_at->diffForHumans() }}</p>
                            <div class="min-w-0 p-2 mt-2 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-700">
                                <p>penggunaan : {{ $energi->last()->penggunaan }}</p>
                                <p>Konsumsi energi : {{ $energi->last()->kwh }} kWh</p>
                                <p>Total konsumsi energi : {{ $energi->sum('kwh') }} kWh</p>
                            </div>
                            @else
                            <p class="text-sm italic">Belum ada catatan Energi.</p>
                            @endif

                        </a>
                    </div>
                </div>

                <div cl ass="col-span-1">
                    {{-- Informasi siklus dan kolam --}}
                    <div class="grid gap-6 grid-cols-1">
                        @if ($siklusSaatIni==null)
                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <div class="flex flex-col items-center justify-center">
                                <h1 class="text-lg font-bold mb-4">Tidak ada siklus yang berjalan</h1>
                            </div>
                        </div>
                        @endif
                        {{-- Informasi Kolam --}}
                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold mb-1">Profil Kolam</h1>
                            <p class="flex justify-between">
                                <span>Nama Kolam</span>
                                <span class="text-right">{{ $kolam->nama }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Lokasi</span>
                                <span class="text-right">{{ $kolam->lokasi }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Luas</span>
                                <span class="text-right">{{ $kolam->luas }} m&sup2;</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Kedalaman</span>
                                <span class="text-right">{{ $kolam->kedalaman }} m</span>
                            </p>
                        </div>

                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h1 class="text-xl font-bold mb-1">Siklus</h1>
                            @if ( $siklusTerpilih || $siklusTerpilih->id == $siklusSaatIni->id)
                            <p class="flex justify-between">
                                <span>Siklus Mulai</span>
                                <span class="text-right">{{ $siklusTerpilih->tanggal_mulai }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Doc</span>
                                <span class="text-right">{{ $siklusTerpilih->pivot->doc }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Total Tebar</span>
                                <span class="text-right">{{ $siklusTerpilih->pivot->jumlah_tebar }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Catatan</span>
                                <span class="text-right">{{ $siklusTerpilih->catatan ? $siklusTerpilih->catatan :
                                    '-'}}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>
                                    Siklus Selesai
                                </span>
                                <span class="text-right">
                                    {{ $siklusTerpilih->tanggal_selesai ? $siklusTerpilih->tanggal_selesai : 'Siklus
                                    berjalan' }}
                                </span>
                            </p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="m-4 flex flex-col items-center justify-center">
                    <h1 class="text-lg font-bold mb-4">Kolam tidak aktif atau belum memiliki siklus</h1>
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <h1 class="text-2xl font-bold mb-1">Profil Kolam</h1>
                <p class="flex justify-between">
                    <span>Nama Kolam</span>
                    <span class="text-right">{{ $kolam->nama }}</span>
                </p>
                <p class="flex justify-between">
                    <span>Lokasi</span>
                    <span class="text-right">{{ $kolam->lokasi }}</span>
                </p>
                <p class="flex justify-between">
                    <span>Luas</span>
                    <span class="text-right">{{ $kolam->luas }} m&sup2;</span>
                </p>
                <p class="flex justify-between">
                    <span>Kedalaman</span>
                    <span class="text-right">{{ $kolam->kedalaman }}</span>
                </p>
            </div>
        </div>
        @endif
    </div>
</x-admin>