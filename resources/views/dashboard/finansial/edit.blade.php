<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Catatan Finansial</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('finansial.update', $finansial->id) }}">
                        @csrf
                        @method('put')

                        <!-- Tanggal -->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="$finansial->tanggal ?? old('tanggal')" required autofocus autocomplete="tanggal" />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Jenis Transaksi -->
                        <div class="mt-4">
                            <x-input-label for="jenis_transaksi" :value="__('Jenis Transaksi')" />
                            <select name="jenis_transaksi" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                <option value="Pemasukan" {{ $finansial->jenis_transaksi == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="Pengeluaran" {{ $finansial->jenis_transaksi == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                <option value="Gaji Karyawan" {{ $finansial->jenis_transaksi == 'Gaji Karyawan' ? 'selected' : '' }}>Gaji Karyawan</option>
                            </select>

                            <x-input-error :messages="$errors->get('jenis_transaksi')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="mt-4">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan" :value="$finansial->keterangan ?? old('keterangan')" required autocomplete="keterangan" />
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <!-- Jumlah -->
                        <div class="mt-4">
                            <x-input-label for="jumlah" :value="__('Jumlah')" />
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" min="0" :value="$finansial->jumlah ?? old('jumlah')" required autocomplete="jumlah" />
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <!-- Catatan-->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan" :value="$finansial->catatan ?? old('catatan')" required autocomplete="catatan" />
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <!-- Status-->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <x-text-input id="status" class="block mt-1 w-full" type="text" name="status" :value="$finansial->status ?? old('status')" required autocomplete="status" />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
