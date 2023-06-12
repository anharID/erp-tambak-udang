@php
    $today = now()->format('Y-m-d');
@endphp

<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Catatan Panen</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('panen.store', ['kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}">
                        @csrf
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$today ?? old('tanggal')" required autofocus autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>

                            <!-- Waktu Panen -->
                            <div>
                                <x-input-label for="waktu_panen" :value="__('Waktu Panen')" />
                                <x-text-input id="waktu_panen" class="block mt-1 w-full" type="time"
                                    name="waktu_panen" :value="old('waktu_panen')" required autofocus
                                    autocomplete="waktu_panen" />
                                <x-input-error :messages="$errors->get('waktu_panen')" class="mt-2" />
                            </div>
                        </div>

                        <h1>Tonase</h1>
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Tonase Besar -->
                            <div>
                                <x-input-label for="tonase_besar" :value="__('Tonase Besar')" class="font-light" />
                                <x-text-input id="tonase_besar" class="block mt-1 w-full" type="number" step='0.01' min='0'
                                    name="tonase_besar" :value="old('tonase_besar')" required autofocus
                                    autocomplete="tonase_besar" />
                                <x-input-error :messages="$errors->get('tonase_besar')" class="mt-2" />
                            </div>

                            <!-- Tonase Kecil -->
                            <div>
                                <x-input-label for="tonase_kecil" :value="__('Tonase Kecil')" class="font-light" />
                                <x-text-input id="tonase_kecil" class="block mt-1 w-full" type="number" step='0.01' min='0'
                                    name="tonase_kecil" :value="old('tonase_kecil')" required autofocus
                                    autocomplete="tonase_kecil" />
                                <x-input-error :messages="$errors->get('tonase_kecil')" class="mt-2" />
                            </div>
                        </div>

                        <h1>Size</h1>
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Size Besar -->
                            <div>
                                <x-input-label for="size_besar" :value="__('Size Besar')" class="font-light" />
                                <x-text-input id="size_besar" class="block mt-1 w-full" type="number" step='0.01' min='0'
                                    name="size_besar" :value="old('size_besar')" required autofocus
                                    autocomplete="size_besar" />
                                <x-input-error :messages="$errors->get('size_besar')" class="mt-2" />
                            </div>

                            <!-- Size Kecil -->
                            <div>
                                <x-input-label for="size_kecil" :value="__('Size Kecil')" class="font-light" />
                                <x-text-input id="size_kecil" class="block mt-1 w-full" type="number" step='0.01' min='0'
                                    name="size_kecil" :value="old('size_kecil')" required autofocus
                                    autocomplete="size_kecil" />
                                <x-input-error :messages="$errors->get('size_kecil')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-text-input id="status" class="block mt-1 w-full" type="text" name="status"
                                :value="old('status')" autofocus autocomplete="status" />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
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
