<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MHilang extends Model
{
    use HasFactory;
    protected $table = 'tr_hilang_rusak';
    protected $guarded = ['id'];

    public function memberLab(){
        return $this->belongsTo(MMemberLab::class,'tr_member_laboratorium_id');//table class,fk
    }

    public function getSttsAttribute()
    {
        if($this->status==1){
            return "Selesai";
        }elseif($this->status==2){
            return "Belum";
        }
    }

    public function setTanggalSanggupAttribute($value)
    {
        $this->attributes['tanggal_sanggup'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getTanggalSanggupAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }



    public function getSanggupAttribute(){
        $dateSanggup = Carbon::parse("{$this->tanggal_sanggup}")->format('d/m/Y H:i:s');
        return Carbon::parse("{$dateSanggup}")->format('d F Y H:i:s');
    }

}
