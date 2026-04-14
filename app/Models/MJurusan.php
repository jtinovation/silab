<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJurusan extends Model
{
    use HasFactory;
    protected $table = 'tm_jurusan';
    protected static $logName = 'Jurusan';
    protected static $logAttributes = ['kode','jurusan'];
    protected $guarded = ['id'];

    public function prodiData(){
        return $this->hasMany(MProgramStudi::class,'tm_jurusan_id');
    }
}
