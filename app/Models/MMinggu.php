<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MMinggu extends Model
{
    protected $table = 'tm_minggu';
    protected $guarded = ['id'];

    public function taData(){
        return $this->belongsTo(MTahunAjaran::class,'tm_tahun_ajaran_id');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getTampilTanggalAttribute()
    {
       /*  //return Carbon::createFromFormat('Y-m-d', $this->end_date)->format('d/m/Y');
        //$hasil = $this->start_date;
        $start = $this->start_date;
        $myDate = '2022-03-14';
        //$date = Carbon::createFromFormat('Y-m-d', $start);

        $monthName = Carbon::parse($myDate)->format('d/m/Y');
        return $monthName; */
    }

    //." - ".Carbon::parse($this->end_date)->format('d F Y')

}
