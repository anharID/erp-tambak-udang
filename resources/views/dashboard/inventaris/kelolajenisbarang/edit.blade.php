<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Jenis Barang</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('kelola_barang.update', ['kelolajenisbarang'=>$kelolajenisbarang->id]) }}">
                        @csrf
                        @method('put')

                        <!-- Jenis Barang-->
                        <div>
                            <x-input-label for="jenisbarang" :value="__('Jenis Barang')" />
                            <x-text-input id="jenisbarang" class="block mt-1 w-full" type="text" name="jenisbarang" :value="old('jenisbarang', $kelolajenisbarang->jenisbarang ?? '')" required autofocus autocomplete="jenisbarang" />
                            <x-input-error :messages="$errors->get('jenisbarang')" class="mt-2" />
                            @error('jenisbarang_duplicate')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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