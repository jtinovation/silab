<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJenisBarang extends Model
{
    use HasFactory;
    protected $table = 'tm_jenis_barang';
    protected $guarded = ['id'];

    public function barangData(){
        return $this->hasMany(MBarang::class,'tm_jenis_barang_id');
    }



}
