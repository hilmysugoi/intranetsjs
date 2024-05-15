<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Lib\GetLibrary;
use App\Models\HistoryNilaiPresentasiModel;
use App\Models\JawabanSoalPresentasiModel;
use App\Models\LogPresentasiModel;
use App\Models\SoalPresentasiModel;
use App\Models\PresentasiModel;
use Illuminate\Http\Request;

class JadwalPresentasi extends Controller
{

    public $button;
    public $jenis;
    public $lib;

    public function __construct()
    {
        $this->button = new GetButton;
        $this->lib = new GetLibrary;
        $this->jenis = request()->segment(2);
    }

    public function index(Request $request)
    {
        $title = 'Jadwal Presentasi';
        $bulan = 0;
        $tahun = 0;
        if (!$request->all()) {
            $surat = new PresentasiModel();
            $data = $surat->jadwal_presentasi()->get();
        } else {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $data = PresentasiModel::join("tujuan_presentasi", "presentasi.id", "=", "tujuan_presentasi.id_presentasi")
                                ->whereRaw("ditujukan = 0 OR tujuan_presentasi.id_departemen = " . auth()->user()->id_departemen . " AND MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun")->get();
        }
        $button = $this->button;
        $lib = $this->lib;
        return view('jadwal_presentasi.index', compact('data', 'title', 'button', 'lib', 'bulan', 'tahun'));
    }

    public function getJawaban($id_soal)
    {
        $result = [
            'jawaban' => '',
            'is_benar' => 2 
        ];
        $jawaban = JawabanSoalPresentasiModel::where(['id_users' => auth()->user()->id, 'id_soal' => $id_soal])->first();
        if($jawaban){
            $result = [
                'jawaban' => $jawaban->jawaban,
                'is_benar' => $jawaban->is_benar 
            ];
        }
        return $result;
    }

    public function jawab_soal(Request $request)
    {
        $jml = $request->jumlah;
        $benar = 0;
        $jml_benar = 0;
        for ($i = 1; $i <= $jml; $i++) {
            $soal = SoalPresentasiModel::find($request->id_soal[$i]);
            $jawaban = JawabanSoalPresentasiModel::where(['id_users' => auth()->user()->id, 'id_soal' => $soal['id']])->first();
            if ($soal['kunci_jawaban'] == $request->jawaban[$i]) {
                $benar = 1;
                $jml_benar = $jml_benar + 1;
            }
            $data = [
                'id_users' => auth()->user()->id,
                'id_soal' => $request->id_soal[$i],
                'jawaban' => $request->jawaban[$i],
                'is_benar' => $benar,
                'created_by' => auth()->user()->username,
                'updated_by' => auth()->user()->username,
            ];
            if(!$jawaban){
                JawabanSoalPresentasiModel::create($data);
            }else{
                $jawaban->update($data);
            }
            $benar = 0;
        }
        $dt_history = [
            'id_users' => auth()->user()->id,
            'id_presentasi' => $soal['id_presentasi'],
            'nilai' => $jml_benar,
            'nilai_max' => $jml,
            'created_by' => auth()->user()->username,
            'updated_by' => auth()->user()->username,
        ];
        HistoryNilaiPresentasiModel::create($dt_history);
        $persen = ($jml_benar/$jml) * 100;
        $status = 3;
        if($persen == 100){
            $status = 2;
        }
        $cek = LogPresentasiModel::where(['id_presentasi' => $soal['id_presentasi'], 'id_users' => auth()->user()->id, 'status' => '2'])->first();
        if (!$cek) {
            LogPresentasiModel::create([
                'id_users' => auth()->user()->id,
                'id_presentasi' => $soal['id_presentasi'],
                'status' => $status
            ]);
        }
        return redirect($this->button->formEtc('Jadwal Presentasi') . '/detail/'.$soal['id_presentasi'].'?tab=soal')->with('success', 'Input data berhasil');
    }

    public function detail(Request $request, $id)
    {
        $cek = LogPresentasiModel::where(['id_presentasi' => $id, 'id_users' => auth()->user()->id, 'status' => '1'])->first();
        if (!$cek) {
            LogPresentasiModel::create([
                'id_users' => auth()->user()->id,
                'id_presentasi' => $id,
                'status' => '1'
            ]);
        }
        $tab = $request->tab;
        $nilai = HistoryNilaiPresentasiModel::where(['id_users' => auth()->user()->id, 'id_presentasi' => $id])->first();
        $data = PresentasiModel::find($id);
        $soal = SoalPresentasiModel::where('id_presentasi', $id)->get()->shuffle();
        $history_nilai = HistoryNilaiPresentasiModel::where(['id_presentasi' => $id, 'id_users' => auth()->user()->id])->orderBy('created_at', 'DESC')->get();
        $button = $this->button;
        $cont = $this;
        $title = 'Jadwal Presentasi';
        return view('jadwal_presentasi.detail', compact('data', 'soal', 'title', 'nilai', 'button', 'cont', 'history_nilai', 'tab'));
    }
}
