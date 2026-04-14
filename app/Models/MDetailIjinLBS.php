<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDetailIjinLBS extends Model
{
    use HasFactory;
    protected $table = 'td_ijin_penggunaan_lbs_detail';
    protected $guarded = ['id'];

    public function ijinLBSData(){
        return $this->belongsTo(MIjinLBS::class,'tr_ijin_penggunaan_lbs_id');//table class,fk
    }

    public function barangLabData(){
        return $this->belongsTo(MBarangLab::class,'tr_barang_laboratorium_id');//table class,fk
    }

    public function kartuStokData(){
        return $this->belongsTo(MKartuStok::class,'tr_kartu_stok_id');//table class,fk
    }

    public function detailSatuanData(){
        return $this->belongsTo(MSatuanDetail::class,'td_satuan_id');//table class,fk
    }

}
