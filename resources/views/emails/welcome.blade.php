<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a R&C Consulting</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #5044c2 0%, #3d2db5 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header img {
            max-width: 180px;
            height: auto;
        }
        .email-body {
            padding: 40px 30px;
            color: #1a1a1a;
        }
        .email-body h1 {
            font-size: 24px;
            font-weight: 700;
            color: #5044c2;
            margin: 0 0 16px;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
            color: #3d3d3d;
            margin: 0 0 16px;
        }
        .btn-primary {
            display: inline-block;
            background: #FF044D;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            padding: 14px 36px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .btn-primary:hover {
            background: #c40032;
        }
        .divider {
            height: 1px;
            background: #e8e8e8;
            margin: 30px 0;
        }
        .email-footer {
            padding: 30px;
            text-align: center;
            background: #f7f7f7;
            color: #636363;
            font-size: 13px;
            line-height: 1.5;
        }
        .email-footer a {
            color: #5044c2;
            text-decoration: none;
        }
        .social-links {
            margin: 16px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 6px;
        }
        @media only screen and (max-width: 480px) {
            .email-header { padding: 30px 20px; }
            .email-body { padding: 30px 20px; }
            .email-body h1 { font-size: 20px; }
        }
    </style>
</head>
<body>
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#f4f4f9;padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;">

                    {{-- HEADER --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#5044c2 0%,#3d2db5 100%);padding:40px 30px;text-align:center;">
                            <img src="https://rc-consulting.org/img/logo-rc.png" alt="R&C Consulting" style="max-width:180px;height:auto;border:0;" onerror="this.style.display='none'">
                            <h1 style="color:#ffffff;font-size:28px;font-weight:700;margin:20px 0 0;font-family:'Poppins','Segoe UI',Arial,sans-serif;">
                                ¡Bienvenido!
                            </h1>
                        </td>
                    </tr>

                    {{-- BODY --}}
                    <tr>
                        <td style="padding:40px 30px;">
                            <h1 style="font-size:24px;font-weight:700;color:#5044c2;margin:0 0 16px;font-family:'Poppins','Segoe UI',Arial,sans-serif;">
                                Hola, {{ $name }}
                            </h1>
                            <p style="font-size:16px;line-height:1.6;color:#3d3d3d;margin:0 0 16px;font-family:'Poppins','Segoe UI',Arial,sans-serif;">
                                Te damos la bienvenida a <strong>R&C Consulting</strong>. Ya tienes acceso a nuestra plataforma de capacitación donde encontrarás cursos, diplomados y recursos diseñados para impulsar tu desarrollo profesional.
                            </p>
                            <p style="font-size:16px;line-height:1.6;color:#3d3d3d;margin:0 0 16px;font-family:'Poppins','Segoe UI',Arial,sans-serif;">
                                Explora nuestros programas, revisa tu progreso y accede al aula virtual desde cualquier dispositivo.
                            </p>
                            <div style="text-align:center;margin:24px 0;">
                                <a href="{{ url('/') }}" class="btn-primary" style="display:inline-block;background:#FF044D;color:#ffffff !important;text-decoration:none;font-size:16px;font-weight:600;font-family:'Poppins','Segoe UI',Arial,sans-serif;padding:14px 36px;border-radius:6px;">
                                    Ir al Aula Virtual
                                </a>
                            </div>
                            <div style="height:1px;background:#e8e8e8;margin:30px 0;"></div>
                            <p style="font-size:14px;line-height:1.5;color:#636363;margin:0;font-family:'Poppins','Segoe UI',Arial,sans-serif;">
                                Si tienes alguna pregunta, responde a este correo o contáctanos a través de nuestra página web.
                            </p>
                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td style="padding:30px;text-align:center;background:#f7f7f7;">
                            <p style="font-size:13px;color:#636363;margin:0 0 8px;font-family:'Poppins','Segoe UI',Arial,sans-serif;">
                                &copy; {{ date('Y') }} R&C Consulting. Todos los derechos reservados.
                            </p>
                            <p style="font-size:13px;color:#636363;margin:0;font-family:'Poppins','Segoe UI',Arial,sans-serif;">
                                <a href="{{ url('/') }}" style="color:#5044c2;text-decoration:none;">rc-consulting.org</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
