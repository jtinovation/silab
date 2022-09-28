<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MBonalat extends Model
{
    use HasFactory;
    protected $table = 'tr_bon_alat';
    protected $guarded = ['id'];

    public function memberLabIn(){
        return $this->belongsTo(MMemberLab::class,'tr_member_laboratorium_id_kembali');//table class,fk
    }

    public function memberLabOut(){
        return $this->belongsTo(MMemberLab::class,'tr_member_laboratorium_id_pinjam');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }

    public function StaffDataKembali(){
        return $this->belongsTo(M_Staff::class,'kembali_tm_staff_id');//table class,fk
    }

    public function mingguData(){
        return $this->belongsTo(MMinggu::class,'tm_minggu_id');//table class,fk
    }

    public function getSttsAttribute()
    {
        if($this->status==1){
            return "Sedang Dipinjam";
        }elseif($this->status==2){
            return "Kembali";
        }
    }

    public function setTanggalPinjamAttribute($value)
    {
        $this->attributes['tanggal_pinjam'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setTanggalKembaliAttribute($value)
    {
        $this->attributes['tanggal_kembali'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
        //Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
        //$this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getTanggalPinjamAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function getTanggalKembaliAttribute($value)
    {
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

    public function getTanggalBonAttribute(){
        $tanggal = Carbon::parse("{$this->created_at}")->format('Y-m-d');
        //$tanggal = Carbon::createFromFormat('d/m/Y', "{$this->tanggal}")->format('Y-m-d');
        return Carbon::parse("{$tanggal}")->format('d F Y');
    }
}
