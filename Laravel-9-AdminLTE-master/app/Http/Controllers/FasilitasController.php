<?php

namespace App\Http\Controllers;

use App\Exports\FasilitasExport;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function exportExcel()
    {
        DB::enableQueryLog();
        try {
            $count = Fasilitas::count();

            if ($count == 0) {
                throw new \Exception('Tidak ada data fasilitas untuk diexport.');
            }
            return Excel::download(new FasilitasExport, 'fasilitas.xlsx');
        } catch (\Exception $e) {
            // Handle the exception, you can log it, redirect, or return a response.
            Log::error($e->getMessage());

            dd(DB::getQueryLog(), $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
