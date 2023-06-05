@php
$today = now()->format('Y-m-d');
@endphp

<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Catatan Sampling</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('sampling.store', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id]) }}">
                        @csrf
                        <div class="grid gap-4 mb-4 md:grid-cols-3">
                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal')" />
                                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                    :value="$today ?? old('tanggal')" required autofocus autocomplete="tanggal" />
                                <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                            </div>
                            <!-- Berat -->
                            <div>
                                <x-input-label for="berat" :value="__('Berat')" />
                                <x-text-input id="berat" class="block mt-1 w-full" type="number" name="berat"
                                    :value="old('berat')" required autofocus autocomplete="berat" />
                                <x-input-error :messages="$errors->get('berat')" class="mt-2" />
                            </div>
                            <!-- Banyak Udang -->
                            <div>
                                <x-input-label for="jumlah_udang" :value="__('Jumlah Udang')" />
                                <x-text-input id="jumlah_udang" class="block mt-1 w-full" type="number"
                                    name="jumlah_udang" :value="old('jumlah_udang')" required autofocus
                                    autocomplete="jumlah_udang" />
                                <x-input-error :messages="$errors->get('jumlah_udang')" class="mt-2" />
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