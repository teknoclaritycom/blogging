<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Alternatifs;
use App\Models\Kriteriaas;

class Alternatif extends Component
{
    public  $alternatif_id, $tanaman, $namatanaman, $kodetanaman, $kriteria;
    public $isModalOpen = 0;
    public function render()
    {
        $this->alternatif = Alternatifs::all();
        return view('livewire.alternatif');
    }
    private function resetCreateForm(){
        $this->kodetanaman = '';
        $this->alternatif_id='';
        $this->namatanaman = '';
        $this->kriteria = [];
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
        $tanaman = Alternatifs::with('kriteria')->findOrFail($id);
        $this->alternatif_id = $id;
        $this->kodetanaman = $tanaman->kodetanaman;
        $this->namatanaman = $tanaman->namatanaman;
        $tanaman->kriteria->each(function($item){
            $this->kriteria[$item->kode]=$item->pivot->score;
        });
        // dd($this->kriteria);
    
        $this->openModalPopover();
    }

    public function store()
    {
        $this->validate([
            'kodetanaman' => 'required',
            'namatanaman' => 'required',
            'kriteria' => 'required',
        ]);
    
        $alternatif = Alternatifs::updateOrCreate(['id' => $this->alternatif_id], [
            'kodetanaman' => $this->kodetanaman,
            'namatanaman' => $this->namatanaman,
        ]);

        if($alternatif->kriteria->first()){
            $alternatif->kriteria()->detach();
        }

        $kriteria = [];
        $score = [];
        Kriteriaas::all()->each(function($item) use (&$kriteria, &$score){
            $kriteria[] = $item->id;
            $score[]['score'] = $this->kriteria[$item->kode];
        });

        $alternatif_kriteria = array_combine($kriteria,$score);

        
        $alternatif->kriteria()->sync($alternatif_kriteria);

        session()->flash('message', $this->alternatif_id ? 'Alternatif updated.' : 'Alternatif created.');
        
        $this->closeModalPopover();
        $this->resetCreateForm();
    }
    
    public function delete($id)
    {
        $alternatif = Alternatifs::find($id);
        $alternatif->kriteria()->detach();
        $alternatif->delete();
        session()->flash('message', 'Alternatif deleted.');
    }
}
