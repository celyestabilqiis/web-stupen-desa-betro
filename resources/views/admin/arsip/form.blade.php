@extends('admin.layouts.app')

@section('title', $arsip ? 'Edit Arsip' : 'Tambah Arsip Baru')
@section('page-title', $arsip ? 'Edit Arsip' : 'Tambah Arsip Baru')
@section('page-desc', $arsip ? 'Perbarui informasi dan dokumen arsip' : 'Tulis artikel atau unggah dokumen arsip desa baru')

@section('content')
<div class="max-w-5xl">
    <form method="POST" action="{{ $arsip ? route('admin.arsip.update', $arsip) : route('admin.arsip.store') }}" enctype="multipart/form-data" class="space-y-6" id="arsipForm">
        @csrf
        @if ($arsip)
            @method('PUT')
        @endif

        <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-xs space-y-6">
            <!-- Judul -->
            <div>
                <label for="judul" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Judul Arsip <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $arsip->judul ?? '') }}" required placeholder="Contoh: Ringkasan Laporan Realisasi APBDes Desa Betro..." class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- Kategori & Tipe Isi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select name="kategori" id="kategori" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="arsip_desa" {{ old('kategori', $arsip->kategori ?? '') === 'arsip_desa' ? 'selected' : '' }}>Arsip Desa</option>
                        <option value="dokumentasi_desa" {{ old('kategori', $arsip->kategori ?? '') === 'dokumentasi_desa' ? 'selected' : '' }}>Dokumentasi Desa</option>
                    </select>
                </div>

                <!-- Tipe Isi -->
                <div>
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                        Tipe Isi <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="tipe" value="artikel" class="text-brand-700 focus:ring-brand-700" {{ old('tipe', $arsip->tipe ?? 'artikel') === 'artikel' ? 'checked' : '' }} onchange="toggleTipe('artikel')">
                            <span class="text-xs font-bold text-gray-700">Tulis Artikel</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="tipe" value="pdf" class="text-brand-700 focus:ring-brand-700" {{ old('tipe', $arsip->tipe ?? '') === 'pdf' ? 'checked' : '' }} onchange="toggleTipe('pdf')">
                            <span class="text-xs font-bold text-gray-700">Unggah File PDF</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Tanggal & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                        Tanggal Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $arsip?->tanggal ? $arsip->tanggal->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                        Status Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                        <option value="draft" {{ old('status', $arsip->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft (Belum Ditampilkan)</option>
                        <option value="terbit" {{ old('status', $arsip->status ?? '') === 'terbit' ? 'selected' : '' }}>Terbit (Ditampilkan ke Publik)</option>
                    </select>
                </div>
            </div>

            <!-- Ringkasan Singkat (Opsional) -->
            <div>
                <label for="ringkasan" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Ringkasan Singkat <span class="text-xs font-normal text-gray-400 lowercase">(opsional, dibuat otomatis jika kosong)</span>
                </label>
                <textarea name="ringkasan" id="ringkasan" rows="2" maxlength="300" placeholder="Ketik ringkasan singkat artikel..." class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('ringkasan', $arsip->ringkasan ?? '') }}</textarea>
                <p class="text-[11px] text-gray-400 mt-1">Maksimal 160-300 karakter untuk deskripsi pratinjau kartu dan SEO.</p>
            </div>

            <!-- Gambar Sampul -->
            <div>
                <label for="gambar_sampul" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Gambar Sampul <span id="labelGambarWajib" class="text-rose-500">*</span>
                    <span class="text-xs font-normal text-gray-400 lowercase">(format: JPG, PNG, WebP - maks 5 MB)</span>
                </label>
                <input type="file" name="gambar_sampul" id="gambar_sampul" accept="image/jpeg,image/png,image/webp,image/jpg" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:outline-none">
                <div id="errorGambarSampul" class="text-xs text-rose-600 font-bold mt-1.5 hidden"></div>

                <!-- Preview Gambar -->
                <div id="previewSampulContainer" class="mt-3 {{ $arsip?->gambar_sampul ? '' : 'hidden' }}">
                    <p class="text-xs font-bold text-gray-500 mb-1.5">Pratinjau Sampul:</p>
                    <img id="previewSampul" src="{{ $arsip?->gambar_sampul ? asset('storage/' . $arsip->gambar_sampul) : '' }}" alt="Pratinjau Sampul" class="w-48 h-28 object-cover rounded-xl border border-gray-200">
                </div>
            </div>

            <!-- Section PDF: Input Unggah File PDF -->
            <div id="sectionPdf" class="{{ old('tipe', $arsip->tipe ?? 'artikel') === 'pdf' ? '' : 'hidden' }} p-5 rounded-xl bg-gray-50 border border-gray-200 space-y-3">
                <label for="file_pdf" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Unggah File PDF <span class="text-rose-500">*</span>
                    <span class="text-xs font-normal text-gray-400 lowercase">(maksimal 10 MB)</span>
                </label>
                <input type="file" name="file_pdf" id="file_pdf" accept="application/pdf" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-white text-xs focus:outline-none">
                <div id="errorFilePdf" class="text-xs text-rose-600 font-bold hidden"></div>

                @if ($arsip?->file_pdf)
                    <div class="flex items-center gap-2 text-xs text-brand-700 font-bold pt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>File PDF saat ini tersimpan: </span>
                        <a href="{{ asset('storage/' . $arsip->file_pdf) }}" target="_blank" class="hover:text-brand-900 transition font-medium">Lihat File PDF</a>
                    </div>
                @endif
            </div>

            <!-- Section Artikel: TipTap Rich Text Editor -->
            <div id="sectionArtikel" class="{{ old('tipe', $arsip->tipe ?? 'artikel') === 'artikel' ? '' : 'hidden' }} space-y-2">
                <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                    Isi Artikel <span class="text-rose-500">*</span>
                </label>

                <!-- TipTap Toolbar -->
                <div class="border border-gray-200 rounded-t-xl bg-gray-50 p-2 flex flex-wrap items-center gap-1.5 text-xs select-none">
                    <!-- Undo / Redo -->
                    <div class="flex items-center border-r border-gray-200 pr-1.5 mr-1 gap-0.5">
                        <button type="button" onclick="tiptapAction('undo')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Undo (Urungkan)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2m0 0l-4-4m4 4l4-4"/></svg>
                        </button>
                        <button type="button" onclick="tiptapAction('redo')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Redo (Ulangi)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a5 5 0 00-5 5v2m0 0l4-4m-4 4l-4-4"/></svg>
                        </button>
                    </div>

                    <!-- Heading Selector -->
                    <select id="tiptapHeadingSelect" onchange="tiptapAction('setHeading', this.value)" class="px-2 py-1 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-700 focus:outline-none">
                        <option value="p">Paragraf</option>
                        <option value="h1">Judul 1 (H1)</option>
                        <option value="h2">Judul 2 (H2)</option>
                        <option value="h3">Judul 3 (H3)</option>
                    </select>

                    <!-- Font Size Selector -->
                    <select onchange="tiptapAction('setFontSize', this.value)" class="px-2 py-1 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-700 focus:outline-none" title="Ukuran Huruf">
                        <option value="">Ukuran Normal</option>
                        <option value="12px">12 px</option>
                        <option value="14px">14 px</option>
                        <option value="16px">16 px</option>
                        <option value="18px">18 px</option>
                        <option value="20px">20 px</option>
                        <option value="24px">24 px</option>
                        <option value="30px">30 px</option>
                        <option value="36px">36 px</option>
                    </select>

                    <!-- Text Formats -->
                    <div class="flex items-center border-l border-r border-gray-200 px-1.5 mx-1 gap-0.5">
                        <button type="button" data-tiptap-btn="bold" onclick="tiptapAction('bold')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700 font-bold" title="Tebal (Bold)">B</button>
                        <button type="button" data-tiptap-btn="italic" onclick="tiptapAction('italic')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700 italic" title="Miring (Italic)">I</button>
                        <button type="button" data-tiptap-btn="underline" onclick="tiptapAction('underline')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700 underline" title="Garis Bawah (Underline)">U</button>
                        <button type="button" data-tiptap-btn="strike" onclick="tiptapAction('strike')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700 line-through" title="Coret (Strikethrough)">S</button>
                    </div>

                    <!-- Warna Teks & Highlight -->
                    <div class="flex items-center gap-1 mr-1">
                        <label class="p-1 hover:bg-gray-200 rounded-lg cursor-pointer flex items-center gap-1" title="Warna Teks">
                            <span class="text-xs font-bold">A</span>
                            <input type="color" onchange="tiptapAction('setColor', this.value)" class="w-4 h-4 cursor-pointer border-0 bg-transparent p-0">
                        </label>
                        <label class="p-1 hover:bg-gray-200 rounded-lg cursor-pointer flex items-center gap-1" title="Warna Sorotan (Highlight)">
                            <span class="text-xs bg-yellow-200 px-1 rounded font-bold">H</span>
                            <input type="color" value="#fef08a" onchange="tiptapAction('setHighlight', this.value)" class="w-4 h-4 cursor-pointer border-0 bg-transparent p-0">
                        </label>
                    </div>

                    <!-- Alignment -->
                    <div class="flex items-center border-l border-r border-gray-200 px-1.5 mx-1 gap-0.5">
                        <button type="button" data-tiptap-btn="align-left" onclick="tiptapAction('align', 'left')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Rata Kiri">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"/></svg>
                        </button>
                        <button type="button" data-tiptap-btn="align-center" onclick="tiptapAction('align', 'center')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Rata Tengah">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M4 18h16"/></svg>
                        </button>
                        <button type="button" data-tiptap-btn="align-right" onclick="tiptapAction('align', 'right')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Rata Kanan">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M4 18h16"/></svg>
                        </button>
                        <button type="button" data-tiptap-btn="align-justify" onclick="tiptapAction('align', 'justify')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Rata Kiri Kanan (Justify)">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    </div>

                    <!-- Lists & Quote -->
                    <div class="flex items-center gap-0.5 mr-1">
                        <button type="button" data-tiptap-btn="bulletList" onclick="tiptapAction('bulletList')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Daftar Poin">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M2 6h.01M2 12h.01M2 18h.01"/></svg>
                        </button>
                        <button type="button" data-tiptap-btn="orderedList" onclick="tiptapAction('orderedList')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Daftar Nomor">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6h13M7 12h13M7 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                        </button>
                        <button type="button" data-tiptap-btn="blockquote" onclick="tiptapAction('blockquote')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Kutipan (Blockquote)">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        </button>
                        <button type="button" onclick="tiptapAction('horizontalRule')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Garis Pemisah">—</button>
                    </div>

                    <!-- Link & Image -->
                    <div class="flex items-center border-l border-r border-gray-200 px-1.5 mx-1 gap-0.5">
                        <button type="button" onclick="tiptapAction('insertLink')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Sisipkan Tautan (Link)">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </button>
                        <button type="button" onclick="tiptapAction('uploadImage')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-700" title="Sisipkan Gambar dari Komputer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </button>
                    </div>

                    <!-- Table Controls -->
                    <div class="flex items-center gap-0.5 mr-1">
                        <button type="button" onclick="tiptapAction('insertTable')" class="px-2 py-1 bg-white border border-gray-200 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-100" title="Sisipkan Tabel (3x3)">
                            + Tabel
                        </button>
                        <button type="button" onclick="tiptapAction('addRowAfter')" class="p-1 hover:bg-gray-200 rounded text-gray-600 text-[10px]" title="Tambah Baris">+Baris</button>
                        <button type="button" onclick="tiptapAction('deleteRow')" class="p-1 hover:bg-gray-200 rounded text-rose-600 text-[10px]" title="Hapus Baris">-Baris</button>
                        <button type="button" onclick="tiptapAction('addColumnAfter')" class="p-1 hover:bg-gray-200 rounded text-gray-600 text-[10px]" title="Tambah Kolom">+Kolom</button>
                        <button type="button" onclick="tiptapAction('deleteColumn')" class="p-1 hover:bg-gray-200 rounded text-rose-600 text-[10px]" title="Hapus Kolom">-Kolom</button>
                        <button type="button" onclick="tiptapAction('deleteTable')" class="p-1 hover:bg-rose-100 rounded text-rose-600 text-[10px]" title="Hapus Tabel">Hapus Tabel</button>
                    </div>

                    <!-- Clear Formatting -->
                    <button type="button" onclick="tiptapAction('clearFormatting')" class="p-1.5 hover:bg-gray-200 rounded-lg text-gray-500 ml-auto" title="Hapus Format (Clear Formatting)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Editor Canvas -->
                <div id="tiptapEditor" class="min-h-[350px] max-h-[600px] overflow-y-auto p-4 border border-t-0 border-gray-200 rounded-b-xl bg-white focus:outline-none tiptap-content"></div>
                <input type="hidden" name="isi" id="isiInput" value="{{ old('isi', $arsip->isi ?? '') }}">
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.arsip.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-bold text-xs hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-md transition">
                    {{ $arsip ? 'Simpan Perubahan' : 'Terbitkan Arsip' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function toggleTipe(tipe) {
        const sectionArtikel = document.getElementById('sectionArtikel');
        const sectionPdf = document.getElementById('sectionPdf');
        const labelGambarWajib = document.getElementById('labelGambarWajib');

        if (tipe === 'pdf') {
            sectionArtikel.classList.add('hidden');
            sectionPdf.classList.remove('hidden');
            labelGambarWajib.classList.add('hidden');
        } else {
            sectionArtikel.classList.remove('hidden');
            sectionPdf.classList.add('hidden');
            labelGambarWajib.classList.remove('hidden');
        }
    }

    // Client-side file validation for Gambar Sampul (max 5 MB)
    const gambarSampulInput = document.getElementById('gambar_sampul');
    const errorGambarSampul = document.getElementById('errorGambarSampul');
    const previewSampul = document.getElementById('previewSampul');
    const previewSampulContainer = document.getElementById('previewSampulContainer');

    gambarSampulInput.addEventListener('change', function () {
        const file = this.files[0];
        errorGambarSampul.classList.add('hidden');
        errorGambarSampul.textContent = '';

        if (!file) return;

        // 5 MB = 5 * 1024 * 1024 = 5242880 bytes
        if (file.size > 5242880) {
            const sizeMb = (file.size / (1024 * 1024)).toFixed(1).replace('.', ',');
            errorGambarSampul.textContent = `Ukuran gambar terlalu besar (${sizeMb} MB). Maksimal 5 MB.`;
            errorGambarSampul.classList.remove('hidden');
            this.value = '';
            previewSampulContainer.classList.add('hidden');
            return;
        }

        // Preview
        const reader = new FileReader();
        reader.onload = function (e) {
            previewSampul.src = e.target.result;
            previewSampulContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    // Client-side file validation for PDF (max 10 MB)
    const filePdfInput = document.getElementById('file_pdf');
    const errorFilePdf = document.getElementById('errorFilePdf');

    if (filePdfInput) {
        filePdfInput.addEventListener('change', function () {
            const file = this.files[0];
            errorFilePdf.classList.add('hidden');
            errorFilePdf.textContent = '';

            if (!file) return;

            // 10 MB = 10 * 1024 * 1024 = 10485760 bytes
            if (file.size > 10485760) {
                const sizeMb = (file.size / (1024 * 1024)).toFixed(1).replace('.', ',');
                errorFilePdf.textContent = `Ukuran file PDF terlalu besar (${sizeMb} MB). Maksimal 10 MB.`;
                errorFilePdf.classList.remove('hidden');
                this.value = '';
                return;
            }
        });
    }

    // Initialize TipTap Editor
    document.addEventListener('DOMContentLoaded', function () {
        const initialContent = document.getElementById('isiInput').value;
        const uploadUrl = "{{ route('admin.arsip.upload-image') }}";
        const csrfToken = "{{ csrf_token() }}";

        if (window.initTipTapEditor) {
            window.initTipTapEditor('tiptapEditor', initialContent, uploadUrl, csrfToken);
        }
    });
</script>
@endpush
