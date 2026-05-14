<?php
require_once '../config.php';

if (!isAdmin()) {
    header("Location: ../login.php");
    exit;
}

// Acción: Actualizar estado de orden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $stmt = $pdo->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
    $stmt->execute([$estado, $id]);
    header("Location: ordenes.php");
    exit;
}

// Listar
$stmt = $pdo->query("
    SELECT p.*, u.nombre as cliente, u.email 
    FROM pedidos p 
    JOIN usuarios u ON p.usuario_id = u.id 
    ORDER BY p.id DESC
");
$ordenes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes - MercaShop Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #f4f7f6; color: #333; }
        .sidebar { width: 250px; background: #1a1a2e; color: white; position: fixed; top: 0; bottom: 0; padding: 2rem 1rem; }
        .sidebar h2 { color: #b400ff; margin-bottom: 2rem; text-align: center; }
        .sidebar a { display: block; color: #ccc; text-decoration: none; padding: 1rem; margin-bottom: 0.5rem; border-radius: 8px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #b400ff; color: white; }
        .main { margin-left: 250px; padding: 2rem; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        .badge { padding: 0.3rem 0.6rem; border-radius: 99px; font-size: 0.8rem; font-weight: bold; color: white; }
        .badge.pendiente { background: #ffc107; color: black; }
        .badge.pagado { background: #17a2b8; }
        .badge.enviado { background: #007bff; }
        .badge.entregado { background: #28a745; }
        .badge.cancelado { background: #dc3545; }
        select { padding: 0.4rem; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 0.4rem 0.8rem; background: #1a1a2e; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>MercaShop Admin</h2>
    <a href="index.php">Dashboard</a>
    <a href="productos.php">📦 Productos (CRUD)</a>
    <a href="ordenes.php" class="active">🧾 Órdenes</a>
    <a href="../index.php">← Volver a la Tienda</a>
</div>

<div class="main">
    <h1>Gestión de Órdenes</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Método Envío</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ordenes as $o): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td>
                    <?= htmlspecialchars($o['cliente']) ?><br>
                    <small style="color: #666;"><?= htmlspecialchars($o['email']) ?></small>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($o['fecha_pedido'])) ?></td>
                <td><span style="text-transform: capitalize;"><?= htmlspecialchars($o['metodo_envio']) ?></span></td>
                <td>$<?= number_format($o['total'], 2) ?></td>
                <td><span class="badge <?= $o['estado'] ?>"><?= ucfirst($o['estado']) ?></span></td>
                <td>
                    <form method="POST" action="" style="display: flex; gap: 0.5rem;">
                        <input type="hidden" name="id" value="<?= $o['id'] ?>">
                        <select name="estado">
                            <option value="pendiente" <?= $o['estado']=='pendiente'?'selected':'' ?>>Pendiente</option>
                            <option value="pagado" <?= $o['estado']=='pagado'?'selected':'' ?>>Pagado</option>
                            <option value="enviado" <?= $o['estado']=='enviado'?'selected':'' ?>>Enviado</option>
                            <option value="entregado" <?= $o['estado']=='entregado'?'selected':'' ?>>Entregado</option>
                            <option value="cancelado" <?= $o['estado']=='cancelado'?'selected':'' ?>>Cancelado</option>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
