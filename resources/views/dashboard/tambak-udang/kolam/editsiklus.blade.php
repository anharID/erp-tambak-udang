<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Siklus Berjalan</h1>
            <div class="mb-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('update_siklus', ['siklus'=>$siklus->id]) }}">
                        @csrf
                        @method('put')

                        <!-- Tanggal Tebar -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Tebar')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai"
                                :value="$siklus->tanggal_mulai ?? old('tanggal_mulai')" required autofocus
                                autocomplete="tanggal_mulai" />
                            <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                        </div>

                        <label class="text-sm">Daftar kolam yang sudah tebar</label><br>
                        @foreach($kolam as $d)
                        <div class="mt-4">
                            <x-input-label for="kolam_{{ $d->id }}" :value="__($d->nama)" />
                            <input type="hidden" id="kolam_{{ $d->id }}" name="kolam_list[]" value="{{ $d->id }}">
                            <x-text-input id="total_tebar" class="block mt-1 w-full" type="number"
                                name="jumlah_tebar[{{ $d->id }}]"
                                :value="$siklus->kolam->find($d->id)->pivot->jumlah_tebar ?? old('total_tebar')"
                                required autocomplete="total_tebar" />
                            <x-input-error :messages="$errors->get('total_tebar')" class="mt-2" />
                        </div>
                        @endforeach

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Catatan Siklus')" />
                            <x-text-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                                :value="$siklus->catatan ?? old('catatan')" autocomplete="catatan" />
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Ubah Siklus') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>

            {{-- <h1 class="mb-4 text-xl font-bold">Hapus Siklus</h1>

            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex justify-between">
                    <p>Peringatan! Anda tidak akan bisa lagi mengakses data siklus yang telah dihapus</p>
                    <form action="{{ route('hapus_siklus', ['kolamId' => $kolam->id, 'siklus'=>$siklus->id]) }}"
                        method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-800 dark:bg-red-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-400 focus:bg-red-700 dark:focus:bg-red-500 active:bg-red-900 dark:active:bg-red-300"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus siklus saat ini? Tindakan ini akan menghapus semua data terkait!')">Hapus
                            Siklus</button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>

</x-admin>