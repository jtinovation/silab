<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKartuStok extends Model
{
    use HasFactory;
    protected $table = 'tr_kartu_stok';
    protected $guarded = ['id'];
}
