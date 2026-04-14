<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvKartuStok extends Model
{
    use HasFactory;
    protected $table = 'vkartu_stok';
    protected $guarded = ['id'];
}
