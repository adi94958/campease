<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FasilitasController extends Controller
{
    public function index()
    {
        return view('page.admin.fasilitas.index');
    }

    public function dataTable()
    {
        return DataTables::of(Fasilitas::query())
            ->addColumn('options', function ($fasilitas) {
                $editUrl = route('fasilitas.edit', $fasilitas->id);
                $deleteUrl = route('fasilitas.delete', $fasilitas->id);
                return "<a href='$editUrl'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$fasilitas->id' data-url='$deleteUrl'><i class='fas fa-trash fa-lg text-danger'></i></a>";
            })
            ->rawColumns(['options'])
            ->make(true);
    }

    public function tambahFasilitas(Request $request)
    {
        if ($request->isMethod('post')) {
            Fasilitas::create([
                'nama_fasilitas' => $request->nama_fasilitas,
                'jumlah' => $request->jumlah,
            ]);
            return redirect()->route('fasilitas.add')->with('status', 'Data Fasilitas telah ditambahkan');
        }
        return view('page.admin.fasilitas.addFasilitas');
    }

    public function ubahFasilitas($id, Request $request)
    {
        $usr = Fasilitas::findOrFail($id);
        if ($request->isMethod('post')) {
            $usr->update([
                'nama_fasilitas' => $request->nama_fasilitas,
                'jumlah' => $request->jumlah,
            ]);
            return redirect()->route('fasilitas.edit', ['id' => $usr->id])->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.fasilitas.ubahFasilitas', [
            'usr' => $usr
        ]);
    }

    public function hapusFasilitas($nama_fasilitas)
    {
        $usr = Fasilitas::findOrFail($nama_fasilitas);
        // dd($id);
        $usr->delete($nama_fasilitas);
        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
