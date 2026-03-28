<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromptNote;

class PromptNoteController extends Controller
{
    // Mengambil semua data untuk ditampilkan di halaman index
    public function index()
    {
        $prompts = PromptNote::orderBy('created_at', 'desc')->get();
        return view('promptnotes.indexpromptnotes', compact('prompts'));
    }

    // Menyimpan data prompt baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $prompt = PromptNote::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Prompt berhasil disimpan',
            'prompt' => $prompt
        ]);
    }

    // Memperbarui data prompt yang diedit
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $prompt = PromptNote::findOrFail($id);
        $prompt->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Prompt berhasil diperbarui',
            'prompt' => $prompt
        ]);
    }

    // Menghapus prompt
    public function destroy($id)
    {
        $prompt = PromptNote::findOrFail($id);
        $prompt->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prompt berhasil dihapus'
        ]);
    }
}