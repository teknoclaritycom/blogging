<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriterias extends Model
{
    use HasFactory;
    protected $table = 'tipe_kriteria';
    protected $fillable = ['c1', 'c2', 'c3', 'c4', 'c5', 'kodedms'];
}
