<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MvPenggantianPraktek extends Model
{
    use HasFactory;
    protected $table = 'vpenggantian_praktek';
    protected $guarded = ['id'];

    public function kaprodiData(){
        return $this->belongsTo(MKaprodi::class,'tr_kaprodi_id');//table class,fk
    }

    public function memberLabData(){
        return $this->belongsTo(MMemberLab::class,'tr_member_laboratorium_id');//table class,fk
    }

    public function staffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }

    public function maproditerData(){
        return $this->belongsTo(MMaproditer::class,'tr_matakuliah_semester_prodi_id');//table class,fk
    }

    public function mingguData(){
        return $this->belongsTo(MMinggu::class,'tm_minggu_id');//table class,fk
    }

    public function setJadwalAsliAttribute($value)
    {
        $this->attributes['jadwal_asli'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
    }

    public function setJadwalGantiAttribute($value)
    {
        $this->attributes['jadwal_ganti'] = Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s');
    }

    public function getJadwalAsliAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function getJadwalGantiAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    public function getAsliAttribute(){
        $dateAsli = Carbon::parse("{$this->jadwal_asli}")->format('d/m/Y H:i:s');
        return Carbon::parse("{$dateAsli}")->format('d F Y H:i:s');
    }

    public function getGantiAttribute(){
        $dateGanti = Carbon::parse("{$this->jadwal_ganti}")->format('d/m/Y H:i:s');
        return Carbon::parse("{$dateGanti}")->format('d F Y H:i:s');
    }
}
