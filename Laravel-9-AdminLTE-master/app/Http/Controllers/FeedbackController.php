<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('page.admin.feedback.index');
    }

    public function dataTable()
    {
        return DataTables::of(Feedback::query())
            ->addColumn('options', function ($feedback) {
                $editUrl = route('feedback.edit', $feedback->id);
                $deleteUrl = route('feedback.delete', $feedback->id);
                return "<a href='$editUrl'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$feedback->id' data-url='$deleteUrl'><i class='fas fa-trash fa-lg text-danger'></i></a>";
            })
            ->rawColumns(['options'])
            ->make(true);
    }

    public function tambahFeedback(Request $request)
    {
        if ($request->isMethod('post')) {
            Feedback::create([
                'id_pengirim' => $request->id_pengirim,
                'isi_feedback' => $request->isi_feedback,
                'rating' => $request->rating,
            ]);
            return redirect()->route('feedback.add')->with('rating', 'Data feedback telah ditambahkan');
        }
        return view('page.admin.feedback.addFeedback'); // Ganti dengan nama view yang sesuai
    }

    public function ubahFeedback($id, Request $request)
    {
        $usr = Feedback::findOrFail($id);
        if ($request->isMethod('post')) {
            $usr->update([
                'id_pengirim' => $request->id_pengirim,
                'isi_feedback' => $request->isi_feedback,
                'rating' => $request->rating,
            ]);
            return redirect()->route('feedback.edit', ['id' => $usr->id])->with('rating', 'Data telah tersimpan di database');
        }
        return view('page.admin.feedback.ubahFeedback', [
            'usr' => $usr
        ]);
    }

    public function hapusFeedback($id_pengirim)
    {
        $usr = Feedback::findOrFail($id_pengirim);
        $usr->delete($id_pengirim);
        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }
}
