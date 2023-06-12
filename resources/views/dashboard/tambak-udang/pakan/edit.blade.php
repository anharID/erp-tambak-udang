<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Catatan Pakan</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('pakan.update', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'pakan'=>$pakan->id]) }}">
                        @csrf
                        @method('put')
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$pakan->tanggal ?? old('tanggal')" required autofocus
                                    autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <!-- Waktu -->
                            <div>
                                <x-input-label for="waktu_pemberian" :value="__('Waktu Pemberian')" />
                                <x-text-input id="waktu_pemberian" class="block mt-1 w-full" type="time"
                                    name="waktu_pemberian" :value="$pakan->waktu_pemberian ?? old('waktu_pemberian')"
                                    required autofocus autocomplete="waktu_pemberian" />
                                <x-input-error :messages="$errors->get('waktu_pemberian')" class="mt-2" />
                            </div>
                            <!-- Pakan -->
                            <div>
                                <x-input-label for="no_pakan" :value="__('Jenis Pakan')" />
                                <x-text-input id="no_pakan" class="block mt-1 w-full" type="text" name="no_pakan"
                                    :value="$pakan->no_pakan ?? old('no_pakan')" required autofocus
                                    autocomplete="no_pakan" />
                                <x-input-error :messages="$errors->get('no_pakan')" class="mt-2" />
                            </div>
                            <!-- Jumlah Kg -->
                            <div>
                                <x-input-label for="jumlah_kg" :value="__('Jumlah Kg')" />
                                <x-text-input id="jumlah_kg" class="block mt-1 w-full" type="number" step='0.1' min='0'
                                    name="jumlah_kg" :value="$pakan->jumlah_kg ?? old('jumlah_kg')" required autofocus
                                    autocomplete="jumlah_kg" />
                                <x-input-error :messages="$errors->get('jumlah_kg')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Warna Air -->
                        {{-- <div class="mb-4">
                            <x-input-label for="warna_air" :value="__('Warna Air')" />
                            <select name="warna_air"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                <option value="H">H</option>
                                <option value="HC">HC</option>
                                <option value="C">C</option>
                                <option value="HM">HM</option>
                            </select>
                            <x-input-error :messages="$errors->get('warna_air')" class="mt-2" />
                        </div> --}}

                        <!-- Catatan -->
                        <div>
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="$pakan->catatan ?? old('catatan')" autofocus autocomplete="catatan" />
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