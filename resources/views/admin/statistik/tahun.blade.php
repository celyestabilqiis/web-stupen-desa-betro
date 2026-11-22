@extends('admin.layouts.app')
@section('title', 'Pengaturan Tahun Statistik')
@section('page-title', 'Pengaturan Tahun')
@section('page-desc', 'Tahun tersedia secara otomatis dari rekam data statistik yang dikelola')
@section('content')
<div class="mb-5 flex gap-2"><a href="{{ route('admin.statistik.index') }}" class="rounded-lg border bg-white px-3 py-2 text-xs font-bold text-brand-700">Kembali ke Data Statistik</a><a href="{{ route('admin.statistik.create') }}" class="rounded-lg bg-brand-700 px-3 py-2 text-xs font-bold text-white">Tambah Data Tahun</a></div>
<div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm"><div class="overflow-x-auto"><table class="w-full min-w-[600px] text-left text-sm"><thead class="bg-gray-50 text-xs uppercase text-gray-500"><tr><th class="p-4">Tahun</th><th class="p-4">Jumlah Rekam Data</th><th class="p-4 text-right">Aksi</th></tr></thead><tbody class="divide-y divide-gray-100">@forelse($years as $year)<tr><td class="p-4 font-bold">{{ $year->tahun }}</td><td class="p-4">{{ $year->statistics_count }}</td><td class="p-4 text-right"><a href="{{ route('admin.statistik.index', ['tahun' => $year->tahun]) }}" class="font-bold text-brand-700">Lihat Data</a></td></tr>@empty<tr><td colspan="3" class="p-8 text-center text-gray-500">Belum ada tahun data. Tahun terbentuk saat statistik pertama ditambahkan.</td></tr>@endforelse</tbody></table></div></div>
<p class="mt-4 text-xs leading-relaxed text-gray-500">Data setiap tahun disimpan sebagai rekam terpisah. Mengubah atau menghapus satu tahun dilakukan pada data statistik terkait, sehingga riwayat pada tahun lainnya tetap tersimpan.</p>
@endsection
