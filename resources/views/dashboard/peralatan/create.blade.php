<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Peralatan</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('peralatan.store') }}">
                        @csrf

                        <!-- Nama Alat-->
                        <div>
                            <x-input-label for="nama_alat" :value="__('Nama Alat')" />
                            <x-text-input id="nama_alat" class="block mt-1 w-full" type="text" name="nama_alat" :value="old('nama_alat')" required autofocus autocomplete="nama_alat" />
                            <x-input-error :messages="$errors->get('nama_alat')" class="mt-2" />
                        </div>

                        <!-- Jumlah Alat -->
                        <div class="mt-4">
                            <x-input-label for="jumlah_alat" :value="__('Jumlah Alat')" />
                            <x-text-input id="jumlah_alat" class="block mt-1 w-full" type="number" name="jumlah_alat" :value="old('jumlah_alat')" required autocomplete="jumlah_alat" />
                            <x-input-error :messages="$errors->get('jumlah_alat')" class="mt-2" />
                        </div>

                        <!-- Kondisi Alat -->
                        <div class="mt-4">
                            <x-input-label for="kondisi_alat" :value="__('Kondisi Alat')" />
                            <x-text-input id="kondisi_alat" class="block mt-1 w-full" type="text" name="kondisi_alat" :value="old('kondisi_alat')" required autocomplete="kondisi_alat" />
                            <x-input-error :messages="$errors->get('kondisi_alat')" class="mt-2" />
                        </div>

                        <!-- Maintenance -->
                        <div class="mt-4">
                            <x-input-label for="maintenance" :value="__('Maintenance')" />
                            <x-text-input id="maintenance" class="block mt-1 w-full" type="text" name="maintenance" :value="old('maintenance')" required autocomplete="maintenance" />
                            <x-input-error :messages="$errors->get('maintenance')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan" min="0" :value="old('catatan')" required autocomplete="catatan" />
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
