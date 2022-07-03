<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Nilaikriterias;
use App\Models\Kriteriaas;
use App\Models\Decisioners;

class Nilaikriteria extends Component
{
    public  $nilaikriteria_id, $idpertama, $value, $idkedua, $iddms, $decisioner, $data;
    public $isModalOpen = 0;
    public $isModalOpen1 = 0;
    public $matriks = [];
    public function render()
    {
        $this->kriteria = Nilaikriterias::all();
        $this->kriterias = Kriteriaas::all();
        $this->decisioner = Decisioners::all('id', 'nama');
        return view('livewire.nilaikriteria');
    }
    private function resetCreateForm()
    {
        $this->idpertama = '';
        $this->value = '';
        $this->idkedua = '';
        $this->nilaikriteria_id = '';
        $this->iddms = '';
    }
    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }
    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    public function openModalPopover1()
    {
        $this->isModalOpen1 = true;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }
    public function closeModalPopover1()
    {
        $this->isModalOpen1 = false;
    }

    public function lihat($id)
    {
        $this->data = Kriteriaas::all();
        for ($baris = 0; $baris < 5; $baris++) {
            for ($kolom = 0; $kolom < 5; $kolom++) {
                if (Nilaikriterias::where('idpertama', $baris + 1)->where('idkedua', $kolom + 1)->where('iddms', $id)->exists()) {
                    $cek = Nilaikriterias::where('idpertama', $baris + 1)->where('idkedua', $kolom + 1)->where('iddms', $id)->first();
                    $this->matriks[$baris][$kolom] = $cek->value;
                } else {
                    $this->matriks[$baris][$kolom] = 0;
                }
            }
        }
        $this->openModalPopover1();
    }

    public function edit($id)
    {
        $kriteria = Nilaikriterias::findOrFail($id);
        $this->nilaikriteria_id = $id;
        $this->idpertama = $kriteria->idpertama;
        $this->value = $kriteria->value;
        $this->idkedua = $kriteria->idkedua;
        $this->iddms = $kriteria->iddms;

        $this->openModalPopover();
    }

    public function store()
    {
        $this->validate([
            'idpertama' => 'required',
            'value' => 'required',
            'idkedua' => 'required',
            'iddms' => 'required',
        ]);
        $idpertama = $this->idpertama;
        $value = $this->value;
        $idkedua = $this->idkedua;
        $iddms = $this->iddms;

        $nilai = Nilaikriterias::where([
            ['idpertama','=',$idpertama],['idkedua','=',$idkedua],['iddms','=',$iddms]
        ])->get();

        if($idpertama == $idkedua){
            $value = 1;
        }

        if($nilai->count() < 1){
            $perbandingan = Nilaikriterias::create(
                ['idpertama' => $idpertama, 'idkedua' => $idkedua, 'value' => round($value,3), 'iddms' => $iddms]
            );
            if($value!=1){
                $perbandingan = Nilaikriterias::create(
                    ['idpertama' => $idkedua, 'idkedua' => $idpertama, 'value' => round(1/$value,3), 'iddms' => $iddms]
                );
            }
        }else{
            if($value!=1){
                $perbandingan = Nilaikriterias::where([
                    ['idpertama','=',$idpertama],['idkedua','=',$idkedua],['iddms','=',$iddms]
                ])->update([
                    'value' => round($value,3)
                ]);
                $perbandingan = Nilaikriterias::where([
                    ['idpertama','=',$idkedua],['idkedua','=',$idpertama],['iddms','=',$iddms]
                ])->update([
                    'value' => round(1/$value,3)
                ]);   
            }
        }

        // if ($idpertama == $idkedua) {

            

        //     }
        // } else {
        //     $perbandingan = Nilaikriterias::updateOrCreate(
        //         ['idpertama' => $idpertama, 'idkedua' => $idkedua, 'value' => round($value,3), 'iddms' => $iddms]
        //     );
        //     $kebalikan = Nilaikriterias::updateOrCreate(
        //         ['idpertama' => $idkedua, 'idkedua' => $idpertama, 'value' => round(1 / $value,3), 'iddms' => $iddms]
        //     );
        // }

        session()->flash('message', $this->nilaikriteria_id ? 'Penilaian updated.' : 'Penilaian created.');
        $this->closeModalPopover();
        $this->resetCreateForm();
    }
}
