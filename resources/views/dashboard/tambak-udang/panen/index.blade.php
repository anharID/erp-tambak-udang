<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <div class="flex flex-row items-center mb-4">
                {{-- Kembali --}}
                <a href="{{ route('data_kolam', ['kolam' => $kolam->id, 'siklus' => $siklus->id]) }}"
                    class="mr-2 flex items-center justify-center bg-gray-300 rounded-full w-8 h-8">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h1 class="font-bold text-2xl">Panen Udang Kolam {{ $kolam->nama }}</h1>
            </div>

            @if ($siklusTerpilih)
            <div class="my-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full p-6">

                    {{-- Alert --}}
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif
                    {{-- @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M14.348 14.849c-.244.244-.642.243-.885-.001l-3.464-3.464-3.464 3.464c-.243.243-.642.244-.885.001-.244-.244-.243-.642.001-.885l3.464-3.464-3.464-3.464c-.244-.244-.244-.642 0-.885.243-.243.642-.244.885 0l3.464 3.464 3.464-3.464c.243-.244.642-.243.885 0 .244.243.243.641-.001.885l-3.464 3.464 3.464 3.464c.243.243.243.641 0 .885z">
                                </path>
                            </svg>
                        </span>
                    </div>
                    @endif --}}

                    @if ($siklusBerjalan)
                    <a href="{{ route('panen.create',  ['kolamId' => $kolam->id,'siklus'=>$siklus->id]) }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Catatan
                    </a>
                    @endif

                    <div class="w-full overflow-x-auto mt-4">
                        <table class="min-w-full table-auto mt-4 datatable">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        Tanggal Panen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        Waktu Panen</th>
                                    <th style="text-align:center;"
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        colspan="3">
                                        Tonase</th>
                                    <th style="text-align:center;"
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        colspan="2">
                                        Size</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        Populasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        ABW</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        Catatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        Validasi</th>
                                    @if ($siklusBerjalan)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                        rowspan="2">
                                        Aksi</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Besar</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kecil</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jumlah</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Besar</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kecil</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach($siklusTerpilih as $row)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->waktu_panen }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tonase_besar }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tonase_kecil }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tonase_jumlah }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->size_besar }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->size_kecil }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->populasi_terambil }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->abw }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->is_validated == 0 ? 'Belum' :
                                        'Sudah' }}</td>

                                    @if ($siklusBerjalan)
                                    <td class="px-6 py-4 whitespace-nowrap flex">
                                        @can('hakTeknisi')
                                        @if ($row->is_validated == 0)
                                        <form
                                            action="{{ route('validasi_panen', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'panen'=>$row->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Aksi ini tidak dapat dibatalkan! Tandai catatan ini sebagai sudah divalidasi? ')"
                                                class="text-green-600 mr-4"><i
                                                    class="fa-regular fa-circle-check"></i></button>
                                        </form>
                                        @endif
                                        @endcan
                                        @if ($row->is_validated == 0 || auth()->user()->role === "superadmin")
                                        <a href="{{ route('panen.edit', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'panen'=>$row->id]) }}"
                                            class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form
                                            action="{{ route('panen.destroy', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'panen'=>$row->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Aksi ini tidak dapat dibatalkan! Apakah Anda yakin ingin menghapus catatan ini? ')"
                                                class="text-red-600"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <h1>tidak ada siklus berjalan</h1>



            @endif
        </div>
    </div>
</x-admin>