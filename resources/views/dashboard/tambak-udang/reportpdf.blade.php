<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Budidaya Siklus {{ $siklus->tanggal_mulai }}</title>

    <style>
        .w-full {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .table {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            border-collapse: collapse;
            text-align: center;
            margin-top: 10px;
            /* width: 100%; */
        }

        .table td,
        .table th {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #bdc8ff;
            /* color: white; */
            text-align: center;
        }

        p {
            margin: 0;
            padding: 0;
        }

        h3 {
            margin: 20px 0 5px 0;
        }

        h4 {
            margin: 10px 0 5px 0;
        }

        h5 {
            margin: 0;
        }

        .mb {
            margin-bottom: 10px
        }

        .text-red {
            color: red;
        }

        .text-green {
            color: green;
        }

        .caption {
            font-style: italic;
            color: gray;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h1>Laporan Budidaya Udang</h1>
        <h4>CV Riz Samudera</h4>
    </div>

    <section>
        <h3>Rekap Kolam</h3>
        <table>
            <tr>
                <td>Periode Siklus</td>
                <td>: {{ \Carbon\Carbon::parse($siklus->tanggal_mulai)->isoFormat('D MMMM YYYY') }} - {{
                    $siklus->tanggal_selesai ? \Carbon\Carbon::parse($siklus->tanggal_selesai)->isoFormat('D MMMM YYYY')
                    : '(Berjalan)' }}</td>
            </tr>
            <tr>
                <td>Jumlah Kolam </td>
                <td>: {{ $siklus->kolam->count() }}</td>
            </tr>
        </table>

        {{-- Tabel kolam yang digunakan siklus --}}
        <div>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Kolam</th>
                        <th>Tipe</th>
                        <th>Luas (m<sup>2</sup>)</th>
                        <th>Jumlah tebar</th>
                        <th>Total Pakan (Kg)</th>
                        <th>Tonase Panen (Kg)</th>
                        <th>SR %</th>
                        <th>FCR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataRekap as $d)
                    <tr>
                        <td><a href="#{{ $d['kolam']->nama }}">{{ $d['kolam']->nama }}</a>
                        </td>
                        <td>{{ $d['kolam']->tipe }}</td>
                        <td>{{ $d['kolam']->luas }}</td>
                        <td>{{ $d['kolam']->pivot->jumlah_tebar }}</td>
                        <td>{{ $d['pakan']->sum('jumlah_kg') }}</td>
                        <td>{{ $d['panen']->sum('tonase_jumlah') }}</td>
                        <td>{{ $d['sr'] }}</td>
                        <td>{{ $d['fcr'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <h3>Ringkasan</h3>
            @if ($rataSR >= 80 && $rataSR <= 100) <h4>Hasil panen <span class="text-green">baik</span></h4>
                <p>Dilihat dari rata-rata hasil akhir survival rate (SR) yaitu <span class="text-green">{{ $rataSR
                        }} %</span> dapat
                    dikatakan
                    hasil panen baik.</p>
                @else
                <h4>Hasil panen <span class="text-red">kurang baik</span></h4>
                <p>Dilihat dari rata-rata hasil akhir survival rate (SR) yaitu <span class="text-red">{{ $rataSR }}
                        %</span> dapat
                    dikatakan
                    hasil panen kurang baik.</p>
                <p class="caption">*Nilai SR ideal > 80 %</p>
                @endif

                @if ($rataFCR >= 1.1 && $rataFCR <= 1.2) <h4>Nilai FCR <span class="text-green">sudah ideal</span></h4>
                    <p>Dilihat dari rata-rata hasil akhir feed conversion ratio (FCR) yaitu <span class="text-green">{{
                            $rataFCR }}</span> dapat dikatakan
                        sudah ideal.</p>
                    @else
                    <h4>Nilai FCR <span class="text-red">kurang ideal</span></h4>
                    <p>Dilihat dari rata-rata hasil akhir feed conversion ratio (FCR) yaitu <span class="text-red">{{
                            $rataFCR
                            }}</span> dapat
                        dikatakan
                        tidak ideal.</p>
                    <p class="caption">*NIlai FCR ideal 1.1 - 1.2</p>
                    @endif
                    @if ($rataADG >= 0.2 && $rataADG <= 0.5) <h4>Pertumbuhan udang <span class="text-green">sudah
                            ideal</span></h4>
                        <p>Dilihat dari rata-rata hasil akhir ADG yaitu <span class="text-green">{{
                                $rataADG }}</span> dapat dikatakan
                            sudah ideal.</p>
                        @else
                        <h4>Pertumbuhan udang <span class="text-red">kurang ideal</span></h4>
                        <p>Dilihat dari rata-rata hasil akhir ADG yaitu <span class="text-red">{{
                                $rataADG
                                }}</span> dapat
                            dikatakan
                            tidak ideal.</p>
                        <p class="caption">*Nilai ADG ideal 0.2 - 0.5</p>
                        @endif
                        @if (($rataSuhu <26 || $rataSuhu> 32) && ($rataPH <7.5 || $rataPH> 8.5) && ($rataDO <5 ||
                                    $rataDO> 8) && ($rataSal <20 || $rataSal> 35) ) <h4>Kualitas air kolam <span
                                                class="text-green">sudah
                                                stabil</span></h4>
                                        <p>Kolam yang stabil dapat meningkatkan pertumbuhan dan kelangsungan hidup
                                            udang.</p>
                                        @else
                                        <h4>Kualitas air kolam <span class="text-red">kurang stabil</span></h4>
                                        <p>Kolam yang kurang stabil dapat menurunkan pertumbuhan dan kelangsungan hidup
                                            udang. Silahkan cek detail monitoring kualitas air masing-masing kolam.</p>
                                        <p class="caption">*Parameter ideal : pH 7.5 -8.5; Suhu 26-32 &deg;C; DO 5-8
                                            mg/L; Salinitas 20-35ppt.</p>
                                        @endif
        </div>
    </section>

    @foreach ($dataRekap as $d)
    <div style="page-break-before: always;"></div> <!-- Pemisah halaman -->
    <section>
        <div class="text-center">
            <h2 id="{{ $d['kolam']->nama }}">Kolam {{ $d['kolam']->nama }}</h2>
            <h4>{{ \Carbon\Carbon::parse($siklus->tanggal_mulai)->isoFormat('D MMMM YYYY') }} - {{
                $siklus->tanggal_selesai ? \Carbon\Carbon::parse($siklus->tanggal_selesai)->isoFormat('D MMMM YYYY')
                : '(Berjalan)' }}</h4>
        </div>

        <table>
            <tr>
                <td>Nama Kolam</td>
                <td>: {{ $d['kolam']->nama }}</td>
            </tr>
            <tr>
                <td>Tipe Kolam </td>
                <td>: {{ $d['kolam']->tipe }}</td>
            </tr>
            <tr>
                <td>Lokasi Kolam </td>
                <td>: {{ $d['kolam']->lokasi }}</td>
            </tr>
            <tr>
                <td>Luas Kolam</td>
                <td>: {{ $d['kolam']->luas }}</td>
            </tr>
            <tr>
                <td>Jumlah Tebar</td>
                <td>: {{ $d['kolam']->pivot->jumlah_tebar }}</td>
            </tr>
        </table>

        {{-- Data Monitoring --}}
        <div>
            <h3>Data Monitoring Kualitas Air</h3>
            <p>Berikut merupakan rekap data pencatatan kualitas air pada kolam :</p>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        <th colspan="2">PH</th>
                        <th colspan="2">Suhu (&deg;C)</th>
                        <th colspan="2">DO (mg/L)</th>
                        <th colspan="2">Salinitas (ppt)</th>
                    </tr>
                    <tr>
                        <th>Pagi</th>
                        <th>Sore</th>
                        <th>Pagi</th>
                        <th>Sore</th>
                        <th>Pagi</th>
                        <th>Sore</th>
                        <th>Pagi</th>
                        <th>Sore</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($d['monitoring'] as $monitoring => $data)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($data[0]->tanggal)) }}</td>
                        <td class="{{ ($data[0]->ph < 7.5 || $data[0]->ph > 8.5) ? 'text-red' : '' }}">{{ $data[0]->ph
                            }}</td>
                        <td
                            class="{{ isset($data[1]) && ($data[1]->ph < 7.5 || $data[1]->ph > 8.5) ? 'text-red' : '' }}">
                            {{ $data[1]->ph ?? '-' }}</td>
                        <td class="{{ ($data[0]->suhu < 26 || $data[0]->suhu > 32) ? 'text-red' : '' }}">{{
                            $data[0]->suhu }}</td>
                        <td
                            class="{{ isset($data[1]) && ($data[1]->suhu < 26 || $data[1]->suhu > 32) ? 'text-red' : '' }}">
                            {{
                            $data[1]->suhu ?? '-' }}</td>
                        <td class="{{ ($data[0]->do < 5 || $data[0]->do > 8) ? 'text-red' : '' }}">{{ $data[0]->do }}
                        </td>
                        <td class="{{ isset($data[1]) && ($data[1]->do < 5 || $data[1]->do > 8) ? 'text-red' : '' }}">{{
                            $data[1]->do ?? '-' }}</td>
                        <td class="{{ ($data[0]->salinitas < 20 || $data[0]->salinitas > 35) ? 'text-red' : '' }}">{{
                            $data[0]->salinitas }}</td>
                        <td
                            class="{{ isset($data[1]) && ($data[1]->salinitas < 20 || $data[1]->salinitas > 35) ? 'text-red' : '' }}">
                            {{ $data[1]->salinitas ?? '-' }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>Rata-rata</td>
                        <td class="{{ ($d['monitoringAll']->avg('ph') < 7.5 || $d['monitoringAll']->avg('ph') > 8.5) ? 'text-red' : '' }}"
                            colspan="2">{{ round($d['monitoringAll']->avg('ph'), 2) }}</td>
                        <td class="{{ ($d['monitoringAll']->avg('suhu') < 26 || $d['monitoringAll']->avg('suhu') > 32) ? 'text-red' : '' }}"
                            colspan="2">{{ round($d['monitoringAll']->avg('suhu'), 2) }}</td>
                        <td class="{{ ($d['monitoringAll']->avg('do') < 5 || $d['monitoringAll']->avg('do') > 8) ? 'text-red' : '' }}"
                            colspan="2">{{ round($d['monitoringAll']->avg('do'), 2) }}</td>
                        <td class="{{ ($d['monitoringAll']->avg('salinitas') < 20 || $d['monitoringAll']->avg('salinitas') > 35) ? 'text-red' : '' }}"
                            colspan="2">{{ round($d['monitoringAll']->avg('salinitas'), 2) }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="caption">*Parameter ideal : pH 7.5 -8.5; Suhu 26-32 &deg;C; DO 5-8 mg/L; Salinitas 20-35ppt.</p>
        </div>

        <div>
            <h3>Data Pakan</h3>
            <p>Berikut merupakan rekap data pencatatan pemberian pakan udang pada kolam :</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pakan / Hari (Kg)</th>
                        <th>Pakan Kumulatif (Kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($d['detailPakan'] as $pakan => $row)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
                        <td>{{ $row->total_pakan}}</td>
                        <td>{{ $row->total_pakan_kumulatif}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <h3>Data Sampling</h3>
            <p>Berikut merupakan rekap data pencatatan hasil sampling udang pada kolam :</p>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Umur</th>
                        <th>ABW</th>
                        <th>ADG</th>
                        <th>Size</th>
                        <th>FR %</th>
                        <th>SR %</th>
                        <th>Biomassa (Kg)</th>
                        <th>FCR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($d['sampling'] as $sampling)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($sampling->tanggal)) }}</td>
                        <td>{{ $sampling->umur }}</td>
                        <td>{{ $sampling->abw }}</td>
                        <td>{{ $sampling->adg }}</td>
                        <td>{{ $sampling->size }}</td>
                        <td>{{ $sampling->fr }}</td>
                        <td>{{ $sampling->sr }}</td>
                        <td>{{ $sampling->biomas }}</td>
                        <td>{{ $sampling->fcr }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <h3>Data Panen</h3>
            <p>Berikut merupakan rekap data pencatatan hasil panen udang pada kolam :</p>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal Panen</th>
                        <th rowspan="2">Status</th>
                        <th colspan="3">Tonase</th>
                        <th colspan="2">Size</th>
                        <th rowspan="2">Populasi</th>
                        <th rowspan="2">ABW</th>
                    </tr>
                    <tr>
                        <th>Besar</th>
                        <th>Kecil</th>
                        <th>Jumlah</th>
                        <th>Besar</th>
                        <th>Kecil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($d['panen'] as $panen)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($panen->tanggal)) }}</td>
                        <td>{{ $panen->status }}</td>
                        <td>{{ $panen->tonase_besar }}</td>
                        <td>{{ $panen->tonase_kecil }}</td>
                        <td>{{ $panen->tonase_jumlah }}</td>
                        <td>{{ $panen->size_besar }}</td>
                        <td>{{ $panen->size_kecil }}</td>
                        <td>{{ $panen->populasi_terambil }}</td>
                        <td>{{ $panen->abw }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @endforeach

    <div style="page-break-before: always;"></div> <!-- Pemisah halaman -->

    <section>
        <div class="text-center">
            <h2>Riwayat Perlakuan Udang</h2>
            <h4>{{ \Carbon\Carbon::parse($siklus->tanggal_mulai)->isoFormat('D MMMM YYYY') }} - {{
                $siklus->tanggal_selesai ? \Carbon\Carbon::parse($siklus->tanggal_selesai)->isoFormat('D MMMM YYYY')
                : '(Berjalan)' }}</h4>
        </div>

        @foreach ($dataRekap as $d)
        <h3>Kolam {{ $d['kolam']->nama }}</h3>
        <table class="table w-full">
            <thead>
                <tr>
                    <th width="150px">Tanggal</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($d['perlakuan'] as $perlakuan)
                <tr>
                    @if ($perlakuan->tanggal)
                    <td>{{ $perlakuan->tanggal }}</td>
                    <td>{!! nl2br(e($perlakuan->catatan)) !!}</td>
                    @else
                    <td colspan="2">tidak ada data</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach

    </section>

</body>

</html>