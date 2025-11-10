<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSS - Document Management System</title>
    <!-- Placeholder Icon -->
    <link rel="icon" href="{{ asset('assets/Logo-compressed 1.png')}}">

    <!-- CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- TAMBAHAN: Impor library Turbo.js -->
    <!-- Ini akan membuat navigasi terasa instan tanpa reload halaman penuh -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-esm.js"></script>

    <!-- CSS -->
    <style>
        :root{
            --blue-kss: #0077C2;
            --orange-kss: #F39C12;
            --black-color: #111111;
            --base-white: #F9F9F9;
            --redcolor: #D20000;
            --green-call: #25d366; /* Warna hijau dari btn-call */
        }

        /* Global CSS */
        body {
            font-family: 'Inter', sans-serif;
            /* height: 100vh; DIHAPUS agar body bisa memanjang */
            width: 100%;
            display: flex;
            align-items: start;
            background-color: var(--base-white);
            /* Mencegah overflow horizontal saat transisi */
            overflow-x: hidden;
        }

        /* --- TAMBAHAN: CSS Untuk Turbo Loader --- */
        #turbo-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.8); /* Latar belakang semi-transparan */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none; /* Sembunyi by default */
            transition: opacity 0.2s ease; /* Transisi halus */
        }

        #turbo-loader .spinner {
            border: 8px solid #f3f3f3; /* Abu-abu muda */
            border-top: 8px solid var(--blue-kss); /* Biru KSS */
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* --- AKHIR CSS Loader --- */

        .menu, .logout-button {
            padding: 10px 12px;
            gap: 20px;
            border-radius: 8px;
            text-decoration: none;
            /* Transisi untuk gap dan padding */
            transition: all 0.1s ease;
        }
        .menu .text-sidebar, .logout-button .logout {
            font-size: 14px;
            font-weight: 500;
            color: var(--black-color);
            text-decoration: none;
            /* Transisi untuk opacity dan visibilitas */
            transition: opacity 0.1s ease, visibility 0.1s ease;
            white-space: nowrap; /* Mencegah teks turun baris saat transisi */
        }
        .menu:hover {
            background: rgba(243, 157, 18, 0.132);
            outline: 1px solid #f39d123e;
            border-radius: 8px;
            text-decoration: none;
        }
        .logout-button:hover {
            outline: 1px solid #D20000;
            background: rgba(210, 0, 0, 0.05);
        }
        .logout-button:active {
            background: rgba(210, 0, 0, 0.2);
        }
        .logout-button .logout:active {
            color: #D20000;
            font-weight: 700;
        }
        .sidebar-menu a {
            align-self: stretch;
        }
        .menu svg path {
            fill: var(--black-color);
        }

        .menu.active {
            border-radius: 8px;
            background: rgba(243, 156, 18, 0.20);
        }
        .menu.active .text-sidebar {
            font-weight: 700;
        }

        .menu.active svg path {
            fill: var(--orange-kss);
        }

        .header {
            padding: 15px 20px;
            border-radius: 20px 20px 0 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.25);
        }
        .btn-close-sidebar {
            border-radius: 50px;
            padding: 8px 10px;
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.50);
            border: none;
            cursor: pointer; /* Menambahkan cursor pointer */
        }
        /* Transisi untuk tombol panah */
        .btn-close-sidebar svg {
            /* Mengganti 'ease' dengan cubic-bezier untuk efek 'bouncy' */
            /* transition: transform 0.3s ease; */
            /* Diubah ke ease-in-out-back 500ms */
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .notif {
            padding: 10px;
            border-radius: 60px;
            background: #FFF;
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.50);
            border: none;
        }

        /* --- CSS Style untuk Sidebar --- */
        .sidebar {
            padding: 20px;
            /* Transisi untuk lebar sidebar */
            /* Mengganti 'ease' dengan cubic-bezier untuk efek 'bouncy' */
            /* transition: width 0.3s ease; */
            /* Diubah ke ease-in-out-back 500ms */
            transition: width 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            /* Menentukan lebar awal sidebar dari kontennya */
            width: 250px; /* (210px menu + 20px padding kiri + 20px padding kanan) */

            /* --- TAMBAHAN UNTUK STICKY/SCROLL --- */
            height: 100vh;
            position: sticky;
            top: 0;
            flex-shrink: 0; /* Mencegah sidebar menyusut */
            /* --- AKHIR TAMBAHAN --- */
        }

        .sidebar-menu {
            transition: width 0.3s ease; /* Transisi untuk lebar menu */
        }

        .logo img {
            transition: all 0.3s ease; /* Transisi untuk logo */
        }

        /* --- MODIFIKASI: Style untuk .sidebar-collapsed --- */

        /* 1. Atur ulang lebar sidebar saat body memiliki class .sidebar-collapsed */
        body.sidebar-collapsed .sidebar {
            width: 86px; /* (46px lebar ikon logo + 20px padding kiri + 20px padding kanan) */
            align-items: center; /* Menengahkan item saat diciutkan */
        }

        /* 2. Sembunyikan teks KSS pada logo */
        body.sidebar-collapsed .logo img[alt='Kaltim Satria Samudera'] {
            display: none;
        }

        /* 3. Pusatkan logo */
        body.sidebar-collapsed .logo {
            justify-content: center;
            width: 100%; /* Memastikan logo terpusat di dalam sidebar 86px */
        }

        /* 4. Sembunyikan judul "MENU" */
        body.sidebar-collapsed .menu-text {
            display: none;
        }

        /* 5. Atur ulang lebar sidebar-menu */
        body.sidebar-collapsed .sidebar-menu {
            width: auto; /* Biarkan lebar mengikuti konten (ikon) */
            align-items: center; /* Menengahkan menu */
        }

        /* 6. Atur ulang menu item dan tombol logout */
        body.sidebar-collapsed .menu,
        body.sidebar-collapsed .logout-button {
            width: 46px; /* Samakan lebar dengan ikon logo */
            gap: 0;
            justify-content: center; /* Menengahkan ikon di dalam tombol */
            padding-left: 0;
            padding-right: 0;
        }

        /* 7. Sembunyikan semua teks di dalam menu dan tombol logout */
        body.sidebar-collapsed .text-sidebar,
        body.sidebar-collapsed .logout {
            display: none;
            opacity: 0;
            visibility: hidden;
        }

        /* 8. Putar tombol panah di header */
        body.sidebar-collapsed .btn-close-sidebar svg {
            transform: rotate(180deg);
        }

        /* Content Styling */
        .title-page{
            font-size: 20px;
            font-weight: 600;
            color: var(--black-color);
        }

        /* Dashboard */
        .card {
            display: flex;
            padding: 8px 15px;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            flex: 1 0 0;
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.25);
        }
        .card:hover {
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.25);
            transition: box-shadow 0.2s ease;
            cursor: pointer;
        }

        .card-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex: 1 0 0;
        }

        .card-info .number {
            font-size: 28px;
            font-weight: 500;
            color: var(--black-color);
        }

        .card-info .card-title {
            font-size: 12px;
            font-weight: 300;
            align-self: stretch;
            color: var(--black-color);
        }

        .card-icon {
            display: flex;
            width: 45px;
            height: 45px;
            padding: 10px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 50px;
            background: rgba(0, 0, 0, 0.10);
        }

        .dashboard-notif {
            border-radius: 15px;
            padding: 20px 25px;
            gap: 20px;
            border: 1px solid rgba(0, 0, 0, 0.25);
        }

        .notif-item {
            display: flex;
            padding: 15px 20px;
            justify-content: space-between;
            align-items: flex-start;
            align-self: stretch;
            border-radius: 10px;
            background: #FFF;
            border: 1px solid rgba(0, 0, 0, 0.25);
        }

        .notif-item:hover {
            box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.25);
            transition: box-shadow 0.2s ease;
            cursor: pointer;
            background-color: #FAFAFA;
        }

        .see-doc {
            font-size: 12px;
            font-weight: 400;
            padding: 6px 15px;
            gap: 7px;
            color: var(--blue-kss);
            text-decoration: none;
            border: none;
            border-radius: 10px;
            background-color: rgba(0, 120, 194, 0.20);
            transition: .2s ease-in-out;
        }

        .see-doc:hover {
            background-color: rgba(0, 120, 194, 0.30);
            outline: 1px solid rgba(0, 120, 194, 0.70);
        }
        .download {
            font-size: 12px;
            font-weight: 400;
            padding: 6px 15px;
            gap: 7px;
            color: var(--black-color);
            text-decoration: none;
            border: none;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.20);
            transition: .2s ease-in-out;
        }
        .download:hover {
            background-color: rgba(0, 0, 0, 0.30);
            outline: 1px solid rgba(0, 0, 0, 0.70);
        }


        /* Dokumen */
        .filter label {
            font-size: 12px;
            font-weight: 500;
            color: var(--black-color);
        }

        .filter input, .filter select {
            font-size: 12px;
            font-weight: 500;
            color: var(--black-color);
            display: flex;
            padding: 10px 15px;
            justify-content: space-between;
            align-items: center;
            align-self: stretch;
            border-radius: 10px;
            background: #FFF;
            border: 1px solid rgba(0, 0, 0, 0.25);
        }
        .filter select {
            padding-left: 8px;
        }

        .submit-filter {
            display: flex;
            width: 200px;
            padding: 10px 15px;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            background: #0077C2;
            box-shadow: 0 0 1px 0 #000;
            border: none;
            color: #FFF;
            font-size: 12px;
            font-weight: 600;
        }

        .document-table {
            border-radius: 10px;
            background-color: #FFF;
            border: 1px solid rgba(0, 0, 0, 0.25);
        }

        /* --- BLOK TABEL PERTAMA (DUPLIKAT) DIHAPUS --- */
        /* Styling tabel yang sebelumnya ada di sini (baris 430-457)
           sebagian besar tumpang tindih dan ditimpa oleh blok di baris 475.
           Saya telah menghapusnya dan menggabungkan aturan unik
           (.keterangan) ke dalam blok di bawah.
        */


        /* Pengguna */
        .btn-add {
            display: flex;
            align-items: center;
            background-color: var(--blue-kss);
            color: #FFF;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 18px;
            gap: 10px;
            border-radius: 10px;
            border: none;
        }
        .btn-add:hover {
            background-color: #0069AA;
            color: #FFF;
        }


        /* --- BLOK STYLING TABEL UTAMA (GABUNGAN) --- */
        .table tr th, .table tr td{
            display: flex;
            padding: 10px 15px;
            align-items: center;
            flex: 1 0 0;
            font-size: 12px;
            font-weight: 600;
            max-width: 250px;
            word-break: break-word; /* Tambahan */
        }
        .table tr th.number, .table tr td.number {
            max-width: 50px;
            min-width: 20px;
            flex: 0 0 50px; /* Tambahan */
        }

        /* Aturan ini dipindahkan dari blok duplikat pertama */
        .table tr th.keterangan, .table tr td.keterangan {
            min-width: 350px;
            max-width: 2000px;
        }

        /* --- TAMBAHAN STYLE UNTUK KOLOM STATUS & AKSI --- */
        .table tr th.status, .table tr td.status-cell {
            max-width: 150px;
            flex: 0 0 150px;
        }
        /* --- AKHIR TAMBAHAN STYLE --- */

        .table tr td {
            font-weight: 400;
        }
        .table tr td.aksi {
            gap: 5px;
            align-items: center;
        }
        .table tr td.aksi button {
            border: none;
            padding: 6px 10px;
            color: #FFF;
            font-size: 10px;
            text-align: center;
            border-radius: 6px;


            /* CATATAN: Jika Anda memerlukan tombol *tanpa* background di
               beberapa tabel (seperti di .document-table), Anda perlu
               membuat aturan CSS yang lebih spesifik.

               Misalnya, Anda bisa menambahkan:
               .document-table .table tr td.aksi button {
                   background: none;
                   padding: 0;
                   color: initial;
               }

               Untuk saat ini, saya mengasumsikan styling tombol ini
               (dengan background warna) adalah yang diinginkan.
            */
        }

            tr.body td {
        border-bottom: none;
        }

        tr.body {
            border-bottom: 1px solid #E0E0E0;
        }

        .btn-edit {
            padding: 4px 10px !important;
            background-color: rgb(0, 120, 194) !important;
        }
        .btn-call {
            padding: 4px 10px !important;
            background: rgb(37, 211, 101) !important;
        }

        /* --- STYLES BARU UNTUK TOGGLE SWITCH (LEBIH KECIL) --- */
        .status-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: space-between; /* Mendorong teks & toggle */
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px; /* Lebar toggle (lebih kecil) */
            height: 20px; /* Tinggi toggle (lebih kecil) */
            flex-shrink: 0; /* Mencegah toggle menciut */
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc; /* Warna nonaktif */
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px; /* Tinggi lingkaran (lebih kecil) */
            width: 14px; /* Lebar lingkaran (lebih kecil) */
            left: 3px; /* Jarak kiri */
            bottom: 3px; /* Jarak bawah */
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: var(--green-call); /* Warna aktif dari btn-call */
        }

        input:focus + .slider {
            box-shadow: 0 0 1px var(--green-call);
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(20px);
            -ms-transform: translateX(20px);
            transform: translateX(20px); /* Jarak pergeseran (40-14-3-3) */
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 20px; /* Disesuaikan dgn tinggi */
        }

        .slider.round:before {
            border-radius: 50%;
        }

    </style>
</head>
<body>
    <!-- TAMBAHAN: Elemen Loading Overlay -->
    <div id="turbo-loader">
        <div class="spinner"></div>
    </div>

    <!-- Sidebar -->
    @include('layouts.sidebar.sidebar')

    <!-- Main-Content -->
    <!-- PERUBAHAN: Menambahkan height: 100vh dan overflow-y: auto -->
    <div class="main-content d-flex flex-column align-items-start align-self-stretch bg-white" style="gap: 20px; flex: 1 0 0; box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.50); z-index: 1000; height: 100vh; overflow-y: auto;">
    <!-- Header -->
    @include('layouts.header.header')
        <!-- Content -->
        <!-- PERUBAHAN: Menambahkan padding-bottom agar ada ruang di akhir scroll -->
        <div class="content-page d-flex flex-column align-items-center justify-content-center align-self-stretch" style="padding:  0px 25px 25px 25px; gap: 10px;">
            @yield('content')
        </div>
    </div>

         <!-- JS Boostrap -->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
         xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
         crossorigin="anonymous"></script>

        <!-- MODIFIKASI: JavaScript untuk Toggle Sidebar DAN Toggle Status -->
         <script>
            // --- (BARU) Variabel untuk melacak waktu muat ---
            // (MODIFIKASI) Pindahkan ke 'window' agar persisten antar muatan Turbo
            // Inisialisasi hanya jika belum ada
            if (typeof window.loaderStartTime === 'undefined') {
                window.loaderStartTime = null;
            }
            const minDisplayTime = 500; // 0.5 detik

            // --- 1. Event Listener untuk Navigasi Turbo (Menampilkan Loader) ---
            document.addEventListener('turbo:click', function(event) {
                const clickedLink = event.target.closest('a');
                if (clickedLink && clickedLink.classList.contains('menu') && clickedLink.classList.contains('active')) {
                    return; // Jangan tampilkan loader jika menu sudah aktif
                }

                // (MODIFIKASI) Catat waktu mulai dan tampilkan loader
                // (MODIFIKASI) Gunakan window.loaderStartTime
                window.loaderStartTime = Date.now();
                const loader = document.getElementById('turbo-loader');
                if (loader) {
                    loader.style.display = 'flex';
                }
            });

            // --- 2. Event Listener untuk Tombol Sidebar (Event Delegation) ---
            document.addEventListener('click', function(event) {
                // Cek apakah yang diklik (atau parent-nya) adalah tombol sidebar
                const sidebarToggleBtn = event.target.closest('.btn-close-sidebar');

                if (sidebarToggleBtn) {
                    // Jika ya, jalankan logika toggle
                    const sidebarStateKey = 'sidebarCollapsedState';
                    document.body.classList.toggle('sidebar-collapsed');

                    // Simpan status baru ke localStorage
                    if (document.body.classList.contains('sidebar-collapsed')) {
                        localStorage.setItem(sidebarStateKey, 'true');
                    } else {
                        localStorage.setItem(sidebarStateKey, 'false');
                    }
                }
            });

            // --- 3. Event Listener setelah Halaman Selesai Dimuat Turbo ---
            document.addEventListener('turbo:load', function() {

                // (A) Sembunyikan Loader (MODIFIKASI)
                function hideTurboLoader() {
                    const loader = document.getElementById('turbo-loader');
                    if (loader) {
                        loader.style.display = 'none';
                    }
                    window.loaderStartTime = null; // Reset
                }

                // (MODIFIKASI) Periksa window.loaderStartTime
                if (window.loaderStartTime) {
                    // Jika load dipicu oleh 'turbo:click'
                    const loadTime = Date.now();
                    // (MODIFIKASI) Hitung dari window.loaderStartTime
                    const elapsedTime = loadTime - window.loaderStartTime;

                    if (elapsedTime < minDisplayTime) {
                        // Jika terlalu cepat, tunggu sisa waktunya
                        const remainingTime = minDisplayTime - elapsedTime;
                        setTimeout(hideTurboLoader, remainingTime);
                    } else {
                        // Jika sudah cukup lama, sembunyikan langsung
                        hideTurboLoader();
                    }
                } else {
                    // Jika ini adalah load halaman awal (bukan 'turbo:click')
                    hideTurboLoader();
                }

                // (B) Terapkan Status Sidebar dari localStorage
                const sidebarStateKey = 'sidebarCollapsedState';
                if (localStorage.getItem(sidebarStateKey) === 'true') {
                    document.body.classList.add('sidebar-collapsed');
                }

                // (C) Pasang listener untuk Toggle Status di dalam Tabel
                const toggles = document.querySelectorAll('.document-table .toggle-switch input[type="checkbox"], .table .toggle-switch input[type="checkbox"]'); // Ditambahkan .table
                toggles.forEach(toggle => {
                    toggle.addEventListener('change', function() {
                        const cell = this.closest('.status-cell');
                        if (cell) {
                            const statusTextElem = cell.querySelector('.status-text');
                            if (statusTextElem) {
                                statusTextElem.textContent = this.checked ? 'Aktif' : 'Nonaktif';
                            }
                        }
                    });
                });

            });
         </script>
</body>
</html>
