<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\Transaksi;
use App\Models\Kavling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                $totalHarga = $this->hitungTotalHarga($transaksi->tanggal_check_in, $transaksi->tanggal_check_out, $transaksi->area_kavling);
                return "Rp " . number_format($totalHarga, 0, ',', '.');
            })
            ->addColumn('options', function ($transaksi) {
                $editUrl = route('transaksi.edit', $transaksi->id);
                $deleteUrl = route('transaksi.delete', $transaksi->id);
                return "<a href='$editUrl'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$transaksi->id' data-url='$deleteUrl'><i class='fas fa-trash fa-lg text-danger'></i></a>";
            })
            ->rawColumns(['options'])
            ->make(true);
    }

    private function hitungTotalHarga($tanggalCheckIn, $tanggalCheckOut, $areaKavling)
    {
        $hargaKavling = Kavling::where('area_kavling', $areaKavling)->value('harga');
        $selisihHari = Carbon::parse($tanggalCheckIn)->diffInDays(Carbon::parse($tanggalCheckOut));
        $totalHarga = ($selisihHari + 1) * $hargaKavling;
        return $totalHarga;
    }

    public function getHargaByAreaKavling(Request $request)
    {
        $selectedAreaKavling = $request->area_kavling;
        $totalHarga = $this->hitungTotalHarga($request->tanggal_check_in, $request->tanggal_check_out, $selectedAreaKavling);

        return response()->json(['harga' => $totalHarga]);
    }

    public function tambahTransaksi(Request $request)
    {
        $availableKavlings = Kavling::where('status', 'Available')->get();

        if ($request->isMethod('post')) {
            $totalHarga = $this->hitungTotalHarga($request->tanggal_check_in, $request->tanggal_check_out, $request->area_kavling);

            Transaksi::create([
                'nama_penyewa' => $request->nama_penyewa,
                'no_handphone' => $request->no_handphone,
                'area_kavling' => $request->area_kavling,
                'tanggal_check_in' => $request->tanggal_check_in,
                'tanggal_check_out' => $request->tanggal_check_out,
                'harga' => $totalHarga,
            ]);

            Kavling::where('area_kavling', $request->area_kavling)->update(['status' => 'Booked']);

            return redirect()->route('transaksi.index')->with('status', 'Data transaksi telah ditambahkan');
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
        $areaKavling = $usr->area_kavling;

        $usr->delete($id_transaksi);

        Kavling::where('area_kavling', $areaKavling)->update(['status' => 'Available']);

        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }

    public function exportExcel()
    {
        DB::enableQueryLog();
        try {
            $count = Transaksi::count();

            if ($count == 0) {
                throw new \Exception('Tidak ada data transaksi untuk diexport.');
            }
            return Excel::download(new TransaksiExport, 'transaksi.xlsx');
        } catch (\Exception $e) {
            // Handle the exception, you can log it, redirect, or return a response.
            Log::error($e->getMessage());

            dd(DB::getQueryLog(), $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
