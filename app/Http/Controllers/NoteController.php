<?php
namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class NoteController extends Controller
{
    // Mengambil semua catatan untuk kalender
    public function index()
    {
        return response()->json(Note::orderBy('date')->latest('created_at')->get());
    }

    // Menyimpan catatan baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $note = Note::create($request->all());
        ActivityLogger::log('Notes', 'create', 'Membuat catatan baru: ' . $note->title, null, $note->toArray());

        // Kirim notifikasi ke Planner jika yang membuat adalah Admin
        $creator = auth()->user();
        if ($creator && in_array(strtolower($creator->role), ['admin'])) {
            $planners = User::whereIn('role', ['Planner', 'Content Planner', 'planner', 'content planner'])->get();

            Notification::send($planners, new SystemNotification(
                'Calendar Note',
                'Admin menambahkan catatan: "' . $note->title . '".',
                'info',
                route('calendar.index')
            ));
        }

        return response()->json(['message' => 'Catatan berhasil disimpan', 'note' => $note]);
    }

    // Menampilkan detail catatan
    public function show(Note $note)
    {
        return response()->json($note);
    }

    // Form edit catatan
    public function edit(Note $note)
    {
        return view('calendernotes.editnotes', compact('note'));
    }

    // Mengupdate catatan
    public function update(Request $request, Note $note)
    {
        $before = $note->toArray();
        $note->update($request->all());
        ActivityLogger::log('Notes', 'update', 'Memperbarui catatan: ' . $note->title, $before, $note->fresh()->toArray());

        if ($request->expectsJson()) {
            return response()->json(['note' => $note]);
        }

        // 3. Jika request datang dari Form HTML biasa (tombol submit di editnotes.blade.php)
        return redirect()->route('calendar.index')->with('success', 'Catatan berhasil diperbarui!');
    }

    // Menghapus catatan
    public function destroy(Note $note)
    {
        ActivityLogger::log('Notes', 'delete', 'Menghapus catatan: ' . $note->title, $note->toArray(), null);
        $note->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Catatan dihapus']);
        }

        return redirect()->route('calendar.index')->with('success', 'Catatan dihapus');
    }
}
