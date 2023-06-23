<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Kolam</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('kolam.store') }}">
                        @csrf

                        <div class="mt-4 grid md:grid-cols-2">
                            <!-- Nama -->
                            <div class="mt-4 md:mt-2 md:mr-2">
                                <x-input-label for="nama" :value="__('Nama')" />
                                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama"
                                    :value="old('nama')" required autofocus autocomplete="nama" />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>

                            <!-- Lokasi -->
                            <div class="mt-4 md:mt-2 md:ml-2">
                                <x-input-label for="lokasi" :value="__('Lokasi')" />
                                <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi"
                                    :value="old('lokasi')" required autocomplete="lokasi" />
                                <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                            </div>


                            <div class="mt-4 md:mt-2 md:mr-2">
                                <x-input-label for="luas" :value="__('Luas (meter kuadrat)')" />
                                <x-text-input id="luas" class="block mt-1 w-full" type="number" name="luas"
                                    :value="old('luas')" required autocomplete="luas" />
                                <x-input-error :messages="$errors->get('luas')" class="mt-2" />
                            </div>

                            <div class="mt-4 md:mt-2 md:ml-2">
                                <x-input-label for="kedalaman" :value="__('Kedalaman (meter)')" />
                                <x-text-input id="kedalaman" class="block mt-1 w-full" type="number" step='0.1'
                                    name="kedalaman" :value="old('kedalaman')" required autocomplete="kedalaman" />
                                <x-input-error :messages="$errors->get('kedalaman')" class="mt-2" />
                            </div>

                            <!-- Tipe -->
                            <div class="mt-4 md:mt-2 md:mr-2">
                                <x-input-label for="tipe" :value="__('Tipe Kolam')" />
                                <select name="tipe"
                                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                    <option value="" disabled selected>Pilih satu opsi</option>
                                    <option value="Kolam Riset">Kolam Riset</option>
                                    <option value="Kolam Bisnis">Kolam Bisnis</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div class="mt-4 md:mt-2 md:ml-2">
                                <x-input-label for="status" :value="__('Status Kolam')" />
                                <select name="status"
                                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                    <option value="" disabled selected>Pilih satu opsi</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="old('catatan')" autofocus autocomplete="catatan" />
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