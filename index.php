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
    <meta name="description" content="Conección con Mercado Pago API REST usando SDK oficial PHP. Certificación Dev Program - Checkout Pro">
    <meta name="author" content="wilson arriola">
    <title>Checkout Pro - Mercado Pago</title>
    <link rel="stylesheet" href="./utiles/css/styles.css">
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
                            'currency_id' => 'UYP',
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
                // Obtener el identificador de la preferencia
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
                    locale: 'es-UY'
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
                    <div class="price">$ 100.00 <span style="font-size: 16px; color: #666;">UYP</span></div>
                    
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
