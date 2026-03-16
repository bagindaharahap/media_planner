<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    // Menampilkan halaman board
    public function index()
    {
        // Ambil semua data planning dari database
        $plannings = Planning::all();
        return view('boardplanning.indexboard', compact('plannings'));
    }

    // Menyimpan data baru (Create)
    public function store(Request $request)
    {
        $planning = Planning::create($request->all());
        return response()->json(['success' => true, 'data' => $planning]);
    }

    // Mengupdate data (Update) - Termasuk update status saat drag & drop
    public function update(Request $request, $id)
    {
        $planning = Planning::findOrFail($id);
        $planning->update($request->all());
        return response()->json(['success' => true, 'data' => $planning]);
    }

    // Menghapus data (Delete)
    public function destroy($id)
    {
        $planning = Planning::findOrFail($id);
        $planning->delete();
        return response()->json(['success' => true]);
    }


    // Method baru untuk menangani File Upload dari Modal
    public function uploadMedia(Request $request)
    {
        // Validasi dan simpan file
        if ($request->hasFile('media_file')) {
            $file = $request->file('media_file');
            
            // Format nama: timestamp_namaasli.ext agar tidak konflik
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan ke storage/app/public/media_plannings
            $path = $file->storeAs('public/media_plannings', $filename);

            // Kembalikan URL aset publik ke frontend
            return response()->json([
                'success' => true,
                'file_url' => asset('storage/media_plannings/' . $filename)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'File tidak terdeteksi'], 400);
    }
}