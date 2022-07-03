<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilaikriterias extends Model
{
    use HasFactory;
    protected $fillable = ['idpertama','value','idkedua','iddms'];

    public function decisioner(){
        return $this->belongsTo(Decisioners::class,'iddms','id');
    }
}
