<?php
namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\KpiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class Kpi extends Controller
{
    public $button;

    public function __construct()
    {
        $this->button = new GetButton;
    }

    public function index($id = null)
    {
        if(auth()->user()->id_jabatan != 1){
            $id = auth()->user()->id;
        }
        $title = 'KPI';
        $data = KpiModel::where('id_users', $id)->orderBy('tahun')->get();
        $user = UserModel::find($id);
        $button = $this->button;
        return view('kpi.index', compact('data', 'user', 'title', 'button'));
    }

    public function store(Request $request, $id_user)
    {
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'tahun' => 'required|digits:4',
                'nilai' => 'required|numeric|min:0|max:100',
            ]);

            if ($validatedData) {
                $data = [
                    'id_users' => $id_user,
                    'tahun' => $request->tahun,
                    'nilai' => $request->nilai,
                    'created_by' => auth()->user()->email,
                    'updated_by' => auth()->user()->email,
                ];
                KpiModel::create($data);
                return redirect($this->button->formEtc('KPI') . '/' . $id_user)->with('success', 'Input data berhasil');
            }
        } else {
            $title = 'KPI';
            $button = $this->button;
            return view('kpi.add', compact('title', 'id_user', 'button'));
        }
    }

    public function update(Request $request, $id = null)
    {
        if ($request->isMethod('POST')) {
            $kpi = KpiModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'tahun' => 'required|digits:4',
                'nilai' => 'required|numeric|min:0|max:100',
            ]);

            if ($validatedData) {
                $kpi->update([
                    'id_users' => $request->id_users,
                    'tahun' => $request->tahun,
                    'nilai' => $request->nilai,
                    'updated_by' => auth()->user()->email,
                ]);
                return redirect($this->button->formEtc('KPI') . '/' . $request->id_users)->with('success', 'Edit data berhasil');
            }
        } else {
            $title = 'KPI';
            $button = $this->button;
            $data = KpiModel::find($id);
            return view('kpi.edit', compact('data', 'title', 'button'));
        }
    }

    public function delete($id, $_users)
    {
        $kpi = KpiModel::findOrFail($id);
        $kpi->delete();
        return redirect($this->button->formEtc('KPI') . '/' . $_users)->with('success', 'Data berhasil dihapus');
    }
}
