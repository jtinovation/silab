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
        $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value){
        $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getStartDateAttribute($value){
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function getEndDateAttribute($value){
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function getKembaliAttribute(){
        $dateKembali = Carbon::parse("{$this->tanggal_kembali}")->format('d/m/Y H:i:s');
        return Carbon::parse("{$dateKembali}")->format('d F Y H:i:s');
    }

    public function getPinjamAttribute(){
        $datePinjam = Carbon::parse("{$this->tanggal_pinjam}")->format('d/m/Y H:i:s');
        return Carbon::parse("{$datePinjam}")->format('d F Y H:i:s');
    }
}
