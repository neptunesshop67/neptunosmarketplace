<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$usuario = $stmt->fetch();

// Obtener sus pedidos
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC");
$stmt->execute([$user_id]);
$pedidos = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<div class="section" style="max-width: 1000px; margin: 2rem auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="section-title">Mi <span class="accent">Perfil</span></h2>
        <a href="logout.php" class="btn-secondary" style="border-color: var(--red); color: var(--red); text-decoration: none; padding: 0.5rem 1rem;">Cerrar Sesión</a>
    </div>

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        
        <!-- Datos de usuario -->
        <div style="flex: 1; min-width: 300px; background: var(--white); padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card); align-self: flex-start;">
            <h3 style="margin-bottom: 1.5rem; color: var(--blue-deep);">Datos Personales</h3>
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.85rem; color: var(--gray-400); font-weight: 600;">Nombre completo</label>
                <div style="font-size: 1.1rem; font-weight: 600; color: var(--gray-900);"><?= htmlspecialchars($usuario['nombre']) ?></div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.85rem; color: var(--gray-400); font-weight: 600;">Correo electrónico</label>
                <div style="font-size: 1.1rem; color: var(--gray-700);"><?= htmlspecialchars($usuario['email']) ?></div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="font-size: 0.85rem; color: var(--gray-400); font-weight: 600;">Miembro desde</label>
                <div style="font-size: 1rem; color: var(--gray-700);"><?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></div>
            </div>
        </div>

        <!-- Historial de Pedidos -->
        <div style="flex: 2; min-width: 350px;">
            <h3 style="margin-bottom: 1.5rem; color: var(--blue-deep);">Historial de Pedidos</h3>
            
            <?php if (count($pedidos) === 0): ?>
                <div style="background: var(--white); padding: 3rem; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-card); color: var(--gray-400);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🛍️</div>
                    <p>Aún no has realizado ninguna compra.</p>
                    <a href="index.php" class="btn-primary" style="display: inline-block; margin-top: 1rem; text-decoration: none;">Ver Catálogo</a>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach($pedidos as $pedido): ?>
                        <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <div style="font-weight: 700; color: var(--blue-deep); margin-bottom: 0.3rem;">Pedido #<?= $pedido['id'] ?></div>
                                <div style="font-size: 0.85rem; color: var(--gray-400);"><?= date('d M Y, H:i', strtotime($pedido['fecha_pedido'])) ?></div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.2rem; color: var(--gray-900);">$<?= number_format($pedido['total'], 2) ?></div>
                                <div style="font-size: 0.8rem; text-transform: capitalize; color: var(--gray-700);">Envío: <?= $pedido['metodo_envio'] ?></div>
                            </div>
                            <div>
                                <span style="
                                    padding: 0.4rem 0.8rem; 
                                    border-radius: 99px; 
                                    font-size: 0.8rem; 
                                    font-weight: 700;
                                    <?= $pedido['estado'] === 'pendiente' ? 'background: #fff3cd; color: #856404;' : 
                                       ($pedido['estado'] === 'pagado' ? 'background: #d1ecf1; color: #0c5460;' : 
                                       ($pedido['estado'] === 'enviado' ? 'background: #cce5ff; color: #004085;' : 
                                       ($pedido['estado'] === 'entregado' ? 'background: #d4edda; color: #155724;' : 
                                       'background: #f8d7da; color: #721c24;'))) ?>
                                ">
                                    <?= ucfirst($pedido['estado']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
