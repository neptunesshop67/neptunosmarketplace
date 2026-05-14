<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

require_once 'includes/header.php';
?>

<div class="section" style="max-width: 1000px; margin: 2rem auto;">
    <a href="index.php" style="color: var(--blue-accent); text-decoration: none; font-weight: 600; margin-bottom: 1rem; display: inline-block;">← Volver al catálogo</a>
    
    <div style="display: flex; gap: 3rem; background: var(--white); padding: 3rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card); flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; font-size: 10rem; border-radius: var(--radius-md);">
            <?= htmlspecialchars($producto['emoji']) ?>
        </div>
        
        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column;">
            <?php if($producto['badge']): ?>
                <span class="product-badge <?= strtolower($producto['badge']) === 'nuevo' ? 'new' : (strtolower($producto['badge']) === 'hot' ? 'hot' : '') ?>" style="position: static; display: inline-block; width: fit-content; margin-bottom: 1rem;">
                    <?= htmlspecialchars($producto['badge']) ?>
                </span>
            <?php endif; ?>
            
            <div style="font-size: 0.9rem; color: var(--gray-400); font-weight: 600; margin-bottom: 0.5rem;"><?= htmlspecialchars($producto['vendedor']) ?> | Categoría: <?= htmlspecialchars($producto['categoria_nombre']) ?></div>
            <h1 style="font-family: 'Syne', sans-serif; font-size: 2rem; color: var(--blue-deep); margin-bottom: 1rem; line-height: 1.2;">
                <?= htmlspecialchars($producto['nombre']) ?>
            </h1>
            
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <span style="color: var(--yellow-dark);">★★★★☆</span>
                <span style="color: var(--gray-400); font-size: 0.9rem;">(Valoraciones)</span>
            </div>

            <div style="margin-bottom: 2rem;">
                <div style="font-size: 1rem; color: var(--gray-400); text-decoration: line-through;">$<?= number_format($producto['precio_original'], 2) ?></div>
                <div style="display: flex; align-items: baseline; gap: 1rem;">
                    <div style="font-family: 'Syne', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--gray-900);">$<?= number_format($producto['precio'], 2) ?></div>
                    <div style="color: var(--green); font-weight: 700; font-size: 1.2rem;">-<?= $producto['descuento'] ?>% OFF</div>
                </div>
                <div style="color: var(--blue-accent); font-weight: 600; margin-top: 0.5rem;">o 12x $<?= number_format($producto['precio']/12, 2) ?> sin interés</div>
            </div>

            <div style="margin-bottom: 2rem; color: var(--gray-700); line-height: 1.6;">
                <?= nl2br(htmlspecialchars($producto['descripcion'] ?? 'Sin descripción detallada.')) ?>
            </div>

            <div style="margin-top: auto; display: flex; gap: 1rem;">
                <button class="btn-primary" style="flex: 1; padding: 1rem; font-size: 1.1rem;" onclick="addToCart(event, <?= $producto['id'] ?>)">
                    🛒 Agregar al carrito
                </button>
                <button class="btn-secondary" style="border-color: var(--gray-200); color: var(--gray-700);" onclick="toggleFav(event, <?= $producto['id'] ?>)">
                    🤍 Favorito
                </button>
            </div>
            
            <div style="margin-top: 1rem; color: var(--green); font-weight: 600; font-size: 0.9rem;">
                ✅ Envío gratis a todo el país. Llega entre 3 y 5 días.
            </div>
            <div style="margin-top: 0.5rem; color: var(--gray-400); font-weight: 500; font-size: 0.9rem;">
                Stock disponible: <?= $producto['stock'] ?> unidades
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
