<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Catatan Panen</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('panen.update', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'panen'=>$panen->id] ) }}">
                        @csrf
                        @method('put')
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$panen->tanggal ?? old('tanggal')" required autofocus
                                    autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>

                            <!-- Waktu Panen -->
                            <div>
                                <x-input-label for="waktu_panen" :value="__('Waktu Panen')" />
                                <x-text-input id="waktu_panen" class="block mt-1 w-full" type="time" name="waktu_panen"
                                    :value="$panen->waktu_panen ?? old('waktu_panen')" required autofocus
                                    autocomplete="waktu_panen" />
                                <x-input-error :messages="$errors->get('waktu_panen')" class="mt-2" />
                            </div>
                        </div>

                        <h1>Tonase</h1>
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Tonase Besar -->
                            <div>
                                <x-input-label for="tonase_besar" :value="__('Tonase Besar (Kg)')" class="font-light" />
                                <x-text-input id="tonase_besar" class="block mt-1 w-full" type="number" step='0.01'
                                    min='0' name="tonase_besar" :value="$panen->tonase_besar ?? old('tonase_besar')"
                                    required autofocus autocomplete="tonase_besar" />
                                <x-input-error :messages="$errors->get('tonase_besar')" class="mt-2" />
                            </div>

                            <!-- Tonase Kecil -->
                            <div>
                                <x-input-label for="tonase_kecil" :value="__('Tonase Kecil (Kg)')" class="font-light" />
                                <x-text-input id="tonase_kecil" class="block mt-1 w-full" type="number" step='0.01'
                                    min='0' name="tonase_kecil" :value="$panen->tonase_kecil ?? old('tonase_kecil')"
                                    required autofocus autocomplete="tonase_kecil" />
                                <x-input-error :messages="$errors->get('tonase_kecil')" class="mt-2" />
                            </div>
                        </div>

                        <h1>Size</h1>
                        <div class="grid gap-4 mb-4 md:grid-cols-2">
                            <!-- Size Besar -->
                            <div>
                                <x-input-label for="size_besar" :value="__('Size Besar')" class="font-light" />
                                <x-text-input id="size_besar" class="block mt-1 w-full" type="number" step='0.01'
                                    min='0' name="size_besar" :value="$panen->size_besar ?? old('size_besar')" required
                                    autofocus autocomplete="size_besar" />
                                <x-input-error :messages="$errors->get('size_besar')" class="mt-2" />
                            </div>

                            <!-- Size Kecil -->
                            <div>
                                <x-input-label for="size_kecil" :value="__('Size Kecil')" class="font-light" />
                                <x-text-input id="size_kecil" class="block mt-1 w-full" type="number" step='0.01'
                                    min='0' name="size_kecil" :value="$panen->size_kecil ?? old('size_kecil')" required
                                    autofocus autocomplete="size_kecil" />
                                <x-input-error :messages="$errors->get('size_kecil')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                <option value="Parsial" {{ $panen->status === 'Parsial' ? 'selected' : '' }}>Parsial
                                </option>
                                <option value="Total" {{ $panen->status === 'Total' ? 'selected' : '' }}>Total</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="$panen->catatan ?? old('catatan')" autofocus autocomplete="catatan" />
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