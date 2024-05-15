<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPresentasiModel extends Model
{
    use HasFactory;
    protected $table = 'log_presentasi';
    protected $fillable = [
        'id_presentasi',
        'id_users',
        'status',
    ];

    public function presentasi()
    {
        return $this->belongsTo(PresentasiModel::class, 'id_presentasi')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_users')->withDefault();
    }

    public function ket_status($st)
    {
        switch ($st) {
            case 1:
                return "SE Dilihat.";
                break;
            case 2:
                return "SE Tuntas.";
                break;
            case 3:
                return "SE Belum Tuntas.";
                break;
            default:
                return "Belum Diketahui.";
        }
    }

    public function ket_member($st, $id_surat)
    {
        $surat = PresentasiModel::find($id_surat);
        $ket = '';
        if($surat){
            $ket = $surat->keterangan_topik;
        }

        switch ($st) {
            case 1:
                return "Buka SE ".$ket.".";
                break;
            case 2:
                return "Mengerjakan Soal SE ".$ket.".";
                break;
            case 3:
                return "SE Tuntas.";
                break;
            default:
                return "Belum Diketahui.";
        }
    }
}
