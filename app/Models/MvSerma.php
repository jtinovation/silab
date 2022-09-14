<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvSerma extends Model
{
    use HasFactory;
    protected $table = 'v_serma';

    public function memberLabData(){
        return $this->belongsTo(MMemberLab::class,'tr_member_laboratorium_id');//table class,fk
    }

    public function pengampuData(){
        return $this->belongsTo(M_Staff::class,'pengampu');//table class,fk
    }

    public function LaboratoriumData(){
        return $this->belongsTo(MLab::class,'tm_laboratorium_id');//table class,fk
    }

    public function maproditerData(){
        return $this->belongsTo(MMaproditer::class,'tr_matakuliah_semester_prodi_id');//table class,fk
    }
}
