<?php

namespace App\Http\Controllers;

use App\Models\Kavling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class KavlingController extends Controller
{
    public function index()
    {
        return view('page.admin.akun.index');
    }

    public function dataTable(Request $request)
    {
        $totalDataRecord = Kavling::count();
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = 'area_kavling'; // Misalnya, Anda ingin mengurutkan berdasarkan area_kavling secara default
        $dir_val = 'asc'; // Atau 'desc' jika ingin mengurutkan secara descending

        $kavling_data = Kavling::offset($start_val)
            ->limit($limit_val)
            ->orderBy($order_val, $dir_val)
            ->get();

        $data_val = array();
        if (!empty($kavling_data)) {
            foreach ($kavling_data as $kavling_val) {
                $url = route('kavling.edit', ['id' => $kavling_val->id]);
                $urlHapus = route('kavling.delete', $kavling_val->id);
                $kavlingnestedData['area_kavling'] = $kavling_val->area_kavling;
                $kavlingnestedData['harga'] = $kavling_val->harga;
                $kavlingnestedData['status'] = $kavling_val->status;
                $kavlingnestedData['options'] = "<a href='$url'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$kavling_val->id' data-url='$urlHapus'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                $data_val[] = $kavlingnestedData;
            }
        }

        $draw_val = $request->input('draw');
        $get_json_data = array(
            "draw"            => intval($draw_val),
            "recordsTotal"    => intval($totalDataRecord),
            "recordsFiltered" => intval($totalDataRecord),
            "data"            => $data_val
        );

        echo json_encode($get_json_data);
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
        return view('page.admin.akun.addAkun'); // Ganti dengan nama view yang sesuai
    }

    // public function ubahAkun($id, Request $request)
    // {
    //     $usr = Kavling::findOrFail($id);
    //     if ($request->isMethod('post')) {

    //         $this->validate($request, [
    //             'area_kavling' => 'required|string|max:200|min:3'.$usr->id,
    //             'harga' => 'required|integer|min:3', // Harga tidak perlu validasi email
    //             'status' => 'required|min:3|in:available,booked', // Status hanya boleh 'available' atau 'booked'
    //         ]);
    //         $usr->update([
    //             'area_kavling' => $request->area_kavling,
    //             'harga' => $request->harga,
    //             'status' => $request->status,
    //         ]);
    //         return redirect()->route('kavling.index')->with('status', 'Data kavling telah diubah');
    //     }
    //     return view('page.admin.akun.ubahAkun'); // Ganti dengan nama view yang sesuai
    // }

    public function hapusKavling($area_kavling)
    {
        $usr = Kavling::findOrFail($area_kavling);
        dd($id);
        $usr->delete($area_kavling);
        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
