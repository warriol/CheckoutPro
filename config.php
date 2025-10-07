<?php
/**
 * Configuración de Mercado Pago
 * 
 * Renombrar este archivo a config.php y completar con tus credenciales
 * Obtén tus credenciales en: https://www.mercadopago.com/developers/panel
 */
require_once 'autoload.php';

use class\Config;

$config = new class\Config(__DIR__ . '/.env');

$AT = $config->getAccessToken();
$BU = $config->getBaseUrl();
$NU = $config->getNotificationUrl();

return [
    // Access Token de Mercado Pago (usar credenciales de TEST para pruebas)
    'access_token' => $AT,
    
    // URLs de retorno después del pago
    'base_url' => $BU,
    
    // Configuración de notificaciones
    'notification_url' => $NU
];
