<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSS - Document Management System</title>
    <link rel="icon" href="FOTO/Logo-compressed 1.png">

    <!-- CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

    <!-- CSS -->
    <style>
        :root{
            --blue-kss: #0077C2;
            --orange-kss: #F39C12;
            --black-color: #111111;
            --base-white: #F9F9F9;
            --redcolor: #D20000;
        }

        body {
            display: flex;
            font-family: 'Nunito Sans', sans-serif;
            width: 100%;
            height: 100dvh;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(117deg, #EDFCFF 0.55%, #83A6BD 99.45%);
        }

        .container-login {
            display: flex;
            width: 500px;
            padding: 40px 50px;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            border-radius: 50px;
            background: linear-gradient(180deg, #EFEFEF 0%, #FFF2BF 100%);
            box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.25);
        }

        .image-login {
           width: 159px;
            height: 60px;
            aspect-ratio: 159/40;
        }

        .box-login {
            gap: 0px;
            text-align: center;
            align-self: stretch;
            font-weight: 400;
            color: var(--black-color);
            font-size: 14px;
        }

        .login-input label {
            font-size: 14px;
            font-weight: 300;
            color: rgba(17, 17, 17, 0.75);
            padding-left: 25px;
        }

        .login-input input, .login-input select {
            display: flex;
            padding: 15px 25px;
            align-items: center;
            gap: 10px;
            align-self: stretch;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.90);
            font-weight: 400;
            font-size: 16px;
            color: #111111;
            border: none;
            box-shadow:  0 0 1px 0 rgba(0, 0, 0);
        }

        .btn-login {
            display: flex;
            padding: 20px 10px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            align-self: stretch;
            border-radius: 50px;
            background: #FFD117;
            font-size: 18px;
            font-weight: 600;
            border: none;
            margin-top: 20px;
        }

        .btn-login:hover {
            background:#ffcc00;
            outline: 2px solid var(--orange-kss);
        }


    </style>
</head>
<body>
    @yield('content')
</body>
</html>

