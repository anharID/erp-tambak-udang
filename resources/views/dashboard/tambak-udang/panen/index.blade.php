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
                    <h1 class="font-bold text-2xl">Panen Udang Kolam {{ $kolam->nama }}</h1>
                </div>

                @if ($siklusTerpilih)
                <div class="my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="w-full p-6">

                        {{-- Alert --}}
                        @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                        @endif
                        {{-- @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-current h-6 w-6 text-red-500" role="button"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <title>Close</title>
                                    <path
                                        d="M14.348 14.849c-.244.244-.642.243-.885-.001l-3.464-3.464-3.464 3.464c-.243.243-.642.244-.885.001-.244-.244-.243-.642.001-.885l3.464-3.464-3.464-3.464c-.244-.244-.244-.642 0-.885.243-.243.642-.244.885 0l3.464 3.464 3.464-3.464c.243-.244.642-.243.885 0 .244.243.243.641-.001.885l-3.464 3.464 3.464 3.464c.243.243.243.641 0 .885z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        @endif --}}

                        @if ($siklusBerjalan)
                        <a href="{{ route('panen.create', ['kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Catatan
                        </a>
                        @endif

                        <div class="w-full overflow-x-auto mt-4">
                            <table class="min-w-full table-auto mt-4 datatable">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                            rowspan="2">
                                            Tanggal Panen</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                            rowspan="2">
                                            Waktu Panen</th>
                                        <th style="text-align:center;"
                                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                            colspan="3">
                                            Tonase</th>
                                        <th style="text-align:center;"
                                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                            colspan="2">
                                            Size</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                            rowspan="2">
                                            Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                            rowspan="2">
                                            Validasi</th>
                                        @if ($siklusBerjalan)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                            rowspan="2">
                                            Aksi</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Besar</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Kecil</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Jumlah</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Besar</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Kecil</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                    @foreach ($siklusTerpilih as $row)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->waktu_panen }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tonase_besar }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tonase_kecil }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->tonase_jumlah }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->size_besar }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->size_kecil }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->status }}</td>
                                        <div class="hidden">{{ $row->siklus }}</div>
                                        <div class="hidden">{{ $row->kolam }}</div>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $row->is_validated == 0 ? 'Belum' : 'Sudah' }}
                                        </td>

                                        @if ($siklusBerjalan)
                                        <td class="px-6 py-4 whitespace-nowrap flex">
                                            @can('hakTeknisi')
                                            @if ($row->is_validated == 0)
                                            <form
                                                action="{{ route('validasi_panen', ['kolamId' => $kolam->id, 'siklus' => $siklus->id, 'panen' => $row->id]) }}"
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
                                            <button @click="showModalData({{ json_encode($row) }})"
                                                class="text-blue-600 mr-4"><i class="fa-solid fa-eye"></i></button>
                                            <a href="{{ route('panen.edit', ['kolamId' => $kolam->id, 'siklus' => $siklus->id, 'panen' => $row->id]) }}"
                                                class="text-yellow-600 mr-4"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form
                                                action="{{ route('panen.destroy', ['kolamId' => $kolam->id, 'siklus' => $siklus->id, 'panen' => $row->id]) }}"
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
                        Data Panen
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
                                <td class="p-2 font-medium dark:text-gray-300">Waktu Panen</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.waktu_panen"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Tonase Besar</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.tonase_besar + ' kg'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Tonase Kecil</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.tonase_kecil + ' kg'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Tonase Jumlah</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.tonase_jumlah + ' kg'"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Size Besar</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.size_besar"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Size Kecil</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.size_kecil"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Populasi</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.populasi_terambil"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">ABW</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.abw"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Status</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.status"></td>
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
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalData', () => ({
            showModal: false,
            selectedData: {},

            showModalData(data) {
                this.selectedData = data;
                console.log(this.selectedData);
                this.showModal = true;
            },
        }))
    })
</script>