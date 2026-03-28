<?php
namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

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
        // 1. Update data (sesuaikan dengan validasi Anda sebelumnya)
        $note->update($request->all());

        // 2. CEK TIPE REQUEST:
        // Jika request datang dari AJAX Kalender (Fetch API yang memiliki header 'Accept: application/json')
        if ($request->expectsJson()) {
            return response()->json(['note' => $note]);
        }

        // 3. Jika request datang dari Form HTML biasa (tombol submit di editnotes.blade.php)
        return redirect()->route('calendar.index')->with('success', 'Catatan berhasil diperbarui!');
    }

    // Menghapus catatan
    public function destroy(Note $note)
    {
        $note->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Catatan dihapus']);
        }

        return redirect()->route('calendar.index')->with('success', 'Catatan dihapus');
    }
}
