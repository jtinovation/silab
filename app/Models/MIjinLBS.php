<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MIjinLBS extends Model
{
    use HasFactory;
    protected $table = 'tr_ijin_penggunaan_lbs';
    protected $guarded = ['id'];

    public function memberLab(){
        return $this->belongsTo(MMemberLab::class,'tr_member_laboratorium_id');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }

    public function StaffDataPembimbing(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id_pembimbing');//table class,fk
    }

    public function prodiData(){
        return $this->belongsTo(MProgramStudi::class,'tm_program_studi_id');//table class,fk
    }

    public function getSttsAttribute(){
        if($this->status==1){
            return "Belum Selesai";
        }elseif($this->status==2){
            return "Selesai";
        }
    }

    public function setStartDateAttribute($value){
        $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value){
        $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getStartDateAttribute($value){
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getEndDateAttribute($value){
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getMulaiAttribute(){
        $dateMulai = Carbon::createFromFormat('d/m/Y',"{$this->start_date}")->format('Y-m-d');
        return Carbon::parse("{$dateMulai}")->format('d F Y');
    }

    public function getSelesaiAttribute(){
        $dateSelesai = Carbon::createFromFormat('d/m/Y',"{$this->end_date}")->format('Y-m-d');
        return Carbon::parse("{$dateSelesai}")->format('d F Y');
    }


}
