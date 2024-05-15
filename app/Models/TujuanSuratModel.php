<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanSuratModel extends Model
{
    use HasFactory;
    protected $table = 'tujuan_surat';
    public $timestamps = false;
    protected $fillable = [
        'id_surat',
        'id_departemen',
    ];

    public function surat()
    {
        return $this->belongsTo(SuratModel::class, 'id_surat')->withDefault();
    }

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'id_departemen')->withDefault();
    }
}
