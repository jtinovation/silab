<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSatuanDetail extends Model
{
    use HasFactory;
    protected $table = 'td_satuan';
    protected $guarded = ['id'];

    public function BarangData(){
        return $this->belongsTo(MBarang::class,'tm_barang_id');//table class,fk
    }

    public function SatuanData(){
        return $this->belongsTo(MSatuan::class,'tm_satuan_id');//table class,fk
    }
}
