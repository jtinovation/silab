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

    public function getSttsAttribute(){
        if($this->status==1){
            return "Selesai";
        }elseif($this->status==0){
            return "Belum";
        }
    }

    public function setTanggalSanggupAttribute($value){
        $this->attributes['tanggal_sanggup'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getTanggalSanggupAttribute($value){
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getSanggupAttribute(){
        $dateSanggup = Carbon::createFromFormat('d/m/Y', "{$this->tanggal_sanggup}")->format('Y-m-d');
        return  Carbon::parse("{$dateSanggup}")->isoFormat('D MMMM Y');
        //return Carbon::parse("{$dateSanggup}")->format('d F Y');
    }

    public function getSanggupHariAttribute(){
        $dateSanggup = Carbon::createFromFormat('d/m/Y', "{$this->tanggal_sanggup}")->format('Y-m-d');
        return  Carbon::parse("{$dateSanggup}")->isoFormat('dddd');
        //return Carbon::parse("{$dateSanggup}")->format('d F Y');
    }

    public function getTanggalAttribute(){
        $tanggal = Carbon::parse("{$this->created_at}")->format('Y-m-d');
        return Carbon::parse("{$tanggal}")->format('d F Y');
    }

}
