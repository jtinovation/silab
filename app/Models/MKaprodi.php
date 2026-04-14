<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKaprodi extends Model
{
    use HasFactory;
    protected $table = 'tr_kaprodi';
    protected $guarded = ['id'];

    public function ProdiData(){
        return $this->belongsTo(MProgramStudi::class,'tm_program_studi_id');//table class,fk
    }

    public function StaffData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }
}
