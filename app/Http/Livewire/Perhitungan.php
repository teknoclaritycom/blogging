<?php

//BISMILLAH YA ALLAH

namespace App\Http\Livewire;

use App\Models\Alternatifs;
use App\Models\Decisioners;
use App\Models\Kriteriaas;
use App\Models\Kriterias;
use App\Models\Nilaikriterias;
use Livewire\Component;
use PDO;

class Perhitungan extends Component
{

    public $kriteriaas;
    // Variabel tuk AHP

    public $matriksahp = [];
    public $tmatriksahp = [];
    public $normalisasiahp = [];
    public $jnormalisasiahp = [];
    public $vnormalisasiahp = [];
    public $bnormalisasiahp = [];
    public $lambda = [];
    public $consistencyindex = [];
    public $consistencyrasio = [];
    public $dapatnol = false;
    public $namakriteria;

    // Variabel tuk TOPSIS

    public $decisioner;
    public $alternatif;
    public $alternatifkriteria;
    public $tipekriteria;
    public $pembagi;
    public $ternormalisasi;
    public $ternormalisasiterbobot;
    public $Aplus;
    public $Amin;
    public $jarakDplus;
    public $jarakDmin;
    public $Dplus;
    public $Dmin;
    public $hasil;
    public $hasilRanking;

    // Variabel BORDA

    public $set;
    public $hasilBorda;
    public $hasilBordaRanking;
    public $peringkat;

    public function mount()
    {        
        $this->decisioner = Decisioners::all();
        $this->alternatif = Alternatifs::get();
        $this->kriteriaas = Kriteriaas::all();
        $this->namakriteria = Kriteriaas::select('nama')->get();

        foreach ($this->decisioner as $index => $dm) {
            for ($baris = 0; $baris < 5; $baris++) {
                for ($kolom = 0; $kolom < 5; $kolom++) {
                    if (Nilaikriterias::where('idpertama', $baris + 1)->where('idkedua', $kolom + 1)->where('iddms', $dm->id)->exists()) {
                        $cek = Nilaikriterias::where('idpertama', $baris + 1)->where('idkedua', $kolom + 1)->where('iddms', $dm->id)->first();
                        $this->matriksahp[$index][$baris][$kolom] = $cek->value;
                    } else {
                        $this->matriksahp[$index][$baris][$kolom] = 0;
                    }
                }
            }
        }

        // foreach($this->decisioner as $index => $dm) {
        //     foreach($dm->nilaiKriteria as $nilaikriteria){
        //         $this->matriksahp[$index][$nilaikriteria->idpertama-1][$nilaikriteria->idkedua-1] = $nilaikriteria->value;
        //     }
        // }


        // MENCARI TOTAL MATRIKS
        foreach ($this->decisioner as $index => $dm) {
            for ($key = 0; $key < 5; $key++) {
                round($this->tmatriksahp[$index][$key] = 0 ,3);
                for ($keyy = 0; $keyy < 5; $keyy++) {
                    $this->tmatriksahp[$index][$key] += $this->matriksahp[$index][$keyy][$key];
                }
            }
        }

        // MENG NORMALISASI MATRIKS
        foreach ($this->decisioner as $index => $dm) {

            for ($key = 0; $key < 5; $key++) {
                for ($keyy = 0; $keyy < 5; $keyy++) {
                    $this->normalisasiahp[$index][$key][$keyy] = $this->matriksahp[$index][$key][$keyy] / $this->tmatriksahp[$index][$keyy];
                }
            }
        }

        // MENG JUMLAH MATRIKS
        foreach ($this->decisioner as $index => $dm) {

            for ($key = 0; $key < 5; $key++) {
                $this->jnormalisasiahp[$index][$key] = 0;
                for ($keyy = 0; $keyy < 5; $keyy++) {
                    $this->jnormalisasiahp[$index][$key] += $this->normalisasiahp[$index][$key][$keyy];
                }
            }
        }

        // MENG BOBOT
        foreach ($this->decisioner as $index => $dm) {

            for ($key = 0; $key < 5; $key++) {
                $this->bnormalisasiahp[$index][$key] = $this->jnormalisasiahp[$index][$key] / 5;
            }
        }

        // // Belajar Multiplication Matriks Aneh
        // foreach ($this->decisioner as $index => $dm) {

        //     for ($key = 0; $key < 5; $key++) {
        //         $this->bnormalisasiahp[$index][$key] = 0;
        //         for ($keyy = 0; $keyy < 5; $keyy++) {
        //             // if ($keyy = 2) {
        //             //     round($this->matriksahp[$index][$key][$keyy] * $this->vnormalisasiahp[$index][$keyy], 3);
        //             // }
        //             $this->bnormalisasiahp[$index][$key] = floor(($this->bnormalisasiahp[$index][$key] + $this->matriksahp[$index][$key][$keyy] * $this->vnormalisasiahp[$index][$keyy]) * 10000) / 10000;
        //             // if ($keyy = 1) {
        //             //     dd($this->bnormalisasiahp);
        //             // }
        //         }
        //         $this->bnormalisasiahp[$index][$key] = round($this->bnormalisasiahp[$index][$key] / $this->vnormalisasiahp[$index][$key], 3, PHP_ROUND_HALF_DOWN);
        //     }
        // }


        // MENENTUKAN LAMDA
        foreach ($this->decisioner as $index => $dm) {
            $this->lambda[$index] = 0;
            for ($key = 0; $key < 5; $key++) {
                $this->lambda[$index] = $this->lambda[$index] + ( $this->tmatriksahp[$index][$key] * $this->bnormalisasiahp[$index][$key]);                
            }   
                     
        }

        // MENGHITUNG CONSISTENCY INDEX
        foreach ($this->decisioner as $index => $dm) {
            $this->consistencyindex[$index] = ($this->lambda[$index] - 5) / (5 - 1);
        }
        // MENGHITUNG CONSISTENCY RASIO
        foreach ($this->decisioner as $index => $dm) {
            $this->consistencyrasio[$index] = $this->consistencyindex[$index] / 1.12;
        }


        // PERHITUNGAN TOPSIS

        // foreach ($this->decisioner as $index => $dm) {
        //     foreach ($this->alternatif as $key => $alternatif) {
        //         $this->alternatifkriteria[$index][$key][0] = $alternatif->c1;
        //         $this->alternatifkriteria[$index][$key][1] = $alternatif->c2;
        //         $this->alternatifkriteria[$index][$key][2] = $alternatif->c3;
        //         $this->alternatifkriteria[$index][$key][3] = $alternatif->c4;
        //         $this->alternatifkriteria[$index][$key][4] = $alternatif->c5;
        //     }
        // }

        foreach ($this->decisioner as $index => $dm) {
            foreach ($this->alternatif as $key => $alternatif) {
                foreach($alternatif->kriteria as $key_k => $score_kriteria){
                    $this->alternatifkriteria[$index][$key][$key_k] = $score_kriteria->pivot->score;
                }
            }
        }

        foreach ($this->decisioner as $index => $dm) {
            $tampung = Kriterias::where('kodedms', $dm->kode)->first();
            $this->tipekriteria[$index][0] = $tampung->c1;
            $this->tipekriteria[$index][1] = $tampung->c2;
            $this->tipekriteria[$index][2] = $tampung->c3;
            $this->tipekriteria[$index][3] = $tampung->c4;
            $this->tipekriteria[$index][4] = $tampung->c5;
        }


        // MENCARI PEMBAGI
        foreach ($this->decisioner as $index => $dm) {
            for ($i = 0; $i < 5; $i++) {
                $this->pembagi[$index][$i] = 0;
                for ($j = 0; $j < count($this->alternatifkriteria[$index]); $j++) {
                    $this->pembagi[$index][$i] = $this->pembagi[$index][$i] + pow($this->alternatifkriteria[$index][$j][$i], 2);
                }
                $this->pembagi[$index][$i] = sqrt($this->pembagi[$index][$i]);
            }
        }

        // MENORMALISASIKAN
        foreach ($this->decisioner as $index => $dm) {
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < count($this->alternatifkriteria[$index]); $j++) {
                    $this->ternormalisasi[$index][$j][$i] = $this->alternatifkriteria[$index][$j][$i] / $this->pembagi[$index][$i];
                }
            }
        }

        // MENORMALISASIKAN DENGAN NILAI BOBOT
        foreach ($this->decisioner as $index => $dm) {
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < count($this->alternatifkriteria[$index]); $j++) {
                    $this->ternormalisasiterbobot[$index][$j][$i] = $this->ternormalisasi[$index][$j][$i] * $this->bnormalisasiahp[$index][$i];
                }
            }
        }

        foreach ($this->decisioner as $index => $dm) {
            // MENCARI NILAI A+ DAN A-
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < count($this->ternormalisasiterbobot[$index]); $j++) {
                    if ($j == 0) {
                        $this->Aplus[$index][$i] = $this->ternormalisasiterbobot[$index][$j][$i];
                    }
                    if ($this->tipekriteria[$index][$i] == 'benefit') {
                        if ($this->Aplus[$index][$i] < $this->ternormalisasiterbobot[$index][$j][$i]) {
                            $this->Aplus[$index][$i] = $this->ternormalisasiterbobot[$index][$j][$i];
                        }
                    } else {
                        if ($this->Aplus[$index][$i] > $this->ternormalisasiterbobot[$index][$j][$i]) {
                            $this->Aplus[$index][$i] = $this->ternormalisasiterbobot[$index][$j][$i];
                        }
                    }
                }

                for ($j = 0; $j < count($this->ternormalisasiterbobot[$index]); $j++) {
                    if ($j == 0) {
                        $this->Amin[$index][$i] = $this->ternormalisasiterbobot[$index][$j][$i];
                    }
                    if ($this->tipekriteria[$index][$i] == 'benefit') {
                        if ($this->Amin[$index][$i] > $this->ternormalisasiterbobot[$index][$j][$i]) {
                            $this->Amin[$index][$i] = $this->ternormalisasiterbobot[$index][$j][$i];
                        }
                    } else {
                        if ($this->Amin[$index][$i] < $this->ternormalisasiterbobot[$index][$j][$i]) {
                            $this->Amin[$index][$i] = $this->ternormalisasiterbobot[$index][$j][$i];
                        }
                    }
                }
            }
        }

        // // MENCARI JARAK DARI A+ DAN A-
        foreach ($this->decisioner as $index => $dm) {
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < count($this->ternormalisasiterbobot[$index]); $j++) {
                    $this->jarakDplus[$index][$j][$i] = pow($this->Aplus[$index][$i] - $this->ternormalisasiterbobot[$index][$j][$i], 2);
                }

                for ($j = 0; $j < count($this->ternormalisasiterbobot[$index]); $j++) {
                    $this->jarakDmin[$index][$j][$i] = pow($this->ternormalisasiterbobot[$index][$j][$i] - $this->Amin[$index][$i], 2);
                }
            }
        }

        // dd($this->jarakDplus);

        // // MENENTUKAN NILAI D+ DAN D-
        foreach ($this->decisioner as $index => $dm) {
            for ($j = 0; $j < count($this->jarakDplus[$index]); $j++) {
                $this->Dplus[$index][$j] = 0;
                $this->Dmin[$index][$j] = 0;

                for ($i = 0; $i < 5; $i++) {
                    $this->Dplus[$index][$j] = $this->Dplus[$index][$j] + $this->jarakDplus[$index][$j][$i];
                }
                for ($i = 0; $i < 5; $i++) {
                    $this->Dmin[$index][$j] = $this->Dmin[$index][$j] + $this->jarakDmin[$index][$j][$i];
                }
                $this->Dplus[$index][$j] = sqrt($this->Dplus[$index][$j]);
                $this->Dmin[$index][$j]  = sqrt($this->Dmin[$index][$j]);
            }
        }

        foreach ($this->decisioner as $index => $dm) {
            foreach ($this->alternatif as $j => $alternatif) {
                $this->hasil[$index][$j] = [
                    'kode' => $alternatif->kodetanaman,
                    'nama_tanaman' => $alternatif->namatanaman,
                    'hasil' => $this->Dmin[$index][$j] / ($this->Dmin[$index][$j] + $this->Dplus[$index][$j]),
                ];
            }
        }
        // dd($this->hasil);
        $this->hasilRanking = $this->hasil;
        // MELAKUKAN SORTING
        foreach ($this->decisioner as $index => $dm) {

            array_multisort(array_column($this->hasilRanking[$index], 'hasil'), SORT_DESC, $this->hasilRanking[$index]);
        }

        $this->set = count(Alternatifs::all()) - 1;


        for ($index = 0; $index < $this->set + 1; $index++) {
            for ($j = 0; $j < $this->set + 1; $j++) {
                $this->peringkat[$index][$j] = 0;
            }
        }
        // PERHITUNGAN BORDA

        for ($index = 0; $index < $this->set + 1; $index++) {
            $this->hasilBorda[$index] = [
                'hasil' => 0,
            ];
            foreach ($this->decisioner as $key => $dm) {
                $nilaiperingkat = $this->set;
                for ($column = 0; $column < $this->set + 1; $column++) {
                    // dd($this->hasilRanking[$key][$column]['nama_tanaman']);
                    if ($this->alternatif[$index]['namatanaman'] == $this->hasilRanking[$key][$column]['nama_tanaman']) {
                        // dd($this->alternatif[$index]['namatanaman']);
                        $this->hasilBorda[$index] = [
                            'kode' => $this->hasilRanking[$key][$column]['kode'],
                            'nama_tanaman' => $this->hasilRanking[$key][$column]['nama_tanaman'],
                            'hasil' => $this->hasilBorda[$index]['hasil'] + $nilaiperingkat,
                        ];
                        // $this->hasilBorda[$key]['tes'][$key][$column] = $this->hasilBorda[$key]['tes'][$key][$column] + 1;    
                        // $this->peringkat buat view tidak termasuk proses hitung
                        $this->peringkat[$index][$column] = $this->peringkat[$index][$column] + 1;
                    }
                    $nilaiperingkat--;
                }
            }
        }

        $this->hasilBordaRanking = $this->hasilBorda;

        // MELAKUKAN SORTING BORDA
        array_multisort(array_column($this->hasilBorda, 'hasil'), SORT_DESC, $this->hasilBordaRanking);
    }
    public function render()
    {
        return view('livewire.perhitungan');
    }
}
