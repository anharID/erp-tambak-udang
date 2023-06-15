<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-xl">Manajemen Peralatan</h1>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w- full p-6 overflow-hidden">
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    <a href="{{ route('peralatan.create') }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Tambah Peralatan
                    </a>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full table-auto mt-4 datatable">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Alat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Alat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kondisi Alat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Maintenance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Catatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach($peralatan as $row)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama_alat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->jumlah_alat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->kondisi_alat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->maintenance }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex">
                                        <a href="{{ route('peralatan.edit', $row->id) }}" class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('peralatan.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus peralatan ini?')" class="text-red-600"><i class="fa-solid fa-trash"></i></button>
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
