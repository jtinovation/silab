<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MTahunAjaran extends Model
{
    use HasFactory;
    protected $table = 'tm_tahun_ajaran';
    protected $guarded = ['id'];

    public function getOddEvenAttribute()
    {
        return $this->is_genap?"Genap":"Ganjil";
    }

}
