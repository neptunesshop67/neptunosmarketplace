<?php
require_once 'config.php';
require_once 'includes/header.php';

// Obtener productos de la base de datos
$stmt = $pdo->query("SELECT p.*, c.nombre as categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id LIMIT 12");
$productos = $stmt->fetchAll();
?>

  <!-- ===== HERO ===== -->
  <section class="hero">
    <div class="hero-content">
      <div class="hero-badge">🔥 Mega Oferta — Hasta 60% OFF</div>
      <h1>Compra con <em>confianza</em>, entrega garantizada</h1>
      <p>Millones de productos con envío gratis. Paga como quieras: tarjeta, efectivo o hasta 24 cuotas sin interés.</p>
      <div class="hero-cta">
        <button class="btn-primary" onclick="scrollToProducts()">Ver ofertas del día</button>
        <button class="btn-secondary">Cómo funciona →</button>
      </div>
    </div>
    <div class="hero-image">
      <div class="hero-phone-mock">
        <div class="mock-product">📱</div>
        <div class="mock-line" style="width:100%"></div>
        <div class="mock-line" style="width:70%"></div>
        <div class="mock-price">$ 799.99</div>
        <button class="mock-btn">Comprar ahora</button>
      </div>
    </div>
  </section>

  <!-- ===== TRUST STRIP ===== -->
  <div class="trust-strip">
    <div class="trust-item"><span>🚚</span> Envío gratis en miles de productos</div>
    <div class="trust-item"><span>🔒</span> Compra 100% segura</div>
    <div class="trust-item"><span>💳</span> Hasta 24 cuotas sin interés</div>
    <div class="trust-item"><span>↩️</span> Devolución sin preguntas</div>
    <div class="trust-item"><span>⭐</span> Atención 24/7</div>
  </div>

  <!-- ===== CATEGORÍAS ===== -->
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">Explorar por <span class="accent">categoría</span></h2>
      <a href="#" class="see-all">Ver todas →</a>
    </div>
    <div class="category-pills">
      <div class="pill active"><span class="pill-icon">🛒</span> Todo</div>
      <div class="pill"><span class="pill-icon">📱</span> Tecnología</div>
      <div class="pill"><span class="pill-icon">👗</span> Moda</div>
      <div class="pill"><span class="pill-icon">🏠</span> Hogar</div>
      <div class="pill"><span class="pill-icon">⚽</span> Deporte</div>
      <div class="pill"><span class="pill-icon">🎮</span> Gaming</div>
    </div>

    <!-- BANNERS PROMO -->
    <div class="promo-grid">
      <div class="promo-card blue" data-emoji="💻">
        <div>
          <div class="promo-label">Semana Tech</div>
          <div class="promo-title">Laptops y PCs<br>hasta 45% OFF</div>
        </div>
        <button class="promo-cta">Ver ofertas</button>
      </div>
      <div class="promo-card amber" data-emoji="👟">
        <div>
          <div class="promo-label">Moda &amp; Estilo</div>
          <div class="promo-title">Zapatillas<br>de temporada</div>
        </div>
        <button class="promo-cta">Comprar ahora</button>
      </div>
    </div>

    <!-- PRODUCTS (Dinámico) -->
    <div class="section-header">
      <h2 class="section-title" id="productsTitle">Más <span class="accent">vendidos</span></h2>
      <a href="#" class="see-all">Ver todos →</a>
    </div>
    <div class="product-grid" id="productGrid">
      <?php foreach($productos as $p): ?>
      <div class="product-card" onclick="window.location.href='producto.php?id=<?= $p['id'] ?>'">
        <div class="product-image-wrap">
          <span style="font-size:4rem"><?= htmlspecialchars($p['emoji']) ?></span>
          <?php if($p['badge']): ?>
            <div class="product-badge <?= strtolower($p['badge']) === 'nuevo' ? 'new' : (strtolower($p['badge']) === 'hot' ? 'hot' : '') ?>">
              <?= htmlspecialchars($p['badge']) ?>
            </div>
          <?php endif; ?>
          <button class="fav-btn" onclick="toggleFav(event,<?= $p['id'] ?>)" title="Guardar">🤍</button>
        </div>
        <div class="product-info">
          <div class="product-seller"><?= htmlspecialchars($p['vendedor']) ?></div>
          <div class="product-name"><?= htmlspecialchars($p['nombre']) ?></div>
          <div class="product-rating">
            <span class="stars">★★★★☆</span>
            <span class="rating-count">(+100)</span>
          </div>
          <div class="product-prices">
            <div class="price-original">$<?= number_format($p['precio_original'], 2) ?></div>
            <div style="display:flex; align-items:baseline; gap:0.4rem">
              <div class="price-main">$<?= number_format($p['precio'], 2) ?></div>
              <div class="price-discount">-<?= $p['descuento'] ?>%</div>
            </div>
            <div class="price-installments">o 12x $<?= number_format($p['precio']/12, 2) ?> sin interés</div>
          </div>
          <div class="product-shipping">✅ Envío gratis</div>
          <button class="add-cart-btn" onclick="addToCart(event,<?= $p['id'] ?>)" id="btn-<?= $p['id'] ?>">
            🛒 Agregar al carrito
          </button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ===== DEALS STRIP ===== -->
  <div class="section">
    <div class="deals-strip">
      <div class="deals-header">
        <div class="deals-title">⚡ Ofertas del día</div>
        <div class="countdown">
          <div class="count-unit" id="hours">04</div><span class="count-sep">:</span>
          <div class="count-unit" id="minutes">02</div><span class="count-sep">:</span>
          <div class="count-unit" id="seconds">19</div>
        </div>
      </div>
      <div class="deals-grid" id="dealsGrid">
        <div class="deal-card"><div class="deal-emoji">⌚</div><div class="deal-name">Apple Watch</div><div class="deal-price">$299</div><div class="deal-off">↓ 35% OFF</div></div>
        <div class="deal-card"><div class="deal-emoji">🖥️</div><div class="deal-name">Monitor LG</div><div class="deal-price">$349</div><div class="deal-off">↓ 28% OFF</div></div>
        <div class="deal-card"><div class="deal-emoji">🎒</div><div class="deal-name">Mochila</div><div class="deal-price">$89</div><div class="deal-off">↓ 40% OFF</div></div>
      </div>
    </div>
  </div>

<?php require_once 'includes/footer.php'; ?>
