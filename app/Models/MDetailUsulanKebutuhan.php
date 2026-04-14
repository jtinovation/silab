<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MDetailUsulanKebutuhan extends Model
{
    protected $table = 'tr_usulan_kebutuhan_detail';
    protected $guarded = ['id'];

    public function BarangData(){
        return $this->belongsTo(MBarang::class,'tm_barang_id');//table class,fk
    }

    public function detailSatuanData(){
        return $this->belongsTo(MSatuanDetail::class,'td_satuan_id');//table class,fk
    }
}
