<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Catatan Sampling</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('sampling.update', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'sampling'=>$sampling->id] ) }}">
                        @csrf
                        @method('put')
                        <div class="grid gap-4 mb-4 md:grid-cols-3">
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$sampling->tanggal ?? old('tanggal')" required autofocus
                                    autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <!-- Berat -->
                            <div>
                                <x-input-label for="berat_sampling" :value="__('Berat')" />
                                <x-text-input id="berat_sampling" class="block mt-1 w-full" type="number"
                                    name="berat_sampling" :value="$sampling->berat_sampling ?? old('berat_sampling')"
                                    required autofocus autocomplete="berat_sampling" />
                                <x-input-error :messages="$errors->get('berat_sampling')" class="mt-2" />
                            </div>
                            <!-- Banyak Udang -->
                            <div>
                                <x-input-label for="banyak_sampling" :value="__('Jumlah Udang')" />
                                <x-text-input id="banyak_sampling" class="block mt-1 w-full" type="number"
                                    name="banyak_sampling" :value="$sampling->banyak_sampling ?? old('banyak_sampling')"
                                    required autofocus autocomplete="banyak_sampling" />
                                <x-input-error :messages="$errors->get('banyak_sampling')" class="mt-2" />
                            </div>
                        </div>


                        <!-- Catatan -->
                        <div>
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="$sampling->catatan ?? old('catatan')" autofocus autocomplete="catatan" />
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