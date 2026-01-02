<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Pakaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            height: 100vh;
        }

        .card-login {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            letter-spacing: 1px;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="card card-login p-4 bg-white" style="width: 400px;">
        <div class="card-body">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-primary">Toko Pakaian </h4>
                <p class="text-muted small">Silakan login untuk memulai shift</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger py-2 small rounded-3">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small text-muted fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control bg-light border-0" placeholder="nama@toko.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small text-muted fw-bold">Password</label>
                    <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-login shadow-sm">MASUK SISTEM</button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">© 2026 Sistem Pakaian</small>
            </div>
        </div>
    </div>

</body>

</html>