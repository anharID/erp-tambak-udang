<x-admin>
    <div x-data="modalData">
        <div class="container grid py-12">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900   overflow-hidden">
                <h1 class="mb-4 font-bold text-xl">Manajemen Karyawan</h1>
                <div class="bg-white   shadow-sm sm:rounded-lg">
                    <div class="w- full p-6 overflow-hidden">
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                                <p class="font-bold">Success</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif

                        <a href="{{ route('karyawan.create') }}"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Karyawan
                        </a>
                        @can('hakSuperadmin')
                            <a href="{{ route('jabatan.index') }}"
                                class="ml-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                                Detail Jabatan
                            </a>
                        @endcan
                        <div class="w-full mt-4">
                            <table class="w-full table-auto mt-4 datatable hover">
                                <thead class="bg-gray-50  ">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500   uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500   uppercase tracking-wider">
                                            Nomor HP</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500   uppercase tracking-wider">
                                            Alamat Email</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500   uppercase tracking-wider">
                                            Jabatan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500   uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500   uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200    ">
                                    @foreach ($karyawan as $row)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->no_hp }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->jabatan->jabatan ?? '-'}}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->status}}</td>
                                            <td class="px-6 py-4 whitespace-nowrap flex">
                                                <button @click="showKaryawan({{ json_encode($row) }})" class="text-blue-600 mr-4"><i
                                                        class="fa-solid fa-eye"></i></button>
                                                <a href="{{ route('karyawan.edit', $row->id) }}"
                                                    class="text-yellow-600 mr-4"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <form action="{{ route('karyawan.destroy', $row->id) }}" method="POST">
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
                class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg   sm:rounded-lg sm:m-4 sm:max-w-xl"
                role="dialog" id="modal">
                <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                <header class="flex justify-end">
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded   hover: hover:text-gray-700"
                        aria-label="close" @click="showModal = false">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                            <path
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </button>
                </header>
                <!-- Modal body -->
                <div class="mt-3 mb-2">
                    <!-- Modal title -->
                    <p class="mb-3 text-lg font-semibold text-gray-700  ">
                        Data Karyawan
                    </p>
                    <!-- Modal description -->
                    <table class="table-fixed w-full border border-gray-200">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-2 w-1/4 font-medium ">Nama Karyawan</td>
                                <td class="py-2 " x-text="selectedData.nama"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Alamat</td>
                                <td class="py-2 " x-text="selectedData.alamat"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Tempat Lahir</td>
                                <td class="py-2 " x-text="selectedData.tempat_lahir"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Tanggal Lahir</th>
                                <td class="py-2 " x-text="formatDate(selectedData.tanggal_lahir)"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Nomor HP</td>
                                <td class="py-2 " x-text="selectedData.no_hp"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Email</td>
                                <td class="py-2 " x-text="selectedData.email"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Jabatan</td>
                                <td class="py-2 " x-text="selectedData.jabatan.jabatan"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Status</td>
                                <td class="py-2 " x-text="selectedData.status"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Gaji</td>
                                <td class="py-2 " x-text="formatCurrency(selectedData.jabatan.gaji)"></td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium ">Bonus</td>
                                <td class="py-2 " x-text="selectedData.jabatan.bonus + '%'"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <footer
                    class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50  ">
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

            showKaryawan(data) {
                this.selectedData = data;
                console.log(this.selectedData);
                this.showModal = true;
            },
        }))
    })
    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }
    function formatDate(date) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(date).toLocaleDateString('id-ID', options);
    }
</script>