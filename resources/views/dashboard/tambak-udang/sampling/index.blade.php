@php
$param = request()->input('chart');
@endphp

<x-admin>
    <div class="container grid py-12">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100 overflow-hidden">
            <div class="flex flex-row items-center mb-4">
                {{-- Kembali --}}
                <a href="{{ route('data_kolam', ['kolam' => $kolam->id, 'siklus' => $siklus->id]) }}"
                    class="mr-2 flex items-center justify-center bg-gray-300 rounded-full w-8 h-8">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h1 class="font-bold text-2xl">Sampling Udang Kolam {{ $kolam->nama }}</h1>
            </div>

            @if ($siklusTerpilih)
            <div class="mb-8">
                <select
                    class="mr-2 mb-2 w-60 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2"
                    name="chart" onchange="location = this.value;">
                    <option value="">Pilih Grafik</option>
                    <option
                        value="{{ route('sampling.index', ['chart' => 'abw', 'kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}"
                        {{ $param=='abw' ? 'selected' : '' }}>
                        Chart ABW</option>
                    <option
                        value="{{ route('sampling.index', ['chart' => 'adg', 'kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}"
                        {{ $param=='adg' ? 'selected' : '' }}>
                        Chart ADG</option>
                    <option
                        value="{{ route('sampling.index', ['chart' => 'size', 'kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}"
                        {{ $param=='size' ? 'selected' : '' }}>
                        Chart Size</option>
                    <option
                        value="{{ route('sampling.index', ['chart' => 'sr', 'kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}"
                        {{ $param=='sr' ? 'selected' : '' }}>
                        Chart SR</option>
                    <option
                        value="{{ route('sampling.index', ['chart' => 'fcr', 'kolamId' => $kolam->id, 'siklus' => $siklus->id]) }}"
                        {{ $param=='fcr' ? 'selected' : '' }}>
                        Grafik FCR</option>
                </select>
                <div class="min-w-0 h-96 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <canvas id="myChart">
                        <p>Your browser does not support the canvas element.</p>
                    </canvas>

                </div>
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

                    @if ($siklusBerjalan)
                    <a href="{{ route('sampling.create',  ['kolamId' => $kolam->id,'siklus'=>$siklus->id]) }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Tambah Catatan
                    </a>
                    @endif



                    <div class="w-full overflow-x-auto mt-4">
                        <table class="min-w-full table-auto mt-4 datatable">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Umur</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        ABW</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        ADG</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Size</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        FR %</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        SR %</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Biomassa</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        FCR</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->umur }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->abw }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->adg }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->size }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->fr }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->sr }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->biomas }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->fcr }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->catatan }}</td>
                                    @if ($siklusBerjalan)
                                    <td class="px-6 py-4 whitespace-nowrap flex">
                                        <a href="{{ route('sampling.edit', ['kolamId'=>$kolam->id, 'siklus'=>$siklus->id, 'sampling'=>$row->id]) }}"
                                            class="text-yellow-600 mr-4"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form
                                            action="{{ route('sampling.destroy', ['kolamId'=>$kolam->id,'siklus'=>$siklus->id,'sampling'=>$row->id]) }}"
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

<script type="module" src="{{ Vite::asset('resources/js/chartSampling.js') }}" defer></script>
<script>
    const chartData = @JSON($chartData);
</script>