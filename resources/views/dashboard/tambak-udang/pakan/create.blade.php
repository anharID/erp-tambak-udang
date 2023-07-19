@php
$today = now()->format('Y-m-d');
@endphp

<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Catatan Pakan</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('pakan.store', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id]) }}">
                        @csrf
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$today ?? old('tanggal')" required autofocus autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <!-- Waktu -->
                            <div>
                                <x-input-label for="waktu_pemberian" :value="__('Waktu Pemberian')" />
                                <x-text-input id="waktu_pemberian" class="block mt-1 w-full" type="time"
                                    name="waktu_pemberian" :value="old('waktu_pemberian')" required autofocus
                                    autocomplete="waktu_pemberian" />
                                <x-input-error :messages="$errors->get('waktu_pemberian')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="no_pakan" :value="__('Jenis Pakan')" />
                                <select name="no_pakan"
                                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                    <option value="" disabled selected>Pilih satu opsi</option>
                                    @foreach($inventaris as $item)
                                    <option value="{{ $item->nama_barang }}">{{ $item->nama_barang }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('no_pakan')" class="mt-2" />
                            </div>

                            <!-- Jumlah Kg -->
                            <div>
                                <x-input-label for="jumlah_kg" :value="__('Jumlah Kg')" />
                                <x-text-input id="jumlah_kg" class="block mt-1 w-full" type="number" step='0.1' min='0'
                                    name="jumlah_kg" :value="old('jumlah_kg')" required autofocus
                                    autocomplete="jumlah_kg" />
                                <x-input-error :messages="$errors->get('jumlah_kg')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
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