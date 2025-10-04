# CheckoutPro - Mercado Pago

Aplicación web en PHP 8 para integración con Mercado Pago mediante API REST usando el SDK oficial para la certificación Checkout Pro del Dev Program.

## 🚀 Características

- ✅ Integración completa con Mercado Pago Checkout Pro
- ✅ SDK oficial de Mercado Pago (dx-php v3.0+)
- ✅ PHP 8.0 compatible
- ✅ Creación de preferencias de pago
- ✅ Páginas de retorno (éxito, fallo, pendiente)
- ✅ Webhook para notificaciones IPN
- ✅ Interfaz de usuario moderna y responsive
- ✅ Logging de notificaciones

## 📋 Requisitos

- PHP 8.0 o superior
- Composer
- Cuenta de desarrollador en Mercado Pago
- Servidor web (Apache/Nginx) o PHP built-in server

## 🔧 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/warriol/CheckoutPro.git
cd CheckoutPro
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar credenciales

Copia el archivo de ejemplo y edita con tus credenciales:

```bash
cp config.example.php config.php
```

Edita `config.php` y agrega tu Access Token de Mercado Pago:

```php
return [
    'access_token' => 'TU_ACCESS_TOKEN_AQUI',
    'base_url' => 'http://localhost:8000',
    'notification_url' => 'http://localhost:8000/webhook.php',
];
```

### 4. Obtener credenciales de Mercado Pago

1. Accede al [Panel de Desarrolladores de Mercado Pago](https://www.mercadopago.com/developers/panel)
2. Crea una aplicación o usa una existente
3. Obtén tus credenciales de TEST desde "Credenciales"
4. Copia el **Access Token** de prueba

## 🏃 Ejecución

### Opción 1: PHP Built-in Server (Desarrollo)

```bash
php -S localhost:8000
```

Luego accede a: http://localhost:8000

### Opción 2: Apache/Nginx

Configura tu servidor web para servir la aplicación desde el directorio raíz del proyecto.

## 📁 Estructura del Proyecto

```
CheckoutPro/
├── index.php           # Página principal - Crear preferencias
├── success.php         # Página de pago exitoso
├── failure.php         # Página de pago fallido
├── pending.php         # Página de pago pendiente
├── webhook.php         # Manejador de notificaciones IPN
├── config.php          # Configuración (no incluido en git)
├── config.example.php  # Plantilla de configuración
├── composer.json       # Dependencias del proyecto
├── webhook.log         # Log de notificaciones (generado automáticamente)
├── .gitignore         # Archivos ignorados por git
└── README.md          # Este archivo
```

## 🔄 Flujo de la Aplicación

1. **Crear Preferencia**: El usuario accede a `index.php` y crea una preferencia de pago
2. **Checkout**: Se abre automáticamente el checkout de Mercado Pago
3. **Pago**: El usuario completa el pago en la plataforma de Mercado Pago
4. **Retorno**: El usuario es redirigido a:
   - `success.php` - Si el pago fue aprobado
   - `failure.php` - Si el pago fue rechazado
   - `pending.php` - Si el pago está pendiente
5. **Notificación**: Mercado Pago envía notificaciones a `webhook.php` sobre cambios en el estado del pago

## 🔔 Webhook (IPN)

El webhook recibe notificaciones de Mercado Pago sobre cambios en los pagos. Para testing local, puedes usar:

### Ngrok (Recomendado para desarrollo)

```bash
ngrok http 8000
```

Luego actualiza la URL del webhook en `config.php` con la URL de ngrok:

```php
'notification_url' => 'https://tu-subdominio.ngrok.io/webhook.php',
```

### Logs

Las notificaciones se registran automáticamente en `webhook.log` para debugging.

## 🧪 Testing

### Credenciales de TEST

Asegúrate de usar las credenciales de TEST para pruebas. Mercado Pago proporciona:

- Tarjetas de crédito de prueba
- Usuarios de prueba
- Environment de sandbox

### Tarjetas de Prueba

Consulta la [documentación oficial de Mercado Pago](https://www.mercadopago.com.ar/developers/es/docs/checkout-pro/additional-content/test-cards) para tarjetas de prueba.

## 📚 Documentación Adicional

- [Mercado Pago Developers](https://www.mercadopago.com/developers)
- [SDK PHP Oficial](https://github.com/mercadopago/sdk-php)
- [Documentación Checkout Pro](https://www.mercadopago.com.ar/developers/es/docs/checkout-pro/landing)
- [API Reference](https://www.mercadopago.com.ar/developers/es/reference)

## 🔒 Seguridad

- ⚠️ Nunca compartas tu Access Token de producción
- ⚠️ El archivo `config.php` está excluido del control de versiones
- ⚠️ Usa HTTPS en producción
- ⚠️ Valida siempre las notificaciones del webhook

## 🤝 Certificación Dev Program

Este proyecto está diseñado para cumplir con los requisitos de certificación del Dev Program de Mercado Pago para Checkout Pro:

- ✅ Implementación del SDK oficial
- ✅ Creación de preferencias de pago
- ✅ Manejo de URLs de retorno
- ✅ Procesamiento de notificaciones IPN
- ✅ Buenas prácticas de seguridad

## 📝 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## 👤 Autor

warriol

## 🐛 Reportar Issues

Si encuentras algún problema, por favor abre un issue en el repositorio de GitHub.
