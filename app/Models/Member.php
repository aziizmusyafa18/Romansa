<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tahun_masuk',
        'lulus_madrasah',
        'kampus',
        'wali',
        'job',
        'alamat_lengkap',
    ];
}
