<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Data Logistik</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('logistik.update', $logistik->id) }}">
                        @csrf
                        @method('put')

                        <!-- Tanggal-->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="$logistik->tanggal ?? old('tanggal')" required autofocus autocomplete="tanggal" />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Stok Masuk -->
                        <div class="mt-4">
                            <x-input-label for="stok_masuk" :value="__('Stok Masuk')" />
                            <x-text-input id="stok_masuk" class="block mt-1 w-full" type="number" name="stok_masuk" :value="$logistik->stok_masuk ?? old('stok_masuk')" required autocomplete="stok_masuk" />
                            <x-input-error :messages="$errors->get('stok_masuk')" class="mt-2" />
                        </div>

                        <!-- Stok Keluar -->
                        <div class="mt-4">
                            <x-input-label for="stok_keluar" :value="__('Stok Keluar')" />
                            <x-text-input id="stok_keluar" class="block mt-1 w-full" type="number" name="stok_keluar" :value="$logistik->stok_keluar ?? old('stok_keluar')" required autocomplete="stok_keluar" />
                            <x-input-error :messages="$errors->get('stok_keluar')" class="mt-2" />
                        </div>

                        <!-- Harga Satuan -->
                        <div class="mt-4">
                            <x-input-label for="harga_satuan" :value="__('Harga Satuan')" />
                            <x-text-input id="harga_satuan" class="block mt-1 w-full" type="number" name="harga_satuan" :value="$logistik->harga_satuan ?? old('harga_satuan')" required autocomplete="harga_satuan" />
                            <x-input-error :messages="$errors->get('harga_satuan')" class="mt-2" />
                        </div>

                        <!-- Harga Total -->
                        <div class="mt-4">
                            <x-input-label for="harga_total" :value="__('Harga Total')" />
                            <x-text-input id="harga_total" class="block mt-1 w-full" type="number" name="harga_total" :value="$logistik->harga_total ?? old('harga_total')" required autocomplete="harga_total" />
                            <x-input-error :messages="$errors->get('harga_total')" class="mt-2" />
                        </div>

                        <!-- Sumber -->
                        <div class="mt-4">
                            <x-input-label for="sumber" :value="__('Sumber')" />
                            <x-text-input id="sumber" class="block mt-1 w-full" type="text" name="sumber" :value="$logistik->sumber ?? old('sumber')" required autocomplete="sumber" />
                            <x-input-error :messages="$errors->get('sumber')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan" :value="$logistik->catatan ?? old('catatan')" autocomplete="catatan" />
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
