@php
$today = now()->format('Y-m-d');
@endphp


<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Buat Siklus Baru</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('store_siklus', ['kolamId' => $kolamId]) }}">
                        @csrf

                        <!-- Tanggal Tebar -->
                        <div>
                            <x-input-label for="tanggal_mulai" :value="__('Taanggal Tebar')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai"
                                :value="$today ?? old('tanggal_mulai')" required autofocus
                                autocomplete="tanggal_mulai" />
                            <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                        </div>

                        <!-- Jumlah Tebar -->
                        <div class="mt-4">
                            <x-input-label for="total_tebar" :value="__('Total Tebar')" />
                            <x-text-input id="total_tebar" class="block mt-1 w-full" type="number" name="total_tebar"
                                :value="old('total_tebar')" required autocomplete="total_tebar" />
                            <x-input-error :messages="$errors->get('total_tebar')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="old('catatan')" required autocomplete="catatan" />
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>



                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Tambah Siklus') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-admin>