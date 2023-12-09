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
            ->addColumn('options', function ($transaksi) {
                $editUrl = route('transaksi.edit', $transaksi->id);
                $deleteUrl = route('transaksi.delete', $transaksi->id);
                return "<a href='$editUrl'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$transaksi->id' data-url='$deleteUrl'><i class='fas fa-trash fa-lg text-danger'></i></a>";
            })
            ->rawColumns(['options'])
            ->make(true);
    }

    public function getHargaByAreaKavling(Request $request)
    {
        $selectedAreaKavling = $request->area_kavling;
        $harga = Kavling::where('area_kavling', $selectedAreaKavling)->value('harga');
        return response()->json(['harga' => $harga]);
    }

    public function tambahTransaksi(Request $request)
    {
        $availableKavlings = Kavling::where('status', 'Available')->get();

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

    public function ubahTransaksi($id, Request $request)
    {
        $usr = Transaksi::findOrFail($id);
        $availableKavlings = Kavling::where('area_kavling', $usr->area_kavling)
            ->orWhere(function ($query) {
                $query->where('status', 'Available');
            })
            ->get();

        if ($request->isMethod('post')) {
            // Periksa apakah kavling yang dipilih sama dengan kavling sebelumnya
            if ($request->area_kavling != $usr->area_kavling) {
                // Jika berbeda, update status kavling sebelumnya menjadi 'Available'
                Kavling::where('area_kavling', $usr->area_kavling)->update(['status' => 'Available']);

                // Update status kavling baru menjadi 'Booked'
                Kavling::where('area_kavling', $request->area_kavling)->update(['status' => 'Booked']);
            }

            // Update data transaksi
            $usr->update([
                'nama_penyewa' => $request->nama_penyewa,
                'no_handphone' => $request->no_handphone,
                'area_kavling' => $request->area_kavling,
                'tanggal_check_in' => $request->tanggal_check_in,
                'tanggal_check_out' => $request->tanggal_check_out,
            ]);

            return redirect()->route('transaksi.edit', ['id' => $usr->id])->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.transaksi.ubahTransaksi', ['usr' => $usr, 'availableKavlings' => $availableKavlings]);
    }

    public function hapusTransaksi($id_transaksi)
    {
        $usr = Transaksi::findOrFail($id_transaksi);
        $areaKavling = $usr->area_kavling; // Dapatkan area_kavling sebelum dihapus

        $usr->delete($id_transaksi);

        // Setelah menghapus transaksi, ubah status kavling menjadi "Available"
        Kavling::where('area_kavling', $areaKavling)->update(['status' => 'Available']);

        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
