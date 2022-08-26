<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function mingguData(){
        return $this->belongsTo(MMinggu::class,'tm_minggu_id');//table class,fk
    }

    public function getSttsAttribute()
    {
        if($this->rekomendasi==1){
            return "Siapkan dan Lanjutkan";
        }elseif($this->rekomendasi==2){
            return "Dimodifiksi";
        }elseif($this->rekomendasi==3){
            return "Diganti acara praktek yang ";
        }elseif($this->rekomendasi==4){
            return "Ditunda";
        }
    }

    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getTanggalAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
