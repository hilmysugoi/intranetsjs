<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSoalPresentasiModel extends Model
{
    use HasFactory;
    protected $table = 'jawaban_soal_presentasi';
    protected $fillable = [
        'id_users',
        'id_soal_presentasi',
        'jawaban',
        'is_benar',
        'created_by',
        'updated_by',
    ];
}
