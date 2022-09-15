<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MSermaSisa extends Model
{
    use HasFactory;
    protected $table = 'td_sisa_praktek';
    protected $guarded = ['id'];

    public function sermaData(){
        return $this->belongsTo(MSerma::class,'tr_serma_hasil_sisa_praktek_id');//table class,fk
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
