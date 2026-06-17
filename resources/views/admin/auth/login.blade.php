<!DOCTYPE html>
<html lang="id">
<head>

<script>
(function (m, a, z, e) {
  var s, t, u, v;
  try {
    t = m.sessionStorage.getItem('maze-us');
  } catch (err) {}

  if (!t) {
    t = new Date().getTime();
    try {
      m.sessionStorage.setItem('maze-us', t);
    } catch (err) {}
  }

  u = document.currentScript || (function () {
    var w = document.getElementsByTagName('script');
    return w[w.length - 1];
  })();
  v = u && u.nonce;

  s = a.createElement('script');
  s.src = z + '?apiKey=' + e;
  s.async = true;
  if (v) s.setAttribute('nonce', v);
  a.getElementsByTagName('head')[0].appendChild(s);
  m.mazeUniversalSnippetApiKey = e;
})(window, document, 'https://snippet.maze.co/maze-universal-loader.js', '261ff951-2586-41d6-b312-d053e23738d3');
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Surat Desa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a3c34 0%, #2d6a4f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 460px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #1a3c34, #2d6a4f);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header .icon-wrap {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #2d6a4f;
            box-shadow: 0 0 0 3px rgba(45,106,79,0.15);
        }

        .btn-admin {
            background: linear-gradient(135deg, #1a3c34, #2d6a4f);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            font-size: 1rem;
            transition: opacity 0.2s;
        }

        .btn-admin:hover {
            opacity: 0.9;
            color: white;
        }

        .login-footer {
            background: #f8f9fa;
            padding: 1rem 2rem;
            text-align: center;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- Header --}}
    <div class="login-header">
        <div class="icon-wrap">
            <i class="bi bi-shield-lock-fill fs-2"></i>
        </div>
        <h4 class="fw-bold mb-1">Panel Admin</h4>
        <p class="mb-0 opacity-75 small">Desa Simpang Sungai Duren</p>
    </div>

    {{-- Body --}}
    <div class="login-body">

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Alert error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error validasi --}}
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                    <i class="bi bi-envelope me-1"></i>Email Admin
                </label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="email@desassd.id"
                    autofocus
                    required
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">
                    <i class="bi bi-lock me-1"></i>Password
                </label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                    <button class="btn btn-outline-secondary" type="button"
                            onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            {{-- Remember --}}
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input"
                       id="remember" name="remember">
                <label class="form-check-label text-muted" for="remember">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn btn-admin">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Panel Admin
            </button>

        </form>
    </div>

    {{-- Footer --}}
    <div class="login-footer">
        <small class="text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                Kembali ke Halaman Utama
            </a>
        </small>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const input  = document.getElementById('password');
        const icon   = document.getElementById('eyeIcon');
        const isPass = input.type === 'password';
        input.type   = isPass ? 'text' : 'password';
        icon.className = isPass ? 'bi bi-eye-slash' : 'bi bi-eye';
    }
</script>

</body>
</html>