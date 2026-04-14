<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MMaproditer extends Model
{
    use HasFactory;
    protected $table = 'tr_matakuliah_semester_prodi';
    protected static $logName = 'maproditer';
    protected static $logAttributes = [];
    protected $guarded = ['id'];

    public function prodiData(){
        return $this->belongsTo(MProgramStudi::class,'tm_program_studi_id');//table class,fk
    }

    public function semesterData(){
        return $this->belongsTo(MSemester::class,'tm_semester_id');//table class,fk
    }

    public function mkData(){
        return $this->belongsTo(MMatakuliah::class,'tm_matakuliah_id');//table class,fk
    }

}
