@php
$currentRoute = request()->url();
@endphp
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex flex-row items-center">
                        {{-- Kembali --}}
                        <a href="{{ route('kolam.index') }}"
                            class="mr-2 flex items-center justify-center bg-gray-300 dark:bg-slate-500 rounded-full w-8 h-8">
                            <i class="fa-solid fa-arrow-left fa-lg"></i>
                        </a>
                        <h1 class="font-bold text-2xl">Kolam {{ $kolam->nama }}</h1>
                    </div>
                </div>
                <div class="col-span-1">
                    @if ($kolam->siklus->count()>0)
                    <select
                        class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2"
                        onchange="location = this.value;">
                        <option value="" selected disabled>Silahkan Pilih Siklus</option>
                        @if ($siklusSaatIni)
                        <option value="{{ route('data_kolam', ['kolam'=>$kolam->id, 'siklus'=>$siklusSaatIni->id]) }}"
                            {{ $siklusTerpilih->id == $siklusSaatIni->id ? 'selected' : '' }}>
                            {{ $siklusSaatIni->tanggal_mulai }} - Siklus Aktif</option>
                        @endif
                        @foreach ($siklusSelesai as $item)
                        <option value="{{ route('data_kolam', [$kolam->id, $item->id]) }}" {{ $siklusTerpilih->id ==
                            $item->id ? 'selected' : '' }}>Siklus {{
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
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $monitoring->last()->suhu }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                &deg;C</span></p>
                                        <p class="flex justify-center">Suhu</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $monitoring->last()->ph }} </p>
                                        <p class="flex justify-center">pH</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $monitoring->last()->do }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300"> mg/L</span>
                                        </p>
                                        <p class="flex justify-center">DO</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $monitoring->last()->salinitas }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                ppt</span></p>
                                        <p class="flex justify-center text">Salinitas</p>
                                    </div>
                                </div>
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
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $jumlahPakanTerpakaiHariIni }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                Kg</span></p>
                                        <p class="flex justify-center">Pakan terpakai hari ini</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $pakan->sum('jumlah_kg') }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                Kg</span></p>
                                        <p class="flex justify-center">Pakan terpakai Komulatif</p>
                                    </div>
                                </div>
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
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $sampling->last()->adg }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                gr</span></p>
                                        <p class="flex justify-center">ADG</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $sampling->last()->biomas }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                Kg</span></p>
                                        <p class="flex justify-center">Biomassa</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $sampling->last()->sr }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                %</span></p>
                                        <p class="flex justify-center">SR</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $sampling->last()->fcr }}
                                            {{-- <span class="text-sm text-gray-600">%</span> --}}
                                        </p>
                                        <p class="flex justify-center">FCR</p>
                                    </div>
                                </div>
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
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $panen->last()->tonase_jumlah }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                Kg</span></p>
                                        <p class="flex justify-center">Panen terakhir ({{ $panen->last()->status }})</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $panen->sum('tonase_jumlah') }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                Kg</span></p>
                                        <p class="flex justify-center">Total tonase panen</p>
                                    </div>
                                </div>
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
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $energi->last()->kwh }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                KWh</span></p>
                                        <p class="flex justify-center">Penggunaan terakhir ({{
                                            $energi->last()->penggunaan->penggunaan }})</p>
                                    </div>
                                    <div class="grid-cols-1">
                                        <p class="flex justify-center text-xl font-semibold">{{
                                            $energi->sum('kwh') }} <span
                                                class="text-sm text-gray-600 dark:text-gray-300">
                                                KWh</span></p>
                                        <p class="flex justify-center">Penggunaan total</p>
                                    </div>
                                </div>
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
                            <p class="flex justify-between">
                                <span>Tipe Kolam</span>
                                <span class="text-right">{{ $kolam->tipe }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Status Kolam</span>
                                <span class="text-right">{{ $kolam->status == 1 ? "Aktif" : "Tidak Aktif" }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span>Catatan</span>
                                <span class="text-right">{{ $kolam->catatan ?? "-"}}</span>
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
                <p class="flex justify-between">
                    <span>Tipe Kolam</span>
                    <span class="text-right">{{ $kolam->tipe }}</span>
                </p>
                <p class="flex justify-between">
                    <span>Status Kolam</span>
                    <span class="text-right">{{ $kolam->status == 1 ? "Aktif" : "Tidak Aktif" }}</span>
                </p>
                <p class="flex justify-between">
                    <span>Catatan</span>
                    <span class="text-right">{{ $kolam->catatan}}</span>
                </p>
            </div>
        </div>
        @endif
    </div>
</x-admin>