<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromptNote;
use App\Services\ActivityLogger;

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
        ActivityLogger::log('Prompt', 'create', 'Membuat prompt baru: ' . $prompt->title, null, $prompt->toArray());

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
        $before = $prompt->toArray();
        $prompt->update($request->all());
        ActivityLogger::log('Prompt', 'update', 'Memperbarui prompt: ' . $prompt->title, $before, $prompt->fresh()->toArray());

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
        ActivityLogger::log('Prompt', 'delete', 'Menghapus prompt: ' . $prompt->title, $prompt->toArray(), null);
        $prompt->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prompt berhasil dihapus'
        ]);
    }
}