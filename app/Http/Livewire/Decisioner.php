<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Decisioners;
use App\Models\Kriterias;
use App\Models\Nilaikriterias;

class Decisioner extends Component
{
    public  $decisioner_id, $decisioner, $nama, $kode;
    public $isModalOpen = 0;
    public function render()
    {
        $this->decisioner = Decisioners::all();
        return view('livewire.decisioner');
    }
    private function resetCreateForm(){
        $this->kode = '';
        $this->decisioner_id='';
        $this->nama = '';
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
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }    
    
    public function edit($id)
    {
        $decisioner = Decisioners::findOrFail($id);
        $this->decisioner_id = $id;
        $this->kode = $decisioner->kode;
        $this->nama = $decisioner->nama;
    
        $this->openModalPopover();
    }

    public function store()
    {
        $this->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);
    
        Decisioners::updateOrCreate(['id' => $this->decisioner_id], [
            'kode' => $this->kode,
            'nama' => $this->nama,            
        ]);
        session()->flash('message', $this->decisioner_id ? 'Decisioner updated.' : 'Decisioner created.');
        $this->closeModalPopover();
        $this->resetCreateForm();
    }
    
    public function delete($id)
    {
        $kodedms = Decisioners::findOrFail($id);
        $kode = $kodedms->kode;
        Kriterias::where('kodedms', $kode)->delete();
        Nilaikriterias::where('iddms', $id)->delete();
        Decisioners::find($id)->delete();        
        session()->flash('message', 'Decisioner deleted.');
    }
}
