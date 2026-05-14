<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="section" style="max-width: 800px; margin: 4rem auto; background: var(--white); padding: 3rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card);">
    <h2 class="section-title" style="margin-bottom: 2rem;">Términos y <span class="accent">Condiciones</span></h2>
    
    <div style="margin-bottom: 2rem; color: var(--gray-700); line-height: 1.6;">
        <p>Bienvenido a MercaShop. Al acceder y utilizar nuestro sitio web, aceptas cumplir con los siguientes términos y condiciones. Si no estás de acuerdo con alguna parte de estos términos, no debes utilizar nuestra plataforma.</p>
        
        <h4 style="color: var(--blue-deep); margin-top: 1.5rem; margin-bottom: 0.5rem;">1. Uso del Servicio</h4>
        <p>Solo puedes utilizar MercaShop con fines lícitos. Está prohibido utilizar nuestro sitio para cualquier actividad ilegal, fraudulenta o que viole los derechos de terceros.</p>

        <h4 style="color: var(--blue-deep); margin-top: 1.5rem; margin-bottom: 0.5rem;">2. Cuentas de Usuario</h4>
        <p>Para realizar compras o utilizar el panel de vendedor, debes crear una cuenta. Eres responsable de mantener la confidencialidad de tus credenciales y de todas las actividades que ocurran bajo tu cuenta.</p>

        <h4 style="color: var(--blue-deep); margin-top: 1.5rem; margin-bottom: 0.5rem;">3. Precios y Pagos</h4>
        <p>Todos los precios mostrados están en la moneda local y pueden estar sujetos a impuestos según la legislación aplicable. Nos reservamos el derecho a modificar los precios en cualquier momento sin previo aviso.</p>

        <h4 style="color: var(--blue-deep); margin-top: 1.5rem; margin-bottom: 0.5rem;">4. Envíos</h4>
        <p>Los tiempos de entrega son estimaciones y pueden variar. Nos comprometemos a despachar los productos a tiempo según el método seleccionado (Estándar o Express) en el checkout.</p>

        <h4 style="color: var(--blue-deep); margin-top: 1.5rem; margin-bottom: 0.5rem;">5. Privacidad</h4>
        <p>La información personal que nos proporciones será utilizada únicamente para procesar tus pedidos y mejorar tu experiencia. No venderemos tu información a terceros.</p>

        <p style="margin-top: 2rem; font-size: 0.85rem; color: var(--gray-400);">Última actualización: <?= date('d M Y') ?></p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
