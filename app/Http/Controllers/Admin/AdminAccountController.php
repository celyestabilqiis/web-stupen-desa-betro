<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAccountController extends Controller
{
    public function index(): View
    {
        $users = User::query()->orderBy('name')->get();

        return view('admin.accounts.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.accounts.form', ['user' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create($validated);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function editPassword(User $user): View
    {
        return view('admin.accounts.edit-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->update(['password' => $request->input('password')]);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Password berhasil diubah.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Tidak boleh hapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        // Tidak boleh hapus akun terakhir
        if (User::count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus akun terakhir. Minimal harus ada satu akun admin.');
        }

        $user->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
