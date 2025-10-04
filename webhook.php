<?php
/**
 * Webhook - IPN (Instant Payment Notification)
 * Recibe notificaciones de Mercado Pago sobre cambios en los pagos
 */

require_once 'vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;

// Cargar configuración
$config = require_once 'config.php';

// Configurar SDK de Mercado Pago
MercadoPagoConfig::setAccessToken($config['access_token']);

// Función para registrar logs
function logNotification($message, $data = null) {
    $logFile = __DIR__ . '/webhook.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    
    if ($data !== null) {
        $logMessage .= "\n" . json_encode($data, JSON_PRETTY_PRINT);
    }
    
    $logMessage .= "\n" . str_repeat('-', 80) . "\n";
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Obtener datos de la notificación
$input = file_get_contents('php://input');
$notification = json_decode($input, true);

// Registrar notificación recibida
logNotification('Notificación recibida', [
    'method' => $_SERVER['REQUEST_METHOD'],
    'headers' => getallheaders(),
    'query_params' => $_GET,
    'body' => $notification
]);

// Responder inmediatamente con 200 OK
http_response_code(200);
echo json_encode(['status' => 'received']);

// Procesar la notificación de forma asíncrona
try {
    // Verificar que sea una notificación de pago
    if (isset($_GET['topic']) && $_GET['topic'] === 'payment') {
        $paymentId = $_GET['id'] ?? null;
        
        if ($paymentId) {
            // Obtener información del pago
            $client = new PaymentClient();
            $payment = $client->get($paymentId);
            
            logNotification('Información del pago obtenida', [
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'status_detail' => $payment->status_detail,
                'external_reference' => $payment->external_reference,
                'transaction_amount' => $payment->transaction_amount,
                'date_created' => $payment->date_created,
                'date_approved' => $payment->date_approved,
            ]);
            
            // Aquí puedes agregar la lógica de negocio según el estado del pago
            switch ($payment->status) {
                case 'approved':
                    logNotification('Pago aprobado', ['payment_id' => $payment->id]);
                    // Lógica para pago aprobado (ej: marcar pedido como pagado)
                    break;
                    
                case 'pending':
                    logNotification('Pago pendiente', ['payment_id' => $payment->id]);
                    // Lógica para pago pendiente
                    break;
                    
                case 'rejected':
                    logNotification('Pago rechazado', ['payment_id' => $payment->id]);
                    // Lógica para pago rechazado
                    break;
                    
                case 'cancelled':
                    logNotification('Pago cancelado', ['payment_id' => $payment->id]);
                    // Lógica para pago cancelado
                    break;
                    
                case 'refunded':
                    logNotification('Pago reembolsado', ['payment_id' => $payment->id]);
                    // Lógica para pago reembolsado
                    break;
                    
                case 'charged_back':
                    logNotification('Pago con contracargo', ['payment_id' => $payment->id]);
                    // Lógica para contracargo
                    break;
                    
                default:
                    logNotification('Estado desconocido', [
                        'payment_id' => $payment->id,
                        'status' => $payment->status
                    ]);
            }
        }
    } elseif (isset($_GET['topic']) && $_GET['topic'] === 'merchant_order') {
        $merchantOrderId = $_GET['id'] ?? null;
        
        if ($merchantOrderId) {
            logNotification('Notificación de merchant_order', ['order_id' => $merchantOrderId]);
            // Aquí puedes procesar la orden del comerciante si es necesario
        }
    } else {
        logNotification('Tipo de notificación no manejada', $_GET);
    }
    
} catch (MPApiException $e) {
    logNotification('Error de API de Mercado Pago', [
        'message' => $e->getMessage(),
        'api_response' => $e->getApiResponse(),
    ]);
} catch (Exception $e) {
    logNotification('Error general', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);
}
