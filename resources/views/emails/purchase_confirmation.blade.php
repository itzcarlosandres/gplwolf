<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 800;
        }
        .header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            font-size: 14px;
        }
        .icon-badge {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .order-summary {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .order-summary h3 {
            margin: 0 0 15px 0;
            color: #1f2937;
            font-size: 16px;
            font-weight: 700;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .item-name {
            color: #374151;
            font-weight: 600;
        }
        .item-price {
            color: #6b7280;
            font-weight: 700;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            margin-top: 15px;
            border-top: 2px solid #e5e7eb;
            font-weight: 800;
            font-size: 18px;
        }
        .total-label {
            color: #1f2937;
        }
        .total-amount {
            color: #667eea;
        }
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #FF2121;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .info-box p {
            margin: 0;
            color: #1e40af;
            font-size: 14px;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 700;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #9ca3af;
            font-size: 12px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="icon-badge">🎉</div>
            <h1>¡Compra Confirmada!</h1>
            <p>Orden #{{ $order->id }} • {{ $order->created_at->format('d \d\e F, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">¡Hola {{ $order->user->name ?? 'Cliente' }}!</div>
            
            <div class="message">
                <p>¡Gracias por tu compra! Tu pedido ha sido confirmado y está siendo procesado.</p>
                <p>Recibirás un email adicional cuando tus productos estén listos para descargar.</p>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3>📦 Resumen del Pedido</h3>
                
                @foreach($order->items as $item)
                <div class="order-item">
                    <span class="item-name">{{ $item->product_name ?? $item->product->name ?? 'Item' }}</span>
                    <span class="item-price">${{ number_format($item->price, 2) }}</span>
                </div>
                @endforeach
                
                @if($order->user->rank && $order->user->rank->discount_percentage > 0)
                <div class="order-item">
                    <span class="item-name">Descuento VIP ({{ $order->user->rank->name }})</span>
                    <span class="item-price" style="color: #10b981;">
                        -${{ number_format(($order->subtotal * $order->user->rank->discount_percentage / 100), 2) }}
                    </span>
                </div>
                @endif
                
                @if($order->coupon_discount > 0)
                <div class="order-item">
                    <span class="item-name">Descuento Cupón</span>
                    <span class="item-price" style="color: #10b981;">-${{ number_format($order->coupon_discount, 2) }}</span>
                </div>
                @endif
                
                @if($order->points_discount > 0)
                <div class="order-item">
                    <span class="item-name">Descuento Puntos</span>
                    <span class="item-price" style="color: #10b981;">-${{ number_format($order->points_discount, 2) }}</span>
                </div>
                @endif
                
                <div class="total-row">
                    <span class="total-label">Total Pagado</span>
                    <span class="total-amount">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Info Box -->
            @if($pointsEarned > 0)
            <div class="info-box">
                <p><strong>💎 ¡Ganaste {{ $pointsEarned }} puntos!</strong><br>
                Estos puntos se han añadido a tu cuenta y puedes usarlos en tu próxima compra.</p>
            </div>
            @endif

            <!-- CTA Button -->
            <center>
                <a href="{{ route('user.profile') }}" class="button">Ver Mis Descargas</a>
            </center>

            <!-- Additional Info -->
            <div class="message" style="margin-top: 30px;">
                <p style="font-size: 14px; color: #9ca3af;">
                    <strong>Información de Pago:</strong><br>
                    Método: {{ $order->payment_method ?? 'Tarjeta de Crédito' }}<br>
                    Fecha: {{ $order->created_at->format('d \d\e F, Y \a \l\a\s H:i') }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Tu tienda de confianza para WordPress</p>
            
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            <p style="margin-top: 15px;">
                <a href="{{ route('home') }}" style="color: #9ca3af; text-decoration: none;">Visitar Tienda</a> •
                <a href="{{ route('home') }}" style="color: #9ca3af; text-decoration: none;">Soporte</a>
            </p>
        </div>
    </div>
</body>
</html>