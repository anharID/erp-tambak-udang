<x-admin>
    <div x-data="modalData">
        <div class="container grid py-12">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
                <div class="flex flex-row items-center mb-4">
                    {{-- Kembali --}}
                    <a href="{{ route('data_kolam', ['kolam' => $kolam->id, 'siklus' => $siklus->id]) }}"
                        class="mr-2 flex items-center justify-center bg-gray-300 dark:bg-slate-500 rounded-full w-8 h-8">
                        <i class="fa-solid fa-arrow-left fa-lg"></i>
                    </a>
                    <h1 class="font-bold text-2xl">Monitoring Kualitas Air Kolam {{ $kolam->nama }}</h1>
                </div>
                @if ($siklusTerpilih)
                <div class="mb-8">
                    <select
                        class="mr-2 mb-2 w-60 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2"
                        name="chart" id="selectChart">
                        <option value="suhu" chartLabel="Suhu" selected>
                            Grafik Suhu</option>
                        <option value="ph" chartLabel="pH">
                            Grafik pH</option>
                        <option value="do" chartLabel="DO">
                            Grafik DO</option>
                        <option value="salinitas" chartLabel="Salinitas">
                            Grafik Salinitas</option>
                        <option value="kecerahan" chartLabel="Kecerahan Air">
                            Grafik Kecerahan Air</option>
                        <option value="tinggi_air" chartLabel="Tinggi Air">
                            Grafik Tinggi Air</option>
                    </select>
                    <div class="min-w-0 h-96 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                        <canvas id="myChart">
                            <p>Your browser does not support the canvas element.</p>
                        </canvas>

                    </div>
                </div>
                <div class="my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="w-full p-6">

                        {{-- Alert --}}
                        @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                        @endif


                        @if ($siklusBerjalan)
                        <a href="{{ route('monitoring.create', ['kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Catatan
                        </a>
                        @endif

                        <div class="w-full overflow-x-auto mt-4">
                            <table class="min-w-full table-auto mt-4 datatable hover">
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
                                            Suhu</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            pH</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            DO</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Salinitas</th>
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
                                    @foreach ($siklusTerpilih as $row)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->waktu_pengukuran }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->suhu }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->ph }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->do }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->salinitas }}</td>
                                        <div class="hidden">{{ $row->kolam }}</div>
                                        <div class="hidden">{{ $row->siklus }}</div>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $row->is_validated == 0 ? 'Belum' : 'Sudah' }}
                                        </td>

                                        @if ($siklusBerjalan)
                                        <td class="px-6 py-4 whitespace-nowrap flex">
                                            @can('hakTeknisi')
                                            @if ($row->is_validated == 0)
                                            <form
                                                action="{{ route('validasi_monitoring', ['kolamId' => $kolam->id, 'siklus' => $siklus->id, 'monitoring' => $row->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Aksi ini tidak dapat dibatalkan! Tandai catatan ini sebagai sudah divalidasi? ')"
                                                    class="text-green-600 mr-4"><i
                                                        class="fa-regular fa-circle-check"></i></button>
                                            </form>
                                            @endif
                                            @endcan
                                            @if ($row->is_validated == 0 || auth()->user()->role === 'superadmin')
                                            <button @click="showMonitoring({{ json_encode($row) }})"
                                                class="text-blue-600 mr-4"><i class="fa-solid fa-eye"></i></button>
                                            <a href="{{ route('monitoring.edit', ['kolamId' => $kolam->id, 'siklus' => $siklus->id, 'monitoring' => $row->id]) }}"
                                                class="text-yellow-600 mr-4"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form
                                                action="{{ route('monitoring.destroy', ['kolamId' => $kolam->id, 'siklus' => $siklus->id, 'monitoring' => $row->id]) }}"
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
                </div>
                @else
                <h1>tidak ada siklus berjalan</h1>



                @endif
            </div>
        </div>

        <!-- Modal backdrop. This what you want to place close to the closing body tag -->
        <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
            <!-- Modal -->
            <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="showModal = false"
                @keydown.escape="showModal = false"
                class="w-full h-4/5 px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                role="dialog" id="modal">
                <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                <header class="flex justify-end">
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                        aria-label="close" @click="showModal = false">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                            <path
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </button>
                </header>
                <!-- Modal body -->
                <div class="mt-3 mb-2 overflow-auto h-full">
                    <!-- Modal title -->
                    <p class="mb-3 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Data Monitoring
                    </p>
                    <!-- Modal description -->
                    <table class="table-fixed w-full border border-gray-200 mb-14">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="p-2 w-1/4 font-medium dark:text-gray-300">Siklus</td>
                                <td class="p-2 dark:text-gray-300" x-text={{ 'selectedData.siklus.tanggal_mulai' }}>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Kolam</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.kolam.nama"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Tanggal</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.tanggal"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Waktu Pengukuran</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.waktu_pengukuran"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Suhu</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.suhu + ' &deg;C'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">pH</th>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.ph"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">DO</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.do + ' mg/L'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Salinitas</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.salinitas + ' ppt'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Kecerahan</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.kecerahan + ' cm'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Warna Air</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.warna_air"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Tinggi Air</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.tinggi_air + ' cm'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Cuaca</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.cuaca"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Amonia</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.amonia ?? '-' + ' ppm'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Nitrit</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.nitrit ?? '-' + ' ppm'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Validasi</td>
                                <td class="py-2 dark:text-gray-300"
                                    x-text="selectedData.is_validated ? 'Sudah' : 'Belum'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Catatan</td>
                                <td class="p-2 break-words dark:text-gray-300" x-text="selectedData.catatan"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <footer
                    class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                </footer>
            </div>
        </div>
        <!-- End of modal backdrop -->
    </div>
</x-admin>
<script type="module" src="{{ Vite::asset('resources/js/chartMonitoring.js') }}" defer></script>
<script>
    const chartData = @JSON($chartData);
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalData', () => ({
            showModal: false,
            selectedData: {},

            showMonitoring(data) {
                this.selectedData = data;
                this.showModal = true;
            },
        }))
    })
</script>