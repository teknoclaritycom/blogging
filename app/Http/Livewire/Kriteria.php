<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kriterias;
use App\Models\Decisioners;

class Kriteria extends Component
{
    public  $kriteria_id, $kriteria, $c1, $c2, $c3, $c4, $c5, $kodedms, $decisioner;
    public $isModalOpen = 0;
    public function render()
    {        
        $this->kriteria = Kriterias::all();
        $this->decisioner = Decisioners::all();
        return view('livewire.kriteria');
    }
    private function resetCreateForm(){
        $this->c1 = '';
        $this->kriteria_id='';
        $this->c2 = '';
        $this->c3 = '';
        $this->c4 = '';
        $this->c5 = '';
        $this->kodedms = '';
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
        $kriteria = Kriterias::findOrFail($id);
        $this->kriteria_id = $id;
        $this->c1 = $kriteria->c1;
        $this->c2 = $kriteria->c2;
        $this->c3 = $kriteria->c3;
        $this->c4 = $kriteria->c4;
        $this->c5 = $kriteria->c5;
        $this->kodedms = $kriteria->kodedms;
    
        $this->openModalPopover();
    }

    public function store()
    {
        $this->validate([
            'c1' => 'required',
            'c2' => 'required',
            'c3' => 'required',
            'c4' => 'required',
            'c5' => 'required',
            'kodedms' => 'required',
        ]);
    
        Kriterias::updateOrCreate(['id' => $this->kriteria_id], [
            'c1' => $this->c1,            
            'c2' => $this->c2,
            'c3' => $this->c3,
            'c4' => $this->c4,
            'c5' => $this->c5,
            'kodedms' => $this->kodedms,
        ]);
        session()->flash('message', $this->kriteria_id ? 'Kriteria updated.' : 'Kriteria created.');
        $this->closeModalPopover();
        $this->resetCreateForm();
    }
    
    public function delete($id)
    {
        Kriterias::find($id)->delete();
        session()->flash('message', 'Kriteria deleted.');
    }
}
