<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MUsulanKebutuhan extends Model
{
    protected $table = 'tr_usulan_kebutuhan';
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
     ];

    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function mingguData(){
        return $this->belongsTo(MMinggu::class,'tm_minggu_id');//table class,fk
    }

    public function labData(){
        return $this->belongsTo(MLab::class,'tm_laboratorium_id');//table class,fk
    }

    public function getTanggalAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getSttsAttribute()
    {
        if($this->status==1){
            return "Pengajuan";
        }elseif($this->status==2){
            return "Review";
        }elseif($this->status==3){
            return "Cetak Tim Bahan Jurusan";
        }elseif($this->status==4){
            return "ACC Pengadaan Pusat";
        }elseif($this->status==5){
            return "Deliver To Unit";
        }elseif($this->status==6){
            return "Selesai";
        }
    }
}
