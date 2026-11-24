@extends('admin.layouts.app')
@section('title', 'Detail '.$config['title'])
@section('page-title', 'Detail '.$config['title'])
@section('page-desc', $item->{$config['name']})
@section('content')
<article class="max-w-4xl space-y-5 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
    @if($item->{$config['image']})<img class="max-h-96 w-full rounded-2xl bg-gray-50 object-contain" src="{{ asset('storage/'.$item->{$config['image']}) }}" alt="{{ $item->{$config['name']} }}">@endif
    <h2 class="text-2xl font-extrabold text-gray-900">{{ $item->{$config['name']} }}</h2>
    <dl class="grid gap-3 sm:grid-cols-2">@foreach($config['fields'] as $field)@continue(in_array($field, [$config['name'], $config['image'], 'deskripsi', 'status']))<div class="rounded-xl bg-gray-50 p-4"><dt class="text-xs font-semibold uppercase text-gray-500">{{ str($field)->replace('_', ' ')->title() }}</dt><dd class="mt-1 text-sm font-bold text-gray-900">{{ $item->{$field} ?? 'Belum diisi' }}</dd></div>@endforeach<div class="rounded-xl bg-gray-50 p-4"><dt class="text-xs font-semibold uppercase text-gray-500">Status Publikasi</dt><dd class="mt-1 text-sm font-bold text-gray-900">{{ $item->status ? 'Aktif' : 'Nonaktif' }}</dd></div></dl>
    @if($item->deskripsi)<section><h3 class="font-bold text-gray-900">Deskripsi</h3><p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ $item->deskripsi }}</p></section>@endif
    <div class="flex gap-3"><a class="rounded-xl bg-brand-700 px-5 py-3 font-bold text-white" href="{{ route('admin.wilayah.items.edit', [$section, $item->id]) }}">Edit Informasi</a><a class="rounded-xl border px-5 py-3 font-semibold text-gray-700" href="{{ route('admin.wilayah.items.index', $section) }}">Kembali</a></div>
</article>
@endsection
