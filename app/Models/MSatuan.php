<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSatuan extends Model
{
    use HasFactory;
    protected $table = 'tm_satuan';
    protected $guarded = ['id'];
}
