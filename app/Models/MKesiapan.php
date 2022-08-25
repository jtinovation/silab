<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKesiapan extends Model
{
    use HasFactory;
    protected $table = 'tr_kesiapan_praktek';
    protected $guarded = ['id'];

    public function maproditerData(){
        return $this->belongsTo(MMaproditer::class,'tr_matakuliah_semester_prodi_id');//table class,fk
    }

    public function pengampuData(){
        return $this->belongsTo(MPengampu::class,'tr_matakuliah_dosen_id');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }

    public function getSttsAttribute()
    {
        if($this->rekomendasi==1){
            return "Siapkan dan Lanjutkan";
        }elseif($this->status==2){
            return "Dimodifiksi";
        }elseif($this->status==3){
            return "Diganti acara praktek yang ";
        }elseif($this->status==4){
            return "Ditunda";
        }
    }
}
