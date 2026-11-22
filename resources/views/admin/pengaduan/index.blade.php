@extends('admin.layouts.app')

@section('title', 'Pengaduan Warga')
@section('page-title', 'Pengaduan Warga')
@section('page-desc', 'Pantau laporan warga dan tindak lanjutnya')
@section('page-actions')
    <a href="{{ route('admin.pengaduan.create') }}" class="rounded-xl bg-brand-700 px-4 py-2.5 text-xs font-bold text-white">+ Tambah Pengaduan</a>
@endsection

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-2 gap-3 xl:grid-cols-5">
        @foreach ([['Total Pengaduan', $stats['total'], 'text-gray-900'], ['Baru', $stats['baru'], 'text-sky-700'], ['Diproses', $stats['diproses'], 'text-amber-700'], ['Selesai', $stats['selesai'], 'text-emerald-700'], ['Ditolak', $stats['ditolak'], 'text-rose-700']] as [$label, $value, $color])
            <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm"><p class="text-xs font-semibold text-gray-500">{{ $label }}</p><p class="mt-1 text-2xl font-extrabold {{ $color }}">{{ $value }}</p></div>
        @endforeach
    </div>
    <section class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between"><div><h2 class="font-bold text-gray-900">Tren Pengaduan</h2><p class="mt-1 text-xs text-gray-500">Jumlah laporan dalam 12 bulan terakhir</p></div></div>
        <div class="mt-5 grid h-44 grid-cols-12 items-end gap-2">
            @php($maxMonthly = max(1, $monthly->max('count')))
            @foreach ($monthly as $month)
                <div class="flex h-full flex-col items-center justify-end gap-2"><span class="text-[10px] font-bold text-gray-600">{{ $month['count'] }}</span><div class="w-full rounded-t bg-brand-700" style="height: {{ max(4, (int) ($month['count'] / $maxMonthly * 100)) }}%" title="{{ $month['label'] }}: {{ $month['count'] }}"></div><span class="text-[9px] text-gray-500">{{ $month['label'] }}</span></div>
            @endforeach
        </div>
    </section>
    <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <form method="GET" class="grid grid-cols-1 gap-3 border-b border-gray-100 p-4 sm:grid-cols-2 xl:grid-cols-6">
            <input name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau jenis..." class="rounded-xl border-gray-200 text-sm xl:col-span-2">
            <select name="status" class="rounded-xl border-gray-200 text-sm"><option value="">Semua status</option>@foreach (\App\Models\Pengaduan::STATUSES as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach</select>
            <select name="jenis" class="rounded-xl border-gray-200 text-sm"><option value="">Semua jenis</option>@foreach ($jenisPengaduan as $jenis)<option @selected(request('jenis') === $jenis)>{{ $jenis }}</option>@endforeach</select>
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" aria-label="Tanggal mulai" class="rounded-xl border-gray-200 text-sm">
            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" aria-label="Tanggal selesai" class="rounded-xl border-gray-200 text-sm">
            <div class="flex gap-2 sm:col-span-2 xl:col-span-6"><button class="rounded-xl bg-brand-700 px-4 py-2 text-xs font-bold text-white">Terapkan Filter</button><a href="{{ route('admin.pengaduan.index') }}" class="rounded-xl border border-gray-200 px-4 py-2 text-xs font-bold text-gray-600">Reset</a><span class="flex-1"></span><a href="{{ route('admin.pengaduan.export.excel', request()->query()) }}" class="rounded-xl bg-emerald-700 px-4 py-2 text-xs font-bold text-white">Export Excel</a><a target="_blank" href="{{ route('admin.pengaduan.export.pdf', request()->query()) }}" class="rounded-xl bg-gray-700 px-4 py-2 text-xs font-bold text-white">Cetak / PDF</a></div>
        </form>
        <div class="overflow-x-auto"><table class="w-full min-w-[850px] text-left text-sm"><thead class="bg-gray-50 text-[11px] uppercase tracking-wide text-gray-500"><tr><th class="px-5 py-3">No.</th><th class="px-5 py-3">Pelapor</th><th class="px-5 py-3">WhatsApp/HP</th><th class="px-5 py-3">Jenis Pengaduan</th><th class="px-5 py-3">Tanggal</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Aksi</th></tr></thead><tbody class="divide-y divide-gray-100">
        @forelse ($pengaduans as $item)
            @php($badge = ['baru' => 'bg-sky-50 text-sky-700', 'diproses' => 'bg-amber-50 text-amber-700', 'selesai' => 'bg-emerald-50 text-emerald-700', 'ditolak' => 'bg-rose-50 text-rose-700'][$item->status] ?? 'bg-gray-100 text-gray-700')
            <tr><td class="px-5 py-4 text-gray-500">{{ $pengaduans->firstItem() + $loop->index }}</td><td class="px-5 py-4 font-bold text-gray-900">{{ $item->nama }}</td><td class="px-5 py-4">{{ $item->telepon }}</td><td class="px-5 py-4">{{ $item->jenis }}</td><td class="whitespace-nowrap px-5 py-4">{{ $item->created_at->format('d/m/Y H:i') }}</td><td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $badge }}">{{ ucfirst($item->status) }}</span></td><td class="whitespace-nowrap px-5 py-4"><a class="font-bold text-brand-700" href="{{ route('admin.pengaduan.show', $item) }}">Detail</a><a class="ml-3 font-semibold text-gray-600" href="{{ route('admin.pengaduan.edit', $item) }}">Edit</a></td></tr>
        @empty<tr><td colspan="7" class="px-5 py-10 text-center text-gray-500">Belum ada pengaduan yang sesuai.</td></tr>@endforelse
        </tbody></table></div>
        <div class="p-4">{{ $pengaduans->links() }}</div>
    </section>
</div>
@endsection
