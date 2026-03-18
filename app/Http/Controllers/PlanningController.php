<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use App\Models\Note; // <-- WAJIB DITAMBAHKAN
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    // Menampilkan halaman board
    public function index()
    {
        $plannings = Planning::all();
        return view('boardplanning.indexboard', compact('plannings'));
    }

    // Menyimpan data baru (Create)
    public function store(Request $request)
    {
        $planning = Planning::create($request->all());
        return response()->json(['success' => true, 'data' => $planning]);
    }

    // Mengupdate data (Update)
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

    // Method untuk menangani File Upload
    public function uploadMedia(Request $request)
    {
        if ($request->hasFile('media_file')) {
            $file = $request->file('media_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/media_plannings', $filename);

            return response()->json([
                'success' => true,
                'file_url' => asset('storage/media_plannings/' . $filename)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'File tidak terdeteksi'], 400);
    }

    // ==========================================
    // FUNGSI BARU UNTUK HALAMAN KALENDER
    // ==========================================
    public function calendar() 
    {
        $plannings = Planning::all(); 
        $notes = Note::all(); // Mengambil data notes dari database
        
        return view('calendarnotes.calendarnotesindex', compact('plannings', 'notes'));
    }
}