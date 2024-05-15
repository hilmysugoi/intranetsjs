<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiModel extends Model
{
    use HasFactory;
    protected $table = 'kpi';
    protected $fillable = [
        'id_users',
        'tahun',
        'nilai',
         'keterangan',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users')->withDefault();
    }
}
