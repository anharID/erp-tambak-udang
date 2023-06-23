<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-xl">Manajemen Finansial</h1>
            <div class="grid gap-6 mb-8 md:grid-cols-1">
                <div class="min-w-0 h-96 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <canvas id="myChart">
                        <p>Your browser does not support the canvas element.</p>
                    </canvas>

                </div>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-4 sm:grid-cols-2">
                <div class="min-w-0 p-4 bg-blue-300 rounded-lg shadow-sm dark:bg-gray-800">
                    <p class="text-base mb-2">Saldo Hari Ini</p>
                    <p class="text-xl font-medium">{{ 'Rp ' . number_format($finansial->last()->total_saldo ?? 0, 2, ',', '.') }}
                    </p>
                </div>
                <div class="min-w-0 p-4 bg-orange-300 rounded-lg shadow-sm dark:bg-gray-800">
                    <p class="text-base mb-2">Laba/Rugi</p>
                    <p class="text-xl font-medium">
                        {{ 'Rp ' . number_format($totalPemasukan - $totalPengeluaran ?? 0, 2, ',', '.') }}
                    </p>
                </div>
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
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w- full p-6 overflow-hidden">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <a href="{{ route('finansial.create') }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Catatan Finansial
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
                                @foreach ($finansial as $row)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->jenis_transaksi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->keterangan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ 'Rp ' . number_format($row->jumlah, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap flex">
                                            <a href="{{ route('finansial.edit', $row->id) }}"
                                                class="text-yellow-600 mr-4"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form action="{{ route('finansial.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
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
</x-admin>
<script type="module" src="{{ Vite::asset('resources/js/chartFinansial.js') }}" defer></script>
<script>
    const chartDataPemasukan = @JSON($chartDataPemasukan);
    const chartDataPengeluaran = @JSON($chartDataPengeluaran);
</script>
