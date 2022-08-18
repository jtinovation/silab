<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvExistMK extends Model
{
    use HasFactory;
    protected $table = 'vExistMK';

    public function prodiData(){
        return $this->belongsTo(MProgramStudi::class,'tm_program_studi_id');//table class,fk
    }
    
    public function staffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }

    public function getOddEvenAttribute()
    {
        return $this->is_genap?"Genap":"Ganjil";
    }

}
