<x-admin>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Tambah Kategori Penggunaan</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('penggunaan.store') }}">
                        @csrf
                        <div>
                            <div>
                                <x-input-label for="penggunaan" :value="__('Nama Kategori Penggunaan')" />
                                <x-text-input id="penggunaan" class="block mt-1 w-full" type="text" name="penggunaan"
                                    :value="old('penggunaan')" autofocus autocomplete="penggunaan" />
                                <x-input-error :messages="$errors->get('penggunaan')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Tambah Data') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-admin>