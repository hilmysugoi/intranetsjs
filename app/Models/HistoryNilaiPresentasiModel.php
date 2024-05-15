<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryNilaiPresentasiModel extends Model
{
    use HasFactory;
    protected $table = 'history_nilai_presentasi';
    protected $fillable = [
        'id_users',
        'id_presentasi',
        'nilai',
        'nilai_max',
        'created_by',
        'updated_by',
    ];

    public function presentasi()
    {
        return $this->belongsTo(PresentasiModel::class, 'id_presentasi')->withDefault();
    }

    public function users()
    {
        return $this->belongsTo(UserModel::class, 'id_users')->withDefault();
    }
}
