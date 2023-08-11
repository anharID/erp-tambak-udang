<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <div class="flex flex-row items-center mb-4">
                {{-- Kembali --}}
                <a href="{{ route('data_kolam', ['kolam' => $kolam->id, 'siklus' => $siklus->id]) }}"
                    class="mr-2 flex items-center justify-center bg-gray-300 rounded-full w-8 h-8">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h1 class="font-bold text-2xl">Pakan Udang Kolam {{ $kolam->nama }}</h1>
            </div>

            @if ($dataPakan)
            <div class="mb-8">
                <select
                    class="mr-2 mb-2 w-60 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2"
                    name="chart" id="selectChart">
                    <option value="total_pakan" chartLabel="Pakan Harian" selected>
                        Grafik Pakan Harian</option>
                    <option value="total_pakan_kumulatif" chartLabel="Pakan Kumulatif">
                        Grafik Pakan Kumulatif</option>
                </select>
                <div class="min-w-0 h-96 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <canvas id="myChart">
                        <p>Your browser does not support the canvas element.</p>
                    </canvas>

                </div>
            </div>
            <div class="w-full p-6 my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Alert --}}
                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                @if ($siklusBerjalan)
                <a href="{{ route('pakan.create',  ['kolamId' => $kolam->id,'siklus'=>$siklus->id]) }}"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Catatan
                </a>
                @endif

                <div class="w-full mt-4">
                    <table class="w-full table-auto mt-4 datatable">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Waktu</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jenis Pakan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jumlah (Kg)</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Catatan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Validasi</th>
                                @if ($siklusBerjalan)
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @foreach($dataPakan as $row)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->waktu_pemberian }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->no_pakan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->jumlah_kg }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $row->is_validated == 0 ? 'Belum' :
                                    'Sudah' }}</td>

                                @if ($siklusBerjalan)
                                <td class="px-6 py-4 whitespace-nowrap flex">
                                    @can('hakTeknisi')
                                    @if ($row->is_validated == 0)
                                    <form
                                        action="{{ route('validasi_pakan', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'pakan'=>$row->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Aksi ini tidak dapat dibatalkan! Tandai catatan ini sebagai sudah divalidasi? ')"
                                            class="text-green-600 mr-4"><i
                                                class="fa-regular fa-circle-check"></i></button>
                                    </form>
                                    @endif
                                    @endcan
                                    @if ($row->is_validated == 0 || auth()->user()->role === "superadmin")
                                    <a href="{{ route('pakan.edit', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'pakan'=>$row->id]) }}"
                                        class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form
                                        action="{{ route('pakan.destroy', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'pakan'=>$row->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Aksi ini tidak dapat dibatalkan! Apakah Anda yakin ingin menghapus catatan ini? ')"
                                            class="text-red-600"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    @else
                                    -
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



            <h1 class="mb-4 font-bold text-2xl">Ringkasa Pakan</h1>
            <div class="w-full p-6 my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full table-auto mt-4 datatable">
                    <thead class="w-full bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Pakan Harian(Kg)</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Pakan Komulatif (Kg)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @foreach($ringkasan as $row)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->total_pakan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->total_pakan_kumulatif }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <h1>tidak ada siklus berjalan</h1>
        @endif
    </div>
</x-admin>

<script type="module" src="{{ Vite::asset('resources/js/chartPakan.js') }}" defer></script>
<script>
    const chartData = @JSON($chartData);
</script>