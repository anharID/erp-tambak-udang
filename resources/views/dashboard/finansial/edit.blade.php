<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Data Karyawan</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('karyawan.update', $karyawan->id) }}">
                        @csrf
                        @method('put')

                        <!-- Nama -->
                        <div>
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="$karyawan->nama ?? old('nama')" required autofocus autocomplete="nama" />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <!-- Alamat -->
                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="$karyawan->alamat ?? old('alamat')" required autocomplete="alamat" />
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <!-- Nomor HP -->
                        <div class="mt-4">
                            <x-input-label for="no_hp" :value="__('Nomor HP')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="$karyawan->no_hp ?? old('no_hp')" required autocomplete="no_hp" />
                            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$karyawan->email ?? old('email')" required autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Jabatan -->
                        <div class="mt-4">
                            <x-input-label for="jabatan" :value="__('Jabatan')" />
                            <select name="jabatan" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                <option value="superadmin" {{ $karyawan->jabatan == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="direktur" {{ $karyawan->jabatan == 'direktur' ? 'selected' : '' }}>Direktur</option>
                                <option value="manajer keuangan" {{ $karyawan->jabatan == 'manajer keuangan' ? 'selected' : '' }}>Manajer Keuangan</option>
                                <option value="teknisi" {{ $karyawan->jabatan == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                                <option value="admin" {{ $karyawan->jabatan == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>

                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <input type="radio" id="cuti" name="status" value="0" class="form-radio h-3 w-3 mx-1" {{ $karyawan->status == '0' ? 'checked' : '' }}>
                            <x-input-label for="cuti" class="inline font-normal">Cuti</x-input-label><br>
                            <input type="radio" id="bekerja" name="status" value="1" class="form-radio h-3 w-3 mx-1" {{ $karyawan->status == '1' ? 'checked' : '' }}>
                            <x-input-label for="cuti" class="inline font-normal" for="bekerja">Bekerja</x-input-label><br>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Gaji -->
                        <div class="mt-4">
                            <x-input-label for="gaji" :value="__('Gaji')" />
                            <x-text-input id="gaji" class="block mt-1 w-full" type="number" name="gaji" min="0" :value="$karyawan->gaji ?? old('gaji')" required autocomplete="gaji" />
                            <x-input-error :messages="$errors->get('gaji')" class="mt-2" />
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
