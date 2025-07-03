<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-1: #F4EEFF;
            --color-2: #DCD6F7;
            --color-3: #A6B1E1;
            --color-4: #424874;
        }
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, var(--color-1), var(--color-2), var(--color-3), var(--color-4));
            background-size: 200% 200%;
            animation: gradientBG 12s ease-in-out infinite;
            font-family: 'Poppins', Arial, sans-serif;
        }
        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        .login-box {
            width: 100%;
            max-width: 370px;
            margin: 6vh auto 0 auto;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 1.2rem;
        }
        .login-logo b {
            color: var(--color-4);
            font-size: 1.7rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .card {
            border-radius: 1.2rem;
            box-shadow: 0 8px 32px 0 rgba(66, 72, 116, 0.13);
            background: rgba(255,255,255,0.98);
            border: none;
        }
        .login-card-body {
            padding: 2.2rem 1.5rem 1.5rem 1.5rem;
        }
        .login-box-msg {
            color: var(--color-4);
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .input-group {
            position: relative;
        }
        .form-control {
            border-radius: 0.8rem;
            border: 1.5px solid var(--color-2);
            background: #fff;
            color: var(--color-4);
            font-size: 1rem;
            padding-left: 2.5rem;
            height: 2.7rem;
            box-shadow: none;
            transition: border 0.2s;
        }
        .form-control:focus {
            border-color: var(--color-3);
            background: var(--color-1);
            box-shadow: 0 0 0 2px var(--color-2, #DCD6F7);
        }
        .input-group-text {
            position: absolute;
            left: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            color: var(--color-3);
            border: none;
            font-size: 1.1rem;
            z-index: 2;
            pointer-events: none;
            width: 1.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .input-group .form-control {
            padding-left: 2.7rem;
        }
        .btn-primary {
            background: linear-gradient(90deg, var(--color-3), var(--color-4));
            border: none;
            border-radius: 1.2rem;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.7rem 0;
            transition: background 0.5s, color 0.5s;
            box-shadow: 0 2px 8px 0 rgba(66, 72, 116, 0.10);
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(90deg, var(--color-4), var(--color-3));
            color: #fff;
        }
        .icheck-primary label {
            font-weight: 600;
            color: var(--color-4);
            font-size: 0.98rem;
        }
        .icheck-primary input[type="checkbox"]:checked + label::before {
            background-color: var(--color-3) !important;
            border-color: var(--color-4) !important;
        }
        .alert-danger {
            border-radius: 0.75rem;
            background: #fff0f3;
            color: #b71c1c;
            border: 1px solid #f8bbd0;
        }
        a {
            color: var(--color-3);
            text-decoration: none;
            font-size: 0.98rem;
            transition: color 0.2s;
        }
        a:hover {
            color: var(--color-4);
            text-decoration: underline;
        }
        .row {
            align-items: center;
        }
        .col-8, .col-4 {
            padding: 0;
        }
        @media (max-width: 400px) {
            .login-box { max-width: 98vw; }
            .login-card-body { padding: 1.2rem 0.5rem; }
        }
    </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
    <div class="login-logo">
        <b>Yapay Zeka</b> Asistanı
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Oturum açmak için giriş yapın</p>

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    <input type="password" name="password" class="form-control" placeholder="Şifre" required>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">Beni Hatırla</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Giriş</button>
                    </div>
                </div>
            </form>

            <!-- Sosyal girişleri gizleyebiliriz -->
            <!--
            <div class="social-auth-links text-center mt-2 mb-3">
              <a href="#" class="btn btn-block btn-primary"><i class="fab fa-facebook mr-2"></i> Facebook ile Giriş</a>
              <a href="#" class="btn btn-block btn-danger"><i class="fab fa-google-plus mr-2"></i> Google ile Giriş</a>
            </div>
            -->

            <p class="mb-1"><a href="#">Şifremi unuttum</a></p>
            <p class="mb-0"><a href="#" class="text-center">Kayıt olmak istiyorum</a></p>
        </div>
    </div>
</div>

<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
