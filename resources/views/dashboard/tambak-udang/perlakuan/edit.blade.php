<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Ubah Catatan Perlakuan</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 ">
                    <form method="POST"
                        action="{{ route('perlakuan.update', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'perlakuan'=>$perlakuan->id]) }}">
                        @csrf
                        @method('put')
                        <!-- Tanggal -->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                :value="$perlakuan->tanggal ?? old('tanggal')" required autofocus
                                autocomplete="tanggal" />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>
                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="catatan" :value="__('Perlakuan')" />
                            <textarea id="catatan"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                name="catatan" rows='5' required autofocus
                                autocomplete="catatan">{{ $perlakuan->catatan ? $perlakuan->catatan : old('catatan') }}</textarea>
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