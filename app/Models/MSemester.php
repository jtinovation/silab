<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MSemester extends Model
{
    use HasFactory;
    protected $table = 'tm_semester';
    protected $guarded = ['id'];

    public function taData(){
        return $this->belongsTo(MTahunAjaran::class,'tm_tahun_ajaran_id');
    }
}
