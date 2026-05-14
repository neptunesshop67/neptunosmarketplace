<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="section" style="max-width: 800px; margin: 4rem auto; background: var(--white); padding: 3rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card);">
    <h2 class="section-title" style="margin-bottom: 2rem;">Centro de <span class="accent">Ayuda</span></h2>
    
    <div style="margin-bottom: 2rem;">
        <h3 style="color: var(--blue-deep); margin-bottom: 1rem;">¿Cómo realizar una compra?</h3>
        <p style="color: var(--gray-700); line-height: 1.6;">Para comprar en MercaShop, simplemente navega por nuestro catálogo, elige el producto que desees y haz clic en "Agregar al carrito". Una vez estés listo, dirígete al carrito en la esquina superior derecha y haz clic en "Ir a pagar". Tendrás que iniciar sesión o registrarte si no lo has hecho aún.</p>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3 style="color: var(--blue-deep); margin-bottom: 1rem;">Métodos de envío</h3>
        <p style="color: var(--gray-700); line-height: 1.6;">Ofrecemos dos modalidades de envío:</p>
        <ul style="color: var(--gray-700); line-height: 1.6; margin-left: 1.5rem; margin-top: 0.5rem;">
            <li><strong>Envío Estándar:</strong> Totalmente gratuito y llega a tu domicilio en un plazo de 3 a 5 días hábiles.</li>
            <li><strong>Envío Express:</strong> Tiene un costo adicional de $15.00, pero garantiza que tu paquete llegue al día siguiente hábil antes del mediodía.</li>
        </ul>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3 style="color: var(--blue-deep); margin-bottom: 1rem;">Políticas de Devolución</h3>
        <p style="color: var(--gray-700); line-height: 1.6;">Si no estás conforme con tu producto, tienes un plazo de 30 días calendario para solicitar la devolución de tu dinero. El producto debe estar en sus condiciones originales, sin uso, y con todas las etiquetas y empaques originales. Para iniciar una devolución, contacta a nuestro equipo mediante el botón de abajo.</p>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
        <p style="margin-bottom: 1rem; color: var(--gray-700); font-weight: 600;">¿Aún tienes dudas?</p>
        <button class="btn-primary" onclick="alert('Funcionalidad de chat en desarrollo.')">💬 Iniciar Chat en Vivo</button>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
