<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDetailHilang extends Model
{
    use HasFactory;
    protected $table = 'td_hilang_rusak_detail';
    protected $guarded = ['id'];

    public function hilangData(){
        return $this->belongsTo(MHilang::class,'tr_hilang_rusak_id');//table class,fk
    }

    public function barangLabData(){
        return $this->belongsTo(MBarangLab::class,'tr_barang_laboratorium_id');//table class,fk
    }
}
