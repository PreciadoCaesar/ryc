# Avances - Integración Izipay

## Resumen
Integración de Izipay (Lyra Krypton SDK V4.0) como pasarela de pago embebida para el carrito de compras de R&C Consulting, reemplazando el flujo manual de WhatsApp.

## Implementado

### Configuración
- `config/izipay.php`: endpoint, username, password, public_key, sha256_key
- `.env`: credenciales sandbox de Izipay
- `bootstrap/app.php`: rutas de Krypton/IPN excluidas de CSRF

### Backend
- `app/Services/IzipayService.php`: generateFormToken() y verifyHash()
- `app/Http/Controllers/PaymentController.php`:
  - `index()`: genera formToken y renderiza vista de pago
  - `success()`: POST handler valida hash HMAC, orderStatus (PAID=éxito, UNPAID/ABANDONED/EXPIRED=rechazo), actualiza compras, envía email, redirige. GET handler valida transaction_id real.
  - `cancel()`: acepta GET+POST, distingue rechazo 3DS2 (POST con kr-answer) de cancelación manual
  - `ipn()`: webhook para notificaciones asíncronas
- `app/Http/Controllers/CheckoutController.php`: store() redirige a /checkout/pagar
- `app/Mail/PurchaseConfirmation.php`: mailable con datos de compra
- `app/Models/Purchase.php`: nuevos fillable (transaction_id, payment_method, payment_status, amount, izipay_order_id)

### Base de datos
- Migración: `add_payment_fields_to_purchases` (transaction_id, payment_method, payment_status, izipay_order_id)
- Migración: `make_purchases_user_id_nullable` (user_id nullable para checkout anónimo)

### Frontend
- `resources/views/cart/payment.blade.php`: formulario Krypton embebido con CSS personalizado de marca
- `resources/views/cart/confirmacion.blade.php`: pantalla de éxito con resumen de compra
- `resources/views/emails/purchase-confirmation.blade.php`: template de email con diseño DESIGN.md (Poppins, colores #5044c2/#FF044D/#1a1a1a, button-primary, card-product, footer-dark)

### Rutas
- `checkout.payment` (GET /checkout/pagar)
- `checkout.success` (GET+POST /checkout/exito)
- `checkout.cancel` (GET+POST /checkout/cancelado)
- `izipay.ipn` (POST /izipay/ipn)
- Fallback `/exito` → redirect a `checkout.success`

### Manejo de estados de pago
- **orderStatus = PAID**: marca como activo, envía email, redirect a éxito
- **orderStatus = UNPAID/ABANDONED/EXPIRED**: marca como rechazado, redirect a carrito con error
- **POST sin kr-answer**: redirect a carrito con error
- **GET sin transaction_id**: redirect a carrito con error (Krypton navegó sin crear transacción)
- **POST a cancel con kr-answer**: marca como rechazado (3DS2 falló)
- **GET a cancel**: marca como cancelado (usuario canceló)

### Tarjetas de prueba manejadas
| Tarjeta | Escenario | Comportamiento |
|---|---|---|
| Exitosa | Pago normal | ✅ orderStatus=PAID → activo + email |
| 0063 | Fallo auth 3DS2 | ❌ orderStatus=UNPAID → rechazado |
| 0039 | Challenge 3DS2 rechazado | ❌ POST a cancel → rechazado |
| 0054 | Timeout challenge 3DS2 | ❌ POST a cancel → rechazado |

## Pendiente
- Obtener contraseña SMTP correcta para noreply@rc-consulting.org (la actual es rechazada por Gmail)
- Probar envío de correo de confirmación con SMTP funcional
- Probar flujo completo con tarjeta exitosa (crear carrito → checkout → pago → email)
- Migrar a producción (cambiar credenciales sandbox → producción en .env)

## Notas
- SDK: https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js
- API: https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment
- 3DS2 configurado como opcional/soft → el orderStatus es el campo definitivo, no transactions[0].status
