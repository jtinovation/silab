<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKajur extends Model
{
    use HasFactory;
    protected $table = 'tr_kajur';
    protected $guarded = ['id'];

    public function JurusanData(){
        return $this->belongsTo(MLab::class,'tm_jurusan_id');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }
}
