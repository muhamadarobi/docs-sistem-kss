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

<div class="header d-flex justify-content-between align-items-center align-self-stretch">
    <div class="left-header d-flex align-items-center" style="gap: 22px;">
        <!-- Ini adalah tombol trigger kita -->
        <button class="btn-close-sidebar d-flex align-items-center bg-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="4" height="8" viewBox="0 0 4 8" fill="none">
                <path d="M1.53942 4.1888C1.51662 4.16403 1.49853 4.1346 1.48619 4.1022C1.47385 4.06981 1.4675 4.03508 1.4675 4C1.4675 3.96492 1.47385 3.93019 1.48619 3.8978C1.49853 3.8654 1.51662 3.83597 1.53942 3.8112L3.78476 1.36591C3.92253 1.21591 3.99995 1.01243 4 0.800243C4.00005 0.588055 3.92271 0.384538 3.785 0.234464C3.64729 0.084389 3.46049 5.00327e-05 3.2657 2.22536e-08C3.07091 -4.99882e-05 2.88407 0.0841932 2.7463 0.234197L0.50096 2.68002C0.180153 3.03044 0 3.50512 0 4C0 4.49488 0.180153 4.96956 0.50096 5.31998L2.7463 7.7658C2.88407 7.91581 3.07091 8.00005 3.2657 8C3.46049 7.99995 3.64729 7.91561 3.785 7.76554C3.92271 7.61546 4.00005 7.41195 4 7.19976C3.99995 6.98757 3.92253 6.78409 3.78476 6.63409L1.53942 4.1888Z" fill="#374957"/>
            </svg>
        </button>
        <div class="akun-title d-flex flex-column align-items-start" style="gap: 2px;">

            <!-- MODIFIKASI DI SINI -->
            <!-- Menampilkan sapaan dan nama user -->
            <span class="nama" style="font-weight: 600; color: #111;">{{ $greeting }}, {{ $userName }}</span>

            <!-- MODIFIKASI DI SINI -->
            <!-- Menampilkan peran user -->
            <span class="title" style="font-size: 10px; font-weight: 300; color: #111;">{{ $userRole }}</span>

        </div>
    </div>
    <div class="right-header d-flex justify-content-end align-items-center" style="gap: 30px;">
        <button class="notif d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14" fill="none">
            <path d="M12.883 7.70411L11.8357 4.03124C11.4979 2.84777 10.7646 1.80845 9.7523 1.0784C8.74005 0.348359 7.50691 -0.0305326 6.24879 0.00192446C4.99068 0.0343815 3.77976 0.476326 2.80842 1.25754C1.83708 2.03876 1.16103 3.11444 0.887693 4.31368L0.0782783 7.86692C-0.0285038 8.33604 -0.026007 8.82258 0.0855844 9.29063C0.197176 9.75869 0.415013 10.1963 0.72302 10.5712C1.03103 10.9461 1.42134 11.2486 1.86515 11.4566C2.30897 11.6645 2.79495 11.7725 3.28724 11.7726H3.52636C3.7166 12.4148 4.11545 12.9793 4.66284 13.3811C5.21024 13.7828 5.87653 14 6.56137 14C7.2462 14 7.91249 13.7828 8.45989 13.3811C9.00728 12.9793 9.40613 12.4148 9.59637 11.7726H9.71174C10.2186 11.7727 10.7187 11.6583 11.1728 11.4385C11.6269 11.2187 12.0228 10.8994 12.3296 10.5054C12.6363 10.1115 12.8456 9.6537 12.9411 9.16775C13.0366 8.6818 13.0157 8.18087 12.8801 7.70411H12.883ZM10.9049 9.44543C10.7662 9.62529 10.5863 9.77107 10.3797 9.87115C10.1731 9.97124 9.94539 10.0229 9.71473 10.022H3.28724C3.06349 10.0219 2.84261 9.97284 2.64089 9.87833C2.43917 9.78382 2.26176 9.6463 2.12176 9.47592C1.98176 9.30553 1.88274 9.10664 1.83201 8.89391C1.78127 8.68118 1.78011 8.46004 1.82862 8.24682L2.63804 4.68715C2.8239 3.86789 3.28518 3.13286 3.94843 2.59908C4.61168 2.0653 5.4388 1.76344 6.2981 1.74157C7.15741 1.71969 7.99951 1.97905 8.69037 2.47836C9.38122 2.97766 9.88112 3.68822 10.1105 4.49691L11.1554 8.16979C11.2185 8.38676 11.2286 8.61511 11.1852 8.83661C11.1417 9.0581 11.0457 9.2666 10.9049 9.44543V9.44543Z" fill="#111111"/>
        </svg>
        </button>
        <span class="line" style="background-color: rgba(0, 0, 0, 0.25); width: 1px; height: 40px;"></span>
        <!-- Menggunakan placeholder untuk User -->
        <img src="{{ asset('assets/User 02a.png') }}" alt="User" style="width: 30px; height: 30px; border-radius: 25%;">
    </div>
</div>
