@extends('admin.layouts.app')

@section('title', 'Ubah Password Admin')
@section('page-title', 'Ubah Password')
@section('page-desc', 'Perbarui password untuk akun ' . $user->name)

@section('content')
<div class="max-w-xl">
    <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-xs">
        <form method="POST" action="{{ route('admin.accounts.update-password', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Info Akun -->
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200">
                <p class="text-xs text-gray-500">Nama Pengguna:</p>
                <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                <p class="text-xs text-gray-500 mt-2">Email:</p>
                <p class="text-sm font-semibold text-gray-700">{{ $user->email }}</p>
            </div>

            <!-- Password Baru -->
            <div>
                <label for="password" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Password Baru <span class="text-rose-500">*</span>
                    <span class="text-xs font-normal text-gray-400 lowercase">(minimal 8 karakter)</span>
                </label>
                <input type="password" name="password" id="password" required minlength="8" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Konfirmasi Password Baru <span class="text-rose-500">*</span>
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.accounts.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-bold text-xs hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-md transition">
                    Perbarui Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
