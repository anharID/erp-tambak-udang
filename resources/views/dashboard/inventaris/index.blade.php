<x-admin>
    <div x-data="modalData">
        <div class="container grid py-12">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
                <h1 class="mb-4 font-bold text-xl">Manajemen Inventaris</h1>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="w- full p-6 overflow-hidden">
                        @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                        @endif

                        <a href="{{ route('inventaris.create') }}"
                            class="px-4 py-2 mr-4 inline-block text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Inventaris
                        </a>
                        @can('hakSuperadmin')
                        <a href="{{ route('kelola_barang') }}"
                            class="px-4 py-2 inline-block text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            Kelola Jenis Barang
                        </a>
                        @endcan

                        <div class="w-full overflow-x-auto mt-4">
                            <table class="w-full table-auto mt-4 hover display nowrap datatable">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nama Item</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Jenis Item</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Stok</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                    @foreach($inventaris as $row)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('logistik.index', $row->id) }}">{{ $row->nama_barang
                                                }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->kelolajenisbarang->jenisbarang
                                            }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->stok }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap flex">
                                            <button @click="showInventaris({{ json_encode($row) }})"
                                                class="text-blue-600 mr-4"><i class="fa-solid fa-eye"></i></button>
                                            <a href="{{ route('inventaris.edit', $row->id) }}"
                                                class="text-yellow-600 mr-4"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form action="{{ route('inventaris.destroy', $row->id) }}" method="POST">
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
                        Data Inventaris
                    </p>
                    <!-- Modal description -->
                    <table class="table-fixed w-full border border-gray-200 mb-14">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="p-2 w-1/4 font-medium dark:text-gray-300">Nama Barang</td>
                                <td class="p-2 dark:text-gray-300" x-text={{ 'selectedData.nama_barang' }}>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Jenis Barang</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.kelolajenisbarang.jenisbarang">
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Tanggal Peroleh</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.tanggal_peroleh"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Stok</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.stok"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Harga Satuan</td>
                                <td class="p-2 dark:text-gray-300" x-text="'Rp. ' + selectedData.harga_satuan"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Nilai Inventaris</th>
                                <td class="p-2 dark:text-gray-300" x-text="'Rp. ' + selectedData.nilai_inventaris"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Lokasi</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.lokasi"></td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium dark:text-gray-300">Status</td>
                                <td class="p-2 dark:text-gray-300" x-text="selectedData.status'"></td>
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

    </div>
</x-admin>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalData', () => ({
            showModal: false,
            selectedData: {},

            showInventaris(data) {
                this.selectedData = data;
                this.showModal = true;
            },
        }))
    })
</script>