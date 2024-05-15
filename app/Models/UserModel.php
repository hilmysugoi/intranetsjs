<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at']; //soft delete
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pegawai',
        'id_jabatan',
        'id_departemen',
        'username',
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'no_bpjs',
        'tanggal_join',
        'tanggal_masuk',
        'tanggal_berakhir',
        'foto',
        'file_cv',
        'status',
        'badge'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jabatan()
    {
        return $this->belongsTo(JabatanModel::class, 'id_jabatan')->withDefault();
    }

    public function departemen()
    {
        return $this->belongsTo(DepartemenModel::class, 'id_departemen')->withDefault();
    }

    public function umur()
    {
        return Carbon::parse($this->attributes['tanggal_lahir'])->age;
    }

    public function jumlah_teguran($id)
    {
        $result['teguran'] = TeguranModel::where(['kategori' => 0, 'id_users' => $id])->count();
        $result['pelanggaran'] = TeguranModel::where(['kategori' => 1, 'id_users' => $id])->count();
        return $result;
    }


    public function jumlah_kpi($id)
{
    $result['jumlah_kpi'] = KpiModel::where('id_users', $id)->count();
    $result['rata_rata_nilai'] = KpiModel::where('id_users', $id)->avg('nilai');
    return $result;
}

}
