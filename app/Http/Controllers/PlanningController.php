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
        $data = $request->only([
            'title', 'status', 'content_type', 'description',
            'start_date', 'due_date', 'priority',
            'assigned', 'references', 'media_link', 'revision_note'
        ]);

        // Pastikan assigned dan references tersimpan sebagai JSON
        if (isset($data['assigned']) && is_array($data['assigned'])) {
            // Bersihkan field customJob dan customTool yang tidak perlu disimpan
            $data['assigned'] = array_map(function($a) {
                return [
                    'name' => $a['name'] ?? '',
                    'jobdesks' => $a['jobdesks'] ?? [],
                    'tools' => $a['tools'] ?? [],
                ];
            }, $data['assigned']);
        }

        $planning = Planning::create($data);
        return response()->json(['success' => true, 'data' => $planning]);
    }

    // Mengupdate data (Update)
    public function update(Request $request, $id)
    {
        $planning = Planning::findOrFail($id);

        $data = $request->only([
            'title', 'status', 'content_type', 'description',
            'start_date', 'due_date', 'priority',
            'assigned', 'references', 'media_link', 'revision_note'
        ]);

        // Bersihkan field customJob dan customTool jika ada
        if (isset($data['assigned']) && is_array($data['assigned'])) {
            $data['assigned'] = array_map(function($a) {
                return [
                    'name' => $a['name'] ?? '',
                    'jobdesks' => $a['jobdesks'] ?? [],
                    'tools' => $a['tools'] ?? [],
                ];
            }, $data['assigned']);
        }

        $planning->update($data);
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