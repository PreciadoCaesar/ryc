<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Lead</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden;">
        <div style="background: #0A1F5C; padding: 20px; text-align: center;">
            <h1 style="color: #FFB800; margin: 0; font-size: 20px;">R&amp;C Consulting</h1>
            <p style="color: #fff; margin: 5px 0 0; font-size: 14px;">Nuevo Lead - Solicitud de Información</p>
        </div>
        <div style="padding: 25px;">
            <p style="font-size: 14px; color: #555;">Hola <strong>{{ $advisorName }}</strong>,</p>
            <p style="font-size: 14px; color: #555;">Alguien solicitó información sobre el curso:</p>

            <div style="background: #F0F4FF; border-radius: 8px; padding: 15px; margin: 15px 0;">
                <p><strong>Curso:</strong> {{ $lead->curso }}</p>
                <p><strong>Nombre:</strong> {{ $lead->nombre }}</p>
                <p><strong>Email:</strong> {{ $lead->correo ?? 'No registrado' }}</p>
                <p><strong>WhatsApp:</strong> {{ $lead->celular }}</p>
                <p><strong>Consulta:</strong> {{ $lead->consulta ?? 'Sin consulta' }}</p>
                <p><strong>Fecha:</strong> {{ $lead->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <a href="https://wa.me/51{{ $lead->celular }}" style="display: inline-block; background: #25D366; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 50px; font-weight: 600; font-size: 14px;">
                Contactar por WhatsApp
            </a>

            <p style="font-size: 12px; color: #999; margin-top: 20px;">
                Este correo fue enviado automáticamente desde el sistema de R&amp;C Consulting.
            </p>
        </div>
    </div>
</body>
</html>
