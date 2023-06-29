<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Data Peralatan</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('peralatan.update', $peralatan->id) }}">
                        @csrf
                        @method('put')

                        <!-- Nama Alat-->
                        <div>
                            <x-input-label for="nama_alat" :value="__('Nama Alat')" />
                            <x-text-input id="nama_alat" class="block mt-1 w-full" type="text" name="nama_alat" :value="$peralatan->nama_alat ?? old('nama_alat')" required autofocus autocomplete="nama_alat" />
                            <x-input-error :messages="$errors->get('nama_alat')" class="mt-2" />
                        </div>

                        <!-- Jumlah Alat -->
                        <div class="mt-4">
                            <x-input-label for="jumlah_alat" :value="__('Jumlah Alat')" />
                            <x-text-input id="jumlah_alat" class="block mt-1 w-full" type="number" name="jumlah_alat" :value="$peralatan->jumlah_alat ?? old('jumlah_alat')" required autocomplete="jumlah_alat" />
                            <x-input-error :messages="$errors->get('jumlah_alat')" class="mt-2" />
                        </div>

                        <!-- Kondisi Alat -->
                        <div class="mt-4">
                            <x-input-label for="kondisi_alat" :value="__('Kondisi Alat')" />
                            <select name="kondisi_alat" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                <option value="Baik" {{ $peralatan->kondisi_alat == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Tidak baik" {{ $peralatan->kondisi_alat == 'Tidak baik' ? 'selected' : '' }}>Tidak Baik</option>
                            </select>

                            <x-input-error :messages="$errors->get('kondisi_alat')" class="mt-2" />
                        </div>

                        <!-- Maintenance -->
                        <div class="mt-4">
                            <x-input-label for="maintenance" :value="__('Maintenance')" />
                            <input type="radio" id="sedang_maintenance" name="maintenance" value="1" class="form-radio h-3 w-3 mx-1" {{ $peralatan->maintenance == '1' ? 'checked' : '' }}>
                            <x-input-label for="sedang_maintenance" class="inline font-normal">Sedang Maintenance</x-input-label><br>
                            <input type="radio" id="tidak_sedang_maintenance" name="maintenance" value="0" class="form-radio h-3 w-3 mx-1" {{ $peralatan->maintenance == '0' ? 'checked' : '' }}>
                            <x-input-label for="tidak_sedang_maintenance" class="inline font-normal">Tidak Sedang Maintenance</x-input-label><br>
                            <x-input-error :messages="$errors->get('maintenance')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan" min="0" :value="$peralatan->catatan ?? old('catatan')" autocomplete="catatan" />
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Ubah Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-admin>
