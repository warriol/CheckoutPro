<?php
/**
 * Página de éxito después del pago
 */

$payment_id = $_GET['payment_id'] ?? null;
$status = $_GET['status'] ?? null;
$external_reference = $_GET['external_reference'] ?? null;
$merchant_order_id = $_GET['merchant_order_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso - Checkout Pro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .icon {
            width: 80px;
            height: 80px;
            background: #38ef7d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: scaleIn 0.5s ease-out;
        }
        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
        .icon svg {
            width: 50px;
            height: 50px;
            stroke: white;
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        h1 {
            color: #11998e;
            margin-bottom: 10px;
            font-size: 32px;
        }
        p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .details-row:last-child {
            border-bottom: none;
        }
        .details-label {
            color: #999;
            font-size: 14px;
        }
        .details-value {
            color: #333;
            font-weight: 600;
            font-size: 14px;
            word-break: break-all;
        }
        .btn {
            background: #11998e;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #0d7a6f;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(17,153,142,0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <h1>¡Pago Exitoso!</h1>
        <p>Tu pago ha sido procesado correctamente.</p>

        <?php if ($payment_id || $status || $external_reference || $merchant_order_id): ?>
        <div class="details">
            <?php if ($payment_id): ?>
            <div class="details-row">
                <span class="details-label">ID de Pago:</span>
                <span class="details-value"><?php echo htmlspecialchars($payment_id); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($status): ?>
            <div class="details-row">
                <span class="details-label">Estado:</span>
                <span class="details-value"><?php echo htmlspecialchars($status); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($external_reference): ?>
            <div class="details-row">
                <span class="details-label">Referencia:</span>
                <span class="details-value"><?php echo htmlspecialchars($external_reference); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($merchant_order_id): ?>
            <div class="details-row">
                <span class="details-label">Orden:</span>
                <span class="details-value"><?php echo htmlspecialchars($merchant_order_id); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <a href="index.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>
