<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kavling;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('page.admin.transaksi.index');
    }

    public function dataTable()
    {
        return DataTables::of(Transaksi::query())
            ->addColumn('harga', function (Transaksi $transaksi) {
                $hargaKavling = $transaksi->kavling->harga;
                return "Rp " . number_format($hargaKavling, 0, ',', '.');
            })
            ->make(true);
    }

    public function getHargaByAreaKavling(Request $request)
    {
        // Lakukan logika untuk mendapatkan harga berdasarkan area kavling
        $selectedAreaKavling = $request->area_kavling;
        $harga = Kavling::where('area_kavling', $selectedAreaKavling)->value('harga');

        // Return JSON response dengan harga
        return response()->json(['harga' => $harga]);
    }

    public function tambahTransaksi(Request $request)
    {
        $availableKavlings = Kavling::where('status', 'available')->get();

        if ($request->isMethod('post')) {
            Transaksi::create([
                'nama_penyewa' => $request->nama_penyewa,
                'no_handphone' => $request->no_handphone,
                'area_kavling' => $request->area_kavling,
                'tanggal_check_in' => $request->tanggal_check_in,
                'tanggal_check_out' => $request->tanggal_check_out,
            ]);

            Kavling::where('area_kavling', $request->area_kavling)
            ->update(['status' => 'Booked']);

            return redirect()->route('transaksi.add')->with('status', 'Data transaksi telah ditambahkan');
        }
        return view('page.admin.transaksi.addTransaksi', ['availableKavlings' => $availableKavlings]);
    }
}
