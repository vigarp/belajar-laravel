<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Web Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)),
                url('/images/unpam.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin: 0;
            padding: 1.5rem;
            font-family: var(--bs-font-sans-serif, system-ui, -apple-system, sans-serif);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
            border: none;
        }

        .login-header {
            background-color: #f59e0b;
            color: #1f2937;
            padding: 18px 24px;
            text-align: center;
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: 0.3px;
        }

        .login-body {
            padding: 28px 28px 24px;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.25);
        }

        .btn-login {
            background-color: #f59e0b;
            color: #1f2937;
            border: none;
            font-weight: 700;
            padding: 11px;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-login:hover {
            background-color: #d97706;
            color: #ffffff;
        }

        .watermark-footer {
            position: absolute;
            bottom: 16px;
            right: 24px;
            color: #ffffff;
            font-size: 1.4rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);
            pointer-events: none;
        }

        @media (max-width: 576px) {
            .watermark-footer {
                font-size: 1rem;
                bottom: 10px;
                right: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="login-header">
            Admin Login
        </div>
        <div class="login-body">
            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3 text-sm">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success py-2 px-3 mb-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email') }}" required autofocus placeholder="Masukkan email">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required
                        placeholder="Masukkan password">
                </div>

                <button type="submit" class="btn btn-login w-100">
                    Login
                </button>
            </form>

            <div class="text-center mt-4 text-muted" style="font-size: 0.85rem;">
                Demo Login : admin@example.com / password
            </div>
        </div>
    </div>

</body>

</html>

