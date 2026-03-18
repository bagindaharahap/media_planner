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
        return view('calendernotes.lihatnotes', compact('note'));
    }

    // Form edit catatan
    public function edit(Note $note)
    {
        return view('calendernotes.editnotes', compact('note'));
    }

    // Mengupdate catatan
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $note->update($request->all());

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Catatan diperbarui', 'note' => $note]);
        }

        return redirect()->route('calendar.notes.show', $note)->with('success', 'Catatan diperbarui');
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
