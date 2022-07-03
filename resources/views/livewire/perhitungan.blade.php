<x-slot name="header">
    <h2 class="text-center">Halaman Perhitungan AHP->TOPSIS->BORDA</h2><hr class="mt-3">
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
        <p>Silahkan Pilih Decision Maker : </p>
    @foreach ($this->decisioner as $dm => $data)
    <button class="btn btn-primary btn-sm decission" data-id="{{ $data->kode }}">Perhitungan {{ $data->nama }}</button>
    @endforeach
    <button class="btn btn-primary btn-sm" onclick="borda()">Borda</button>
    <button class="btn btn-primary btn-sm" onclick="reset()">Reset</button>
    <hr class="mb-5 mt-4">
    
    @foreach ($this->decisioner as $dm => $data)
    <div id="{{$data->kode}}" class="show-data " data-id="{{$data->kode}}" style="display:none;">
    DECISIONER {{ $data->nama }} <br>
    <div class="w-full bg-blue-300 p-4 mb-5">AHP</div>

    <p> 1. MATRIKS PERBANDINGAN</p>
    <span>(*Membentuk sebuah matriks dengan menggunakan pendapat dari setiap DMs)</span>
    <table class="text-center w-3/4 border mb-6">
        <thead class="table-primary">
            <tr>
                <td class="table-warning">Kriteria</td>
                @foreach($this->kriteriaas as $krit)
                <td>{{$krit->nama}}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($matriksahp[$dm] as $index => $item)
            <tr class="border">
                <td class="table-primary">{{ $namakriteria[$index]->nama }}</td>
                @foreach ($item as $colum)
                <td <?php if($colum == 1){echo"class='table-success'";} ?>>{{ $colum }}</td>
                @endforeach
            </tr>
            @endforeach
            <tr>
                <td class="table-danger">Total</td>
                @foreach ($tmatriksahp[$dm] as $item)
                <td class="table-danger">
                    {{ $item }}
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>

   <p> 2. Normalisasi</p>
   <span>(* Matriks Normalisasi di butuhkan untuk mencari prioritas masing-masing kriteria)</span>

    <table class="text-center w-3/4 border mb-6">
        <thead class="table-primary">
            <tr>
                <td class="table-warning">Kriteria</td>
                @foreach($this->kriteriaas as $krit)
                <td>{{$krit->nama}}</td>
                @endforeach
                <td class="table-danger">JUMLAH</td>
                <td class="table-danger">Bobot/Rata-Rata</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($normalisasiahp[$dm] as $key => $item)
            <tr class="border">
                <td class="table-primary"> {{$namakriteria[$key]->nama}} </td>
                @foreach ($item as $colum)
                <td>{{ round($colum,3) }}</td>
                @endforeach

                <td>
                    {{ round($jnormalisasiahp[$dm][$key],3 )}}
                </td>
                <td>
                    {{ round($bnormalisasiahp[$dm][$key],3 )}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <p> 3. LamdaMAX = {{ round($lambda[$dm], 3) }}</p><span>(* Perhitungan LamdaMAX Total Matriks Perbandingan dan Rata-Rata Normalisasi Setiap Kriteria)</span> <br><br>
    <p> 4. Konsistensi Index = {{ round($consistencyindex[$dm], 3) }}</p><span>(* Konsistensi Index Alias CI Merupakan Perhitungan dari LamdaMAX-N/N-1 )</span> <br><br>
    <p> 5. Konsistensi Rasio = {{ round($consistencyrasio[$dm], 3) }} @if(round($consistencyrasio[$dm], 3)<0.1) <span class="text-primary h4"><b>Nilai Konsisten</b></span> @else <span class="text-danger h4"> <b>Nilai Tidak Konsisten</b></span> @endif</p><span>(* Konsistensi Rasio Alias CR Merupakan Perhitungan untuk Mengecek Konsisten dari Perhitungan, Dimana Perhitungan Di  Anggap Konsisten Apabila Nilai CR < 0.1, CR hasil perhitungan dari CI/IR dimana IR untuk 5 Kriteria adalah 1.12)</span> <br><br>

    <hr>
    <div class="w-full bg-blue-300 p-4 mb-5">TOPSIS</div>

    <div class="w-full bg-blue-300 p-4 mb-5">
        <p class="text-sm">Matrik Keputusan</p>
    </div>
    <table class="md:table-fixed sm:table-auto w-full">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                <th>kode</th>
                <th>Nama</th>
                <th>C1</th>
                <th>C2</th>
                <th>C3</th>
                <th>C4</th>
                <th>C5</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alternatifkriteria[$dm] as $value =>$row)
            <tr>
                <td class="truncate border px-4 py-2 ">{{ $alternatif[$value]->kodetanaman }}</td>
                <td class="truncate border px-4 py-2">{{ $alternatif[$value]->namatanaman }}</td>
                <td class="truncate border px-4 py-2 text-center">{{ $row[0]}}</td>
                <td class="truncate border px-4 py-2 text-center">{{ $row[1]}}</td>
                <td class="truncate border px-4 py-2 text-center">{{ $row[2]}}</td>
                <td class="truncate border px-4 py-2 text-center">{{ $row[3]}}</td>
                <td class="truncate border px-4 py-2 text-center">{{ $row[4]}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
<br>
    <div class="w-full bg-blue-300 p-4 mb-5">
        <p class="text-sm">Matrik Ternormalisasi</p>
    </div>
    <table class="md:table-fixed sm:table-auto w-full">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Jenis Tanah<br>(C1)</th>
                <th class="px-4 py-2">Curah Hujan<br>(C2)</th>
                <th class="px-4 py-2">Kelembaban<br>(C3)</th>
                <th class="px-4 py-2">Ketinggian<br>(C4)</th>
                <th class="px-4 py-2">Suhu Udara (C)<br>(C5)</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($ternormalisasi[$dm]); $i++) <tr>
                <td class="truncate border px-4 py-2 text-center">{{ round($ternormalisasi[$dm][$i][0], 3) }}</td>
                <td class="truncate border px-4 py-2 text-center">{{ round($ternormalisasi[$dm][$i][1], 3) }}</td>
                <td class="truncate border px-4 py-2 text-center">{{ round($ternormalisasi[$dm][$i][2], 3) }}</td>
                <td class="truncate border px-4 py-2 text-center">{{ round($ternormalisasi[$dm][$i][3], 3) }}</td>
                <td class="truncate border px-4 py-2 text-center">{{ round($ternormalisasi[$dm][$i][4], 3) }}</td>
                </tr>
                @endfor
        </tbody>
    </table><br>
    <div class="w-full bg-blue-300 p-4 mb-5">
        <p class="text-sm">Matrik Ternormalisasi Terbobot</p>
    </div>
    <table class="md:table-fixed sm:table-auto w-full">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                @foreach($tipekriteria[$dm] as $kode => $benefitco)
                <th class="px-2 py-2">C{{ $kode+1 }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($tipekriteria[$dm] as $nilai)
                <td class="border px-4 py-2 text-center">{{ $nilai }}</td>
                @endforeach
            </tr>
            <tr>
                @foreach($bnormalisasiahp[$dm] as $nilai)
                <td class="border px-4 py-2 text-center">{{ round($nilai, 3) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <table class="md:table-fixed sm:table-auto w-full my-10 text-sm">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Jenis Tanah<br>(C1)</th>
                <th class="px-4 py-2">Curah Hujan<br>(C2)</th>
                <th class="px-4 py-2">Kelembaban<br>(C3)</th>
                <th class="px-4 py-2">Ketinggian<br>(C4)</th>
                <th class="px-4 py-2">Suhu Udara (C)<br>(C5)</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($ternormalisasiterbobot[$dm]); $i++) <tr>
                <td class="truncate border px-2 py-2 text-center">{{ round($ternormalisasiterbobot[$dm][$i][0], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($ternormalisasiterbobot[$dm][$i][1], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($ternormalisasiterbobot[$dm][$i][2], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($ternormalisasiterbobot[$dm][$i][3], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($ternormalisasiterbobot[$dm][$i][4], 3) }}</td>
                </tr>
                @endfor
        </tbody>
    </table><br>
    <div class="w-full bg-blue-300 p-4 mb-5">
        <p class="text-sm">Matrik Ideal Positif dan Negatif</p>
    </div>
    <table class="md:table-fixed sm:table-auto w-full text-sm">
        <tbody>
            <tr>
                <td class="border px-4 py-2 text-center bg-gray-200">A+</td>
                @for($i = 0; $i < count($Aplus[$dm]); $i++) <td class="truncate border px-2 py-2 text-center">{{
                    round($Aplus[$dm][$i], 3) }}</td>
                    @endfor
            </tr>
            <tr>
                <td class="border px-4 py-2 text-center bg-gray-200">A-</td>
                @for($i = 0; $i < count($Amin[$dm]); $i++) <td class="truncate border px-2 py-2 text-center">{{
                    round($Amin[$dm][$i], 3) }}</td>
                    @endfor
            </tr>
        </tbody>
    </table><br>
    <div class="w-full bg-blue-300 p-4 mb-5">
        <p class="text-sm"> Jarak Setiap Alternatif dengan Matriks Solusi Ideal Positif & Solusi Ideal Negatif</p>
    </div>
    <table class="md:table-fixed sm:table-auto w-full text-sm">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                <th class="px-4 py-2">D+</th>
                <th class="px-4 py-2">Jenis Tanah<br>(C1)</th>
                <th class="px-4 py-2">Curah Hujan<br>(C2)</th>
                <th class="px-4 py-2">Kelembaban<br>(C3)</th>
                <th class="px-4 py-2">Ketinggian<br>(C4)</th>
                <th class="px-4 py-2">Suhu Udara (C)<br>(C5)</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($jarakDplus[$dm]); $i++) <tr>
                <td class="truncate border px-2 py-2 text-center">{{ round($Dplus[$dm][$i], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDplus[$dm][$i][0], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDplus[$dm][$i][1], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDplus[$dm][$i][2], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDplus[$dm][$i][3], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDplus[$dm][$i][4], 3) }}</td>
                </tr>
                @endfor
        </tbody>
    </table>
    <table class="md:table-fixed sm:table-auto w-full my-10 text-sm">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                <th class="px-4 py-2">D-</th>
                <th class="px-4 py-2">Jenis Tanah<br>(C1)</th>
                <th class="px-4 py-2">Curah Hujan<br>(C2)</th>
                <th class="px-4 py-2">Kelembaban<br>(C3)</th>
                <th class="px-4 py-2">Ketinggian<br>(C4)</th>
                <th class="px-4 py-2">Suhu Udara (C)<br>(C5)</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($jarakDmin[$dm]); $i++) <tr>
                <td class="truncate border px-2 py-2 text-center">{{ round($Dmin[$dm][$i], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDmin[$dm][$i][0], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDmin[$dm][$i][1], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDmin[$dm][$i][2], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDmin[$dm][$i][3], 3) }}</td>
                <td class="truncate border px-2 py-2 text-center">{{ round($jarakDmin[$dm][$i][4], 3) }}</td>
                </tr>
                @endfor
        </tbody>
    </table><br>
    <div class="w-full bg-blue-300 p-4 mb-5">
        <p class="text-sm"> Hasil</p>
    </div>
    <table class="md:table-fixed sm:table-auto w-full/2 text-lg ">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Kode</th>
                <th class="px-4 py-2">Nama Tanaman</th>
                <th class="px-4 py-2">Hasil</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil[$dm] as $nilai)
            <tr>
                <td class="border px-2 py-2 ">{{ $nilai['kode'] }}</td>
                <td class="border px-2 py-2 ">{{ $nilai['nama_tanaman'] }}</td>
                <td class="border px-2 py-2 text-center">{{ round($nilai['hasil'], 3) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table><br>
    <div class="w-full bg-blue-300 p-4 mb-5">
        <p class="text-sm"> Hasil Ranking</p>
    </div>
    <table class="md:table-fixed sm:table-auto w-full/2 text-lg ">
        <thead class="table-primary">
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Kode</th>
                <th class="px-4 py-2">Nama Tanaman</th>
                <th class="px-4 py-2">Hasil</th>
                <th class="px-4 py-2">Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasilRanking[$dm] as $key => $nilai)
            <tr>
                <td class="border px-2 py-2 ">{{ $nilai['kode'] }}</td>
                <td class="border px-2 py-2 ">{{ $nilai['nama_tanaman'] }}</td>
                <td class="border px-2 py-2 text-center">{{ round($nilai['hasil'], 3) }}</td>
                <td class="border px-2 py-2 text-center">{{ $key+1 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    @endforeach

    <div class="w-full p-4 mb-5" id="borda" style="display: none;">BORDA
    <table class="md:table-fixed sm:table-auto w-full">
        <thead class="table-primary">
            <tr class="border">
                <th class="px-1 py-2 text-sm border-r" rowspan="3"> Kode Tanaman</th>
            </tr>
            <tr class="border">
                <th class="px-4 py-2 text-sm text-center border-r" colspan="{{ count($hasilBordaRanking) }}">
                    Hasil Peringkat TOPSIS
                </th>
                <th class="px-4 py-2 text-sm border-r" rowspan="2"> Score Borda</th>
                <th class="px-1 py-2 text-sm text-center" rowspan="2"> Ranking</th>
            </tr>
            <tr>
                @foreach ($hasilBordaRanking as $key => $item)
                <th class="px-2 py-2 text-sm bg-blue-300">{{$key+1}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($alternatif as $index => $row)
            <tr>
                <td class="border px-4 py-2 table-primary">{{$row->kodetanaman}}</td>
                @foreach ($peringkat as $index2 => $col)
                <td class="border text-center @if($peringkat[$index][$index2]>0) table-warning @endif">{{ $peringkat[$index][$index2] }}</td>
                @endforeach
                <td class="text-center border "> {{ $hasilBorda[$index]['hasil'] }}</td>
                @foreach ($hasilBordaRanking as $key => $item)
                @if($item['nama_tanaman'] == $row['namatanaman'])
                <td class="border text-center">{{ $key+1 }}</td>
                @endif
                @endforeach
                {{-- @foreach($hasilRanking[$key] as $hasil)
                <td class="border px-4 py-2 ">{{ $hasil['n_bibit'] }}<br>({{$hasil['kode']}})</td>
                @endforeach --}}
            </tr>
            @endforeach
            <tr>
                <td class="border px-4 py-2 font-bold ">Total Bobot</td>
                @foreach ($hasilBordaRanking as $key => $item)
                <th class="px-2 py-1 text-sm bg-blue-300 "><span>{{$set}}</span></th>
                @php
                $set--;
                @endphp
                @endforeach
            </tr>
        </tbody>
    </table>
    <div class="flex ">

        <div
            class="w-full bg-yellow-300 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-sm my-3 mt-10">
            <p class="text-sm text-center"> Hasil Akhir</p>
        </div>
    </div>

    <div class="flex justify-center ">

        <table class="md:table-fixed sm:table-auto w-full/2 text-lg ">
            <thead class="table-primary">
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Kode</th>
                    <th class="px-4 py-2">Nama Tanaman</th>
                    <th class="px-4 py-2">Total Nilai</th>
                    <th class="px-4 py-2">Ranking</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilBordaRanking as $key => $nilai)
                <tr>
                    <td class="border px-2 py-2 ">{{ $nilai['kode'] }}</td>
                    <td class="border px-2 py-2 ">{{ $nilai['nama_tanaman'] }}</td>
                    <td class="border px-2 py-2 text-center">{{ $nilai['hasil'] }}</td>
                    <td class="border px-2 py-2 text-center">{{ $key + 1 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
    </div></div>
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <script>
            $(".decission").click(function(){
                let id = $(this).data('id')
                
                let show = $('.show-data')

                show.each(function(){
                    if($(this).data('id') == id){
                        $(this).show()
                        $("#borda").hide()
                    }else{
                        $(this).hide()
                        $("#borda").hide()
                    }
                })
            })

            function borda(){
                document.getElementById('borda').style.display = 'block';
                <?php foreach ($this->decisioner as $dm => $data){                
            echo"document.getElementById('{$data->kode}').style.display = 'none';";
            }?>
            }
            function reset(){
                document.getElementById('borda').style.display = 'none';
                <?php foreach ($this->decisioner as $dm => $data){                
            echo"document.getElementById('{$data->kode}').style.display = 'none';";
            }?>
            }
    </script>