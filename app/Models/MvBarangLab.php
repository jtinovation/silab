<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvBarangLab extends Model
{
    use HasFactory;
    protected $table = 'v_barang_laboratorium';

    public function prodiData(){
        return $this->belongsTo(MProgramStudi::class,'tm_program_studi_id');//table class,fk
    }
}
