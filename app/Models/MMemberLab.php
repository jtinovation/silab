<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMemberLab extends Model
{
    use HasFactory;
    protected $table = 'tr_member_laboratorium';
    protected $guarded = ['id'];

    public function LaboratoriumData(){
        return $this->belongsTo(MLab::class,'tm_laboratorium_id');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }
}
