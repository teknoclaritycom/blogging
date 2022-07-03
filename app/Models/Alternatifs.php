<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatifs extends Model
{
    use HasFactory;
    protected $fillable = ['kodetanaman', 'namatanaman'];

    public function kriteria(){
        return $this->belongsToMany(Kriteriaas::class,'kriteria_alternatif','alternatif_id','kriteria_id')->withPivot('score');;
    }
}
