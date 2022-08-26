<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDetailKesiapan extends Model
{
    use HasFactory;
    protected $table = 'td_kesiapan_praktek_detail';
    protected $guarded = ['id'];

    public function kesiapanData(){
        return $this->belongsTo(MKesiapan::class,'tr_kesiapan_praktek_id');//table class,fk
    }

    public function barangLabData(){
        return $this->belongsTo(MBarangLab::class,'tr_barang_laboratorium_id');//table class,fk
    }

}
