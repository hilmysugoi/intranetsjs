<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\DepartemenModel;
use App\Models\HistoryNilaiModel;
use App\Models\LogSuratModel;
use App\Models\SoalModel;
use App\Models\SuratModel;
use App\Models\TopikSeModel;
use App\Models\TujuanSuratModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Surat extends Controller
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
        if ($this->jenis == 'umum') {
            $title = 'Internal General';
            $data = SuratModel::where('ditujukan', 0)->where('id_topik', '!=', 14)->orderBy('tanggal', 'DESC')->get();
        } else if ($this->jenis == 'khusus') {
            $title = 'Internal Departemen';
            $data = SuratModel::whereRaw('ditujukan != 0')->orderBy('tanggal', 'DESC')->get();
        } else if ($this->jenis == 'eksternal') {
            $title = 'Eksternal General';
            $data = SuratModel::where('ditujukan', 0)->where('status_se', 1)->orderBy('tanggal', 'DESC')->get();
        } else if ($this->jenis == 'kustomer') {
            $title = 'Eksternal Customer';
            $data = SuratModel::where('ditujukan', 0)->where('status_se', 1)->orderBy('tanggal', 'DESC')->get();
        } else {
            $title = 'Presentasi';
            $data = SuratModel::where('ditujukan', 0)->where('id_topik', 14)->orderBy('tanggal', 'DESC')->get();
        }
        $button = $this->button;
        $cont = $this;
        return view('surat.index', compact('data', 'title', 'button', 'cont'));
    }


    public function store(Request $request)
    {
        if ($this->jenis == 'umum') {
            $title = 'Internal General';
        } else if ($this->jenis == 'khusus') {
            $title = 'Internal Departemen';
        } else if ($this->jenis == 'eksternal') {
            $title = 'Eksternal General';
        } else if ($this->jenis == 'kustomer') {
            $title = 'Eksternal Customer';
        } else {
            $title = 'Presentasi';
        }
        // kode lainnya

        if ($request->isMethod('POST')) {
            if ($request->semua == '1') {
                $ditujukan = 0;
            } else {
                $ditujukan = 1;
            }
            $validatedData = $request->validate([
                'nomor_surat' => 'required',
                'id_topik' => 'required',
                'id_user' => 'required',
                'keterangan_topik' => 'required',
                'tanggal' => 'required',
                'status_se' => 'required',
                'ditujukan' => 'required',
                'reminder' => 'required',
                'file_surat' => 'required',
            ]);
            if ($validatedData) {
                $uploadPath = public_path('upload/surat/' . date('Y', strtotime($request->tanggal)) . '/' . date('m', strtotime($request->tanggal)));

                if (!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true, true);
                }
                $file = $request->file('file_surat');
                $extension = $file->getClientOriginalExtension();
                $rename = date('YmdHis') . '.' . $extension;
                $file->move($uploadPath, $rename);

                $renameP = '';

                if($request->file('file_ppt')){
                    $uploadPathP = public_path('upload/ppt/' . date('Y', strtotime($request->tanggal)) . '/' . date('m', strtotime($request->tanggal)));

                    if (!File::isDirectory($uploadPathP)) {
                        File::makeDirectory($uploadPathP, 0755, true, true);
                    }
                    $fileP = $request->file('file_ppt');
                    $extensionP = $fileP->getClientOriginalExtension();
                    $renameP = date('YmdHis') . '.' . $extensionP;
                    $fileP->move($uploadPathP, $renameP);
                }

                $tanggal_berakhir = date('Y-m-d', strtotime('+' . $request->reminder . ' month', strtotime($request->tanggal)));
                $data = [
                    'nomor_surat' => $request->nomor_surat,
                    'id_topik' => $request->id_topik,
                    'id_user' => $request->id_user,
                    'keterangan_topik' => $request->keterangan_topik,
                    'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                    'status_se' => $request->status_se,
                    'ditujukan' => $ditujukan,
                    'reminder' => $request->reminder,
                    'tanggal_berakhir' => $tanggal_berakhir,
                    'file_surat' => $rename,
                    'file_ppt' => $renameP,
                    'status_terbit' => 0,
                    'created_by' => auth()->user()->username,
                    'updated_by' => auth()->user()->username,
                ];
                $srt = SuratModel::create($data);
                foreach ($request->ditujukan as $tujuan) {
                    TujuanSuratModel::create([
                        'id_surat' => $srt->id,
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
            return view('surat.add', compact('title', 'button', 'topik', 'user', 'departemen', 'cont'));
        }
    }

    public function update(Request $request)
    {
        if ($this->jenis == 'umum') {
            $title = 'Internal General';
        } else if ($this->jenis == 'khusus') {
            $title = 'Internal Departemen';
        } else if ($this->jenis == 'eksternal') {
            $title = 'Eksternal General';
        } else if ($this->jenis == 'kustomer') {
            $title = 'Eksternal Customer';
        } else {
            $title = 'Presentasi';
        }

        if ($request->semua == '1') {
            $ditujukan = 0;
        } else {
            $ditujukan = 1;
        }

        // process the request
        TujuanSuratModel::where('id_surat', $request->id)->delete();
        $surat = SuratModel::findOrFail($request->id);
        $validatedData = $request->validate([
            'nomor_surat' => 'required',
            'id_topik' => 'required',
            'id_user' => 'required',
            'keterangan_topik' => 'required',
            'tanggal' => 'required',
            'status_se' => 'required',
            'ditujukan' => 'required',
            'reminder' => 'required',
        ]);

        if ($validatedData) {
            $tanggal_berakhir = date('Y-m-d', strtotime('+' . $request->reminder . ' month', strtotime($request->tanggal)));
            $surat->update([
                'nomor_surat' => $request->nomor_surat,
                'id_topik' => $request->id_topik,
                'id_user' => $request->id_user,
                'keterangan_topik' => $request->keterangan_topik,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'status_se' => $request->status_se,
                'ditujukan' => $ditujukan,
                'reminder' => $request->reminder,
                'tanggal_berakhir' => $tanggal_berakhir,
                'status_terbit' => 0,
                'updated_by' => auth()->user()->email,
            ]);
            foreach ($request->ditujukan as $tujuan) {
                TujuanSuratModel::create([
                    'id_surat' => $request->id,
                    'id_departemen' => $tujuan
                ]);
            }
            return redirect($this->button->formEtc($title) . '/detail/' . $request->id)->with('success', 'Edit data berhasil');
        }
    }

    public function delete($id)
    {
        if ($this->jenis == 'umum') {
            $title = 'Internal General';
        } else if ($this->jenis == 'khusus') {
            $title = 'Internal Departemen';
        } else if ($this->jenis == 'eksternal') {
            $title = 'Eksternal General';
        } else if ($this->jenis == 'kustomer') {
            $title = 'Eksternal Customer';
        } else {
            $title = 'Presentasi';
        }
        SuratModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc($title))->with('success', 'Hapus data berhasil');
    }

    public function cekTujuan($id_surat, $id_departemen)
    {
        $tujuan = TujuanSuratModel::where(['id_surat' => $id_surat, 'id_departemen' => $id_departemen])->first();
        if ($tujuan) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function detail(Request $request, $id)
    {
        $tab = $request->tab;
        $data = SuratModel::find($id);
        $soal = SoalModel::where('id_surat', $id)->get()->shuffle();
        $topik = TopikSeModel::all();
        $user = UserModel::all();
        $departemen = DepartemenModel::all();
        $tujuan = TujuanSuratModel::where('id_surat', $id)->get();
        $button = $this->button;

        if ($this->jenis == 'umum') {
            $title = 'Internal General';
        } else if ($this->jenis == 'khusus') {
            $title = 'Internal Departemen';
        } else if ($this->jenis == 'eksternal') {
            $title = 'Eksternal General';
        } else if ($this->jenis == 'kustomer') {
            $title = 'Eksternal Customer';
        } else {
            $title = 'Presentasi';
        }
        $cont = $this;
        $baca = LogSuratModel::where(['id_surat' => $id, 'status' => 1])->get();
        $tuntas = LogSuratModel::where(['id_surat' => $id, 'status' => 2])->get();
        $history_nilai = HistoryNilaiModel::where('id_surat', $id)->orderBy('created_at', 'DESC')->get();
        return view('surat.detail', compact('data', 'soal', 'topik', 'user', 'departemen', 'title', 'button', 'cont', 'baca', 'tuntas', 'history_nilai', 'tab', 'tujuan'));
    }

    public function ganti_surat(Request $request)
    {
        $surat = SuratModel::findOrFail($request->id);

        if ($this->jenis == 'umum') {
            $title = 'Internal General';
        } else if ($this->jenis == 'khusus') {
            $title = 'Internal Departemen';
        } else if ($this->jenis == 'eksternal') {
            $title = 'Eksternal General';
        } else if ($this->jenis == 'kustomer') {
            $title = 'Eksternal Customer';
        } else {
            $title = 'Presentasi';
        }

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

    public function getJmlStatus($id_surat)
    {
        $result['baca'] = LogSuratModel::where(['id_surat' => $id_surat, 'status' => 1])->count();
        $result['tuntas'] = LogSuratModel::where(['id_surat' => $id_surat, 'status' => 2])->count();
        return $result;
    }

    public function getDataLog(Request $request, $id_surat)
    {
        // print_r($request->st);
        // die;
        $log = LogSuratModel::select(
            'name',
            'jabatan.nama as jabatan',
            'departemen.nama as departemen',
            'log_surat.created_at as tanggal'
        )
            ->join('users', 'users.id', '=', 'log_surat.id_users')
            ->join('jabatan', 'jabatan.id', '=', 'users.id_jabatan')
            ->join('departemen', 'departemen.id', '=', 'users.id_departemen')
            ->where(['id_surat' => $id_surat, 'log_surat.status' => $request->st])
            ->get();
        return $log;
    }
}
