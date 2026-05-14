<?php
require_once '../config.php';

if (!isAdmin()) {
    header("Location: ../login.php");
    exit;
}

// Acción: Eliminar
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: productos.php");
    exit;
}

// Acción: Crear o Actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $emoji = $_POST['emoji'];
    $vendedor = $_POST['vendedor'];
    
    if (!empty($_POST['id'])) {
        // Actualizar
        $stmt = $pdo->prepare("UPDATE productos SET nombre=?, precio=?, stock=?, emoji=?, vendedor=? WHERE id=?");
        $stmt->execute([$nombre, $precio, $stock, $emoji, $vendedor, $_POST['id']]);
    } else {
        // Crear
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock, emoji, vendedor, precio_original) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $precio, $stock, $emoji, $vendedor, $precio * 1.2]); // 20% más como original
    }
    header("Location: productos.php");
    exit;
}

// Listar
$stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC");
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - MercaShop Admin</title>
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
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; color: white; font-size: 0.9rem;}
        .btn-blue { background: #007bff; }
        .btn-red { background: #dc3545; }
        .btn-green { background: #28a745; margin-bottom: 1rem; display: inline-block; }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .modal.open { display: flex; }
        .modal-content { background: white; padding: 2rem; border-radius: 8px; width: 400px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>MercaShop Admin</h2>
    <a href="index.php">Dashboard</a>
    <a href="productos.php" class="active">📦 Productos (CRUD)</a>
    <a href="ordenes.php">🧾 Órdenes</a>
    <a href="../index.php">← Volver a la Tienda</a>
</div>

<div class="main">
    <h1>Gestión de Productos</h1>
    <button class="btn btn-green" onclick="openModal()">+ Nuevo Producto</button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Emoji</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td style="font-size: 1.5rem;"><?= htmlspecialchars($p['emoji']) ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td>$<?= number_format($p['precio'], 2) ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <button class="btn btn-blue" onclick='editProduct(<?= json_encode($p) ?>)'>Editar</button>
                    <a href="?delete=<?= $p['id'] ?>" class="btn btn-red" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal" id="productModal">
    <div class="modal-content">
        <h2 id="modalTitle">Nuevo Producto</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" id="prodId">
            <div class="form-group">
                <label>Nombre del Producto</label>
                <input type="text" name="nombre" id="prodNombre" required>
            </div>
            <div class="form-group">
                <label>Emoji (Icono)</label>
                <input type="text" name="emoji" id="prodEmoji" required>
            </div>
            <div class="form-group">
                <label>Vendedor / Marca</label>
                <input type="text" name="vendedor" id="prodVendedor" required>
            </div>
            <div class="form-group">
                <label>Precio ($)</label>
                <input type="number" step="0.01" name="precio" id="prodPrecio" required>
            </div>
            <div class="form-group">
                <label>Stock Disponible</label>
                <input type="number" name="stock" id="prodStock" required>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn" style="background:#ccc; color:black; flex:1;" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-blue" style="flex:1;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalTitle').textContent = 'Nuevo Producto';
        document.getElementById('prodId').value = '';
        document.getElementById('prodNombre').value = '';
        document.getElementById('prodEmoji').value = '';
        document.getElementById('prodVendedor').value = '';
        document.getElementById('prodPrecio').value = '';
        document.getElementById('prodStock').value = '';
        document.getElementById('productModal').classList.add('open');
    }

    function editProduct(p) {
        document.getElementById('modalTitle').textContent = 'Editar Producto';
        document.getElementById('prodId').value = p.id;
        document.getElementById('prodNombre').value = p.nombre;
        document.getElementById('prodEmoji').value = p.emoji;
        document.getElementById('prodVendedor').value = p.vendedor;
        document.getElementById('prodPrecio').value = p.precio;
        document.getElementById('prodStock').value = p.stock;
        document.getElementById('productModal').classList.add('open');
    }

    function closeModal() {
        document.getElementById('productModal').classList.remove('open');
    }
</script>

</body>
</html>
