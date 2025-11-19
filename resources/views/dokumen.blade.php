@extends('layouts.admin')

@section('content')

<style>
    tr.body td.aksi {
        padding: 6px 15px 5px 15px;
        min-width: 120px;
    }
    .btn-aksi {
        border: none; background: #F1F1F1; padding: 5px 8px;
        border-radius: 5px; transition: background-color 0.2s ease;
    }
    .btn-aksi:hover {
        background-color: #E5E5E5;
    }

    #previewModalContent {
        width: 100%;
        display: flex;            /* Agar konten rata tengah */
        justify-content: center;
        align-items: center;
        /* Hapus height: 75vh yang statis di sini */
        min-height: 150px;        /* Tinggi minimal agar loading terlihat */
    }

    /* Style Khusus Gambar */
    #previewModalContent img {
        max-width: 100%;          /* Lebar maksimal mengikuti modal */
        max-height: 85vh;         /* Tinggi maksimal 85% layar agar tidak perlu scroll body */
        height: auto;             /* Tinggi menyesuaikan aspek rasio */
        object-fit: contain;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Style Khusus PDF */
    #previewModalContent embed {
        width: 100%;
        height: 100%;             /* Mengikuti tinggi container yang diset via JS */
        border-radius: 4px;
    }

    /* (PERBAIKAN V3) Paksa modal pratinjau agar selalu terang */
    /* Ini menargetkan modal berdasarkan ID, yang sangat spesifik */
    #previewModal .modal-content {
        background-color: #ffffff !important; /* Latar belakang putih */
        color: #212529 !important; /* Teks gelap */
    }
    #previewModal .modal-header {
        background-color: #f8f9fa !important; /* Latar header sedikit abu-abu */
        color: #212529 !important;
        border-bottom: 1px solid #dee2e6 !important;
    }
    #previewModal .modal-title {
        color: #212529 !important; /* Judul modal menjadi hitam */
    }
    #previewModal .modal-body {
        background-color: #ffffff !important; /* Latar body putih */
    }

    /* Tombol Close 'X' di modal */
    #previewModal .btn-close {
        /* Reset filter yang mungkin diterapkan oleh dark mode */
        filter: none !important;
    }
    /* (AKHIR PERBAIKAN V3) */

    .doc-title {
        font-weight: 600; color: #333;
    }
    .doc-notes {
        font-size: 0.85rem; color: #666; display: block;
    }
    .pagination {
        justify-content: center; margin-top: 20px;
    }
</style>

<!-- ... (Sisa kode HTML Anda dari 'h1' sampai '/div' tidak berubah) ... -->
<h1 class="title-page align-self-stretch">Manajemen Dokumen</h1>
<div class="content d-flex flex-column justify-content-center align-items-center align-self-stretch " style="gap: 20px;">

    <div class="box-filter d-flex align-items-end align-self-stretch style="gap: 40px;">
        <form class="filters d-flex align-items-end" style="gap: 30px; flex: 1 0 0;" method="GET" action="{{ route('admin.document') }}">
            <div class="filter d-flex flex-column align-items-start" style="gap: 10px; flex: 1 0 0;">
                <label for="cari">Cari Dokumen</label>
                <input type="search" name="cari" id="cari" placeholder="Cari Judul/Catatan..." value="{{ request('cari') }}">
            </div>
            <div class="filter d-flex flex-column align-items-start" style="gap: 10px; flex: 1 0 0;">
                <label for="jenis">Jenis Dokumen</label>
                <select name="jenis" id="jenis">
                    <option value="" selected>Semua Jenis...</option>
                    @foreach($documentTypes as $type)
                        <option value="{{ $type->id }}" {{ request('jenis') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter d-flex flex-column align-items-start" style="gap: 10px; flex: 1 0 0;">
                <label for="tanggal">Filter Tanggal (Kejadian)</label>
                <input class="form-date" type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}">
            </div>
            <button class="submit-filter" type="submit">Terapkan Filter</button>
        </form>
    </div>

    <div class="box-table d-flex flex-column justify-content-center align-items-center align-self-stretch" style="gap: 30px;">
        <div class="document-table d-flex flex-column align-items-start align-self-stretch">
            <div class="box-title d-flex flex-column align-items-start align-self-stretch" style="padding: 15px; border-radius: 10px;">
                <span class="title-table" style="font-size:14px;font-weight: 600; color: var(--black-color);">
                    Tabel Dokumen
                </span>
            </div>
            <table class="table" style="border-radius: 0 0 10px 10px;">
                <tr class="head d-flex align-items-center align-self-stretch" style="background-color: #EAEAEA;">
                    <th class="number">No</th>
                    <th>Jenis Dokumen</th>
                    <th>Pengunggah</th>
                    <th>Waktu Upload</th>
                    <th class="keterangan">Judul & Keterangan</th>
                    <th>Aksi</th>
                </tr>

                @forelse($documents as $doc)
                <tr class="body d-flex align-items-center align-self-stretch">
                    <td class="number">{{ $loop->iteration + ($documents->currentPage() - 1) * $documents->perPage() }}</td>
                    <td>{{ $doc->documentType->name ?? 'N/A' }}</td>
                    <td>{{ $doc->user->name ?? 'N/A' }}</td>
                    <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                    <td class="keterangan">
                        <span class="doc-title">{{ $doc->title }}</span>
                        @if($doc->notes)
                            <span style="color: #ccc; margin: 0 5px;">||</span>
                            <span class="doc-notes">{{ Str::limit($doc->notes, 50) }}</span>
                        @endif
                    </td>
                    <td class="aksi">
                        <button type="button" class="btn-aksi btn-preview"
                                data-bs-toggle="modal"
                                data-bs-target="#previewModal"
                                data-title="{{ $doc->title }}"
                                data-path="{{ Storage::url($doc->file_path) }}"
                                data-extension="{{ pathinfo($doc->file_path, PATHINFO_EXTENSION) }}"
                                title="Pratinjau Dokumen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 12 10" fill="none">
                                <path d="M6.00012 0C8.2324 0.0210762 10.3055 1.16099 11.5197 3.03418C12.1606 3.97373 12.1606 5.20986 11.5197 6.14941C10.3055 8.02261 8.23239 9.16253 6.00012 9.18359C3.76712 9.16197 1.69317 8.02094 0.479614 6.14648C-0.15992 5.20765 -0.159852 3.97302 0.479614 3.03418C1.69385 1.16087 3.76771 0.0209436 6.00012 0ZM6.00012 1.50781C4.26208 1.5207 2.64986 2.41765 1.72278 3.8877C1.4338 4.3122 1.43386 4.87037 1.72278 5.29492C2.64984 6.76524 4.26193 7.66292 6.00012 7.67578C7.73818 7.66276 9.34952 6.76512 10.2765 5.29492C10.5655 4.87036 10.5655 4.31222 10.2765 3.8877C9.34944 2.4178 7.73795 1.52081 6.00012 1.50781ZM5.99915 2.58105C7.10949 2.58105 8.00989 3.48153 8.00989 4.5918C8.0098 5.70199 7.10943 6.60156 5.99915 6.60156C4.88906 6.60133 3.98947 5.70185 3.98938 4.5918C3.98938 3.48167 4.88901 2.58129 5.99915 2.58105Z" fill="#0077C2"/>
                            </svg>
                        </button>
                        <!-- (PERBAIKAN) Mengubah string tanggal menjadi objek Carbon sebelum format -->
                        <a href="{{ Storage::url($doc->file_path) }}"
                           download="{{ \Carbon\Carbon::parse($doc->event_date)->format('Y-m-d') }} - {{ preg_replace('/[\\\\\/:"*?<>|]+/', '', $doc->title) }}.{{ pathinfo($doc->file_path, PATHINFO_EXTENSION) }}"
                           class="btn-aksi"
                           title="Unduh Dokumen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M11.25 7.25C11.6642 7.25 12 7.58578 12 8V10.2959C11.9987 11.2366 11.2367 11.9989 10.2959 12H1.70508C0.764312 11.9989 0.00131589 11.2366 0 10.2959V8C4.6351e-06 7.58592 0.33596 7.2502 0.75 7.25C1.16421 7.25 1.5 7.58579 1.5 8V10.2959C1.50047 10.4085 1.59238 10.4997 1.70508 10.5H10.2959C10.4086 10.4997 10.4995 10.4085 10.5 10.2959V8C10.5 7.58592 10.836 7.2502 11.25 7.25ZM6 0C6.41421 0 6.75 0.335789 6.75 0.75L6.76172 7.57422L8.15332 6.18359C8.15934 6.17736 8.16562 6.17106 8.17188 6.16504C8.46982 5.87737 8.94469 5.88569 9.23242 6.18359C9.52003 6.48154 9.51175 6.95643 9.21387 7.24414L7.60742 8.84961C6.72873 9.72828 5.30445 9.7283 4.42578 8.84961L2.81934 7.24316C2.53904 6.95252 2.53885 6.49169 2.81934 6.20117C3.10697 5.90337 3.58192 5.89525 3.87988 6.18262L5.26074 7.56348L5.25 0.75C5.25 0.335882 5.58592 0.000150331 6 0Z" fill="#F39C12"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="body d-flex align-items-center align-self-stretch">
                    <td colspan="6" style="text-align: center; padding: 20px; width: 100%;">
                        Tidak ada dokumen yang ditemukan.
                    </td>
                </tr>
                @endforelse

            </table>

            <div class="d-flex justify-content-center align-self-stretch">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
<!-- Modal Pratinjau Dokumen -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Pratinjau Dokumen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="previewModalContent">
          <p class="text-center">Memuat pratinjau...</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const previewModal = document.getElementById('previewModal');

    if (previewModal) {
        previewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            // Ambil data
            const title = button.getAttribute('data-title');
            const path = button.getAttribute('data-path');
            const extension = button.getAttribute('data-extension').toLowerCase();

            // Elemen DOM
            const modalTitle = previewModal.querySelector('.modal-title');
            const modalBodyContent = previewModal.querySelector('#previewModalContent');

            // Set Judul
            modalTitle.textContent = title;

            // Reset konten & style
            modalBodyContent.innerHTML = '';

            // LOGIKA PENYESUAIAN UKURAN
            if (extension === 'pdf') {
                // KHUSUS PDF: Kita butuh tinggi tetap agar scrollbar PDF muncul
                modalBodyContent.style.height = '80vh';

                const embed = document.createElement('embed');
                embed.src = path;
                embed.type = 'application/pdf';
                modalBodyContent.appendChild(embed);

            } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                // KHUSUS GAMBAR: Tinggi otomatis mengikuti gambar (height: auto)
                modalBodyContent.style.height = 'auto';

                // Tambahkan loader/spinner sederhana sebelum gambar muncul (opsional tapi bagus)
                modalBodyContent.innerHTML = '<div class="text-center py-5">Memuat gambar...</div>';

                const img = new Image();
                img.src = path;
                img.alt = title;

                img.onload = function() {
                    modalBodyContent.innerHTML = ''; // Hapus text loading
                    modalBodyContent.appendChild(img);
                };

                img.onerror = function() {
                    modalBodyContent.innerHTML = '<p class="text-danger text-center py-5">Gagal memuat gambar.</p>';
                };

            } else {
                // File tidak didukung
                modalBodyContent.style.height = 'auto';
                modalBodyContent.innerHTML = '<div class="text-center p-5">Pratinjau tidak tersedia.<br>Silakan unduh file.</div>';
            }
        });

        // Bersihkan saat modal ditutup
        previewModal.addEventListener('hide.bs.modal', function () {
            const modalBodyContent = previewModal.querySelector('#previewModalContent');
            modalBodyContent.innerHTML = '';
            modalBodyContent.style.height = ''; // Reset inline style height
        });
    }
});
</script>
@endpush
