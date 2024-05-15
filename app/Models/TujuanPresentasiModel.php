<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanPresentasiModel extends Model
{
    use HasFactory;
    protected $table = 'tujuan_presentasi';
    public $timestamps = false;
    protected $fillable = [
        'id_presentasi',
        'id_departemen',
    ];

    public function surat()
    {
        return $this->belongsTo(PresentasiModel::class, 'id_presentasi')->withDefault();
    }

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'id_departemen')->withDefault();
    }
}
