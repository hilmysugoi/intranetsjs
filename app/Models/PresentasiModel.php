<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentasiModel extends Model
{
    use HasFactory;
    protected $table = 'presentasi';
    protected $fillable = [
        'nomor_presentasi',
        'id_topik',
        'id_user',
        'keterangan_topik',
        'tanggal',
        'status_se',
        'ditujukan',
        'reminder',
        'tanggal_berakhir',
        'file_surat',
        'file_presentasi',
        'status_terbit',
        'created_by',
        'updated_by',
    ];

    public function topik()
    {
        return $this->belongsTo(TopikSeModel::class, 'id_topik')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user')->withDefault();
    }

    public function tujuan()
    {
        return $this->belongsTo(TujuanPresentasiModel::class, 'id_surat')->withDefault();
    }

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'ditujukan')->withDefault();
    }

    public function expired($tanggal_berakhir)
    {
        $akhir = new DateTime($tanggal_berakhir);
        $sekarang = new DateTime(date('Y-m-d'));
        $selisih = $sekarang->diff($akhir)->days;
        if($sekarang <= $akhir){
            $status = '<span class="badge bg-success">Aktif sampai '.$selisih.' hari</span>';
        }else{
            $status = '<span class="badge bg-warning">Selesai '.$selisih.' hari lalu</span>';
        }
        return $status;
    }

    public function jadwal_presentasi()
    {
        $id_user = auth()->user()->id;
        $id_departemen = auth()->user()->id_departemen;
        $surat = PresentasiModel::selectRaw("surat.id, nomor_presentasi, keterangan_topik, id_user, ditujukan,
                                        (SELECT status FROM log_surat
                                        WHERE id_users = $id_user
                                        AND id_surat = surat.id
                                        ORDER BY created_at DESC LIMIT 1) as status")
                                    ->join("tujuan_presentasi", "tujuan_presentasi.id_presentasi", "=", "surat.id")
                                    ->whereRaw("tujuan_presentasi.id_departemen = $id_departemen OR ditujukan = 0");
        return $surat;
    }

    public function ket_status($id_surat, $st = NULL)
    {
        switch ($st) {
            case 1:
                return '<a href="'.url('kotak_masuk/detail/'.$id_surat).'" class="btn btn-info rounded-pill btn-sm">Belum Tuntas</a>';
                break;
            case 2:
                return '<a href="'.url('kotak_masuk/detail/'.$id_surat).'" class="btn btn-success rounded-pill btn-sm">Sudah Tuntas</a>';
                break;
            default:
                return '<a href="'.url('kotak_masuk/detail/'.$id_surat).'" class="btn btn-warning rounded-pill btn-sm">Belum Baca</a>';
        }
    }
}
