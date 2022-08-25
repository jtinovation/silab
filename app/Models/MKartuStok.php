<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKartuStok extends Model
{
    use HasFactory;
    protected $table = 'tr_kartu_stok';
    protected $guarded = ['id'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d F Y H:i:s');
    }
}
