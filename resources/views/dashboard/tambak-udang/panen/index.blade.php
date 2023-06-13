<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-2xl">Panen Udang Tambak MSTP-UNDIP</h1>

            {{-- Kembali --}}
            <a href="{{ route('data_kolam', ['kolam'=>$kolam->id, 'siklus'=>$siklus->id]) }}"
                class="mr-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>

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

                    @if ($siklusBerjalan)
                    <a href="{{ route('panen.create',  ['kolamId' => $kolam->id,'siklus'=>$siklus->id]) }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Tambah Catatan
                    </a>
                    @endif



                    <div class="w-full overflow-x-auto mt-4">
                        <table class="min-w-full table-auto mt-4 datatable">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" rowspan="2">
                                        Tanggal Panen</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" rowspan="2">
                                        Waktu Panen</th>
                                    <th
                                        style="text-align:center;" class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" colspan="3">
                                        Tonase</th>
                                    <th
                                        style="text-align:center;" class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" colspan="2">
                                        Size</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" rowspan="2">
                                        Populasi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" rowspan="2">
                                        ABW</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" rowspan="2">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" rowspan="2">
                                        Catatan</th>
                                    @if ($siklusBerjalan)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" rowspan="2">
                                        Aksi</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Besar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kecil</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Besar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kecil</th>
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
                                    @if ($siklusBerjalan)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('panen.edit', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'panen'=>$row->id]) }}"
                                            class="text-yellow-600">Edit</a>
                                        <form
                                            action="{{ route('panen.destroy', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'panen'=>$row->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Aksi ini tidak dapat dibatalkan! Apakah Anda yakin ingin menghapus data ini? ')"
                                                class="text-red-600">Hapus Data</button>
                                        </form>

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