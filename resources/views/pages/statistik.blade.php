@extends('layouts.app')

@section('title', 'Statistik Desa Betro - Website Resmi Desa Betro')
@section('description', 'Data statistik Desa Betro berdasarkan kategori dan tahun yang dipublikasikan.')
@section('page-key', 'informasi-statistik')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main">
    @php($statisticsUrl = $page ? route('pages.informasi.statistik.page', $page->slug) : route('pages.informasi.statistik'))
    <nav aria-label="Breadcrumb" class="page-breadcrumb"><a href="{{ route('pages.home') }}">Beranda</a><span>/</span><a href="{{ route('pages.informasi') }}">Informasi</a><span>/</span><a href="{{ route('pages.informasi.statistik') }}">Statistik Desa</a>@if($page)<span>/</span><span aria-current="page">{{ $page->title }}</span>@else<span aria-current="page">Statistik Desa</span>@endif</nav>

    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 px-6 py-10 text-white shadow-xl sm:px-10 sm:py-14">
        <div class="pointer-events-none absolute -right-12 -top-16 h-64 w-64 rounded-full border border-white/10"></div><div class="pointer-events-none absolute -right-2 -top-6 h-44 w-44 rounded-full border border-white/10"></div>
        <div class="relative max-w-3xl"><span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-white/90"><span class="h-2 w-2 rounded-full bg-amber-400"></span>DATA TERBUKA DESA</span><h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl">{{ $page?->title ?? 'Statistik Desa Betro' }}</h1><p class="mt-4 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">{{ $page?->description ?: 'Lihat data agregat Desa Betro berdasarkan kategori dan tahun. Informasi ditampilkan dari data yang telah dipublikasikan.' }}</p></div>
    </section>

    @if($publishedPages->isNotEmpty())
        <nav aria-label="Halaman statistik" class="section-separator grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">@foreach($publishedPages as $publishedPage)<a href="{{ route('pages.informasi.statistik.page', $publishedPage->slug) }}" class="rounded-2xl border border-gray-100 bg-white p-4 font-bold text-gray-800 shadow-sm transition hover:border-brand-200 hover:text-brand-700">{{ $publishedPage->title }}<span class="mt-1 block text-xs font-normal text-gray-500">{{ $page?->is($publishedPage) ? 'Halaman aktif · lihat data' : 'Lihat data dan infografis' }} →</span></a>@endforeach</nav>
    @endif

    <section class="section-separator mt-8 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
        <form method="GET" action="{{ $statisticsUrl }}" class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="w-full sm:max-w-xs"><label for="statistik-tahun" class="mb-2 block text-xs font-bold uppercase tracking-wide text-gray-500">Tahun Data</label><select id="statistik-tahun" name="tahun" class="w-full rounded-xl border-gray-200 text-sm focus:border-brand-500 focus:ring-brand-200"><option value="semua" @selected($selectedYear === 'semua')>Semua Tahun</option>@foreach($years as $year)<option value="{{ $year }}" @selected($selectedYear === (string) $year)>{{ $year }}</option>@endforeach</select></div>
            @if(request()->filled('banding_id'))<input type="hidden" name="banding_id" value="{{ request('banding_id') }}">@endif
            @if(request()->filled('tahun_mulai'))<input type="hidden" name="tahun_mulai" value="{{ request('tahun_mulai') }}">@endif
            @if(request()->filled('tahun_selesai'))<input type="hidden" name="tahun_selesai" value="{{ request('tahun_selesai') }}">@endif
            <button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800">Tampilkan Statistik</button>
        </form>
        @if($selectedYear !== 'semua')<p class="mt-3 text-xs text-gray-500">Menampilkan data publik tahun {{ $selectedYear }}.</p>@else<p class="mt-3 text-xs text-gray-500">Data setiap tahun ditampilkan dalam kelompok terpisah agar nilainya tidak tercampur.</p>@endif
    </section>

    @if($yearGroups->isEmpty())
        <section class="section-separator rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center"><div class="text-4xl">📊</div><h2 class="mt-3 text-lg font-bold text-gray-900">Data statistik belum tersedia</h2><p class="mt-2 text-sm text-gray-500">Belum ada statistik aktif yang dipublikasikan untuk tahun yang dipilih.</p></section>
    @else
        @foreach($yearGroups as $year => $yearStatistics)
            <section class="section-separator">
                <div class="mb-5"><span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">Ringkasan Desa</span><h2 class="mt-1 text-2xl font-extrabold tracking-tight text-gray-900">{{ $selectedYear === 'semua' ? 'Ringkasan Statistik '.$year : 'Ringkasan Statistik Desa' }}</h2></div>
                @php($summaryItems = $summaryGroups->get($year, collect()))
                @if($summaryItems->isNotEmpty())
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($summaryItems as $statistic)
                            <article class="card-hover rounded-2xl border border-gray-100 border-l-4 !border-l-brand-700 bg-white p-5 shadow-sm"><div class="flex items-start justify-between gap-3"><h3 class="text-xs font-bold uppercase tracking-wide text-gray-500">{{ $statistic->nama_statistik }}</h3><span class="text-2xl" aria-hidden="true">{{ $statistic->ikon ?: ($statistic->category->ikon ?: '📊') }}</span></div><p class="mt-4 text-3xl font-extrabold leading-tight text-gray-900">{{ $statistic->nilai_format }} <span class="text-sm font-semibold text-gray-500">{{ $statistic->satuan }}</span></p>@if($statistic->deskripsi)<p class="mt-2 text-xs leading-relaxed text-gray-500">{{ $statistic->deskripsi }}</p>@endif</article>
                        @endforeach
                    </div>
                @else
                    <p class="rounded-2xl border border-gray-100 bg-white p-5 text-sm text-gray-500">Belum ada data yang dipilih untuk ringkasan tahun {{ $year }}.</p>
                @endif
            </section>

            <section class="section-separator">
                @if($selectedYear === 'semua')<div class="mb-6"><span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">Data Per Kategori</span><h2 class="mt-1 text-2xl font-extrabold tracking-tight text-gray-900">Statistik Tahun {{ $year }}</h2></div>@endif
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    @foreach($categories as $category)
                        @php($categoryItems = $yearStatistics->where('category_id', $category->id)->sortBy(fn($item) => sprintf('%06d-%s', $item->urutan, $item->nama_statistik))->values())
                        @if($categoryItems->isNotEmpty())
                        @php($maxValue = max(1, (float) $categoryItems->max(fn($item) => (float) $item->nilai)))
                            <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
                                <header class="mb-6 flex items-start gap-3">@if($category->gambar)<img src="{{ asset('storage/'.$category->gambar) }}" alt="Ilustrasi {{ $category->nama_kategori }}" class="h-11 w-11 shrink-0 rounded-xl object-cover">@else<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-2xl">{{ $category->ikon ?: '📊' }}</span>@endif<div><h3 class="text-lg font-extrabold text-gray-900">{{ $category->nama_kategori }}</h3>@if($category->deskripsi)<p class="mt-1 text-xs leading-relaxed text-gray-500">{{ $category->deskripsi }}</p>@endif</div></header>
                                @if(in_array($category->visualization_type, ['pie', 'doughnut'], true))
                                    @php($colors = ['#801b2a', '#d7ad53', '#b64d5b', '#4c6b78', '#6e9a74', '#8e68a3'])
                                    @php($totalForChart = max(0.0001, (float) $categoryItems->sum(fn($item) => (float) $item->nilai)))
                                    @php($chartStops = [])
                                    @php($runningPercent = 0)
                                    @foreach($categoryItems as $chartIndex => $chartItem)
                                        @php($nextPercent = $runningPercent + ((float) $chartItem->nilai / $totalForChart * 100))
                                        @php($chartStops[] = $colors[$chartIndex % count($colors)].' '.$runningPercent.'% '.$nextPercent.'%')
                                        @php($runningPercent = $nextPercent)
                                    @endforeach
                                    <div class="mb-7 flex flex-wrap items-center gap-6"><div class="relative h-40 w-40 shrink-0 rounded-full" role="img" aria-label="Diagram {{ $category->nama_kategori }}" style="background: conic-gradient({{ implode(', ', $chartStops) }})">@if($category->visualization_type === 'doughnut')<span class="absolute inset-8 rounded-full bg-white"></span>@endif</div><ul class="grid gap-2 text-xs text-gray-700">@foreach($categoryItems as $chartIndex => $chartItem)<li><span class="mr-2 inline-block h-2.5 w-2.5 rounded-full" style="background-color: {{ $colors[$chartIndex % count($colors)] }}"></span>{{ $chartItem->label ?: $chartItem->nama_statistik }}: <strong>{{ $chartItem->nilai_format }} {{ $chartItem->satuan }}</strong></li>@endforeach</ul></div>
                                @endif
                                @if($category->visualization_type === 'table')<div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="text-xs uppercase text-gray-500"><tr><th class="py-2">Indikator</th><th class="py-2">Nilai</th></tr></thead><tbody class="divide-y">@foreach($categoryItems as $statistic)<tr><td class="py-3">{{ $statistic->label ?: $statistic->nama_statistik }}</td><td class="py-3 font-bold">{{ $statistic->nilai_format }} {{ $statistic->satuan }}</td></tr>@endforeach</tbody></table></div>@else
                                <div class="space-y-5">
                                    @foreach($categoryItems as $statistic)
                                        <div><div class="mb-1.5 flex items-end justify-between gap-4"><div><p class="text-sm font-bold text-gray-800">{{ $statistic->label ?: $statistic->nama_statistik }}</p>@if($statistic->deskripsi)<p class="mt-0.5 text-xs text-gray-500">{{ $statistic->deskripsi }}</p>@endif</div><p class="shrink-0 text-sm font-extrabold text-brand-800">{{ $statistic->nilai_format }} <span class="font-semibold text-gray-500">{{ $statistic->satuan }}</span></p></div><div class="h-2.5 overflow-hidden rounded-full bg-gray-100"><div class="h-full rounded-full bg-brand-700" style="width: {{ max(2, min(100, ((float) $statistic->nilai / $maxValue) * 100)) }}%"></div></div>@if($statistic->gambar)<img src="{{ asset('storage/'.$statistic->gambar) }}" alt="{{ $statistic->label ?: $statistic->nama_statistik }}" loading="lazy" class="mt-3 max-h-48 rounded-xl object-cover">@endif @if($statistic->sumber_data)<p class="mt-1 text-[11px] text-gray-400">Sumber: {{ $statistic->sumber_data }}</p>@endif</div>
                                    @endforeach
                                </div>
                                @endif
                            </article>
                        @endif
                    @endforeach
                </div>
            </section>
        @endforeach
    @endif

    <section class="section-separator rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
        <div class="mb-5"><span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">Perkembangan Desa</span><h2 class="mt-1 text-2xl font-extrabold tracking-tight text-gray-900">Bandingkan Statistik Antar Tahun</h2><p class="mt-2 text-sm text-gray-500">Pilih indikator dan rentang tahun untuk melihat perubahan dari data yang dipublikasikan.</p></div>
        <form method="GET" action="{{ $statisticsUrl }}" class="grid grid-cols-1 gap-3 md:grid-cols-4">
            <input type="hidden" name="tahun" value="{{ $selectedYear }}">
            <label class="text-xs font-bold text-gray-600 md:col-span-2">Indikator<select name="banding_id" required class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="">Pilih indikator</option>@foreach($comparisonIndicators as $indicator)<option value="{{ $indicator->id }}" @selected((int) request('banding_id') === $indicator->id)>{{ $indicator->category->nama_kategori }} · {{ $indicator->nama_statistik }}</option>@endforeach</select></label>
            <label class="text-xs font-bold text-gray-600">Dari tahun<select name="tahun_mulai" class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="">Tahun paling awal</option>@foreach($years->sort() as $year)<option value="{{ $year }}" @selected((string) request('tahun_mulai') === (string) $year)>{{ $year }}</option>@endforeach</select></label>
            <label class="text-xs font-bold text-gray-600">Sampai tahun<select name="tahun_selesai" class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="">Tahun paling akhir</option>@foreach($years->sort() as $year)<option value="{{ $year }}" @selected((string) request('tahun_selesai') === (string) $year)>{{ $year }}</option>@endforeach</select></label>
            <div class="md:col-span-4"><button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800">Bandingkan Tahun</button></div>
        </form>

        @if($comparisonIndicator)
            <div class="mt-7 border-t border-gray-100 pt-6"><div class="flex flex-wrap items-end justify-between gap-3"><div><h3 class="font-bold text-gray-900">{{ $comparisonIndicator->category->nama_kategori }} · {{ $comparisonIndicator->nama_statistik }}</h3><p class="mt-1 text-xs text-gray-500">{{ $comparisonStart }}–{{ $comparisonEnd }}</p></div>@if($changeValue !== null)<p class="text-sm font-bold text-gray-700">Perubahan: {{ number_format($changeValue, 2, ',', '.') }} {{ $comparisonIndicator->satuan }}@if($changePercent !== null) <span class="text-brand-700">({{ $changePercent > 0 ? '+' : '' }}{{ number_format($changePercent, 2, ',', '.') }}%)</span>@endif</p>@endif</div>
                @if($comparisonRows->isEmpty())<p class="mt-5 rounded-xl bg-gray-50 p-4 text-sm text-gray-500">Data pembanding belum tersedia pada rentang tahun tersebut.</p>
                @else
                    @php($comparisonMax = max(1, (float) $comparisonRows->max(fn($item) => (float) $item->nilai)))
                    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">@foreach($comparisonRows as $row)<div class="rounded-2xl bg-gray-50 p-4"><div class="flex items-center justify-between"><span class="text-xs font-bold text-gray-500">{{ $row->tahun }}</span><span class="text-sm font-extrabold text-gray-900">{{ $row->nilai_format }} {{ $row->satuan }}</span></div><div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-200"><div class="h-full rounded-full bg-brand-700" style="width: {{ max(2, min(100, ((float) $row->nilai / $comparisonMax) * 100)) }}%"></div></div></div>@endforeach</div>
                    @if($changeValue === null)<p class="mt-4 text-xs text-gray-500">Perubahan persentase belum dapat dihitung karena data pada salah satu ujung rentang tahun tidak tersedia atau nilai awal nol.</p>@endif
                @endif
            </div>
        @elseif(request()->filled('banding_id'))
            <p class="mt-5 rounded-xl bg-gray-50 p-4 text-sm text-gray-500">Indikator tersebut belum tersedia untuk perbandingan.</p>
        @endif
    </section>
</main>
@endsection
