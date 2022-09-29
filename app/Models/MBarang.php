<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBarang extends Model
{
    use HasFactory;
    protected $table = 'tm_barang';
    protected $guarded = ['id'];

    public function SatuanData(){
        return $this->belongsTo(MSatuan::class,'tm_satuan_id');//table class,fk
    }

    public function JenisBarangData(){
        return $this->belongsTo(MJenisBarang::class,'tm_jenis_barang_id');//table class,fk
    }
}
