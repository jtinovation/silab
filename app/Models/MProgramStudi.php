<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MProgramStudi extends Model
{
    use HasFactory;
    protected $table = 'tm_program_studi';
    protected static $logName = 'Prodi';
    protected static $logAttributes = ['kode','program_studi'];
    protected $guarded = ['id'];

    public function JurusanData(){
        return $this->belongsTo(MJurusan::class,'tm_jurusan_id');//table class,fk
    }
}
