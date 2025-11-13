@extends('documents.user')

@section('content')

<style>
        .logout-button {
            padding: 10px 12px;
            gap: 20px;
            border-radius: 8px;
            text-decoration: none;
            /* Transisi untuk gap dan padding */
            transition: all 0.1s ease;
            font-size: 14px;
            border: 2px solid red;
        }

</style>

@php
    // Set timezone ke Waktu Indonesia Tengah (WITA)
    // Sesuaikan 'Asia/Makassar' jika server Anda berada di timezone berbeda
    date_default_timezone_set('Asia/Makassar');
    $hour = (int)date('G');
    $greeting = '';

    if ($hour >= 5 && $hour < 11) {
        $greeting = 'Selamat Pagi'; // 5:00 - 10:59
    } elseif ($hour >= 11 && $hour < 15) {
        $greeting = 'Selamat Siang'; // 11:00 - 14:59
    } elseif ($hour >= 15 && $hour < 19) {
        $greeting = 'Selamat Sore'; // 15:00 - 18:59
    } else {
        $greeting = 'Selamat Malam'; // 19:00 - 4:59
    }

    // Ambil data user yang sedang login.
    // Pastikan user sudah login (middleware 'auth' harus melindungi rute ini)
    $userName = Auth::user()->name ?? 'Pengguna'; // Fallback jika nama tidak ada

    // Ambil nama peran dan ubah huruf pertama jadi kapital
    $userRole = Auth::user()->role ? ucfirst(Auth::user()->role->name) : 'User'; // Fallback jika role tidak ada
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
                    <!-- Mengganti class 'logout' dengan 'text-sidebar' agar konsisten -->
                    <span class="text-sidebar">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="content d-flex flex-column align-items-center align-self-stretch">
        <h4 class="content-title" style="font-weight: 600; font-size: 20px;">Upload Dokumen Baru</h4>
        <form action="" method="" class="box-main-content d-flex flex-column align-items-center align-self-stretch" style="gap: 40px;">
            <div class="box-document d-flex flex-column align-items-start align-self-stretch">
                <span class="step">Langkah 1: Pilih atau Ambil Foto Dokumen</span>
                <div class="take-doc d-flex align-items-center align-self-stretch" style="gap: 30px;">

                    <label id="take-photo-label" for="take-photo" class="take-photo d-flex flex-column align-items-center justify-content-center" style="flex: 1 0 0; gap: 15px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19 5C20.3256 5.00159 21.5968 5.52848 22.5342 6.46582C23.4715 7.40316 23.9984 8.67441 24 10V19C23.9984 20.3256 23.4715 21.5968 22.5342 22.5342C21.5968 23.4715 20.3256 23.9984 19 24H5C3.67441 23.9984 2.40316 23.4715 1.46582 22.5342C0.528487 21.5968 0.00159336 20.3256 0 19V10C0.00158786 8.67441 0.528483 7.40316 1.46582 6.46582C2.40316 5.52848 3.67441 5.00159 5 5H19ZM14.2959 8.45703C13.1996 8.00293 11.993 7.88373 10.8291 8.11523C9.66535 8.34679 8.59685 8.91878 7.75781 9.75781C6.91878 10.5968 6.34679 11.6653 6.11523 12.8291C5.88373 13.993 6.00292 15.1996 6.45703 16.2959C6.91116 17.3923 7.6803 18.33 8.66699 18.9893C9.65358 19.6483 10.8135 20 12 20C13.5908 19.9984 15.1163 19.3661 16.2412 18.2412C17.3661 17.1163 17.9984 15.5908 18 14C18 12.8135 17.6483 11.6536 16.9893 10.667C16.33 9.6803 15.3923 8.91116 14.2959 8.45703ZM12 10C14.2091 10 16 11.7909 16 14C16 16.2091 14.2091 18 12 18C9.79093 17.9999 8 16.2091 8 14C8 11.7909 9.79093 10.0001 12 10ZM13.9316 0C14.3903 0.00166304 14.8432 0.107208 15.2549 0.30957C15.6664 0.511906 16.0262 0.805866 16.3076 1.16797L17.7207 3H6.2793L7.69141 1.16797C7.97288 0.805775 8.33346 0.511933 8.74512 0.30957C9.1566 0.10732 9.60889 0.00173379 10.0674 0H13.9316Z" fill="#0077C2"/>
                        </svg>
                        <span class="text-take">Ambil Foto</span>
                        <input type="file" id="take-photo" name="take-photo" accept="image/*" capture="environment" class="hidden-input">
                    </label>

                    <label for="select-file" class="take-photo d-flex flex-column align-items-center justify-content-center" style="flex: 1 0 0; gap: 15px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19.974 10V14C19.9718 14.7721 19.7899 15.5332 19.4428 16.2229C19.0956 16.9126 18.5928 17.5121 17.974 17.974V15C17.9716 13.1442 17.2334 11.3651 15.9211 10.0529C14.6089 8.74064 12.8298 8.00238 10.974 8H4.974C4.774 8 4.574 8.013 4.382 8.03C4.76791 7.13171 5.40842 6.36609 6.22445 5.82764C7.04048 5.28918 7.99633 5.00147 8.974 5H14.974C16.2996 5.00159 17.5704 5.52888 18.5078 6.46622C19.4451 7.40356 19.9724 8.67441 19.974 10ZM11.568 18.577C11.3823 18.763 11.1617 18.9105 10.9189 19.0111C10.6761 19.1118 10.4158 19.1636 10.153 19.1636C9.89017 19.1636 9.62992 19.1118 9.38712 19.0111C9.14432 18.9105 8.92375 18.763 8.738 18.577L8.262 18.097L2.353 23.225C3.14423 23.7286 4.06211 23.9973 5 24H11C12.3256 23.9984 13.5964 23.4711 14.5338 22.5338C15.4711 21.5964 15.9984 20.3256 16 19V15C15.9946 14.7316 15.9675 14.464 15.919 14.2L11.568 18.577ZM15.119 12.177L10.157 17.171L9.682 16.692C9.32817 16.335 8.85253 16.1249 8.35036 16.1038C7.84819 16.0827 7.35658 16.252 6.974 16.578L0.896 21.843C0.313016 21.0096 0.000232115 20.0171 0 19V15C0.00158786 13.6744 0.528882 12.4036 1.46622 11.4662C2.40356 10.5289 3.67441 10.0016 5 10H11C11.8115 10.001 12.6106 10.1996 13.3282 10.5786C14.0459 10.9575 14.6605 11.5054 15.119 12.175V12.177ZM4.974 14.1C4.974 13.9022 4.91535 13.7089 4.80547 13.5444C4.69559 13.38 4.53941 13.2518 4.35668 13.1761C4.17396 13.1004 3.97289 13.0806 3.77891 13.1192C3.58493 13.1578 3.40675 13.253 3.26689 13.3929C3.12704 13.5327 3.0318 13.7109 2.99321 13.9049C2.95463 14.0989 2.97443 14.3 3.05012 14.4827C3.12581 14.6654 3.25398 14.8216 3.41843 14.9315C3.58288 15.0414 3.77622 15.1 3.974 15.1C4.23922 15.1 4.49357 14.9946 4.68111 14.8071C4.86864 14.6196 4.974 14.3652 4.974 14.1ZM18.974 0H12.974C11.9983 0.00237827 11.0447 0.290514 10.2309 0.828817C9.41716 1.36712 8.77891 2.13201 8.395 3.029C8.586 3.014 8.779 3 8.974 3H14.974C16.8298 3.00238 18.6089 3.74064 19.9211 5.05288C21.2334 6.36512 21.9716 8.14422 21.974 10V12.974C22.5928 12.5121 23.0956 11.9126 23.4428 11.2229C23.7899 10.5332 23.9718 9.77215 23.974 9V5C23.9724 3.67441 23.4451 2.40356 22.5078 1.46622C21.5704 0.528882 20.2996 0.00158786 18.974 0V0Z" fill="#0077C2"/>
                        </svg>
                        <span class="text-take">Pilih dari Galeri</span>
                        <input type="file" id="select-file" name="select-file" accept="image/*" class="hidden-input">
                    </label>
                </div>

                <!-- PRATINJAU -->
                 <div class="pratinjau d-flex justify-content-center align-items-center align-self-stretch mt-3">
                    <span id="preview-placeholder" style="font-size: 14px; color: rgba(0, 0, 0, 0.5); font-weight: 600;">Pratinjau Foto Dokumen</span>
                    <img src="" alt="Pratinjau Foto Dokumen" id="pratinjau-foto" class="d-none">

                    <button type="button" id="cancel-preview-btn" class="d-none" aria-label="Batal Pratinjau">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </button>
                 </div>
            </div>

            <!-- Info Dokumen -->
             <div class="box-document d-flex flex-column align-items-start align-self-stretch">
                <span class="step">Langkah 2: Isi Informasi Dokumen</span>

                <div class="infodocument d-flex flex-column align-items-start align-self-stretch" style="gap: 15px;">
                    <div class="input-box d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                        <label for="jenis-dokumen" style="font-size: 14px; align-self: stretch;">Jenis Dokumen</label>
                        <select class="form-select" id="jenis-dokumen" name="jenis-dokumen" style="border-radius: 10px; font-size: 14px; padding: 10px ">
                            <option value="" selected disabled>Pilih Jenis Dokumen...</option>
                            <option value="surat_jalan">Surat Jalan Kapal</option>
                            <option value="dokumen_muat">Dokumen Muat</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="input-box d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                        <label for="keterangan" style="font-size: 14px; align-self: stretch;">Keterangan</label>
                        <textarea class="keterangan d-flex align-self-stretch form-control" name="keterangan" id="keterangan"
                        style="font-size: 14px; border-radius: 10px; padding: 10px; border: 1px solid rgba(0, 0, 0, 0.25);" rows="4" placeholder="Contoh: Surat Jalan Kapal ke Malinau"></textarea>
                    </div>
                </div>
             </div>

             <button type="submit" class="btn-kirim d-flex align-items-center align-self-stretch justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M13.8232 1.00293C13.999 1.36326 14.0442 1.7733 13.9502 2.16309L11.9805 11.5205C11.8253 12.6036 11.0689 13.5047 10.0293 13.8457C9.72772 13.9477 9.41116 14.0007 9.09277 14.001C8.32158 14.0004 7.58253 13.6917 7.03906 13.1445L6.03613 12.1436C5.92707 12.0338 5.77873 11.9722 5.62402 11.9727H3.77539C3.51591 11.9713 3.25966 11.9115 3.02637 11.7979L13.8232 1.00293ZM11.8535 0.0449219C12.2382 -0.0451968 12.6424 0.00149895 12.9971 0.175781L2.20117 10.9727C2.08747 10.7393 2.02771 10.4832 2.02637 10.2236V8.375C2.02648 8.22025 1.96486 8.07135 1.85547 7.96191L0.853516 6.95996C0.404301 6.51041 0.113953 5.92646 0.0273438 5.29688C-0.191768 3.702 0.923694 2.23089 2.51855 2.01172L11.8535 0.0449219Z" fill="white"/>
                </svg>
                Kirim Dokumen
             </button>
        </form>
    </div>

    <!-- Modal Webcam (Bootstrap) -->
    <div class="modal fade" id="webcam-modal" tabindex="-1" aria-labelledby="webcamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header" style="border-bottom: 0;">
                    <h5 class="modal-title" id="webcamModalLabel" style="font-weight: 600; color: var(--black-color);">Ambil Foto dengan Webcam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="relative">
                        <video id="webcam-video" class="w-100 h-auto rounded-lg bg-dark" autoplay playsinline></video>
                        <canvas id="webcam-canvas" class="d-none"></canvas>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center" style="border-top: 0; gap: 15px;">
                    <button id="cancel-webcam-button" type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 20px; font-weight: 500;">
                        Batal
                    </button>
                    <button id="snap-button" type="button" class="btn btn-primary" style="background-color: var(--blue-kss); border-color: var(--blue-kss); border-radius: 10px; padding: 10px 20px; font-weight: 600;">
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
