<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Logistik</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('logistik.store', ['inventaris' => $inventaris->id]) }}">
                        @csrf

                        <!-- Tanggal-->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="old('tanggal')" required autofocus autocomplete="tanggal" />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="mt-4">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <select id="keterangan" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2" name="keterangan">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                <option value="stok_masuk">Stok Masuk</option>
                                <option value="stok_keluar">Stok Keluar</option>
                            </select>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <!-- Stok Masuk -->
                        <div class="mt-4 stok-masuk">
                            <x-input-label for="stok_masuk" :value="__('Stok Masuk')" />
                            <x-text-input id="stok_masuk" class="block mt-1 w-full" type="number" name="stok_masuk" :value="old('stok_masuk')" autocomplete="stok_masuk" />
                            <x-input-error :messages="$errors->get('stok_masuk')" class="mt-2" />
                        </div>

                        <!-- Stok Keluar -->
                        <div class="mt-4 stok-keluar">
                            <x-input-label for="stok_keluar" :value="__('Stok Keluar')" />
                            <x-text-input id="stok_keluar" class="block mt-1 w-full" type="number" name="stok_keluar" :value="old('stok_keluar')" autocomplete="stok_keluar" />
                            <x-input-error :messages="$errors->get('stok_keluar')" class="mt-2" />
                        </div>

                        <!-- Sumber -->
                        <div class="mt-4">
                            <x-input-label for="sumber" :value="__('Sumber')" />
                            <x-text-input id="sumber" class="block mt-1 w-full" type="text" name="sumber" :value="old('sumber')" required autocomplete="sumber" />
                            <x-input-error :messages="$errors->get('sumber')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan" :value="old('catatan')" autocomplete="catatan" />
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
    <script>
        // Show/hide Stok Masuk and Stok Keluar input based on selected Keterangan value
        document.getElementById('keterangan').addEventListener('change', function () {
            var keteranganValue = this.value;
            var stokMasukInput = document.querySelector('.stok-masuk');
            var stokKeluarInput = document.querySelector('.stok-keluar');
    
            if (keteranganValue === 'stok_masuk') {
                stokMasukInput.style.display = 'block';
                stokKeluarInput.style.display = 'none';
            } else if (keteranganValue === 'stok_keluar') {
                stokMasukInput.style.display = 'none';
                stokKeluarInput.style.display = 'block';
            } else {
                stokMasukInput.style.display = 'none';
                stokKeluarInput.style.display = 'none';
            }
        });
    </script>
    
</x-admin>
