@php
$today = now()->format('Y-m-d');
@endphp


<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Buat Siklus Baru</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('siklus.store') }}">
                        @csrf

                        <!-- Tanggal Tebar -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Tebar')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai"
                                :value="$today ?? old('tanggal_mulai')" required autofocus
                                autocomplete="tanggal_mulai" />
                            <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                        </div>

                        <label class="text-sm">Daftar kolam yang siap tebar</label><br>
                        @foreach($kolam as $d)
                        <div class="mt-4">
                            <x-input-label for="kolam_{{ $d->id }}" :value="__($d->nama)" />
                            <input type="hidden" id="kolam_{{ $d->id }}" name="kolam_list[]" value="{{ $d->id }}">
                            <x-text-input id="jumlah_tebar" class="block mt-1 w-full" type="number"
                                name="jumlah_tebar[{{ $d->id }}]" :value="old('jumlah_tebar[{{ $d->id }}]')" required
                                autocomplete="jumlah_tebar" />
                            <x-input-error :messages="$errors->get('jumlah_tebar[{{ $d->id }}]')" class="mt-2" />
                        </div>
                        @endforeach

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