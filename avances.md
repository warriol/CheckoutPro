# Avances en el proceso de la certificación del Dev Program de Mercado Pago

https://www.mercadopago.com.uy/developers/es/docs/checkout-pro/create-application

## ✅ Requisitos Completados
- [x] Clonar el repositorio
- [x] Instalar dependencias con Composer
- [ ] Configurar credenciales en el archivo `.env`
- [ ] Crear preferencia de pago
- [ ] Implementar páginas de retorno (éxito, fallo, pendiente)
- [ ] Configurar webhook para notificaciones IPN
- [ ] Implementar logging de notificaciones
- [ ] Probar la integración en modo sandbox
- [ ] Documentar el proceso de instalación y configuración
- [ ] Subir el proyecto a un repositorio público en GitHub
- [ ] Enviar el proyecto para revisión en el Dev Program de Mercado Pago
- [ ] Recibir feedback y realizar ajustes necesarios
- [ ] Obtener la certificación oficial de Checkout Pro
- [ ] Publicar el proyecto en GitHub con documentación completa
- [ ] Compartir el proyecto en comunidades de desarrolladores
  
## Conceptos importantes
### Recuerda algunos conceptos que están presentes en este desafío:
- Cuenta de prueba: Funcionan como una simulación de cuentas reales de Mercado Pago, lo que te permite simular una transacción sin necesidad de realizar pagos reales.
- Credenciales: Contraseñas únicas para simular transacciones y verificar el correcto funcionamiento de las integraciones. Las credenciales de producción deben usarse con las cuentas de prueba para recibir pagos.
- Integrator ID: Código exclusivo para identificarte como integrador partner de Mercado Pago. Al agregarlo en tus integraciones, garantizas tu acceso a las ventajas del programa.
- Payment ID: Código de identificación para los pagos realizados en los checkouts de Mercado Pago.
- Access Token: Clave privada de la aplicación (tu integración) utilizada en el Back-end para generar pagos. Es esencial que esta información se mantenga segura en tus servidores.
- Public Key: Clave pública de la aplicación, generalmente utilizada en el Front-end. Permite acceder a información sobre los medios de pago y cifrar los datos de la tarjeta.

## Criterios de evaluación
- [ ] Integrator ID
- [ ] Producto
- [ ] Configuración de pago
- [ ] Páginas de retorno
- [ ] Webhook
- [ ] External Reference

## Crear aplicación
1. Ingresa a [Mercado Pago Developers](https://www.mercadopago.com.uy/developers) y crea una cuenta de desarrollador si no tienes una.
2. Crea las credenciales de prueba.

## Confirguar ambiente de dsarrollo

## Creación de cuenta de prueba
1. Dentro del panel de desarrollador, navega a la sección de "Cuentas de prueba" y crea una nueva cuenta de prueba.
2. Debe tener al menos una cuenta de vendedor y una de comprador.
3. La cuenta de vendedor es la que recibirá los pagos (esta es tu cuenta de usaurio real).
4. La cuenta de comprador es la que realizará los pagos.
5. Opcionalmente existe la cuenta integrador, que es una cuenta de vendedor con un Integrator ID asociado para el modelo marketplace. 
