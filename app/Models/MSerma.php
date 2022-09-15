<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MSerma extends Model
{
    use HasFactory;
    protected $table = 'tr_serma_hasil_sisa_praktek';
    protected $guarded = ['id'];

    public function memberLab(){
        return $this->belongsTo(MMemberLab::class,'tr_member_laboratorium_id');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }

    public function pengampuData(){
        return $this->belongsTo(MPengampu::class,'tr_matakuliah_dosen_id');//table class,fk
    }

    public function setTanggalAttribute($value){
        $this->attributes['tanggal'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getTanggalAttribute($value){
        return Carbon::parse($value)->format('d/m/Y');
    }

}
