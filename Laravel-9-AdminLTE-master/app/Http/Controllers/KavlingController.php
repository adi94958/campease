<?php

namespace App\Http\Controllers;

use App\Models\Kavling;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KavlingController extends Controller
{
    public function index()
    {
        return view('page.admin.kavling.index');
    }

    public function dataTable()
    {
        return DataTables::of(Kavling::query())
            ->addColumn('options', function ($kavling) {
                $editUrl = route('kavling.edit', $kavling->id);
                $deleteUrl = route('kavling.delete', $kavling->id);
                return "<a href='$editUrl'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$kavling->id' data-url='$deleteUrl'><i class='fas fa-trash fa-lg text-danger'></i></a>";
            })
            ->rawColumns(['options'])
            ->make(true);
    }

    public function tambahKavling(Request $request)
    {
        if ($request->isMethod('post')) {
            Kavling::create([
                'area_kavling' => $request->area_kavling,
                'harga' => $request->harga,
                'status' => $request->status,
            ]);
            return redirect()->route('kavling.add')->with('status', 'Data kavling telah ditambahkan');
        }
        return view('page.admin.kavling.addKavling');
    }

    public function ubahKavling($id, Request $request)
    {
        $usr = Kavling::findOrFail($id);
        $existingTransactions = Transaksi::where('area_kavling', $usr->area_kavling)->exists();

        if ($existingTransactions) {
            return redirect()->back()->with('error', 'Kavling tidak dapat diubah karena sudah ada yang memesan.');
        }

        if ($request->isMethod('post')) {
            $usr->update([
                'area_kavling' => $request->area_kavling,
                'harga' => $request->harga,
                'status' => $request->status,
            ]);
            return redirect()->route('kavling.edit', ['id' => $usr->id])->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.kavling.ubahKavling', [
            'usr' => $usr
        ]);
    }

    public function hapusKavling($id)
    {
        $kavling = Kavling::findOrFail($id);
        $existingTransactions = Transaksi::where('area_kavling', $kavling->area_kavling)->exists();

        if ($existingTransactions) {
            dd("return dahulu");
            return redirect()->back()->with('error', 'Kavling tidak dapat dihapus karena sudah ada yang memesan.');
        }

        $kavling->delete();

        return response()->json(['msg' => 'Kavling berhasil dihapus.']);
    }
}
