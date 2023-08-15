<x-admin>
    <div x-data="editModal">
        <div class="container grid py-12">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
                <div class="flex flex-row items-center mb-4">
                    {{-- Kembali --}}
                    <a href="{{ route('karyawan.index') }}"
                        class="mr-2 flex items-center justify-center bg-gray-300 rounded-full w-7 h-7">
                        <i class="fa-solid fa-arrow-left fa-md"></i>
                    </a>
                    <h1 class="font-bold text-xl">Detail Jabatan</h1>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="w- full p-6 overflow-hidden">
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4"
                                role="alert">
                                <p class="font-bold">Success</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif

                        <button @click="openModal"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Data
                        </button>
                        <div class="w-full mt-4">
                            <table class="w-full table-auto mt-4 datatable hover">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Jabatan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Gaji</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Bonus</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                    @foreach ($jabatan as $row)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->jabatan }}</td>
                                            <td class="px-6 py-4">{{ 'Rp ' . number_format($row->gaji, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->bonus . '%' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap flex">
                                                <button @click="showEditJabatan({{ json_encode($row) }})"
                                                    class="text-yellow-600 mr-4"><i
                                                        class="fa-solid fa-pen-to-square"></i></button>
                                                <form action="{{ route('jabatan.destroy', $row->id) }}" method="POST">
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
        <div x-cloak x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
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
                <div class="mt-4 mb-2">
                    <!-- Modal title -->
                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Tambah Jabatan
                    </p>
                    <!-- Modal description -->
                    <form method="POST" action="{{ route('jabatan.store') }}">
                        @csrf

                        <!-- Jabatan -->
                        <div>
                            <x-input-label for="jabatan" :value="__('Jabatan')" />
                            <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan"
                                :value="old('jabatan')" required autofocus autocomplete="jabatan" />
                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>

                        <!-- Gaji -->
                        <div class="mt-4">
                            <x-input-label for="gaji" :value="__('Gaji')" />
                            <x-text-input id="gaji" class="block mt-1 w-full" type="number" name="gaji"
                                min="0" :value="old('gaji')" required autocomplete="gaji" />
                            <x-input-error :messages="$errors->get('gaji')" class="mt-2" />
                        </div>

                        <!-- Bonus -->
                        <div class="mt-4">
                            <x-input-label for="bonus" :value="__('Bonus (%)')" />
                            <x-text-input id="bonus" class="block mt-1 w-full" type="number" name="bonus"
                                min="0" :value="old('bonus')" required autocomplete="bonus" />
                            <x-input-error :messages="$errors->get('bonus')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                <footer
                    class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                </footer>
            </div>
        </div>
        <!-- End of modal backdrop -->

        <!-- Modal backdrop. This what you want to place close to the closing body tag -->
        <div x-cloak x-show="showModalEdit" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
            <!-- Modal -->
            <div x-cloak x-show="showModalEdit" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="showModalEdit = false"
                @keydown.escape="showModalEdit= false"
                class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                role="dialog" id="modalEdit">
                <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                <header class="flex justify-end">
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                        aria-label="close" @click="showModalEdit = false">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img"
                            aria-hidden="true">
                            <path
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </button>
                </header>
                <!-- Modal body -->
                <div class="mt-4 mb-2">
                    <!-- Modal title -->
                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Ubah Jabatan
                    </p>
                    <!-- Modal description -->
                    <form method="POST" id="update-form">
                        @csrf
                        @method('put')

                        <!-- Jabatan -->
                        <div>
                            <x-input-label for="jabatan" :value="__('Jabatan')" />
                            <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan"
                                x-model="selectedData.jabatan" required autofocus autocomplete="jabatan" />
                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>

                        <!-- Gaji -->
                        <div class="mt-4">
                            <x-input-label for="gaji" :value="__('Gaji')" />
                            <x-text-input id="gaji" class="block mt-1 w-full" type="number" name="gaji"
                                min="0" x-model="selectedData.gaji" required autocomplete="gaji" />
                            <x-input-error :messages="$errors->get('gaji')" class="mt-2" />
                        </div>

                        <!-- Bonus -->
                        <div class="mt-4">
                            <x-input-label for="bonus" :value="__('Bonus (%)')" />
                            <x-text-input id="bonus" class="block mt-1 w-full" type="number" name="bonus"
                                min="0" x-model="selectedData.bonus" required autocomplete="bonus" />
                            <x-input-error :messages="$errors->get('bonus')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Data') }}
                            </x-primary-button>
                        </div>
                    </form>
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
    const form = document.getElementById('update-form')
    document.addEventListener('alpine:init', () => {
        Alpine.data('editModal', () => ({
            showModalEdit: false,
            selectedData: {},

            showEditJabatan(data) {
                this.selectedData = data;
                this.showModalEdit = true;
                form.action = `/jabatan/${this.selectedData.id}`
            },
        }))
    })
</script>
