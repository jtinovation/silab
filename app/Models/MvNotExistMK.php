<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvNotExistMK extends Model
{
    use HasFactory;
    protected $table = 'vNotExistMK';

    public function getOddEvenAttribute()
    {
        return $this->is_genap?"Genap":"Ganjil";
    }

}
