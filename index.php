<?php
/**
 * Checkout Pro - Mercado Pago
 * Página principal para crear preferencias de pago
 */

require_once 'vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

// Cargar configuración
$config = require_once 'config.php';

// Configurar SDK de Mercado Pago
MercadoPagoConfig::setAccessToken($config['access_token']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pro - Mercado Pago</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .product {
            border: 2px solid #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fafafa;
        }
        .product h2 {
            color: #333;
            font-size: 22px;
            margin-bottom: 10px;
        }
        .product p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .price {
            color: #009ee3;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .quantity label {
            color: #666;
            font-weight: 500;
        }
        .quantity input {
            width: 60px;
            padding: 8px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .btn {
            background: #009ee3;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #007bb5;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,158,227,0.4);
        }
        .btn:active {
            transform: translateY(0);
        }
        .error {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        .mp-logo {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mp-logo">
            <svg width="120" height="40" viewBox="0 0 120 40" fill="none">
                <rect width="120" height="40" rx="8" fill="#009ee3"/>
                <text x="60" y="25" font-family="Arial, sans-serif" font-size="16" font-weight="bold" fill="white" text-anchor="middle">Mercado Pago</text>
            </svg>
        </div>
        
        <h1>Checkout Pro</h1>
        <p class="subtitle">Certificación Dev Program - Mercado Pago</p>

        <?php
        $error = null;
        $preference_id = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
                $quantity = max(1, min(10, $quantity)); // Entre 1 y 10

                // Crear cliente de preferencias
                $client = new PreferenceClient();

                // Crear preferencia de pago
                $preference = $client->create([
                    'items' => [
                        [
                            'title' => 'Producto Demo',
                            'description' => 'Producto de prueba para certificación Checkout Pro',
                            'quantity' => $quantity,
                            'unit_price' => 100.00,
                            'currency_id' => 'ARS',
                        ]
                    ],
                    'back_urls' => [
                        'success' => $config['base_url'] . '/success.php',
                        'failure' => $config['base_url'] . '/failure.php',
                        'pending' => $config['base_url'] . '/pending.php',
                    ],
                    'auto_return' => 'approved',
                    'notification_url' => $config['notification_url'],
                    'statement_descriptor' => 'CHECKOUTPRO',
                    'external_reference' => 'REF-' . time(),
                ]);

                $preference_id = $preference->id;

            } catch (MPApiException $e) {
                $error = "Error de API: " . $e->getMessage();
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
        ?>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($preference_id): ?>
            <div class="product">
                <h2>✓ Preferencia Creada</h2>
                <p>Tu preferencia de pago ha sido creada exitosamente.</p>
                <p style="word-break: break-all; font-size: 12px; color: #999;">
                    <strong>ID:</strong> <?php echo htmlspecialchars($preference_id); ?>
                </p>
            </div>
            
            <script src="https://sdk.mercadopago.com/js/v2"></script>
            <script>
                const mp = new MercadoPago('<?php echo $config['access_token']; ?>', {
                    locale: 'es-AR'
                });
                
                mp.checkout({
                    preference: {
                        id: '<?php echo $preference_id; ?>'
                    },
                    autoOpen: true
                });
            </script>
            
            <button class="btn" onclick="location.reload()">Crear Nueva Preferencia</button>
        <?php else: ?>
            <form method="POST">
                <div class="product">
                    <h2>Producto Demo</h2>
                    <p>Producto de prueba para certificación Checkout Pro de Mercado Pago</p>
                    <div class="price">$ 100.00 <span style="font-size: 16px; color: #666;">ARS</span></div>
                    
                    <div class="quantity">
                        <label for="quantity">Cantidad:</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="10" value="1">
                    </div>
                </div>

                <button type="submit" class="btn">Crear Preferencia de Pago</button>
            </form>
        <?php endif; ?>

        <div class="footer">
            <p>Checkout Pro - Certificación Dev Program</p>
            <p>Mercado Pago API REST con SDK oficial PHP</p>
        </div>
    </div>
</body>
</html>
