<?php
require_once 'config.php';
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el checkout (En un entorno real, procesaríamos el carrito desde JS o Sesión)
    $metodo_envio = $_POST['metodo_envio']; // 'normal' o 'express'
    $total = 1000.00; // Valor dummy para el ejemplo
    
    if ($metodo_envio === 'express') {
        $total += 15.00; // Costo extra por envío express
    }

    $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, total, metodo_envio, estado) VALUES (?, ?, ?, 'pendiente')");
    $stmt->execute([$_SESSION['user_id'], $total, $metodo_envio]);
    $pedido_id = $pdo->lastInsertId();

    $success = "¡Pedido #$pedido_id creado con éxito! Gracias por tu compra.";
}

require_once 'includes/header.php';
?>

<div class="section" style="max-width: 600px; margin: 2rem auto;">
    <h2 class="section-title">Finalizar <span class="accent">Compra</span></h2>
    
    <?php if(isset($success)): ?>
        <div style="background: #e4ffe8; color: var(--green); padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: bold; border: 1px solid var(--green);">
            <?= htmlspecialchars($success) ?>
        </div>
        <a href="index.php" class="btn-primary" style="text-decoration:none;">← Volver al inicio</a>
    <?php else: ?>
        <div style="background: var(--white); padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card);">
            <form method="POST" action="">
                
                <h3 style="margin-bottom: 1rem; color: var(--blue-deep);">Datos de Envío</h3>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label>Dirección completa</label>
                    <input type="text" name="direccion" required placeholder="Calle, Número, Ciudad">
                </div>

                <h3 style="margin: 2rem 0 1rem; color: var(--blue-deep);">Método de Envío</h3>
                
                <div style="display: flex; gap: 1rem; flex-direction: column;">
                    <label style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid var(--gray-200); border-radius: var(--radius-sm); cursor: pointer;">
                        <input type="radio" name="metodo_envio" value="normal" required checked>
                        <div>
                            <strong>Envío Estándar (Gratis)</strong><br>
                            <span style="font-size: 0.85rem; color: var(--gray-400);">Llega entre 3 a 5 días hábiles.</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid var(--gray-200); border-radius: var(--radius-sm); cursor: pointer;">
                        <input type="radio" name="metodo_envio" value="express" required>
                        <div>
                            <strong>Envío Express (+$15.00)</strong><br>
                            <span style="font-size: 0.85rem; color: var(--gray-400);">Llega mañana antes de las 12:00 PM.</span>
                        </div>
                    </label>
                </div>

                <h3 style="margin: 2rem 0 1rem; color: var(--blue-deep);">Pago</h3>
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label>Tarjeta de Crédito</label>
                    <input type="text" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1.2rem;">Confirmar Pedido</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
