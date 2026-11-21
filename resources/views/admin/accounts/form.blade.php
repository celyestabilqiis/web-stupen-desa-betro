@extends('admin.layouts.app')

@section('title', 'Tambah Akun Admin')
@section('page-title', 'Tambah Akun Admin')
@section('page-desc', 'Buat akun pengelola baru dengan akses ke panel admin Desa Betro')

@section('content')
<div class="max-w-xl">
    <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-xs">
        <form method="POST" action="{{ route('admin.accounts.store') }}" class="space-y-5">
            @csrf

            <!-- Nama -->
            <div>
                <label for="name" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Alamat Email <span class="text-rose-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="admin@desabetro.id" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Password <span class="text-rose-500">*</span>
                    <span class="text-xs font-normal text-gray-400 lowercase">(minimal 8 karakter)</span>
                </label>
                <input type="password" name="password" id="password" required minlength="8" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Konfirmasi Password <span class="text-rose-500">*</span>
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.accounts.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-bold text-xs hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-md transition">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
