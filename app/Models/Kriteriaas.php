<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteriaas extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    protected $fillable = ['kode','nama'];
}
