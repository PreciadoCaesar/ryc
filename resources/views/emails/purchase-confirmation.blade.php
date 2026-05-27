<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de compra - R&C Consulting</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
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
        .email-header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 500;
            margin: 20px 0 0;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            font-size: 20px;
            font-weight: 500;
            color: #1a1a1a;
            margin: 0 0 8px;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.38;
            color: #3d3d3d;
            margin: 0 0 16px;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .card-product {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(26, 26, 26, 0.08);
            border: 1px solid #e8e8e8;
        }
        .card-product h3 {
            font-size: 20px;
            font-weight: 500;
            color: #1a1a1a;
            margin: 0 0 16px;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e8e8e8;
            font-size: 16px;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .item-row:last-child {
            border-bottom: none;
        }
        .item-title {
            color: #1a1a1a;
            font-weight: 400;
        }
        .item-price {
            color: #FF044D;
            font-weight: 600;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0 0;
            margin-top: 8px;
            border-top: 2px solid #e8e8e8;
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .btn-primary {
            display: inline-block;
            background: #5044c2;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            padding: 12px 24px;
            border-radius: 4px;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .btn-primary:hover {
            background: #3d2db5;
        }
        .divider {
            height: 1px;
            background: #e8e8e8;
            margin: 30px 0;
        }
        .footer-dark {
            padding: 40px 30px;
            text-align: center;
            background: #1a1a1a;
        }
        .footer-dark p {
            font-size: 14px;
            color: #ffffff;
            margin: 0 0 8px;
            font-family: 'Poppins', 'Inter', 'Manrope', 'Roboto', Arial, sans-serif;
        }
        .footer-dark a {
            color: #d4cff0;
            text-decoration: none;
        }
        .footer-dark .footer-muted {
            font-size: 12px;
            color: #c2c2c2;
        }
        @media only screen and (max-width: 480px) {
            .email-header { padding: 30px 20px; }
            .email-body { padding: 30px 20px; }
            .footer-dark { padding: 30px 20px; }
            .card-product { padding: 16px; }
        }
    </style>
</head>
<body>
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#f7f7f7;padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;">

                    {{-- HEADER --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#5044c2 0%,#3d2db5 100%);padding:40px 30px;text-align:center;">
                            <img src="https://rc-consulting.org/img/logo-rc.png" alt="R&C Consulting" style="max-width:180px;height:auto;border:0;" onerror="this.style.display='none'">
                            <h1 style="color:#ffffff;font-size:24px;font-weight:500;margin:20px 0 0;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                ¡Gracias por tu compra!
                            </h1>
                        </td>
                    </tr>

                    {{-- BODY --}}
                    <tr>
                        <td style="padding:40px 30px;">
                            <h2 style="font-size:20px;font-weight:500;color:#1a1a1a;margin:0 0 8px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                Hola, {{ $contactName }}
                            </h2>
                            <p style="font-size:16px;line-height:1.38;color:#3d3d3d;margin:0 0 16px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                Te confirmamos que tu pago ha sido procesado exitosamente. Ya estás inscrito en los siguientes cursos:
                            </p>

                            {{-- ITEMS CARD --}}
                            <div class="card-product" style="background:#ffffff;border-radius:16px;padding:24px;margin-bottom:16px;box-shadow:0 2px 8px rgba(26,26,26,0.08);border:1px solid #e8e8e8;">
                                <h3 style="font-size:20px;font-weight:500;color:#1a1a1a;margin:0 0 16px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                    Resumen de compra
                                </h3>
                                @foreach($items as $item)
                                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #e8e8e8;font-size:16px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                        <span style="color:#1a1a1a;font-weight:400;">{{ $item['title'] }}</span>
                                        <span style="color:#FF044D;font-weight:600;">S/ {{ number_format($item['amount'], 0) }}</span>
                                    </div>
                                @endforeach
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0 0;margin-top:8px;border-top:2px solid #e8e8e8;font-size:18px;font-weight:700;color:#1a1a1a;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                    <span>Total pagado</span>
                                    <span style="color:#FF044D;">S/ {{ number_format($total, 0) }}</span>
                                </div>
                            </div>

                            <p style="font-size:16px;line-height:1.38;color:#3d3d3d;margin:0 0 16px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                Pronto recibirás las instrucciones de acceso al aula virtual. Si tienes alguna consulta, no dudes en responder a este correo.
                            </p>

                            <div style="text-align:center;margin:24px 0;">
                                <a href="{{ url('/') }}" class="btn-primary" style="display:inline-block;background:#5044c2;color:#ffffff !important;text-decoration:none;font-size:14px;font-weight:600;letter-spacing:0.7px;text-transform:uppercase;padding:12px 24px;border-radius:4px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                    Ir al inicio
                                </a>
                            </div>

                            <div style="height:1px;background:#e8e8e8;margin:30px 0;"></div>

                            <p style="font-size:14px;line-height:1.5;color:#636363;margin:0;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                Este correo fue enviado a <strong>{{ $contactEmail }}</strong> como confirmación de tu compra en R&C Consulting.
                            </p>
                        </td>
                    </tr>

                    {{-- FOOTER DARK --}}
                    <tr>
                        <td class="footer-dark" style="padding:40px 30px;text-align:center;background:#1a1a1a;">
                            <p style="font-size:14px;color:#ffffff;margin:0 0 8px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                &copy; {{ date('Y') }} R&C Consulting. Todos los derechos reservados.
                            </p>
                            <p style="font-size:14px;color:#ffffff;margin:0 0 8px;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                <a href="{{ url('/') }}" style="color:#d4cff0;text-decoration:none;">rc-consulting.org</a>
                            </p>
                            <p class="footer-muted" style="font-size:12px;color:#c2c2c2;margin:0;font-family:'Poppins','Inter','Manrope','Roboto',Arial,sans-serif;">
                                Especialistas en gestión pública y capacitación
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
