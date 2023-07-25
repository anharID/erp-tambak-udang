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
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                :value="$finansial->tanggal ?? old('tanggal')" required autofocus autocomplete="tanggal" />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Jenis Transaksi -->
                        <div class="mt-4">
                            <x-input-label for="jenis_transaksi" :value="__('Jenis Transaksi')" />
                            <select name="jenis_transaksi" id="jenis_transaksi"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                <option value="Pemasukan"
                                    {{ $finansial->jenis_transaksi == 'Pemasukan' ? 'selected' : '' }}>Pemasukan
                                </option>
                                <option value="Pengeluaran"
                                    {{ $finansial->jenis_transaksi == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran
                                </option>
                                <option value="Gaji Karyawan"
                                    {{ $finansial->jenis_transaksi == 'Gaji Karyawan' ? 'selected' : '' }}>Gaji Karyawan
                                </option>
                                <option value="Bonus Karyawan"
                                    {{ $finansial->jenis_transaksi == 'Bonus Karyawan' ? 'selected' : '' }}>Bonus Karyawan
                                </option>
                                <option value="Penjualan Udang"
                                    {{ $finansial->jenis_transaksi == 'Penjualan Udang' ? 'selected' : '' }}>Penjualan Udang
                                </option>
                            </select>

                            <x-input-error :messages="$errors->get('jenis_transaksi')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="mt-4" id="keterangan_field">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan"
                                :value="$finansial->keterangan ?? old('keterangan')" required autocomplete="keterangan" />
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <!-- Karyawan -->
                        <div class="mt-4" id="karyawan_field" style="display:none;">
                            <x-input-label for="karyawan" :value="__('Nama Karyawan')" />
                            <select name="karyawan" id="karyawan"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                @foreach ($karyawan as $row)
                                    <option value="{{ $row->id }}" gaji="{{ $row->gaji }}" bonus="{{ $row->bonus }}"
                                        nama="{{ $row->nama }}"
                                        {{ $finansial->karyawan_id == $row->id ? 'selected' : '' }}>{{ $row->nama }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('jenis_transaksi')" class="mt-2" />
                        </div>

                        <!-- Kolam -->
                        <div class="mt-4" id="kolam_field" style="display:none;">
                            <x-input-label for="kolam" :value="__('Nama kolam')" />
                            <select name="kolam" id="kolam"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                @foreach ($kolam as $row)
                                    <option nama="{{ $row->nama }}"
                                        {{ $finansial->keterangan == 'Kolam ' . $row->nama ? 'selected' : '' }}>{{ $row->nama }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('jenis_transaksi')" class="mt-2" />
                        </div>

                        <!-- Jumlah -->
                        <div class="mt-4">
                            <x-input-label for="jumlah" :value="__('Jumlah')" />
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah"
                                min="0" :value="$finansial->jumlah ?? old('jumlah')" required autocomplete="jumlah" />
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <!-- Catatan-->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="$finansial->catatan ?? old('catatan')" autocomplete="catatan" />
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <!-- Status-->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <x-text-input id="status" class="block mt-1 w-full" type="text" name="status"
                                :value="$finansial->status ?? old('status')" autocomplete="status" />
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
<script src="{{ Vite::asset('resources/js/finansial.js') }}" defer></script>
