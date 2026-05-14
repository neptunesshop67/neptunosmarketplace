<?php
require_once 'config.php';

$action = $_POST['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'update_qty') {
        $productId = intval($_POST['product_id'] ?? 0);
        $quantity = max(0, intval($_POST['quantity'] ?? 1));
        if ($quantity === 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }
    if ($action === 'clear_cart') {
        $_SESSION['cart'] = [];
    }
    header('Location: cart.php');
    exit;
}

$pageTitle = 'Mi Carrito';
require_once 'includes/header.php';

$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $productIds = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id IN ($placeholders)");
    $stmt->execute($productIds);
    $cartItems = $stmt->fetchAll();
}
?>

<div class="space-y-6">
  <section class="rounded-3xl bg-white p-6 shadow-sm">
    <h1 class="text-3xl font-bold text-slate-900">Mi carrito</h1>
    <?php if (empty($cartItems)): ?>
      <div class="mt-6 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-slate-600">No hay productos en tu carrito todavía.</div>
    <?php else: ?>
      <div class="mt-6 space-y-4">
        <?php foreach ($cartItems as $item): ?>
          <?php $qty = intval($_SESSION['cart'][$item['id']] ?? 1); ?>
          <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
              <p class="text-lg font-semibold text-slate-900"><?= htmlspecialchars($item['nombre']) ?></p>
              <p class="text-sm text-slate-500">Vendedor: <?= htmlspecialchars($item['vendedor']) ?></p>
              <p class="mt-2 text-slate-700">$<?= number_format($item['precio'], 2) ?> x <?= $qty ?> = <strong>$<?= number_format($item['precio'] * $qty, 2) ?></strong></p>
            </div>
            <div class="grid gap-3 sm:w-64">
              <form method="POST" class="grid gap-3">
                <input type="hidden" name="action" value="update_qty">
                <input type="hidden" name="product_id" value="<?= intval($item['id']) ?>">
                <label class="text-sm font-medium text-slate-700">Cantidad</label>
                <input type="number" name="quantity" value="<?= $qty ?>" min="0" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900" />
                <button type="submit" class="rounded-3xl bg-cyan-600 px-4 py-3 text-white font-semibold hover:bg-cyan-700">Actualizar</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-slate-500">Total estimado</p>
          <p class="mt-2 text-3xl font-bold text-slate-900">$<?= number_format(cartTotal($pdo), 2) ?></p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
          <form method="POST">
            <input type="hidden" name="action" value="clear_cart">
            <button type="submit" class="rounded-3xl bg-slate-100 px-5 py-3 text-slate-700 hover:bg-slate-200">Vaciar carrito</button>
          </form>
          <a href="checkout.php" class="rounded-3xl bg-cyan-600 px-5 py-3 text-white hover:bg-cyan-700">Ir a Checkout</a>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>

<?php require_once 'includes/footer.php'; ?>
