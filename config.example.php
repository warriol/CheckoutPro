<?php
/**
 * Configuración de Mercado Pago
 * 
 * Renombrar este archivo a config.php y completar con tus credenciales
 * Obtén tus credenciales en: https://www.mercadopago.com/developers/panel
 */

return [
    // Access Token de Mercado Pago (usar credenciales de TEST para pruebas)
    'access_token' => 'TU_ACCESS_TOKEN_AQUI',
    
    // URLs de retorno después del pago
    'base_url' => 'http://localhost:8000',
    
    // Configuración de notificaciones
    'notification_url' => 'http://localhost:8000/webhook.php',
];
