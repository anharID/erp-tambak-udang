<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900  ">
            <h1 class="mb-4 text-xl font-bold">Ubah Data Karyawan</h1>
            <div class="bg-white   overflow-hidden shadow-sm sm:rounded-lg">
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

                        <!-- Tempat Lahir -->
                        <div class="mt-4">
                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                            <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="$karyawan->tempat_lahir ?? old('tempat_lahir')" required autocomplete="tempat_lahir" />
                            <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="$karyawan->tanggal_lahir ?? old('tanggal_lahir')" required autocomplete="tanggal_lahir" />
                            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                        </div>

                        <!-- Nomor HP -->
                        <div class="mt-4">
                            <x-input-label for="no_hp" :value="__('Nomor HP')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="$karyawan->no_hp ?? old('no_hp')" required autocomplete="no_hp" />
                            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Alamat Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$karyawan->email ?? old('email')" required autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Jabatan -->
                        <div class="mt-4">
                            <x-input-label for="jabatan_id" :value="__('Jabatan')" />
                            <select name="jabatan_id" class="block mt-1 w-full rounded-md border-gray-300       focus:border-indigo-500   focus:ring-indigo-500   shadow-sm px-4 py-2">
                                <option value="">Pilih Jabatan</option>
                                @foreach($jabatan as $row)
                                <option value="{{ $row->id }}" {{ $karyawan->jabatan_id == $row->id ? 'selected' : '' }}>{{ $row->jabatan }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <input type="radio" id="cuti" name="status" value="Cuti" class="form-radio h-3 w-3 mx-1" {{ $karyawan->status == 'Cuti' ? 'checked' : '' }}>
                            <x-input-label for="cuti" class="inline font-normal">Cuti</x-input-label><br>
                            <input type="radio" id="bekerja" name="status" value="Bekerja" class="form-radio h-3 w-3 mx-1" {{ $karyawan->status == 'Bekerja' ? 'checked' : '' }}>
                            <x-input-label for="bekerja" class="inline font-normal">Bekerja</x-input-label><br>
                            <input type="radio" id="mengundurkan_diri" name="status" value="Mengundurkan Diri" class="form-radio h-3 w-3 mx-1" {{ $karyawan->status == 'Mengundurkan Diri' ? 'checked' : '' }}>
                            <x-input-label class="inline font-normal" for="mengundurkan_diri">Mengundurkan Diri</x-input-label><br>
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
