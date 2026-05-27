<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | R&C Consulting</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0A1F5C 0%, #1a3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-card h1 {
            font-size: 24px;
            color: #0A1F5C;
            margin-bottom: 8px;
            text-align: center;
        }
        .login-card p {
            color: #888;
            font-size: 14px;
            text-align: center;
            margin-bottom: 30px;
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-card .logo img {
            height: 50px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
            outline: none;
        }
        .form-group input:focus {
            border-color: #5044c2;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #5044c2;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: #3d32a3;
        }
        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
        .footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #aaa;
        }
        .footer-link a {
            color: #5044c2;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <img src="{{ asset('img/logo-ryc.png') }}" alt="R&C Consulting" onerror="this.style.display='none'">
        </div>
        <h1>Iniciar Sesión</h1>
        <p>Accede con tu cuenta local</p>

        @if($errors->any())
            <div class="error-message">
                {{ $errors->first('usuario') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pruebasesion.login') }}">
            @csrf
            <div class="form-group">                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" name="usuario" value="{{ old('usuario') }}" placeholder="admin" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>
            <button type="submit" class="btn-login">Ingresar</button>
        </form>

        <div class="footer-link">
            <a href="{{ url('/') }}">&larr; Volver al inicio</a>
        </div>
    </div>
</body>
</html>
