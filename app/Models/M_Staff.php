<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class M_Staff extends Model
{
    use HasFactory;
    protected $table = 'tm_staff';
    //protected $primaryKey = 'tm_pegawai_id';
    protected $guarded = ['id'];

}
