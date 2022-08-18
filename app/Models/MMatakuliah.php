<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMatakuliah extends Model
{
    use HasFactory;
    protected $table = 'tm_matakuliah';
    protected static $logName = 'Matakuliah';
    protected static $logAttributes = ['kode','matakuliah','is_aktif',];
    protected $guarded = ['id'];
}
