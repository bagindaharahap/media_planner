<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    // Menampilkan halaman management akun dengan data dari database
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('management_akun.indexakun', compact('users'));
    }

    // Menyimpan data user baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'status'   => 'Aktif',
            'password' => $request->password,
        ]);
        ActivityLogger::log('User', 'create', 'Menambahkan user baru: ' . $request->name . ' (' . $request->role . ')', null, ['name' => $request->name, 'email' => $request->email, 'role' => $request->role, 'status' => 'Aktif']);

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Mengupdate data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'     => 'required|string',
            'status'   => 'required|in:Aktif,Nonaktif',
            'password' => 'nullable|string|min:8',
        ]);

        $before = ['name' => $user->name, 'email' => $user->email, 'role' => $user->role, 'status' => $user->status];

        // Data yang akan diupdate
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Jika password diisi, hash dan tambahkan ke data update
        if ($request->filled('password')) {
            $updateData['password'] = $request->password;
        }

        $user->update($updateData);
        ActivityLogger::log('User', 'update', 'Memperbarui data user: ' . $user->name, $before, ['name' => $user->name, 'email' => $user->email, 'role' => $user->role, 'status' => $user->status]);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // Menghapus data user
    public function destroy(User $user)
    {
        ActivityLogger::log('User', 'delete', 'Menghapus user: ' . $user->name, ['name' => $user->name, 'email' => $user->email, 'role' => $user->role], null);
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}