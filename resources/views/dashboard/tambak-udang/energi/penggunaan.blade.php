<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <div class="flex flex-row items-center mb-4">
                {{-- Kembali --}}
                {{-- <a href="{{ route('data_kolam', ['kolam' => $kolam->id, 'siklus' => $siklus->id]) }}"
                    class="mr-2 flex items-center justify-center bg-gray-300 rounded-full w-8 h-8">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a> --}}
                <h1 class="font-bold text-2xl">Kategori Penggunaan Energi</h1>
            </div>

            <div class="my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full p-6">

                    {{-- Alert --}}
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif


                    <a href="{{ route('penggunaan.create') }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Penggunaan
                    </a>

                    <div class="w-full overflow-x-auto mt-4">
                        <table class="min-w-full table-auto mt-4 datatable hover">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Penggunaan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach($penggunaan as $row)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->penggunaan }}</td>
                                    <td class="edit-button px-6 py-4 whitespace-nowrap flex">
                                        <a href="{{ route('penggunaan.edit', ['penggunaanId'=>$row->id]) }}"
                                            class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('penggunaan.destroy', ['penggunaanId'=>$row->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Aksi ini akan menghapus semua data yang berhubungnan dengan penggunaan {{ $row->penggunaan }}. Apakah Anda yakin ingin kategori penggunaan ini?  ')"
                                                class="text-red-600"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin>