@php
$today = now()->format('Y-m-d');
@endphp

<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Catatan Monitoring</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('monitoring.store', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id]) }}">
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
                                <x-input-label for="waktu_pengukuran" :value="__('Waktu Pengukuran')" />
                                <x-text-input id="waktu_pengukuran" class="block mt-1 w-full" type="time"
                                    name="waktu_pengukuran" :value="old('waktu_pengukuran')" required autofocus
                                    autocomplete="waktu_pengukuran" />
                                <x-input-error :messages="$errors->get('waktu_pengukuran')" class="mt-2" />
                            </div>
                            <!-- Suhu -->
                            <div>
                                <x-input-label for="suhu" :value="__('Suhu')" />
                                <x-text-input id="suhu" class="block mt-1 w-full" type="number" name="suhu"
                                    :value="old('suhu')" required autofocus autocomplete="suhu" />
                                <x-input-error :messages="$errors->get('suhu')" class="mt-2" />
                            </div>
                            <!-- pH -->
                            <div>
                                <x-input-label for="ph" :value="__('pH')" />
                                <x-text-input id="ph" class="block mt-1 w-full" type="number" name="ph"
                                    :value="old('ph')" required autofocus autocomplete="ph" />
                                <x-input-error :messages="$errors->get('ph')" class="mt-2" />
                            </div>
                            <!-- DO -->
                            <div>
                                <x-input-label for="do" :value="__('DO')" />
                                <x-text-input id="do" class="block mt-1 w-full" type="number" name="do"
                                    :value="old('do')" required autofocus autocomplete="do" />
                                <x-input-error :messages="$errors->get('do')" class="mt-2" />
                            </div>
                            <!-- Salinitas -->
                            <div>
                                <x-input-label for="salinitas" :value="__('Salinitas')" />
                                <x-text-input id="salinitas" class="block mt-1 w-full" type="number" name="salinitas"
                                    :value="old('salinitas')" required autofocus autocomplete="salinitas" />
                                <x-input-error :messages="$errors->get('salinitas')" class="mt-2" />
                            </div>
                            <!-- KEcerahan -->
                            <div>
                                <x-input-label for="kecerahan" :value="__('Kecerahan')" />
                                <x-text-input id="kecerahan" class="block mt-1 w-full" type="number" name="kecerahan"
                                    :value="old('kecerahan')" required autofocus autocomplete="kecerahan" />
                                <x-input-error :messages="$errors->get('kecerahan')" class="mt-2" />
                            </div>
                            <!-- Tinggi Air -->
                            <div>
                                <x-input-label for="tinggi_air" :value="__('Tinggi Air')" />
                                <x-text-input id="tinggi_air" class="block mt-1 w-full" type="number" name="tinggi_air"
                                    :value="old('tinggi_air')" required autofocus autocomplete="tinggi_air" />
                                <x-input-error :messages="$errors->get('tinggi_air')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Warna Air -->
                        <div class="mb-4">
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
                        </div>

                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Amonia -->
                            <div>
                                <x-input-label for="amonia" :value="__('Amonia')" />
                                <x-text-input id="amonia" class="block mt-1 w-full" type="number" name="amonia"
                                    :value="old('amonia')" autofocus autocomplete="amonia" />
                                <x-input-error :messages="$errors->get('amonia')" class="mt-2" />
                            </div>
                            <!-- Nitrit -->
                            <div>
                                <x-input-label for="nitrit" :value="__('Nitrit')" />
                                <x-text-input id="nitrit" class="block mt-1 w-full" type="number" name="nitrit"
                                    :value="old('nitrit')" autofocus autocomplete="nitrit" />
                                <x-input-error :messages="$errors->get('nitrit')" class="mt-2" />
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