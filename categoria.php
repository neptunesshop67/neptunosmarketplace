<?php
require_once 'config.php';

$slug = $_GET['slug'] ?? '';
$categoria = null;
$productos = [];

if ($slug) {
    $stmt = $pdo->prepare("SELECT * FROM categorias WHERE slug = ?");
    $stmt->execute([$slug]);
    $categoria = $stmt->fetch();

    if ($categoria) {
        $stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE c.slug = ?");
        $stmt->execute([$slug]);
        $productos = $stmt->fetchAll();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_to_cart') {
    $productId = intval($_POST['product_id'] ?? 0);
    if ($productId > 0) {
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
        header('Location: categoria.php?slug=' . urlencode($slug) . '&added=1');
        exit;
    }
}
$added = isset($_GET['added']);

$pageTitle = 'Categoría | MercaShop';
require_once 'includes/header.php';
?>

<div class="space-y-6 bg-white p-6 rounded-md shadow-sm border border-slate-200 mb-6">
  <div class="border-b border-slate-200 pb-4 mb-4 flex items-center justify-between">
    <div>
      <h2 class="text-2xl font-bold text-slate-900">
        <?php if ($categoria): ?>
          Categoría: <span class="text-[#3483fa]"><?= htmlspecialchars($categoria['nombre']) ?></span>
        <?php else: ?>
          Categoría no encontrada
        <?php endif; ?>
      </h2>
    </div>
  </div>

  <?php if ($added): ?>
    <div class="rounded-md border border-[#00a650] bg-[#e6f7ee] px-4 py-3 text-[#00a650] font-semibold flex items-center gap-2 mb-4">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
      ¡Agregaste un producto a tu carrito!
    </div>
  <?php endif; ?>

  <?php if ($categoria): ?>
    <?php if (count($productos) > 0): ?>
      <section class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
        <?php foreach ($productos as $product): ?>
          <article class="group bg-white rounded-md border border-slate-200 hover:shadow-lg transition-shadow overflow-hidden flex flex-col relative">
            <a href="product.php?id=<?= intval($product['id']) ?>" class="block aspect-square bg-slate-100 relative">
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
                <div class="flex text-[#ffa41c] text-sm">★★★★<span class="text-slate-300">★</span></div>
                <span class="text-xs text-[#3483fa] ml-1">(<?= rand(10, 500) ?>)</span>
              </div>
              
              <div class="mt-auto pt-2">
                <div class="flex items-baseline gap-2">
                  <span class="text-2xl font-light text-slate-900">$<?= number_format($product['precio'], 0, ',', '.') ?></span>
                  <?php if ($product['descuento']): ?>
                    <span class="text-sm text-[#00a650] font-semibold">-<?= $product['descuento'] ?>% OFF</span>
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
    <?php else: ?>
      <div class="p-8 text-center text-slate-600">No hay productos en esta categoría por el momento.</div>
    <?php endif; ?>
  <?php else: ?>
    <div class="p-8 text-center text-slate-600">La categoría que buscas no existe o fue eliminada.</div>
  <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
