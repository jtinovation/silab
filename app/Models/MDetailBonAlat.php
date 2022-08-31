<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDetailBonAlat extends Model
{
    use HasFactory;
    protected $table = 'td_bon_alat_detail';
    protected $guarded = ['id'];

    public function bonAlatData(){
        return $this->belongsTo(MBonalat::class,'tr_bon_alat_id');//table class,fk
    }

    public function barangLabData(){
        return $this->belongsTo(MBarangLab::class,'tr_barang_laboratorium_id');//table class,fk
    }

}
