@extends('documents.user')

@section('content')

<style>
    /* ... (CSS Anda yang sudah ada, tidak berubah) ... */
    .logout-button {
        padding: 10px 12px; gap: 20px; border-radius: 8px;
        text-decoration: none; transition: all 0.1s ease; font-size: 14px;
    }
    .hidden-input { display: none; }
    #pratinjau-foto {
        max-height: 300px; width: auto; object-fit: contain;
        border-radius: 10px; border: 1px solid rgba(0, 0, 0, 0.1);
    }
    #pratinjau-pdf {
        display: flex; flex-direction: column; align-items: center;
        gap: 10px; padding: 20px; border: 1px dashed rgba(0, 0, 0, 0.2);
        border-radius: 10px; background-color: #f8f9fa; color: #6c757d;
        width: 100%; max-width: 400px;
    }
    #pratinjau-pdf-filename {
        font-size: 14px; font-weight: 500; color: #333;
        word-break: break-all; text-align: center;
    }
    #cancel-preview-btn {
        position: absolute; top: -10px; right: -10px; background-color: #dc3545;
        color: white; border: none; border-radius: 50%; width: 25px; height: 25px;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .pratinjau { position: relative; }

    /* (MODIFIKASI) Style untuk dua tombol pilihan */
    .take-photo-option {
        border-radius: 15px;
        border: 1px dashed rgba(0, 0, 0, 0.25);
        background: rgba(0, 119, 194, 0.05);
        padding: 30px;
        cursor: pointer;
        transition: all 0.2s ease;
        flex: 1; /* Membuat kedua tombol sama lebar */
    }
    .take-photo-option:hover {
        background: rgba(0, 119, 194, 0.1);
        border-color: #0077C2;
    }
    .text-take-option {
        font-size: 14px;
        font-weight: 500;
        color: var(--black-color);
    }

    /* (MODIFIKASI) Style untuk video webcam di modal */
    #webcam-video {
        width: 100%;
        height: auto;
        border-radius: 10px;
        background-color: #333;
    }
</style>

@php
    // ... (Logic greeting Anda tidak berubah) ...
    date_default_timezone_set('Asia/Makassar');
    $hour = (int)date('G');
    $greeting = '';
    if ($hour >= 5 && $hour < 11) { $greeting = 'Selamat Pagi'; }
    elseif ($hour >= 11 && $hour < 15) { $greeting = 'Selamat Siang'; }
    elseif ($hour >= 15 && $hour < 19) { $greeting = 'Selamat Sore'; }
    else { $greeting = 'Selamat Malam'; }
    $userName = Auth::user()->name ?? 'Pengguna';
    $userRole = Auth::user()->role ? ucfirst(Auth::user()->role->name) : 'User';
@endphp

    <div class="navbar d-flex justify-content-between align-items-center align-self-stretch bg-white">
        <div class="navbar-left d-flex align-items-center">
            <img src="{{ asset('assets/KSS.png') }}" alt="KSS" style="height: 35px;">
            <div class="akun-title d-flex flex-column align-items-start">
                <span class="nama" style="font-size: 14px; font-weight: 600;">{{ $greeting }}, {{ $userName }}</span>
                <span class="title" style="font-size: 10px; font-weight: 300;">{{ $userRole}}</span>
            </div>
        </div>
        <div class="navbar-right d-flex align-items-center" style="gap: 15px">
            <img src="{{ asset('assets/User 02a.png') }}" alt="User" style="height: 35px; border-radius: 50%;">
            <form action="{{ route('logout') }}" method="POST" class="align-self-stretch" style="margin: 0; padding: 0;" data-turbo="false">
                @csrf
                <button type="submit"
                        class="logout-button menu d-flex align-items-center align-self-stretch"
                        style="background: transparent; border: none; cursor: pointer; text-align: left; width: 100%;"
                        onmouseover="this.style.color='#dc3545'; this.querySelector('svg path').style.fill='#dc3545'; this.style.backgroundColor='rgba(220, 53, 69, 0.2)';"
                        onmouseout="this.style.color='inherit'; this.querySelector('svg path').style.fill='#111111'; this.style.backgroundColor='transparent';">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.33398 0C5.231 0.00101884 6.09129 0.351334 6.72559 0.974609C7.35996 1.59797 7.71683 2.44364 7.71777 3.3252V3.79199C7.71769 4.02379 7.62374 4.24617 7.45703 4.41016C7.29008 4.5742 7.06324 4.66694 6.82715 4.66699C6.59098 4.66699 6.36426 4.57425 6.19727 4.41016C6.03043 4.24615 5.93661 4.02388 5.93652 3.79199V3.3252C5.93652 2.90748 5.76739 2.50631 5.4668 2.21094C5.16632 1.91583 4.75882 1.75009 4.33398 1.75H3.38379C2.95869 1.75 2.55059 1.91557 2.25 2.21094C1.94942 2.50631 1.78125 2.90749 1.78125 3.3252V10.6748C1.78125 11.0925 1.94942 11.4937 2.25 11.7891C2.55059 12.0844 2.95869 12.25 3.38379 12.25H4.33398C4.75882 12.2499 5.16632 12.0842 5.4668 11.7891C5.76739 11.4937 5.93652 11.0925 5.93652 10.6748V10.208C5.93661 9.97612 6.03043 9.75385 6.19727 9.58984C6.36426 9.42575 6.59098 9.33301 6.82715 9.33301C7.06324 9.33306 7.29008 9.4258 7.45703 9.58984C7.62374 9.75383 7.71769 9.97621 7.71777 10.208V10.6748C7.71683 11.5564 7.35996 12.402 6.72559 13.0254C6.09129 13.6487 5.231 13.999 4.33398 14H3.38379C2.48672 13.9991 1.62655 13.6486 0.992188 13.0254C0.357808 12.402 0.000942878 11.5564 0 10.6748V3.3252C0.000942878 2.44363 0.357808 1.59797 0.992188 0.974609C1.62655 0.351357 2.48672 0.000927145 3.38379 0H4.33398ZM10.041 2.625C10.1579 2.62498 10.2738 2.64746 10.3818 2.69141C10.4898 2.73536 10.5882 2.79967 10.6709 2.88086L13.3936 5.55566C13.7822 5.93916 14.0003 6.45876 14 7C13.9997 7.54123 13.7807 8.06034 13.3916 8.44336L10.6689 11.1182C10.5019 11.2822 10.2753 11.3751 10.0391 11.375C9.80291 11.3749 9.57613 11.2823 9.40918 11.1182C9.24233 10.954 9.14838 10.731 9.14844 10.499C9.14859 10.2671 9.24319 10.0448 9.41016 9.88086L11.4678 7.8584L4.15527 7.875C3.91916 7.87496 3.69235 7.78222 3.52539 7.61816C3.35866 7.45419 3.26476 7.23179 3.26465 7C3.26465 6.76802 3.35851 6.54494 3.52539 6.38086C3.69235 6.2168 3.91916 6.12504 4.15527 6.125L11.4365 6.1084L9.41113 4.11816C9.3287 4.0371 9.26345 3.94081 9.21875 3.83496C9.174 3.72886 9.15044 3.61485 9.15039 3.5C9.15033 3.26793 9.24418 3.045 9.41113 2.88086C9.4938 2.79959 9.59218 2.73541 9.7002 2.69141C9.80823 2.6474 9.92407 2.62503 10.041 2.625Z" fill="#111111"/>
                    </svg>
                    <span class="text-sidebar">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="content d-flex flex-column align-items-center align-self-stretch">
        <h4 class="content-title" style="font-weight: 600; font-size: 20px;">Upload Dokumen Baru</h4>

        @if (session('success'))
            <div class="alert alert-success align-self-stretch" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger align-self-stretch">
                <ul style="margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="upload-form" action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="box-main-content d-flex flex-column align-items-center align-self-stretch" style="gap: 20px;">
            @csrf

            <input type="file" id="document_file" name="document_file"
                   accept="image/jpeg,image/png,application/pdf" class="hidden-input" required>

            <div class="box-document d-flex flex-column align-items-start align-self-stretch">
                <span class="step">Langkah 1: Pilih Metode Input</span>

                <div class="d-flex align-items-stretch align-self-stretch" style="gap: 20px;">

                    <button type-="button" id="open-webcam-btn" class="take-photo-option d-flex flex-column align-items-center justify-content-center"
                            data-bs-toggle="modal" data-bs-target="#webcam-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0077C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                        <span class="text-take-option mt-2">Ambil Foto</span>
                    </button>

                    <label for="document_file" class="take-photo-option d-flex flex-column align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0077C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <span class="text-take-option mt-2">Pilih Galeri</span>
                    </label>
                </div>


                <div class="pratinjau d-flex justify-content-center align-items-center align-self-stretch mt-3" style="position: relative;">
                    <span id="preview-placeholder" style="font-size: 14px; color: rgba(0, 0, 0, 0.5); font-weight: 600;">Pratinjau Foto/Dokumen</span>
                    <img src="" alt="Pratinjau Foto Dokumen" id="pratinjau-foto" class="d-none">
                    <div id="pratinjau-pdf" class="d-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc3545" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                            <path d="M5.523 12.424q.21-.124.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.077.03H4.82a.2.2 0 0 1-.099-.04.51.51 0 0 1-.051-.073.38.38 0 0 1-.03-.076.363.363 0 0 1-.01-0.046l-.003-.01c0-.003 0-.005-.003-.006a.37.37 0 0 1-.006-.037.38.38 0 0 1-.003-.082l.001-.03.003-.046a.37.37 0 0 1 .006-.037q.004-.007.007-.01c.003-.006.005-.01.008-.013a.36.36 0 0 1 .046-.046.38.38 0 0 1 .076-.03.51.51 0 0 1 .073-.05.199.199 0 0 1 .04-.01h.046a.282.282 0 0 1 .077.03.266.266 0 0 1 .035.012c.137.056.355.235.635.572.162.193.33.417.45.606.124-.13.24-.268.35-.413s.215-.303.315-.473c.1-.17.18-.358.24-.559a1.76 1.76 0 0 1 .03-.139.3.3 0 0 1 .02-.014c.14-.07.284-.13.43-.175.144-.045.28-.07.41-.07.155 0 .315.026.475.08.16.053.3.13.415.23.116.1.21.22.28.36.07.14.1.29.1.45 0 .14-.03.28-.08.41-.05.13-.12.24-.21.33-.09.09-.2.16-.32.2s-.26.06-.41.06c-.13 0-.26-.02-.38-.06a.78.78 0 0 1-.28-.15.78.78 0 0 1-.18-.24c-.03-.06-.05-.12-.06-.18a.3.3 0 0 1 0-.08c0-.06.01-.12.04-.17s.06-.1.09-.14c.03-.04.06-.07.08-.1.03-.03.05-.05.06-.06.02-.02.03-.03.03-.03.01-.01.01-.01.01-.01H6.88a.2.2 0 0 0-.04.01.5.5 0 0 0-.07.03.37.37 0 0 0-.07.05.38.38 0 0 0-.08.08.37.37 0 0 0-.05.07.2.2 0 0 0-.01.04H6.61a.78.78 0 0 0-.18.24.78.78 0 0 0-.28.15.6.6 0 0 0-.38.06c-.15 0-.29-.02-.41-.06s-.23-.11-.32-.2a.83.83 0 0 1-.21-.33.82.82 0 0 1-.08-.41c0-.16.03-.31.1-.45.07-.14.16-.26.28-.36.115-.1.25-.177.415-.23.16-.054.32-.08.475-.08.13 0 .265.025.41.07.145.045.285.105.43.175a.3.3 0 0 1 .02.014.3.3 0 0 1 .03.139 1.76 1.76 0 0 1 .24.559c.1.17.21.343.315.473s.22.273.35.413Z"/>
                            <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.07V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.463.208.12.455.18.74.18.297 0 .57-.068.81-.2.24-.13.43-.32.57-.57s.21-.56.21-.94v-1.1c0-.7-.25-1.22-.74-1.54s-1.14-.48-1.92-.48c-.4 0-.76.07-1.07.2s-.57.3-.77.53c-.2.24-.31.52-.31.83 0 .34.1.62.3.86.2.24.47.36.8.36.36 0 .66-.09.89-.27.23-.18.34-.44.34-.78v-.05c0-.17-.02-.31-.05-.42s-.08-.2-.13-.26c-.05-.06-.11-.1-.19-.12s-.16-.03-.25-.03c-.17 0-.32.03-.45.08s-.24.13-.32.23c-.08.1-.15.22-.19.35s-.07.27-.07.41c0 .35.08.66.23.92.16.26.39.46.69.58s.66.17 1.05.17c.5 0 .93-.09 1.28-.27.35-.18.6-.43.78-.74.18-.3.27-.65.27-1.05v-1.08c0-.86-.3-1.54-.88-2.06s-1.34-.78-2.28-.78c-.9 0-1.66.26-2.26.78-.6.52-.9 1.2-.9 2.04v.92c0 .48.09.9.27 1.26z"/>
                        </svg>
                        <span id="pratinjau-pdf-filename">namafile.pdf</span>
                    </div>
                    <button type="button" id="cancel-preview-btn" class="d-none" aria-label="Batal Pratinjau">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </button>
                </div>
                <div id="file-error" class="align-self-stretch text-danger mt-2" style="font-size: 14px; font-weight: 600; text-align: center;"></div>
                <div id="webcam-error" class="align-self-stretch text-danger mt-2" style="font-size: 14px; font-weight: 600; text-align: center;"></div>
            </div>

            <div class="box-document d-flex flex-column align-items-start align-self-stretch">
                <span class="step">Langkah 2: Isi Informasi Dokumen</span>
                <div class="infodocument d-flex flex-column align-items-start align-self-stretch" style="gap: 15px;">
                    <div class="input-box d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                        <label for="title" style="font-size: 14px; align-self: stretch;">Judul Dokumen</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Surat Jalan Kapal TB. Maju Jaya"
                                style="border-radius: 10px; font-size: 14px; padding: 10px" required>
                    </div>
                    <div class="input-box d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                        <label for="event_date" style="font-size: 14px; align-self: stretch;">Tanggal Kejadian/Dokumen</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" value="{{ old('event_date', date('Y-m-d')) }}"
                                style="border-radius: 10px; font-size: 14px; padding: 10px" required>
                    </div>
                    <div class="input-box d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                        <label for="document_type_id" style="font-size: 14px; align-self: stretch;">Jenis Dokumen</label>
                        <select class="form-select" id="document_type_id" name="document_type_id" style="border-radius: 10px; font-size: 14px; padding: 10px " required>
                            <option value="" selected disabled>Pilih Jenis Dokumen...</option>
                            @foreach($documentTypes as $type)
                                <option value="{{ $type->id }}" {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-box d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                        <label for="notes" style="font-size: 14px; align-self: stretch;">Catatan (Opsional)</label>
                        <textarea class="keterangan d-flex align-self-stretch form-control" name="notes" id="notes"
                        style="font-size: 14px; border-radius: 10px; padding: 10px; border: 1px solid rgba(0, 0, 0, 0.25);" rows="4" placeholder="Contoh: Muatan batu bara 5000 ton">{{ old('notes') }}</textarea>
                    </div>
                </div>
             </div>

             <button type="submit" id="submit-button" class="btn-kirim d-flex align-items-center align-self-stretch justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M13.8232 1.00293C13.999 1.36326 14.0442 1.7733 13.9502 2.16309L11.9805 11.5205C11.8253 12.6036 11.0689 13.5047 10.0293 13.8457C9.72772 13.9477 9.41116 14.0007 9.09277 14.001C8.32158 14.0004 7.58253 13.6917 7.03906 13.1445L6.03613 12.1436C5.92707 12.0338 5.77873 11.9722 5.62402 11.9727H3.77539C3.51591 11.9713 3.25966 11.9115 3.02637 11.7979L13.8232 1.00293ZM11.8535 0.0449219C12.2382 -0.0451968 12.6424 0.00149895 12.9971 0.175781L2.20117 10.9727C2.08747 10.7393 2.02771 10.4832 2.02637 10.2236V8.375C2.02648 8.22025 1.96486 8.07135 1.85547 7.96191L0.853516 6.95996C0.404301 6.51041 0.113953 5.92646 0.0273438 5.29688C-0.191768 3.702 0.923694 2.23089 2.51855 2.01172L11.8535 0.0449219Z" fill="white"/>
                </svg>
                Kirim Dokumen
             </button>
        </form>
    </div>

    <div class="modal fade" id="webcam-modal" tabindex="-1" aria-labelledby="webcamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header" style="border-bottom: 0;">
                    <h5 class="modal-title" id="webcamModalLabel" style="font-weight: 600;">Ambil Foto dengan Kamera</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="relative">
                        <video id="webcam-video" autoplay playsinline></video>
                        <canvas id="webcam-canvas" class="d-none"></canvas>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center" style="border-top: 0; gap: 15px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 20px; font-weight: 500;">
                        Batal
                    </button>
                    <button id="snap-button" type="button" class="btn btn-primary" style="background-color: #0077C2; border-color: #0077C2; border-radius: 10px; padding: 10px 20px; font-weight: 600;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-camera-fill me-2" viewBox="0 0 16 16">
                            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                            <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                        </svg>
                        Ambil Gambar
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Skrip ini menggabungkan logika pratinjau file DAN logika webcam

    // --- Definisi Validasi (Sesuai Controller) ---
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'application/pdf'];
    const DEFAULT_PLACEHOLDER_TEXT = 'Pratinjau Foto/Dokumen';

    // --- Elemen Global ---
    const uploadForm = document.getElementById('upload-form');
    const submitButton = document.getElementById('submit-button');
    const fileInput = document.getElementById('document_file'); // Input file utama

    // Elemen Pratinjau
    const previewImg = document.getElementById('pratinjau-foto');
    const previewPdf = document.getElementById('pratinjau-pdf');
    const previewPdfFilename = document.getElementById('pratinjau-pdf-filename');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    const cancelPreviewBtn = document.getElementById('cancel-preview-btn');
    const fileError = document.getElementById('file-error');
    const webcamError = document.getElementById('webcam-error');

    // --- Elemen Webcam ---
    const webcamModalEl = document.getElementById('webcam-modal');
    const video = document.getElementById('webcam-video');
    const canvas = document.getElementById('webcam-canvas');
    const snapBtn = document.getElementById('snap-button');
    let stream; // Variabel untuk menyimpan stream webcam
    let webcamModal; // Variabel untuk instance modal Bootstrap

    // --- Fungsi untuk Tampilkan Error ---
    function showPreviewError(message) {
        hidePreview(true);
        fileError.textContent = message;
        webcamError.textContent = ''; // Hapus error webcam jika ada
        fileInput.value = null;
    }

    // --- (MODIFIKASI) Fungsi untuk Tampilkan Error Webcam ---
    function showWebcamError(message) {
        webcamError.textContent = message;
        fileError.textContent = ''; // Hapus error file jika ada
    }

    // --- Fungsi untuk Tampilkan Preview ---
    function showPreview(file) {
        fileError.textContent = ''; // Hapus pesan error
        webcamError.textContent = '';
        previewPlaceholder.classList.add('d-none');

        previewImg.classList.add('d-none');
        previewPdf.classList.add('d-none');

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            previewPdfFilename.textContent = file.name;
            previewPdf.classList.remove('d-none');
        }

        cancelPreviewBtn.classList.remove('d-none');
    }

    // --- Fungsi untuk Sembunyikan Preview ---
    function hidePreview(isError = false) {
        previewImg.src = '';
        previewImg.classList.add('d-none');
        previewPdf.classList.add('d-none');
        previewPdfFilename.textContent = '';

        previewPlaceholder.textContent = DEFAULT_PLACEHOLDER_TEXT;
        previewPlaceholder.classList.remove('d-none');

        cancelPreviewBtn.classList.add('d-none');

        if (!isError) {
             fileError.textContent = '';
             webcamError.textContent = '';
        }
        if (!isError && fileInput) {
            fileInput.value = null;
        }
    }

    // --- 1. Event Listener untuk "Pilih Galeri" (File Input) ---
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validasi
                if (file.size > MAX_FILE_SIZE) {
                    showPreviewError('File terlalu besar! Maksimal 5MB.');
                    return;
                }
                if (!ALLOWED_MIMES.includes(file.type)) {
                    showPreviewError('Tipe file tidak valid. Hanya (JPG, PNG, PDF).');
                    return;
                }
                // Tampilkan
                showPreview(file);
            } else {
                hidePreview();
            }
        });
    }

    // --- 2. Event Listener untuk Tombol Batal Preview ---
    if (cancelPreviewBtn) {
        cancelPreviewBtn.addEventListener('click', function() {
            hidePreview(false);
        });
    }

    // --- 3. Event Listener untuk Submit Form ---
    if (uploadForm && submitButton) {
        uploadForm.addEventListener('submit', function(event) {
            if (!fileInput.files || fileInput.files.length === 0) {
                 showPreviewError('Anda harus memilih file dokumen.');
                 event.preventDefault();
                 return;
            }
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-right: 8px;"></span>
                Mengirim...
            `;
        });
    }

    // --- 4. (MODIFIKASI) Logika untuk Webcam ---
    if (webcamModalEl) {
        // Inisialisasi instance Modal Bootstrap
        webcamModal = new bootstrap.Modal(webcamModalEl);

        // Saat modal akan ditampilkan, nyalakan webcam
        webcamModalEl.addEventListener('show.bs.modal', async function () {
            showWebcamError(''); // Hapus error lama
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment' // Prioritaskan kamera belakang (untuk HP)
                    },
                    audio: false
                });
                video.srcObject = stream;
            } catch (err) {
                console.error("Error mengakses webcam: ", err);
                // (PENTING) Tampilkan error kepada pengguna
                showWebcamError('Gagal mengakses kamera. Pastikan Anda menggunakan HTTPS dan telah memberi izin.');
                webcamModal.hide(); // Tutup modal jika gagal
            }
        });

        // Saat modal ditutup, matikan webcam
        webcamModalEl.addEventListener('hide.bs.modal', function () {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });

        // Saat tombol "Ambil Gambar" (snap) diklik
        snapBtn.addEventListener('click', function() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Konversi canvas ke File object
            canvas.toBlob(function(blob) {
                const file = new File([blob], "webcam-capture.jpg", { type: "image/jpeg" });

                // (PENTING) Masukkan file dari webcam ke input file utama
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                // Tampilkan pratinjau
                showPreview(file);

                // Tutup modal
                webcamModal.hide();

            }, 'image/jpeg');
        });
    }

</script>
@endpush
