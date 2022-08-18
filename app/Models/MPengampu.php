<?php

namespace App\Models;

use App\Models\MMaproditer as ModelsMMaproditer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPengampu extends Model
{
    use HasFactory;
    protected $table = 'tr_matakuliah_dosen';
    protected static $logName = 'pengampu';
    protected static $logAttributes = [];
    protected $guarded = ['id'];

    public function maproditerData(){
        return $this->belongsTo(ModelsMMaproditer::class,'tr_matakuliah_semester_prodi_id');//table class,fk
    }

    public function pegawaiData(){
        return $this->belongsTo(M_Staff::class,'tm_staff_id');//table class,fk
    }

}
