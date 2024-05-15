<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalPresentasiModel extends Model
{
    use HasFactory;
    protected $table = 'soal_presentasi';
    protected $fillable = [
        'id_presentasi',
        'pertanyaan',
        'pilihan',
        'kunci_jawaban',
        'created_by',
        'updated_by',
    ];

    public function presentasi()
    {
        return $this->belongsTo(PresentasiModel::class, 'id_presentasi')->withDefault();
    }

    public function pilihan_ganda($id)
    {
        $soal = SoalPresentasiModel::find($id);
        $pilihan = json_decode($soal['pilihan'], true);
        return $pilihan;
    }
}
