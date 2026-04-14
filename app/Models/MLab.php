<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLab extends Model
{
    use HasFactory;
    protected $table = 'tm_laboratorium';
    protected $guarded = ['id'];

    public function JurusanData(){
        return $this->belongsTo(MJurusan::class,'tm_jurusan_id');//table class,fk
    }

    public function sermaData(){
        return $this->hasMany(MSerma::class,'tm_laboratorium_id');
    }

    public function kestekData(){
        return $this->hasMany(MKesiapan::class,'tm_laboratorium_id');
    }

    public function ijinLBSData(){
        return $this->hasMany(MIjinLBS::class,'tm_laboratorium_id');
    }

    public function hilangData(){
        return $this->hasMany(MHilang::class,'tm_laboratorium_id');
    }

    public function bonData(){
        return $this->hasMany(MBonalat::class,'tm_laboratorium_id');
    }
}
