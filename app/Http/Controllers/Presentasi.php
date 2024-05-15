<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use App\Models\HistoryNilaiPresentasiModel;
use App\Models\LogPresentasiModel;
use App\Models\PresentasiModel;
use App\Models\SoalPresentasiModel;
use App\Models\TopikSeModel;
use App\Models\TujuanPresentasiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Presentasi extends Controller
{

    public $button;
    public $jenis;

    public function __construct()
    {
        $this->button = new GetButton;
        $this->jenis = request()->segment(2);
    }

    public function index()
    {
        $title = 'Presentasi';
        $data = PresentasiModel::where('ditujukan', 0)->where('id_topik', '!=', 14)->orderBy('tanggal', 'DESC')->get();
        $button = $this->button;
        $cont = $this;
        return view('presentasi.index', compact('data', 'title', 'button', 'cont'));
    }


    public function store(Request $request)
    {
        $title = 'Presentasi';
        // kode lainnya

        if ($request->isMethod('POST')) {
            if ($request->semua == '1') {
                $ditujukan = 0;
            } else {
                $ditujukan = 1;
            }
            $validatedData = $request->validate([
                'nomor_presentasi' => 'required',
                'id_topik' => 'required',
                'id_user' => 'required',
                'keterangan_topik' => 'required',
                'tanggal' => 'required',
                // 'status_se' => 'required',
                'ditujukan' => 'required',
                'reminder' => 'required',
                'file_surat' => 'required',
            ]);
            if ($validatedData) {
                $uploadPath = public_path('upload/presentasi/' . date('Y', strtotime($request->tanggal)) . '/' . date('m', strtotime($request->tanggal)));

                if (!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true, true);
                }
                $file = $request->file('file_surat');
                $extension = $file->getClientOriginalExtension();
                $rename = date('YmdHis') . '.' . $extension;
                $file->move($uploadPath, $rename);

                $renameP = '';

                if($request->file('file_presentasi')){
                    $uploadPathP = public_path('upload/presentasi/' . date('Y', strtotime($request->tanggal)) . '/' . date('m', strtotime($request->tanggal)));

                    if (!File::isDirectory($uploadPathP)) {
                        File::makeDirectory($uploadPathP, 0755, true, true);
                    }
                    $fileP = $request->file('file_presentasi');
                    $extensionP = $fileP->getClientOriginalExtension();
                    $renameP = date('YmdHis') . '.' . $extensionP;
                    $fileP->move($uploadPathP, $renameP);
                }

                $tanggal_berakhir = date('Y-m-d', strtotime('+' . $request->reminder . ' month', strtotime($request->tanggal)));
                $data = [
                    'nomor_presentasi' => $request->nomor_presentasi,
                    'id_topik' => $request->id_topik,
                    'id_user' => $request->id_user,
                    'keterangan_topik' => $request->keterangan_topik,
                    'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                    // 'status_se' => $request->status_se,
                    'ditujukan' => $ditujukan,
                    'reminder' => $request->reminder,
                    'tanggal_berakhir' => $tanggal_berakhir,
                    'file_surat' => $rename,
                    'file_presentasi' => $renameP,
                    'status_terbit' => 0,
                    'created_by' => auth()->user()->username,
                    'updated_by' => auth()->user()->username,
                ];
                $srt = PresentasiModel::create($data);
                foreach ($request->ditujukan as $tujuan) {
                    TujuanPresentasiModel::create([
                        'id_presentasi' => $srt->id,
                        'id_departemen' => $tujuan
                    ]);
                }
                return redirect($this->button->formEtc($title))->with('success', 'Input data berhasil');
            }
        } else {
            $button = $this->button;
            $topik = TopikSeModel::all();
            $user = UserModel::all();
            $departemen = DepartemenModel::all();
            $cont = $this;
            return view('presentasi.add', compact('title', 'button', 'topik', 'user', 'departemen', 'cont'));
        }
    }

    public function update(Request $request)
    {
        $title = 'Presentasi';

        if ($request->semua == '1') {
            $ditujukan = 0;
        } else {
            $ditujukan = 1;
        }

        // process the request
        TujuanPresentasiModel::where('id_presentasi', $request->id)->delete();
        $surat = PresentasiModel::findOrFail($request->id);
        $validatedData = $request->validate([
            'nomor_presentasi' => 'required',
            'id_topik' => 'required',
            'id_user' => 'required',
            'keterangan_topik' => 'required',
            'tanggal' => 'required',
            // 'status_se' => 'required',
            'ditujukan' => 'required',
            'reminder' => 'required',
        ]);

        if ($validatedData) {
            $tanggal_berakhir = date('Y-m-d', strtotime('+' . $request->reminder . ' month', strtotime($request->tanggal)));
            $surat->update([
                'nomor_presentasi' => $request->nomor_presentasi,
                'id_topik' => $request->id_topik,
                'id_user' => $request->id_user,
                'keterangan_topik' => $request->keterangan_topik,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                // 'status_se' => $request->status_se,
                'ditujukan' => $ditujukan,
                'reminder' => $request->reminder,
                'tanggal_berakhir' => $tanggal_berakhir,
                'status_terbit' => 0,
                'updated_by' => auth()->user()->email,
            ]);
            foreach ($request->ditujukan as $tujuan) {
                TujuanPresentasiModel::create([
                    'id_presentasi' => $request->id,
                    'id_departemen' => $tujuan
                ]);
            }
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id)->with('success', 'Edit data berhasil');
        }
    }

    public function delete($id)
    {
        $title = 'Presentasi';
        PresentasiModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc($title))->with('success', 'Hapus data berhasil');
    }

    public function cekTujuan($id_presentasi, $id_departemen)
    {
        $tujuan = TujuanPresentasiModel::where(['id_presentasi' => $id_presentasi, 'id_departemen' => $id_departemen])->first();
        if ($tujuan) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function detail(Request $request, $id)
    {
        $tab = $request->tab;
        $data = PresentasiModel::find($id);
        $soal = SoalPresentasiModel::where('id_presentasi', $id)->get()->shuffle();
        $topik = TopikSeModel::all();
        $user = UserModel::all();
        $departemen = DepartemenModel::all();
        $tujuan = TujuanPresentasiModel::where('id_presentasi', $id)->get();
        $button = $this->button;

        $title = 'Presentasi';
        $cont = $this;
        $baca = LogPresentasiModel::where(['id_presentasi' => $id, 'status' => 1])->get();
        $tuntas = LogPresentasiModel::where(['id_presentasi' => $id, 'status' => 2])->get();
        $history_nilai = HistoryNilaiPresentasiModel::where('id_presentasi', $id)->orderBy('created_at', 'DESC')->get();
        return view('presentasi.detail', compact('data', 'soal', 'topik', 'user', 'departemen', 'title', 'button', 'cont', 'baca', 'tuntas', 'history_nilai', 'tab', 'tujuan'));
    }

    public function ganti_surat(Request $request)
    {
        $surat = PresentasiModel::findOrFail($request->id);

        $title = 'Presentasi';

        $uploadPath = public_path('upload/'.$request->jenis.'/' . date('Y', strtotime($surat->tanggal)) . '/' . date('m', strtotime($surat->tanggal)));

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }
        $file = $request->file('file_surat');
        $extension = $file->getClientOriginalExtension();
        $rename = date('YmdHis') . '.' . $extension;

        if ($file->move($uploadPath, $rename)) {
            $surat->update([
                'file_'.$request->jenis => $rename,
                'updated_by' => auth()->user()->email,
            ]);
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id)->with('success', 'Edit data berhasil.');
        } else {
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id)->with('gagal', 'Edit data gagal.');
        }
    }

    public function getTarget($id_departemen)
    {
        if ($id_departemen == 0) {
            $user = UserModel::where('id_jabatan', 4)->count();
        } else {
            $user = UserModel::where(['id_jabatan' => 4, 'id_departemen' => $id_departemen])->count();
        }
        return $user;
    }

    public function getJmlStatus($id_presentasi)
    {
        $result['baca'] = LogPresentasiModel::where(['id_presentasi' => $id_presentasi, 'status' => 1])->count();
        $result['tuntas'] = LogPresentasiModel::where(['id_presentasi' => $id_presentasi, 'status' => 2])->count();
        return $result;
    }

    public function getDataLog(Request $request, $id_presentasi)
    {
        // print_r($request->st);
        // die;
        $log = LogPresentasiModel::select(
            'name',
            'jabatan.nama as jabatan',
            'departemen.nama as departemen',
            'log_presentasi.created_at as tanggal'
        )
            ->join('users', 'users.id', '=', 'log_presentasi.id_users')
            ->join('jabatan', 'jabatan.id', '=', 'users.id_jabatan')
            ->join('departemen', 'departemen.id', '=', 'users.id_departemen')
            ->where(['id_presentasi' => $id_presentasi, 'log_presentasi.status' => $request->st])
            ->get();
        return $log;
    }
}
