@php
$param = request()->input('siklus_id');
@endphp
<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">

            <h1 class="mb-4 font-bold text-xl">Manajemen Finansial</h1>
            @if (!$param)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="text-sm italic mb-4">Tidak ada data siklus. Untuk memulai siklus
                    silahkan mulai siklus pada halaman <a href="{{ route('kolam.index') }}" class="underline"
                        target="_blank">Manajemen Tambak Udang</a>.</p>
            </div>
            @endif
            <div class="flex items-center mb-4">
                {{-- <span class="w-24">Pilih Siklus</span> --}}
                <select
                    class="mr-2 w-60 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2"
                    name="siklus_id" onchange="location = this.value;">
                    <option value="">Pilih Siklus</option>
                    @if ($siklusSaatIni)
                    <option value="{{ route('finansial.index', ['siklus_id' => $siklusSaatIni->id]) }}" {{
                        $param==$siklusSaatIni->id ? 'selected' : '' }}>
                        Siklus Aktif - {{ $siklusSaatIni->tanggal_mulai }}</option>
                    @endif
                    @foreach ($siklusSelesai as $item)
                    <option value="{{ route('finansial.index', ['siklus_id' => $item->id]) }}" {{ $param==$item->id ?
                        'selected' : '' }}>Siklus
                        {{ $item->tanggal_mulai }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-6 mb-8 md:grid-cols-1">
                <div class="min-w-0 h-96 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <canvas id="myChart">
                        <p>Your browser does not support the canvas element.</p>
                    </canvas>

                </div>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-3 sm:grid-cols-2">
                <div class="min-w-0 p-4 bg-blue-300 rounded-lg shadow-sm dark:bg-gray-800">
                    <p class="text-base mb-2">Saldo</p>
                    <p class="text-xl font-medium">
                        {{ 'Rp ' . number_format($saldo ?? 0, 2, ',', '.') }}
                    </p>
                </div>
                {{-- <div class="min-w-0 p-4 bg-blue-300 rounded-lg shadow-sm  ">
                    <p class="text-base mb-2">Saldo Hari Ini</p>
                    <p class="text-xl font-medium">
                        {{ 'Rp ' . number_format(($totalSaldoAwal + $totalPemasukan - $totalPengeluaran) ?? 0, 2, ',',
                        '.') }}
                    </p>
                </div> --}}
                {{-- <div class="min-w-0 p-4 bg-orange-300 rounded-lg shadow-sm  ">
                    <p class="text-base mb-2">Laba/Rugi</p>
                    <p class="text-xl font-medium">
                        {{ 'Rp ' . number_format($totalPemasukan - $totalPengeluaran ?? 0, 2, ',', '.') }}
                    </p>
                </div> --}}
                <div class="min-w-0 p-4 bg-green-300 rounded-lg shadow-sm dark:bg-gray-800">
                    <p class="text-base mb-2">Pemasukan</p>
                    <p class="text-xl font-medium">{{ 'Rp ' . number_format($totalPemasukan ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="min-w-0 p-4 bg-red-300 rounded-lg shadow-sm dark:bg-gray-800">
                    <p class="text-base mb-2">Pengeluaran</p>
                    <p class="text-xl font-medium">{{ 'Rp ' . number_format($totalPengeluaran ?? 0, 2, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="bg-white mb-8 dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <tbody>
                        <tr>
                            <td class="w-4/5 p-4">Penjualan Udang</td>
                            <td class="w-1/5 p-4">{{ 'Rp ' . number_format($totalPenjualan ?? 0, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="w-4/5 p-4">Keuntungan Kotor</td>
                            <td class="w-1/5 p-4">{{ 'Rp ' . number_format($keuntunganKotor ?? 0, 2, ',', '.') }}</td>
                        </tr>
                        <tr>

                            <td class="w-4/5 p-4">Total Bonus Karyawan <button @click="openModal"
                                    class="inline-block hover:cursor-pointer bg-blue-500 text-white text-xs ml-1 px-2 py-1 rounded-full">Lihat</button>
                            </td>
                            <td class="w-1/5 p-4">{{ 'Rp ' . number_format($totalBonusKaryawan ?? 0, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w- full p-6 overflow-hidden">
                    @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    <a href="{{ route('finansial.create', ['siklus_id' => $param]) }}"
                        class="px-4 py-2 inline-block text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Catatan Finansial
                    </a>
                    <a href="{{ route('finansial_exportpdf', $param ?? '') }}" target="_blank"
                        class="px-4 py-2 inline-block text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                        <i class="fa-regular fa-file-pdf mr-1"></i> Cetak Laporan Keuangan
                    </a>
                    <div class="w-full mt-4">
                        <table class="w-full table-auto mt-4 datatable hover display nowrap">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jenis Transaksi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Keterangan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jumlah</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Catatan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach ($finansialList as $row)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $row->tanggal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->jenis_transaksi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->keterangan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ 'Rp ' . number_format($row->jumlah, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex">
                                        <a href="{{ route('finansial.edit', $row->id) }}"
                                            class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('finansial.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                class="text-red-600"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
        <!-- Modal -->
        <div x-cloak x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
            @keydown.escape="closeModal"
            class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog" id="modal">
            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
            <header class="flex justify-end">
                <button
                    class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                    aria-label="close" @click="closeModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                        <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </header>
            <!-- Modal body -->
            <div class="mt-4 mb-6">
                <!-- Modal title -->
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    Bonus Karyawan
                </p>
                <!-- Modal description -->
                <table class="w-full table-auto mt-4 datatable hover display nowrap ">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nama</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bonus</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nominal</th>
                            @can('aksesKaryawan')    
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @foreach ($karyawan as $row)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $row->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $row->jabatan->bonus . '%' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">
                                {{ 'Rp ' . number_format(($row->jabatan->bonus / 100) * $keuntunganKotor, 2, ',', '.')
                                }}
                            </td>
                            @can('aksesKaryawan')
                            <td class="px-6 py-4 whitespace-nowrap flex dark:text-gray-300">
                                <a href="{{ route('karyawan.edit', $row->id) }}" target="_blank"
                                    class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer
                class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
            </footer>
        </div>
    </div>
    <!-- End of modal backdrop -->
</x-admin>
<script type="module" src="{{ Vite::asset('resources/js/chartFinansial.js') }}" defer></script>
<script>
    const chartDataPemasukan = @JSON($pemasukanBulanan);
    const chartDataPengeluaran = @JSON($pengeluaranBulanan);
</script>