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

    <!-- Impor library Turbo.js -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-esm.js"></script>

    <!-- CSS -->
    <style>
        :root{
            --blue-kss: #0077C2;
            --orange-kss: #F39C12;
            --black-color: #111111;
            --base-white: #F9F9F9;
            --redcolor: #D20000;
            --green-call: #25d366;
        }

        /* Global CSS */
        body {
            font-family: 'Inter', sans-serif;
            width: 100%;
            display: flex;
            align-items: start;
            background-color: var(--base-white);
            overflow-x: hidden;
        }

        /* --- CSS Untuk Turbo Loader --- */
        #turbo-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none; /* Sembunyi by default */
            transition: opacity 0.2s ease;
        }

        #turbo-loader .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid var(--blue-kss);
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
            /* HAPUS 'transition: all' agar tidak konflik dengan transisi 'width' di .sidebar */
            transition: background 0.1s ease, outline 0.1s ease;
        }
        .menu .text-sidebar, .logout-button .logout {
            font-size: 14px;
            font-weight: 500;
            color: var(--black-color);
            text-decoration: none;
            transition: opacity 0.1s ease, visibility 0.1s ease;
            white-space: nowrap;
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
            cursor: pointer;
        }
        .btn-close-sidebar svg {
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
            /* PERBAIKAN: Transisi 'width' adalah penyebab flicker saat navigasi */
            transition: width 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            width: 250px;
            z-index: 1;
            height: 100vh;
            position: sticky;
            top: 0;
            flex-shrink: 0;
        }

        .main-content {
            z-index: 1;
        }

        .sidebar-menu {
            /* Hapus transisi width dari sini untuk mencegah konflik */
        }

        .modal-backdrop.show {
            opacity: 0.5;
        }

        .logo img {
            transition: all 0.3s ease;
        }

        /* --- MODIFIKASI: Style untuk .sidebar-collapsed --- */

        body.sidebar-collapsed .sidebar {
            width: 86px;
            align-items: center;
        }

        body.sidebar-collapsed .logo img[alt='Kaltim Satria Samudera'] {
            display: none;
        }

        body.sidebar-collapsed .logo {
            justify-content: center;
            width: 100%;
        }

        body.sidebar-collapsed .menu-text {
            display: none;
        }

        body.sidebar-collapsed .sidebar-menu {
            width: auto;
            align-items: center;
        }

        body.sidebar-collapsed .menu,
        body.sidebar-collapsed .logout-button {
            width: 46px;
            gap: 0;
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        body.sidebar-collapsed .text-sidebar,
        body.sidebar-collapsed .logout {
            display: none;
            opacity: 0;
            visibility: hidden;
        }

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


        /* Styling Tabel Utama */
        .table tr th, .table tr td{
            display: flex;
            padding: 10px 15px;
            align-items: center;
            flex: 1 0 0;
            font-size: 12px;
            font-weight: 600;
            max-width: 250px;
            word-break: break-word;
        }
        .table tr th.number, .table tr td.number {
            max-width: 50px;
            min-width: 20px;
            flex: 0 0 50px;
        }

        .table tr th.keterangan, .table tr td.keterangan {
            min-width: 350px;
            max-width: 2000px;
        }

        .table tr th.status, .table tr td.status-cell {
            max-width: 150px;
            flex: 0 0 150px;
        }

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

    </style>
</head>
<body>
    <!-- Elemen Loading Overlay -->
    <div id="turbo-loader">
        <div class="spinner"></div>
    </div>

    <!-- Sidebar -->
    @include('layouts.sidebar.sidebar')

    <!-- Main-Content -->
    <div class="main-content d-flex flex-column align-items-start align-self-stretch bg-white" style="gap: 20px; flex: 1 0 0; box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.50); height: 100vh; overflow-y: auto;">
    <!-- Header -->
    @include('layouts.header.header')
        <!-- Content -->
        <div class="content-page d-flex flex-column align-items-center justify-content-center align-self-stretch" style="padding:  0px 25px 25px 25px; gap: 10px;">
            @yield('content')
        </div>
    </div>

    @stack('modal')


        <!-- JS Boostrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

        <!-- =================================================================== -->
        <!-- SCRIPT BARU UNTUK MENGATASI FLICKER SIDEBAR DENGAN TURBO -->
        <!-- =================================================================== -->
        <script>
            const sidebarStateKey = 'sidebarCollapsedState';

            // --- 1. LOGIKA AGAR TIDAK "BUKA-TUTUP" (PENTING) ---

            // (A) Saat Refresh Halaman (F5)
            // Jalankan segera (IIFE) agar class terpasang sebelum user melihat halaman
            (function() {
                const isCollapsed = localStorage.getItem(sidebarStateKey) === 'true';
                if (isCollapsed) {
                    document.body.classList.add('sidebar-collapsed');
                }
            })();

            // (B) Saat Pindah Menu (Turbo Navigation)
            // Event ini berjalan SEBELUM Turbo menukar body lama dengan body baru
            document.addEventListener('turbo:before-render', (event) => {
                const isCollapsed = localStorage.getItem(sidebarStateKey) === 'true';

                // Jika status tersimpan adalah collapsed,
                // paksa body BARU (event.detail.newBody) untuk punya class tersebut
                if (isCollapsed) {
                    event.detail.newBody.classList.add('sidebar-collapsed');
                }
            });


            // --- 2. LOGIKA LOADER & KLIK (Sama seperti sebelumnya) ---

            if (typeof window.loaderStartTime === 'undefined') {
                window.loaderStartTime = null;
            }
            const minDisplayTime = 500; // 0.5 detik

            // Event saat link diklik (Tampilkan Loader)
            document.addEventListener('turbo:click', function(event) {
                const clickedLink = event.target.closest('a');
                // Jangan tampilkan loader jika menu yang diklik sudah aktif
                if (clickedLink && clickedLink.classList.contains('menu') && clickedLink.classList.contains('active')) {
                    return;
                }

                window.loaderStartTime = Date.now();
                const loader = document.getElementById('turbo-loader');
                if (loader) {
                    loader.style.display = 'flex';
                }
            });

            // Event Listener Global untuk Tombol Toggle Sidebar
            document.addEventListener('click', function(event) {
                const sidebarToggleBtn = event.target.closest('.btn-close-sidebar');

                if (sidebarToggleBtn) {
                    // Toggle class di body
                    document.body.classList.toggle('sidebar-collapsed');

                    // Simpan status terbaru ke localStorage
                    if (document.body.classList.contains('sidebar-collapsed')) {
                        localStorage.setItem(sidebarStateKey, 'true');
                    } else {
                        localStorage.setItem(sidebarStateKey, 'false');
                    }
                }
            });

            // Event setelah Turbo selesai load (Sembunyikan Loader)
            document.addEventListener('turbo:load', function() {

                // (Kita tidak perlu lagi set class sidebar di sini,
                //  karena sudah ditangani oleh 'turbo:before-render' dan IIFE)

                // Logic Sembunyikan Loader
                function hideTurboLoader() {
                    const loader = document.getElementById('turbo-loader');
                    if (loader) {
                        loader.style.display = 'none';
                    }
                    window.loaderStartTime = null; // Reset timer
                }

                if (window.loaderStartTime) {
                    const loadTime = Date.now();
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
            });
        </script>
        <!-- =================================================================== -->
        <!-- AKHIR DARI SCRIPT BARU -->
        <!-- =================================================================== -->

        @stack('scripts')
</body>
</html>
