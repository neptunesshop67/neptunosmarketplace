<?php
require_once 'config.php';

$cartEmpty = empty($_SESSION['cart']);
$message = '';
$success = '';
$items = [];
if (!$cartEmpty) {
    $productIds = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id IN ($placeholders)");
    $stmt->execute($productIds);
    $items = $stmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$cartEmpty) {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
    $direccion = trim($_POST['direccion'] ?? '');
    if ($direccion === '') {
        $message = 'Por favor proporciona una dirección de envío válida.';
    } else {
        $total = cartTotal($pdo);
        $stmt = $pdo->prepare('INSERT INTO ordenes (usuario_id, total, estado, direccion) VALUES (?, ?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $total, 'pendiente', $direccion]);
        $orderId = $pdo->lastInsertId();
        $itemStmt = $pdo->prepare('INSERT INTO orden_items (orden_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)');
        foreach ($items as $item) {
            $qty = intval($_SESSION['cart'][$item['id']] ?? 1);
            $itemStmt->execute([$orderId, $item['id'], $qty, $item['precio']]);
        }
        $_SESSION['cart'] = [];
        $success = "¡Pedido #{$orderId} creado con éxito!";
    }
}

$pageTitle = 'Checkout';
require_once 'includes/header.php';
?>

<div class="space-y-6">
  <section class="rounded-3xl bg-white p-6 shadow-sm">
    <h1 class="text-3xl font-bold text-slate-900">Checkout</h1>
    <?php if ($success): ?>
      <div class="mt-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-6 text-emerald-800"><?= htmlspecialchars($success) ?></div>
      <a href="index.php" class="mt-4 inline-flex rounded-3xl bg-cyan-600 px-6 py-3 text-white hover:bg-cyan-700">Volver a la tienda</a>
    <?php elseif ($cartEmpty): ?>
      <div class="mt-6 rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center text-slate-600">Tu carrito está vacío. <a href="index.php" class="text-cyan-600 hover:underline">Continúa comprando</a>.</div>
    <?php else: ?>
      <?php if ($message): ?>
        <div class="mb-4 rounded-3xl border border-amber-200 bg-amber-50 p-4 text-amber-800"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>
      <div class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
          <h2 class="text-xl font-semibold text-slate-900">Resumen de la orden</h2>
          <div class="mt-4 space-y-4">
            <?php foreach ($items as $item): ?>
              <div class="rounded-3xl bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                  <div>
                    <p class="font-semibold text-slate-900"><?= htmlspecialchars($item['nombre']) ?></p>
                    <p class="text-sm text-slate-500">Cantidad: <?= intval($_SESSION['cart'][$item['id']] ?? 1) ?></p>
                  </div>
                  <p class="font-semibold text-slate-900">$<?= number_format($item['precio'] * intval($_SESSION['cart'][$item['id']] ?? 1), 2) ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="mt-6 rounded-3xl bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total a pagar</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">$<?= number_format(cartTotal($pdo), 2) ?></p>
          </div>
        </div>
        <form method="POST" class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm space-y-6">
          <h2 class="text-3xl font-bold text-slate-900 text-center mb-8">Finalizar compra</h2>
          
          <div>
            <h3 class="text-slate-500 mb-3 text-sm">Datos del cliente</h3>
            <div class="space-y-4">
              <input type="text" name="nombre_completo" value="<?= htmlspecialchars($_SESSION['nombre'] ?? '') ?>" placeholder="Nombre completo" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder:text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400" required>
              <input type="date" name="fecha_nacimiento" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400" required>
              <input type="text" name="direccion" placeholder="Dirección" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder:text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400" required>
            </div>
          </div>

          <div>
            <h3 class="text-slate-500 mb-3 text-sm mt-6">Pago</h3>
            <div class="space-y-4">
              <input type="text" name="tarjeta" placeholder="Número de tarjeta" pattern="\d*" maxlength="16" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder:text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400" required>
              <div class="flex gap-4">
                <input type="month" name="vencimiento" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400" required>
                <input type="text" name="cvv" placeholder="CVV" pattern="\d*" maxlength="4" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder:text-slate-500 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400" required>
              </div>
            </div>
          </div>

          <button type="submit" class="w-full rounded-lg bg-slate-600 px-6 py-3.5 text-white font-medium hover:bg-slate-700 mt-8 transition-colors">Confirmar compra</button>
        </form>
      </div>
    <?php endif; ?>
  </section>
</div>

<?php require_once 'includes/footer.php'; ?>
