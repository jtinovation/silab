<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLab extends Model
{
    use HasFactory;
    protected $table = 'tm_laboratorium';
    protected $guarded = ['id'];

    public function JurusanData(){
        return $this->belongsTo(MJurusan::class,'tm_jurusan_id');//table class,fk
    }
}
