<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBarangLab extends Model
{
    use HasFactory;
    protected $table = 'tr_barang_laboratorium';
    protected $guarded = ['id'];

    public function BarangData(){
        return $this->belongsTo(MBarang::class,'tm_barang_id');//table class,fk
    }

    public function LaboratoriumData(){
        return $this->belongsTo(MLab::class,'tm_laboratorium_id');//table class,fk
    }
}
