<!DOCTYPE html>
<html lang="id"> <!-- Ganti ke 'id' untuk Bahasa Indonesia -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSS - Document Management System</title>
    <!-- Menggunakan placeholder, ganti jika punya URL ikon -->
    <link rel="icon" href="https://placehold.co/32x32/0077C2/FFFFFF?text=KSS">

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
        }

        /* Global CSS */
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: start;
            background-color: var(--base-white);
            overflow-x: hidden;
            gap: 25px;
        }

        .navbar {
            padding: 15px 30px;
            box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.25);
        }

        /* (BARU) Style gap dipindah dari inline ke CSS */
        .navbar-left {
            gap: 25px;
        }

        .nama, .title {
            color: var(--black-color);
        }

        .content {
            padding: 0 60px;
            gap: 20px;
            width: 100%;
            padding-bottom: 60px; /* Jarak di bawah */
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 10px 15px; /* MODIFIKASI: Padding mobile dikurangi */
            }
            .navbar-left {
                gap: 15px; /* (BARU) Kurangi gap di navbar mobile */
            }
            .content {
                padding-left: 15px; /* MODIFIKASI: Padding mobile dikurangi */
                padding-right: 15px; /* MODIFIKASI: Padding mobile dikurangi */
            }
            .take-doc {
                flex-direction: column;
            }
            /* (BARU) Aturan tambahan untuk mobile */
            .box-document {
                padding: 20px 15px; /* Padding L/R dikurangi */
            }
            .take-photo {
                padding: 25px; /* Padding dikurangi agar tidak terlalu tinggi */
            }
            .pratinjau {
                padding: 15px; /* Padding dikurangi */
            }
            .content-title {
                font-size: 18px; /* Kecilkan title */
            }
        }

        .box-document {
            padding: 20px 30px;
            border-radius: 30px;
            background-color: #FFFFFF;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
            gap: 20px;
        }
        .step {
            color: var(--black-color);
            align-self: stretch;
            font-size: 14px;
            font-weight: 600;
        }
        .take-photo {
            border-radius: 15px;
            border: 1px dashed rgba(0, 0, 0, 0.25);
            background: rgba(0, 119, 194, 0.05);
            padding: 40px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .take-photo:hover {
            background: rgba(0, 119, 194, 0.1);
            border-color: var(--blue-kss);
            transform: translateY(-2px);
        }
        .take-photo:active {
            background: rgba(0, 119, 194, 0.2);
            border-color: var(--blue-kss);
            transform: translateY(0);
        }
        .text-take {
            font-size: 14px;
            font-weight: 500;
            color: var(--black-color);
        }

        .pratinjau {
            min-height: 180px;
            padding: 20px;
            border-radius: 15px;
            border: 1px dashed rgba(0, 0, 0, 0.25);
            background: rgba(243, 156, 18, 0.05);
            position: relative;
        }

        /* Style untuk pratinjau gambar */
        #pratinjau-foto {
            max-width: 100%;
            max-height: 600px;
            width: auto;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Style untuk tombol Batal Pratinjau */
        #cancel-preview-btn {
            position: absolute;
            top: 15px;  /* MODIFIKASI: dari 30px, agar lebih dekat ke sudut */
            right: 15px; /* MODIFIKASI: dari 30px, agar lebih dekat ke sudut */
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            line-height: 1;
            padding: 0;
            transition: all 0.2s ease;
        }
        #cancel-preview-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }
        #cancel-preview-btn.d-none {
            display: none;
        }


        .btn-kirim {
            background-color: var(--orange-kss);
            color: #F9F9F9;
            border-radius: 20px;
            padding: 20px 20px;
            gap: 10px;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-kirim:hover {
            background-color: #d6890b;
            transform: translateY(-2px);
        }

        /* Sembunyikan input file asli */
        .hidden-input {
            display: none;
        }
    </style>
</head>
<body>
    <!-- MODIFIKASI: style="gap: 25px;" dihapus dari HTML -->
    @yield('content')
    <!-- CDN Bootstrap JS (Dibutuhkan untuk modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

    <!-- Script Fungsionalitas Utama -->
    <script>
        // Mendapatkan elemen-elemen yang diperlukan
        const takePhotoInput = document.getElementById('take-photo');
        const selectGalleryInput = document.getElementById('select-file');

        const pratinjauFoto = document.getElementById('pratinjau-foto');
        const previewPlaceholder = document.getElementById('preview-placeholder');
        const cancelPreviewBtn = document.getElementById('cancel-preview-btn');

        // Elemen-elemen baru untuk webcam
        const takePhotoLabel = document.getElementById('take-photo-label');
        const webcamModalElement = document.getElementById('webcam-modal');
        const webcamModal = new bootstrap.Modal(webcamModalElement);
        const webcamVideo = document.getElementById('webcam-video');
        const webcamCanvas = document.getElementById('webcam-canvas');
        const snapButton = document.getElementById('snap-button');

        let stream;

        /**
         * Membatalkan pratinjau, mengembalikan ke placeholder
         * dan mereset input file.
         */
        function cancelPreview() {
            pratinjauFoto.src = '';
            pratinjauFoto.classList.add('d-none');
            cancelPreviewBtn.classList.add('d-none');
            previewPlaceholder.classList.remove('d-none');
            takePhotoInput.value = null;
            selectGalleryInput.value = null;
        }

        /**
         * Menangani pemilihan file (dari kamera atau galeri)
         * dan menampilkan pratinjaunya.
         */
        function handleFileSelect(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    pratinjauFoto.src = e.target.result;
                    pratinjauFoto.classList.remove('d-none');
                    previewPlaceholder.classList.add('d-none');
                    cancelPreviewBtn.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                cancelPreview();
            }
        }

        takePhotoInput.addEventListener('change', handleFileSelect);
        selectGalleryInput.addEventListener('change', handleFileSelect);
        cancelPreviewBtn.addEventListener('click', cancelPreview);


        // --- LOGIKA WEBCAM ---

        async function startWebcam() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                });

                webcamModal.show();
                webcamVideo.srcObject = stream;
            } catch (err) {
                console.error("Error mengakses webcam:", err);
                takePhotoInput.click();
            }
        }

        function stopWebcam() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            if (webcamModal._isShown) {
                 webcamModal.hide();
            }
            webcamVideo.srcObject = null;
        }

        function takeSnapshot() {
            const width = webcamVideo.videoWidth;
            const height = webcamVideo.videoHeight;
            webcamCanvas.width = width;
            webcamCanvas.height = height;

            const context = webcamCanvas.getContext('2d');
            context.drawImage(webcamVideo, 0, 0, width, height);

            const dataUrl = webcamCanvas.toDataURL('image/png');

            pratinjauFoto.src = dataUrl;
            pratinjauFoto.classList.remove('d-none');
            previewPlaceholder.classList.add('d-none');
            cancelPreviewBtn.classList.remove('d-none');

            stopWebcam();
        }

        snapButton.addEventListener('click', takeSnapshot);

        webcamModalElement.addEventListener('hidden.bs.modal', function () {
            if (stream) {
                 stopWebcam();
            }
        });

        const isMobile = /Mobi|Android/i.test(navigator.userAgent);

        if (!isMobile && navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {

            takePhotoLabel.addEventListener('click', function(event) {
                event.preventDefault();
                startWebcam();
            });
        }
    </script>

</body>
</html>

