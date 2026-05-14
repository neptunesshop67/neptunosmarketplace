<?php
require_once 'config.php';

$productId = intval($_GET['id'] ?? 0);
if ($productId <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.id = ? LIMIT 1');
$stmt->execute([$productId]);
$product = $stmt->fetch();
if (!$product) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_to_cart') {
    $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
    header('Location: product.php?id=' . $productId . '&added=1');
    exit;
}
$added = isset($_GET['added']);

$pageTitle = 'Detalle del Producto';
require_once 'includes/header.php';
?>

<div class="bg-white p-4 sm:p-6 mb-6 border border-slate-200">
  <!-- Breadcrumb -->
  <div class="text-sm text-slate-500 mb-4">
    <a href="index.php" class="hover:underline">Inicio</a> &rsaquo; 
    <a href="categoria.php?slug=<?= htmlspecialchars($product['categoria_slug']) ?>" class="hover:underline"><?= htmlspecialchars($product['categoria_nombre']) ?></a> &rsaquo; 
    <span class="text-slate-700 font-semibold"><?= htmlspecialchars($product['nombre']) ?></span>
  </div>

  <div class="flex flex-col lg:flex-row gap-8">
    <!-- Left: Product Image -->
    <div class="lg:w-1/3 flex-shrink-0">
      <div class="aspect-square bg-slate-50 border border-slate-100 flex items-center justify-center text-8xl relative overflow-hidden">
        📦
        <?php if ($product['badge']): ?>
          <span class="absolute top-4 left-4 bg-[#00a650] text-white text-xs font-bold px-2 py-1 uppercase tracking-widest rounded-sm">Oferta</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Center: Product Info -->
    <div class="lg:w-1/3 flex-1 flex flex-col">
      <h1 class="text-2xl sm:text-3xl font-medium text-slate-900 leading-tight mb-2"><?= htmlspecialchars($product['nombre']) ?></h1>
      <a href="#" class="text-sm text-[#3483fa] hover:text-[#2968c8] hover:underline mb-2 block">Visita la tienda de <?= htmlspecialchars($product['vendedor']) ?></a>
      
      <!-- Amazon Stars -->
      <div class="flex items-center gap-4 mb-4 pb-4 border-b border-slate-200">
        <div class="flex items-center">
          <div class="flex text-[#ffa41c] text-lg">★★★★<span class="text-slate-300">★</span></div>
          <a href="#" class="text-sm text-[#3483fa] ml-2 hover:underline"><?= rand(10, 500) ?> calificaciones</a>
        </div>
      </div>

      <!-- Description -->
      <div class="mt-2">
        <h3 class="font-bold text-slate-900 mb-2">Acerca de este artículo</h3>
        <p class="text-slate-700 leading-relaxed text-sm"><?= nl2br(htmlspecialchars($product['descripcion'] ?: 'No hay descripción detallada disponible.')) ?></p>
      </div>
    </div>

    <!-- Right: Buy Box -->
    <div class="lg:w-[320px] flex-shrink-0">
      <div class="border border-slate-200 rounded-md p-5 bg-white">
        <div class="mb-4">
          <div class="flex items-baseline gap-2">
            <span class="text-3xl font-light text-slate-900">$<?= number_format($product['precio'], 0, ',', '.') ?></span>
            <?php if ($product['precio_original'] && $product['precio_original'] > $product['precio']): ?>
              <?php $discount = round((($product['precio_original'] - $product['precio']) / $product['precio_original']) * 100); ?>
              <span class="text-sm text-[#00a650] font-semibold">-<?= $discount ?>%</span>
            <?php endif; ?>
          </div>
          <?php if ($product['precio_original'] && $product['precio_original'] > $product['precio']): ?>
            <p class="text-sm text-slate-500">Precio de lista: <span class="line-through">$<?= number_format($product['precio_original'], 0, ',', '.') ?></span></p>
          <?php endif; ?>
        </div>

        <div class="text-sm text-slate-900 mb-4 space-y-2">
          <p class="text-[#00a650] font-semibold flex items-center gap-1">
            Llega gratis mañana
          </p>
          <p class="flex items-center gap-1 text-slate-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
            Enviar a tu dirección
          </p>
          <p class="text-emerald-700 font-semibold mt-2 text-lg">En stock.</p>
        </div>

        <?php if ($added): ?>
          <div class="mb-4 rounded-md border border-[#00a650] bg-[#e6f7ee] px-3 py-2 text-sm text-[#00a650] font-semibold flex items-center gap-2">
            ¡Agregado al carrito!
          </div>
        <?php endif; ?>

        <form method="POST" class="flex flex-col gap-3">
          <input type="hidden" name="action" value="add_to_cart">
          <div class="flex items-center gap-2 mb-2">
            <label for="qty" class="text-sm text-slate-700 font-medium">Cantidad:</label>
            <select id="qty" class="border border-slate-300 rounded-md py-1 px-2 text-sm focus:border-[#3483fa] focus:ring-1 focus:ring-[#3483fa] outline-none bg-slate-50">
              <option>1</option><option>2</option><option>3</option>
            </select>
          </div>
          <button type="submit" class="w-full rounded-full bg-[#ffd814] hover:bg-[#F7CA00] border border-[#FCD200] py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition-colors cursor-pointer">
            Agregar al carrito
          </button>
          <button type="button" class="w-full rounded-full bg-[#ffa41c] hover:bg-[#FA8900] border border-[#FA8900] py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition-colors cursor-pointer">
            Comprar ahora
          </button>
        </form>

        <div class="mt-4 text-xs text-slate-500 space-y-2">
          <div class="flex justify-between">
            <span>Se envía desde</span>
            <span class="font-medium text-slate-700">MercaShop</span>
          </div>
          <div class="flex justify-between">
            <span>Vendido por</span>
            <span class="font-medium text-[#3483fa]"><?= htmlspecialchars($product['vendedor']) ?></span>
          </div>
          <div class="flex justify-between">
            <span>Devoluciones</span>
            <span class="font-medium text-[#3483fa]">Devolución gratis de 30 días</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
