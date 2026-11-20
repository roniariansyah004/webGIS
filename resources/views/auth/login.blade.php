<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Administrator - TembakauGIS Pamekasan</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at 50% 20%, #0e3d26 0%, #072216 50%, #080f18 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow di belakang card */
        .ambient-glow {
            position: absolute;
            width: 580px;
            height: 580px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.28) 0%, rgba(0, 0, 0, 0) 70%);
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
        }

        /* Kotak Login dengan Latar Belakang Foto Petani Tembakau Ultra HD */
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            background-image: url('{{ asset('images/petani-tembakau.jpg') }}?v=hd');
            background-size: cover;
            background-position: center top;
            border-radius: 26px;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.25);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        /* Lapisan Overlay Jernih tanpa blur agar foto petani tetap tajam, jernih & berdefinisi tinggi */
        .login-card-overlay {
            background: linear-gradient(180deg, rgba(6, 22, 14, 0.58) 0%, rgba(10, 26, 18, 0.74) 42%, rgba(15, 23, 42, 0.90) 100%);
            padding: 2.5rem 2.25rem 2.25rem;
            width: 100%;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        /* Logo TembakauGIS: Diperbesar, Bersih Tanpa Kotak, dengan Pinggiran Putih Halus */
        .brand-logo-img {
            width: 150px;
            max-width: 100%;
            height: auto;
            object-fit: contain;
            margin: 0 auto 0.75rem;
            display: block;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            filter: drop-shadow(0 0 1.5px rgba(255, 255, 255, 0.95))
                    drop-shadow(0 0 3.5px rgba(255, 255, 255, 0.8))
                    drop-shadow(0 10px 22px rgba(0, 0, 0, 0.8));
            transition: transform 0.3s ease;
        }

        .brand-logo-img:hover {
            transform: scale(1.05);
        }

        .form-label {
            color: #f1f5f9;
            font-size: 0.88rem;
            margin-bottom: 0.4rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            font-size: 0.95rem;
            background-color: rgba(255, 255, 255, 0.94);
            color: #0f172a;
            font-weight: 500;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #34d399;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.28);
            color: #0f172a;
        }

        .input-group-text {
            background-color: rgba(255, 255, 255, 0.94);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            color: #059669;
            font-size: 1.05rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            padding: 0.85rem;
            border-radius: 12px;
            font-size: 1rem;
            letter-spacing: -0.01em;
            box-shadow: 0 10px 22px -4px rgba(16, 185, 129, 0.55);
            transition: all 0.25s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -4px rgba(16, 185, 129, 0.65);
        }

        .demo-credential-box {
            background-color: rgba(6, 78, 59, 0.55);
            border: 1.5px dashed rgba(52, 211, 153, 0.6);
            border-radius: 14px;
            padding: 0.85rem 1rem;
            font-size: 0.82rem;
            color: #a7f3d0;
            margin-top: 1.5rem;
            backdrop-filter: blur(8px);
        }

        .demo-credential-box strong {
            color: #ffffff;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #f1f5f9;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.5rem 1.15rem;
            border-radius: 50px;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.2s ease;
        }

        .back-link:hover {
            background: rgba(16, 185, 129, 0.4);
            color: #ffffff;
            border-color: rgba(16, 185, 129, 0.6);
            transform: translateX(-3px);
        }
    </style>
</head>
<body>

    <div class="ambient-glow"></div>

    <!-- Kotak Login Utama -->
    <div class="login-card">
        <div class="login-card-overlay">
            <div class="login-header">
                <!-- Logo TembakauGIS Diperbesar & Tanpa Kotak -->
                <img src="{{ asset('images/logo-tembakau.png') }}" alt="Logo TembakauGIS" class="brand-logo-img">
                <p class="text-white-50 small mb-0 fw-medium">Portal Autentikasi Administrator Sistem</p>
            </div>

            <!-- Flash Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 small mb-3 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show border-0 rounded-3 small mb-3 d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>{{ session('info') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 small mb-3" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-1"></i> Gagal Masuk:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                               placeholder="nama@domain.com" 
                               value="{{ old('email', 'admin@tembakau.com') }}" 
                               required 
                               autofocus>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror" 
                               placeholder="Masukkan password" 
                               value="admin123"
                               required>
                        <button class="btn btn-outline-secondary border-start-0 border" type="button" id="togglePassword" style="border-color: rgba(255, 255, 255, 0.25) !important; background-color: rgba(255, 255, 255, 0.94); color: #059669;">
                            <i class="bi bi-eye-fill" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked style="background-color: #10b981; border-color: #10b981;">
                        <label class="form-check-label small text-white-50 fw-medium" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <!-- Akun Demo -->
            <div class="demo-credential-box">
                <div class="fw-bold mb-1 d-flex align-items-center gap-1">
                    <i class="bi bi-info-circle-fill"></i> Akun Demo Administrator:
                </div>
                <div>Email: <strong>admin@tembakau.com</strong></div>
                <div>Password: <strong>admin123</strong></div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Beranda -->
    <div class="mt-4 text-center position-relative" style="z-index: 1;">
        <a href="{{ route('home') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Beranda Portal</span>
        </a>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Show / Hide Password Script -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        });
    </script>
</body>
</html>
