<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <h1 class="mb-4 font-bold text-2xl">Monitoring Kualitas Air Kolam {{ $kolam->nama }}</h1>

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
                    <a href="{{ route('monitoring.create',  ['kolamId' => $kolam->id,'siklus'=>$siklus->id]) }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Tambah Catatan
                    </a>
                    @endif

                    <div class="w-full overflow-x-auto mt-4">
                        <table class="min-w-full table-auto mt-4 datatable hover">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Waktu</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Suhu</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        pH</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        DO</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Salinitas</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kecerahan Air</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tinggi Air</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Warna Air</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Cuaca</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Amonia</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nitrit</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Catatan</th>
                                    @if ($siklusBerjalan)
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach($siklusTerpilih as $row)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->waktu_pengukuran }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->suhu }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->ph }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->do }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->salinitas }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->kecerahan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tinggi_air }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->warna_air }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->cuaca }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->amonia }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->nitrit }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                    @if ($siklusBerjalan)
                                    <td class="px-6 py-4 whitespace-nowrap flex">
                                        <a href="{{ route('monitoring.edit', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'monitoring'=>$row->id]) }}"
                                            class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form
                                            action="{{ route('monitoring.destroy', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'monitoring'=>$row->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Aksi ini tidak dapat dibatalkan! Apakah Anda yakin ingin menghapus kolam ini? ')"
                                                class="text-red-600"><i class="fa-solid fa-trash"></i></button>
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