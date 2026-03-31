<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Planning;
use App\Models\Note;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Notifications\ContentReviewNotification;

class PlanningController extends Controller
{
    /**
     * Menampilkan halaman board planning.
     */
    public function index()
    {
        $plannings = Planning::all();
        return view('boardplanning.indexboard', compact('plannings'));
    }

    /**
     * Menyimpan data planning baru.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title', 'status', 'content_type', 'description',
            'start_date', 'due_date', 'priority',
            'assigned', 'references', 'media_link', 'revision_note'
        ]);

        if (isset($data['assigned']) && is_array($data['assigned'])) {
            $data['assigned'] = array_map(function($a) {
                return [
                    'name' => $a['name'] ?? '',
                    'jobdesks' => $a['jobdesks'] ?? [],
                    'tools' => $a['tools'] ?? [],
                ];
            }, $data['assigned']);
        }

        $planning = Planning::create($data);
        ActivityLogger::log('Planning', 'create', 'Created new planning: ' . $planning->title, null, $planning->toArray());
        
        return response()->json(['success' => true, 'data' => $planning]);
    }

    /**
     * Memperbarui data planning.
     */
    public function update(Request $request, $id)
    {
        $planning = Planning::findOrFail($id);
        $before = $planning->toArray();
        $statusLama = $planning->status;

        $data = $request->only([
            'title', 'status', 'content_type', 'description',
            'start_date', 'due_date', 'priority',
            'assigned', 'references', 'media_link', 'revision_note'
        ]);

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
        
        $statusBaru = $planning->fresh()->status;
        
        // Notifikasi ke Admin jika status berubah menjadi 'review'
        if ($statusLama !== 'review' && $statusBaru === 'review') {
            $admins = User::where('role', 'Admin')->get(); 
            foreach ($admins as $admin) {
                $admin->notify(new ContentReviewNotification($planning));
            }
        }

        ActivityLogger::log('Planning', 'update', 'Updated planning: ' . $planning->title, $before, $planning->fresh()->toArray());
        
        return response()->json(['success' => true, 'data' => $planning]);
    }

    /**
     * Menghapus planning.
     */
    public function destroy($id)
    {
        $planning = Planning::findOrFail($id);
        ActivityLogger::log('Planning', 'delete', 'Deleted planning: ' . $planning->title, $planning->toArray(), null);
        $planning->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Menangani upload media ke penyimpanan lokal.
     */
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

        return response()->json(['success' => false, 'message' => 'File not detected'], 400);
    }

    /**
     * Menampilkan halaman Kalender dan Catatan.
     * PERBAIKAN: Nama view disesuaikan dengan folder resources/views/calendernotes/
     */
    public function calendar() 
    {
        $plannings = Planning::all(); 
        $notes = Note::all(); 
        
        // Mengubah 'calendarnotes' menjadi 'calendernotes' agar sesuai folder
        return view('calendernotes.calendernotesindex', compact('plannings', 'notes'));
    }
}