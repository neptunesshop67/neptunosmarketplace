<?php
require_once '../config.php';

if (!isAdmin()) {
    header("Location: ../login.php");
    exit;
}

// Estadísticas rápidas
$stmt = $pdo->query("SELECT COUNT(*) FROM pedidos");
$total_pedidos = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT SUM(total) FROM pedidos WHERE estado != 'cancelado'");
$ingresos = $stmt->fetchColumn() ?: 0;

$stmt = $pdo->query("SELECT COUNT(*) FROM productos");
$total_productos = $stmt->fetchColumn();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - MercaShop</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #f4f7f6; color: #333; }
        .sidebar { width: 250px; background: #1a1a2e; color: white; position: fixed; top: 0; bottom: 0; padding: 2rem 1rem; }
        .sidebar h2 { color: #b400ff; margin-bottom: 2rem; text-align: center; }
        .sidebar a { display: block; color: #ccc; text-decoration: none; padding: 1rem; margin-bottom: 0.5rem; border-radius: 8px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #b400ff; color: white; }
        .main { margin-left: 250px; padding: 2rem; }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
        .card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card h3 { margin: 0 0 0.5rem; color: #666; font-size: 1rem; }
        .card p { margin: 0; font-size: 2rem; font-weight: bold; color: #1a1a2e; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>MercaShop Admin</h2>
    <a href="index.php" class="active">Dashboard</a>
    <a href="productos.php">📦 Productos (CRUD)</a>
    <a href="ordenes.php">🧾 Órdenes</a>
    <a href="../index.php">← Volver a la Tienda</a>
    <a href="../logout.php" style="color: #ff6b6b; margin-top: auto;">Cerrar sesión</a>
</div>

<div class="main">
    <h1>Dashboard</h1>
    <p>Bienvenido al panel de administración, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>.</p>
    
    <div class="card-grid">
        <div class="card">
            <h3>Ingresos Totales</h3>
            <p>$<?= number_format($ingresos, 2) ?></p>
        </div>
        <div class="card">
            <h3>Pedidos Registrados</h3>
            <p><?= $total_pedidos ?></p>
        </div>
        <div class="card">
            <h3>Productos en Catálogo</h3>
            <p><?= $total_productos ?></p>
        </div>
    </div>
</div>

</body>
</html>
