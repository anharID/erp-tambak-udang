<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Catatan Monitoring</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('monitoring.update', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'monitoring'=>$monitoring->id] ) }}">
                        @csrf
                        @method('put')
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$monitoring->tanggal ?? old('tanggal')" required autofocus
                                    autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <!-- Waktu -->
                            <div>
                                <x-input-label for="waktu_pengukuran" :value="__('Waktu Pengukuran')" />
                                <x-text-input id="waktu_pengukuran" class="block mt-1 w-full" type="time"
                                    name="waktu_pengukuran"
                                    :value="$monitoring->waktu_pengukuran ?? old('waktu_pengukuran')" required autofocus
                                    autocomplete="waktu_pengukuran" />
                                <x-input-error :messages="$errors->get('waktu_pengukuran')" class="mt-2" />
                            </div>
                            <!-- Suhu -->
                            <div>
                                <x-input-label for="suhu" :value="__('Suhu (C)')" />
                                <x-text-input id="suhu" class="block mt-1 w-full" type="number" step="0.1" name="suhu"
                                    :value="$monitoring->suhu ?? old('suhu')" required autofocus autocomplete="suhu" />
                                <x-input-error :messages="$errors->get('suhu')" class="mt-2" />
                            </div>
                            <!-- pH -->
                            <div>
                                <x-input-label for="ph" :value="__('pH')" />
                                <x-text-input id="ph" class="block mt-1 w-full" type="number" step="0.1" name="ph"
                                    :value="$monitoring->ph ?? old('ph')" required autofocus autocomplete="ph" />
                                <x-input-error :messages="$errors->get('ph')" class="mt-2" />
                            </div>
                            <!-- DO -->
                            <div>
                                <x-input-label for="do" :value="__('DO (mg/L)')" />
                                <x-text-input id="do" class="block mt-1 w-full" type="number" step="0.1" name="do"
                                    :value="$monitoring->do ?? old('do')" required autofocus autocomplete="do" />
                                <x-input-error :messages="$errors->get('do')" class="mt-2" />
                            </div>
                            <!-- Salinitas -->
                            <div>
                                <x-input-label for="salinitas" :value="__('Salinitas (ppt)')" />
                                <x-text-input id="salinitas" class="block mt-1 w-full" type="number" step="0.1"
                                    name="salinitas" :value="$monitoring->salinitas ?? old('salinitas')" required
                                    autofocus autocomplete="salinitas" />
                                <x-input-error :messages="$errors->get('salinitas')" class="mt-2" />
                            </div>
                            <!-- KEcerahan -->
                            <div>
                                <x-input-label for="kecerahan" :value="__('Kecerahan (cm)')" />
                                <x-text-input id="kecerahan" class="block mt-1 w-full" type="number" step="0.1"
                                    name="kecerahan" :value="$monitoring->kecerahan ?? old('kecerahan')" required
                                    autofocus autocomplete="kecerahan" />
                                <x-input-error :messages="$errors->get('kecerahan')" class="mt-2" />
                            </div>
                            <!-- Tinggi Air -->
                            <div>
                                <x-input-label for="tinggi_air" :value="__('Tinggi Air (cm)')" />
                                <x-text-input id="tinggi_air" class="block mt-1 w-full" type="number" step="0.1"
                                    name="tinggi_air" :value="$monitoring->tinggi_air ?? old('tinggi_air')" required
                                    autofocus autocomplete="tinggi_air" />
                                <x-input-error :messages="$errors->get('tinggi_air')" class="mt-2" />
                            </div>
                            <!-- Warna Air -->
                            <div>
                                <x-input-label for="warna_air" :value="__('Warna Air')" />
                                <x-text-input id="warna_air" class="block mt-1 w-full" type="text" name="warna_air"
                                    :value="$monitoring->warna_air ?? old('warna_air')" required autofocus
                                    autocomplete="warna_air" />
                                <x-input-error :messages="$errors->get('warna_air')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cuaca" :value="__('Cuaca')" />
                                <x-text-input id="cuaca" class="block mt-1 w-full" type="text" name="cuaca"
                                    :value="$monitoring->cuaca ?? old('cuaca')" required autofocus
                                    autocomplete="cuaca" />
                                <x-input-error :messages="$errors->get('cuaca')" class="mt-2" />
                            </div>
                            {{-- <div>
                                <x-input-label for="cuaca" :value="__('Cuaca')" />
                                <select name="cuaca"
                                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                    <option value="" disabled selected>Pilih satu opsi</option>
                                    <option value="Cerah" {{ $monitoring->cuaca=='Cerah' ? 'selected' : '' }}>Cerah
                                    </option>
                                    <option value="Mendung" {{ $monitoring->cuaca=='Mendung' ? 'selected' : ''
                                        }}>Mendung
                                    </option>
                                    <option value="Hujan" {{ $monitoring->cuaca=='Hujan' ? 'selected' : '' }}>Hujan
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('warna_air')" class="mt-2" />
                            </div> --}}
                            <!-- Amonia -->
                            <div>
                                <x-input-label for="amonia" :value="__('Amonia (ppm)')" />
                                <x-text-input id="amonia" class="block mt-1 w-full" type="number" step="0.1"
                                    name="amonia" :value="$monitoring->amonia ?? old('amonia')" autofocus
                                    autocomplete="amonia" />
                                <x-input-error :messages="$errors->get('amonia')" class="mt-2" />
                            </div>
                            <!-- Nitrit -->
                            <div>
                                <x-input-label for="nitrit" :value="__('Nitrit (ppm)')" />
                                <x-text-input id="nitrit" class="block mt-1 w-full" type="number" step="0.1"
                                    name="nitrit" :value="$monitoring->nitrit ?? old('nitrit')" autofocus
                                    autocomplete="nitrit" />
                                <x-input-error :messages="$errors->get('nitrit')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="$monitoring->catatan ?? old('catatan')" autofocus autocomplete="catatan" />
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