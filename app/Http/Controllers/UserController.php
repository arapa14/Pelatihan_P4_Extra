<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('pages.user.index', compact('users'));
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|in:admin,user',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
        } catch (\Throwable $e) {
            Log::error('Gagal membuat user', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat user.'])->withInput();
        }
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
                'role' => 'required|in:admin,user',
            ]);

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
        } catch (\Throwable $e) {
            Log::error('Gagal update user', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat update user.'])->withInput();
        }
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        try {
            // Cek apakah user mencoba menghapus dirinya sendiri
            if (auth()->id() === $user->id) {
                return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
            }

            $user->delete();

            return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('Gagal hapus user', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat hapus user.');
        }
    }

}
