<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSS - Document Management System</title>
    <!-- Placeholder Icon -->
    <link rel="icon" href="FOTO/Logo-compressed 1.png">

    <!-- CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

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
        .menu, .logout-button {
            padding: 10px 12px;
            gap: 20px;
            border-radius: 8px;
            text-decoration: none;
            /* Transisi untuk gap dan padding */
            transition: all 0.3s ease;
        }
        .menu .text-sidebar, .logout-button .logout {
            font-size: 14px;
            font-weight: 500;
            color: var(--black-color);
            text-decoration: none;
            /* Transisi untuk opacity dan visibilitas */
            transition: opacity 0.2s ease, visibility 0.2s ease;
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
        #active {
            border-radius: 8px;
            background: rgba(243, 156, 18, 0.20);
        }
        #active .text-sidebar {
            font-weight: 700;
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

        .table tr th, .table tr td{
            display: flex;
            padding: 10px 15px;
            align-items: center;
            flex: 1 0 0;
            font-size: 12px;
            font-weight: 600;
            max-width: 250px;
        }
        .table tr th.number, .table tr td.number {
            max-width: 40px;
        }
        .table tr th.keterangan, .table tr td.keterangan {
            min-width: 350px;
            max-width: 2000px;
        }
        .table tr td {
            font-weight: 400;
        }
        .table tr td.aksi {
            gap: 4px;
            align-items: end;
        }
        .table tr td.aksi button {
            border: none;
            background: none;
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

        .document-table {
            border-radius: 10px;
            background-color: #FFF;
            border: 1px solid rgba(0, 0, 0, 0.25);
        }

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
            gap: 4px;
            align-items: end;
        }
        .table tr td.aksi button {
            border: none;
            padding: 6px 10px;
            color: #FFF;
            font-size: 10px;
            text-align: center;
            border-radius: 6px;
        }
        .btn-edit {
            border: 1px solid var(--blue-kss) !important;
            background-color: rgba(0, 120, 194, 0.75) !important;
        }
        .btn-call {
            border: 1px solid #25d366 !important;
            background: rgba(37, 211, 101, 0.75) !important;
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
            // Menjalankan script setelah semua konten HTML dimuat
            document.addEventListener('DOMContentLoaded', function() {

                // 1. Temukan tombol penutup sidebar
                const sidebarToggleBtn = document.querySelector('.btn-close-sidebar');

                // 2. Pastikan tombolnya ada
                if (sidebarToggleBtn) {

                    // 3. Tambahkan event listener untuk 'click'
                    sidebarToggleBtn.addEventListener('click', function() {

                        // 4. Toggle class 'sidebar-collapsed' pada elemen <body>
                        // Ini akan memicu semua style CSS yang sudah kita definisikan
                        document.body.classList.toggle('sidebar-collapsed');
                    });
                }

                                // --- LOGIKA BARU UNTUK TOGGLE STATUS ---

                // 5. Temukan semua toggle switch di dalam tabel
                //    Dibuat lebih spesifik ke .document-table untuk menghindari konflik
                const toggles = document.querySelectorAll('.document-table .toggle-switch input[type="checkbox"]');

                // 6. Tambahkan event listener untuk setiap toggle
                toggles.forEach(toggle => {
                    toggle.addEventListener('change', function() {
                        // 'this' merujuk pada <input> yang diklik

                        // 7. Temukan elemen <td> (status-cell) terdekat
                        const cell = this.closest('.status-cell');
                        if (cell) {
                            // 8. Temukan elemen .status-text di dalam cell tersebut
                            const statusTextElem = cell.querySelector('.status-text');
                            if (statusTextElem) {
                                // 9. Ubah teks berdasarkan status checked
                                if (this.checked) {
                                    statusTextElem.textContent = 'Aktif';
                                } else {
                                    statusTextElem.textContent = 'Nonaktif';
                                }
                            }
                        }
                    });
                });

            });
          </script>
</body>
</html>

