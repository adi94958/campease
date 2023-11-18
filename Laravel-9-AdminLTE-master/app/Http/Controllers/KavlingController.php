<?php

namespace App\Http\Controllers;

use App\Models\Kavling;
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
            // dd($request->all());
            // $this->validate($request, [
            //     'area_kavling' => 'required',
            //     'harga' => 'required', // Harga tidak perlu validasi email
            //     'status' => 'required', // Status hanya boleh 'available' atau 'booked'
            // ]);
            // dd($request->all());
            Kavling::create([
                'area_kavling' => $request->area_kavling,
                'harga' => $request->harga,
                'status' => $request->status,
            ]);
            return redirect()->route('kavling.add')->with('status', 'Data kavling telah ditambahkan');
        }
        return view('page.admin.kavling.addKavling'); // Ganti dengan nama view yang sesuai
    }

    public function ubahKavling($id, Request $request)
    {
        $usr = Kavling::findOrFail($id);
        if ($request->isMethod('post')) {

            // $this->validate($request, [
            //     'area_kavling' => 'required|string|max:200|min:3' . $usr->id,
            //     'harga' => 'required|integer|min:3',
            //     'status' => 'required|min:3|in:available,booked',
            // ]);
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

    public function hapusKavling($area_kavling)
    {
        $usr = Kavling::findOrFail($area_kavling);
        // dd($id);
        $usr->delete($area_kavling);
        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
