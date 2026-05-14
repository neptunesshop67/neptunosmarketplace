<?php
require_once 'config.php';

$search = trim($_GET['q'] ?? '');
$category = trim($_GET['categoria'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_to_cart') {
    $productId = intval($_POST['product_id'] ?? 0);
    if ($productId > 0) {
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
        header('Location: index.php?added=1');
        exit;
    }
}

$pageTitle = 'MercaShop | Inicio';
require_once 'includes/header.php';

$where = [];
$params = [];
if ($search !== '') {
    $where[] = '(p.nombre LIKE ? OR p.descripcion LIKE ? OR p.vendedor LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($category !== '') {
    $where[] = 'c.slug = ?';
    $params[] = $category;
}
$sql = "SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug FROM productos p JOIN categorias c ON p.categoria_id = c.id";
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY p.id DESC LIMIT 50';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
$categories = $pdo->query('SELECT * FROM categorias ORDER BY nombre')->fetchAll();
$added = isset($_GET['added']);
?>

<div class="space-y-6">
  <!-- Promos Banner (Mercado Libre Style Slider Look) -->
  <section class="rounded-md bg-gradient-to-r from-[#232f3e] to-[#37475A] p-6 shadow-sm text-white">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
      <div>
        <span class="inline-flex items-center rounded-sm bg-[#ffd814] px-2 py-0.5 text-xs font-bold text-slate-900 uppercase">Hackathon</span>
        <h1 class="mt-2 text-2xl font-bold sm:text-3xl">Tu marketplace local en Raspberry Pi</h1>
        <p class="mt-2 text-slate-300 max-w-2xl text-sm">Las mejores ofertas, envíos rápidos y la mejor experiencia de compra híbrida.</p>
      </div>
      <div class="flex gap-4">
        <div class="rounded-md bg-white/10 p-4 border border-white/20 backdrop-blur-sm">
          <p class="text-xs uppercase text-slate-300">Carrito</p>
          <p class="text-2xl font-semibold"><?= cartItemCount() ?> items</p>
        </div>
        <div class="rounded-md bg-white/10 p-4 border border-white/20 backdrop-blur-sm">
          <p class="text-xs uppercase text-slate-300">Total estimado</p>
          <p class="text-2xl font-semibold">$<?= number_format(cartTotal($pdo), 2) ?></p>
        </div>
      </div>
    </div>
    <?php if ($added): ?>
      <div class="mt-4 rounded-md border border-[#00a650] bg-[#e6f7ee] px-4 py-3 text-[#00a650] font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
        ¡Agregaste un producto a tu carrito!
      </div>
    <?php endif; ?>
  </section>

  <section class="grid gap-4">
    <form method="GET" action="index.php" class="flex gap-2 w-full md:hidden">
      <!-- Mobile Search Bar (Since desktop header search is hidden on mobile) -->
      <input id="q" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Buscar productos..." class="w-full rounded-sm border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm focus:border-[#3483fa] focus:outline-none" />
      <button type="submit" class="rounded-sm bg-slate-200 px-4 py-2 text-slate-600 shadow-sm hover:bg-slate-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
      </button>
    </form>

    <div class="flex flex-wrap gap-2">
      <a href="index.php" class="rounded-full px-3 py-1.5 text-sm font-semibold transition-colors <?= $category === '' ? 'bg-[#3483fa] text-white' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' ?>">Todas</a>
      <?php foreach ($categories as $cat): ?>
        <a href="index.php?categoria=<?= urlencode($cat['slug']) ?>" class="rounded-full px-3 py-1.5 text-sm font-semibold transition-colors <?= $category === $cat['slug'] ? 'bg-[#3483fa] text-white' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' ?>"><?= htmlspecialchars($cat['nombre']) ?></a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
    <?php if (empty($products)): ?>
      <div class="col-span-full rounded-md bg-white p-8 text-center text-slate-600 shadow-sm">No se encontraron productos con esos filtros.</div>
    <?php endif; ?>
    <?php foreach ($products as $product): ?>
      <article class="group bg-white rounded-md border border-slate-200 hover:shadow-lg transition-shadow overflow-hidden flex flex-col relative">
        <a href="product.php?id=<?= intval($product['id']) ?>" class="block aspect-square bg-slate-100 relative">
          <!-- Placeholder para imagen -->
          <div class="absolute inset-0 flex items-center justify-center text-6xl opacity-50">📦</div>
          <?php if ($product['badge']): ?>
            <span class="absolute top-2 left-2 bg-[#00a650] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-sm uppercase tracking-wider">Oferta</span>
          <?php endif; ?>
        </a>
        
        <div class="p-4 flex flex-col flex-1 border-t border-slate-100">
          <div class="flex items-center gap-1 mb-1">
            <span class="text-xs text-slate-500 uppercase tracking-wider"><?= htmlspecialchars($product['categoria_nombre']) ?></span>
          </div>
          
          <a href="product.php?id=<?= intval($product['id']) ?>">
            <h2 class="text-sm font-normal text-slate-800 leading-tight line-clamp-2 hover:text-[#3483fa]"><?= htmlspecialchars($product['nombre']) ?></h2>
          </a>
          
          <!-- Amazon Stars -->
          <div class="flex items-center mt-1 mb-2">
            <div class="flex text-[#ffa41c] text-sm">
              ★★★★<span class="text-slate-300">★</span>
            </div>
            <span class="text-xs text-[#3483fa] ml-1">(<?= rand(10, 500) ?>)</span>
          </div>
          
          <div class="mt-auto pt-2">
            <div class="flex items-baseline gap-2">
              <span class="text-2xl font-light text-slate-900">$<?= number_format($product['precio'], 0, ',', '.') ?></span>
              <?php if ($product['precio_original'] && $product['precio_original'] > $product['precio']): ?>
                <?php $discount = round((($product['precio_original'] - $product['precio']) / $product['precio_original']) * 100); ?>
                <span class="text-sm text-[#00a650]"><?= $discount ?>% OFF</span>
              <?php endif; ?>
            </div>
            
            <?php if ($product['precio_original'] && $product['precio_original'] > $product['precio']): ?>
              <p class="text-xs text-slate-400 line-through">$<?= number_format($product['precio_original'], 0, ',', '.') ?></p>
            <?php endif; ?>

            <p class="text-xs font-semibold text-[#00a650] mt-1 tracking-tight">Llega gratis mañana</p>
            <p class="text-[10px] text-slate-500 mt-0.5">Vendido por <b><?= htmlspecialchars($product['vendedor']) ?></b></p>
            
            <form method="POST" class="mt-3">
              <input type="hidden" name="product_id" value="<?= intval($product['id']) ?>" />
              <input type="hidden" name="action" value="add_to_cart" />
              <button type="submit" class="w-full rounded-full bg-[#ffd814] hover:bg-[#F7CA00] border border-[#FCD200] py-1.5 text-sm text-slate-900 shadow-sm transition-colors cursor-pointer">
                Agregar al carrito
              </button>
            </form>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </section>
</div>

<?php require_once 'includes/footer.php'; ?>
