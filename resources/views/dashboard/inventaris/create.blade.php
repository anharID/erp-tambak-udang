<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Inventaris</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('inventaris.store') }}">
                        @csrf

                        <!-- Nama Barang -->
                        <div>
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required autofocus autocomplete="nama_barang" />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <!-- Jenis Barang -->
                        <div class="mt-4">
                            <x-input-label for="jenis_barang" :value="__('Jenis Barang')" />
                            <select name="jenis_barang" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                @foreach($availableJenisBarang as $jenisBarang)
                                <option value="{{ $jenisBarang->jenisbarang }}">{{ $jenisBarang->jenisbarang }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jenis_barang')" class="mt-2" />
                        </div>

                        <!-- Tanggal Peroleh -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_peroleh" :value="__('Tanggal Peroleh')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal_peroleh" :value="old('tanggal_peroleh')" required autofocus autocomplete="tanggal_peroleh" />
                            <x-input-error :messages="$errors->get('tanggal_peroleh')" class="mt-2" />
                        </div>

                        <!-- Stok -->
                        <div class="mt-4">
                            <x-input-label for="stok" :value="__('Stok')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok')" required autocomplete="stok" />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <!-- Harga Satuan -->
                        <div class="mt-4">
                            <x-input-label for="harga_satuan" :value="__('Harga Satuan')" />
                            <x-text-input id="harga_satuan" class="block mt-1 w-full" type="number" name="harga_satuan" :value="old('harga_satuan')" required autocomplete="harga_satuan" />
                            <x-input-error :messages="$errors->get('harga_satuan')" class="mt-2" />
                        </div>

                        <!-- Lokasi -->
                        <div class="mt-4">
                            <x-input-label for="lokasi" :value="__('Lokasi')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required autofocus autocomplete="lokasi" />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="status" :value="old('status')" autocomplete="status" />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan" min="0" :value="old('catatan')" autocomplete="catatan" />
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Tambah Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-admin>
