@props(['source', 'year' => null])

@php($sourceParts = preg_split('~(https?://[^\s<>"\']+)~u', (string) $source, -1, PREG_SPLIT_DELIM_CAPTURE))

<p class="mt-3 min-w-0 max-w-full text-xs leading-5 text-gray-500" style="overflow-wrap:anywhere;word-break:break-word;max-width:100%;min-width:0">
    Sumber:
    @foreach($sourceParts as $part)
        @if(str_starts_with($part, 'https://') || str_starts_with($part, 'http://'))
            <a href="{{ $part }}" target="_blank" rel="noopener noreferrer" class="break-all text-blue-700 underline decoration-blue-700 underline-offset-2 transition-colors hover:text-blue-900 hover:decoration-blue-900 focus-visible:rounded-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700">{{ str_ends_with(strtolower($part), '.jpeg') ? 'Lihat foto kegiatan' : 'Buka sumber' }} ↗</a>
        @else
            {{ $part }}
        @endif
    @endforeach
    @if($year) · Data {{ $year }}@endif
</p>
