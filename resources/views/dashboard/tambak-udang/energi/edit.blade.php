<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Catatan Penggunaan Energi</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('energi.update', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'energi'=>$energi->id]) }}">
                        @csrf
                        @method('put')
                        <div class="grid gap-4 mb-4 md:grid-cols-2">

                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$energi->tanggal ?? old('tanggal')" required autofocus
                                    autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="penggunaan" :value="__('Penggunaan Energi')" />
                                <select name="penggunaan"
                                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                    <option value="" disabled selected>Pilih satu opsi</option>
                                    <option value="Kincir" {{ $energi->penggunaan == 'Kincir' ? 'selected' : ''
                                        }}>Kincir</option>
                                    <option value="Penerangan" {{ $energi->penggunaan == 'Penerangan' ? 'selected' : ''
                                        }}>Penerangan</option>
                                    <option value="Utility" {{ $energi->penggunaan == 'Utility' ? 'selected' : ''
                                        }}>Utility</option>
                                </select>
                                <x-input-error :messages="$errors->get('penggunaan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="sumber_energi" :value="__('Sumber Energi')" />
                                <select name="sumber_energi"
                                    class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                    <option value="" disabled selected>Pilih satu opsi</option>
                                    <option value="Genset" {{ $energi->sumber_energi == 'Genset' ? 'selected' : ''
                                        }}>Genset</option>
                                    <option value="Listrik" {{ $energi->sumber_energi == 'Listrik' ? 'selected' : ''
                                        }}>Listrik</option>
                                </select>
                                <x-input-error :messages="$errors->get('sumber_energi')" class="mt-2" />
                            </div>
                            <!-- Jumlah -->
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" min='0' name="jumlah"
                                    :value="$energi->jumlah ?? old('jumlah')" autofocus autocomplete="jumlah" />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>
                            <!-- Daya -->
                            <div>
                                <x-input-label for="daya" :value="__('Daya (Watt)')" />
                                <x-text-input id="daya" class="block mt-1 w-full" type="number" min='0' name="daya"
                                    :value="$energi->daya ?? old('daya')" autofocus autocomplete="daya" />
                                <x-input-error :messages="$errors->get('daya')" class="mt-2" />
                            </div>
                            <!-- Jam penggunaan -->
                            <div>
                                <x-input-label for="lama_penggunaan" :value="__('Lama Penggunaan (Jam)')" />
                                <x-text-input id="lama_penggunaan" class="block mt-1 w-full" type="number" min='0'
                                    name="lama_penggunaan" :value="$energi->lama_penggunaan ?? old('lama_penggunaan')"
                                    autofocus autocomplete="lama_penggunaan" />
                                <x-input-error :messages="$errors->get('lama_penggunaan')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="$energi->catatan ?? old('catatan')" autofocus autocomplete="catatan" />
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