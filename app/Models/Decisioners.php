<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decisioners extends Model
{
    use HasFactory;
    protected $fillable = ['kode', 'nama'];

    public function nilaiKriteria(){
        return $this->hasMany(Nilaikriterias::class,'iddms','id');
    }
}
