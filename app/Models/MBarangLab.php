<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBarangLab extends Model
{
    use HasFactory;
    protected $table = 'tr_barang_laboratorium';
    protected $guarded = ['id'];
}
