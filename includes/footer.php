<!-- ===== FOOTER ===== -->
  <footer>
    <div class="footer-grid">
      <div class="footer-col">
        <div class="footer-logo">MercaShop</div>
        <p style="font-size:0.82rem; line-height:1.6; color:rgba(255,255,255,0.45);">Tu marketplace de confianza. Comprá
          y vendé con total seguridad desde cualquier dispositivo.</p>
      </div>
      <div class="footer-col">
        <h4>Comprador</h4>
        <a href="ayuda.php">Cómo comprar</a>
        <a href="ayuda.php">Medios de pago</a>
        <a href="ayuda.php">Envíos y entregas</a>
        <a href="ayuda.php">Devoluciones</a>
        <a href="terminos.php">Seguridad</a>
      </div>
      <div class="footer-col">
        <h4>Vendedor</h4>
        <a href="file:///C:/Users/HP/Downloads/tienda-online.html#">Vender en MercaShop</a>
        <a href="file:///C:/Users/HP/Downloads/tienda-online.html#">Costos y comisiones</a>
        <a href="file:///C:/Users/HP/Downloads/tienda-online.html#">Publicar gratis</a>
        <a href="file:///C:/Users/HP/Downloads/tienda-online.html#">Herramientas</a>
      </div>
      <div class="footer-col">
        <h4>Ayuda</h4>
        <a href="ayuda.php">Centro de ayuda</a>
        <a href="ayuda.php">Chat en vivo</a>
        <a href="ayuda.php">Reclamos</a>
        <a href="terminos.php">Términos y condiciones</a>
        <a href="terminos.php">Privacidad</a>
      </div>
    </div>
    <div class="footer-bottom">© 2025 MercaShop — Todos los derechos reservados. Compra con confianza.</div>
  </footer>

  <!-- ===== CART ===== -->
  <div class="cart-overlay" id="cartOverlay" onclick="handleOverlayClick(event)">
    <div class="cart-panel">
      <div class="cart-header">
        <h2>🛒 Mi carrito</h2>
        <button class="close-btn" onclick="closeCart()">✕</button>
      </div>
      <div class="cart-items" id="cartItems"></div>
      <div class="cart-footer" id="cartFooter" style="display:none">
        <div class="cart-total">
          <span class="total-label">Total a pagar:</span>
          <span class="total-amount" id="totalAmount">$0.00</span>
        </div>
        <button class="checkout-btn" onclick="checkout()">Ir a pagar →</button>
      </div>
    </div>
  </div>

  <!-- ===== LOGIN MODAL ===== -->
  <div class="login-overlay" id="loginOverlay" onclick="handleLoginClick(event)">
    <div class="login-panel">
      <div class="login-header">
        <h2>👤 Iniciar sesión</h2>
        <button class="close-btn" onclick="closeLogin()">✕</button>
      </div>
      <div class="login-body">
        <div class="form-group">
          <label>Correo electrónico</label>
          <input type="email" placeholder="ejemplo@correo.com">
        </div>
        <div class="form-group">
          <label>Contraseña</label>
          <input type="password" placeholder="••••••••">
        </div>
        <button class="login-btn" onclick="doLogin()">Ingresar</button>
      </div>
      <div class="login-footer">
        ¿No tienes cuenta? <a href="#">Regístrate</a>
      </div>
    </div>
  </div>

  <!-- ===== FAVORITES MODAL ===== -->
  <div class="fav-overlay" id="favOverlay" onclick="handleFavClick(event)">
    <div class="fav-panel">
      <div class="fav-header">
        <h2>❤️ Mis Favoritos</h2>
        <button class="close-btn" onclick="closeFavorites()">✕</button>
      </div>
      <div class="fav-items" id="favItems"></div>
    </div>
  </div>

  <!-- ===== TOAST ===== -->
  <div class="toast-container" id="toastContainer"></div>

  <script>
    const products = [
      { id: 1, name: 'iPhone 15 Pro Max 256GB Titanio', emoji: '📱', seller: 'Apple Official', price: 1199.99, original: 1399.99, discount: 14, rating: 4.8, reviews: 2341, shipping: 'Envío gratis', badge: 'Hot', category: 'tech', installments: '50x $24.00' },
      { id: 2, name: 'MacBook Air M3 13" 8GB RAM', emoji: '💻', seller: 'Apple Store AR', price: 1599.00, original: 1899.00, discount: 16, rating: 4.9, reviews: 891, shipping: 'Envío gratis', badge: 'Nuevo', category: 'tech', installments: '24x $66.63' },
      { id: 3, name: 'Nike Air Max 270 React Blanco/Negro', emoji: '👟', seller: 'Nike Argentina', price: 149.99, original: 199.99, discount: 25, rating: 4.6, reviews: 5632, shipping: 'Envío gratis', badge: 'Sale', category: 'moda', installments: '12x $12.50' },
      { id: 4, name: 'Smart TV Samsung 55" QLED 4K 2024', emoji: '📺', seller: 'Samsung Oficial', price: 799.00, original: 999.00, discount: 20, rating: 4.7, reviews: 3210, shipping: 'Envío gratis', badge: null, category: 'tech', installments: '24x $33.29' },
      { id: 5, name: 'Auriculares Sony WH-1000XM5 Noise Cancelling', emoji: '🎧', seller: 'Sony Store', price: 349.99, original: 449.99, discount: 22, rating: 4.9, reviews: 7812, shipping: 'Envío gratis', badge: 'Hot', category: 'tech', installments: '18x $19.44' },
      { id: 6, name: 'Silla Gamer RGB Ergonómica Pro X', emoji: '🪑', seller: 'Gaming Zone', price: 289.00, original: 389.00, discount: 26, rating: 4.5, reviews: 1203, shipping: 'Envío gratis', badge: 'Sale', category: 'gaming', installments: '12x $24.08' },
      { id: 7, name: 'Set de Pesas Ajustables 20kg Premium', emoji: '🏋️', seller: 'Fitness Pro', price: 99.99, original: 139.99, discount: 29, rating: 4.4, reviews: 876, shipping: 'Envío gratis', badge: null, category: 'deporte', installments: '6x $16.67' },
      { id: 8, name: 'Cámara Sony Alpha ZV-E10 con Lente 16-50mm', emoji: '📸', seller: 'Photo Expert', price: 699.00, original: 849.00, discount: 18, rating: 4.8, reviews: 2109, shipping: 'Envío gratis', badge: 'Nuevo', category: 'tech', installments: '24x $29.13' },
      { id: 9, name: 'Aspiradora Robot Roomba i7+ Mapeado', emoji: '🤖', seller: 'iRobot AR', price: 499.00, original: 699.00, discount: 29, rating: 4.7, reviews: 1432, shipping: 'Envío gratis', badge: 'Sale', category: 'hogar', installments: '18x $27.72' },
      { id: 10, name: 'PlayStation 5 Edición Digital + 2 Controles', emoji: '🎮', seller: 'Sony Gamer', price: 549.99, original: 649.99, discount: 15, rating: 4.9, reviews: 9845, shipping: 'Envío gratis', badge: 'Hot', category: 'gaming', installments: '24x $22.92' },
      { id: 11, name: 'Zapatillas Adidas Ultraboost 22 Correr', emoji: '🏃', seller: 'Adidas Oficial', price: 179.99, original: 229.99, discount: 22, rating: 4.7, reviews: 3298, shipping: 'Envío gratis', badge: null, category: 'deporte', installments: '12x $15.00' },
      { id: 12, name: 'Tablet iPad 10ma Gen 64GB WiFi', emoji: '📋', seller: 'Apple Argentina', price: 449.99, original: 549.99, discount: 18, rating: 4.8, reviews: 4521, shipping: 'Envío gratis', badge: 'Nuevo', category: 'tech', installments: '18x $25.00' },
    ];

    const deals = [
      { emoji: '⌚', name: 'Apple Watch Series 9', price: '$299', off: '35%', bar: 60 },
      { emoji: '🖥️', name: 'Monitor LG 27" IPS 4K', price: '$349', off: '28%', bar: 45 },
      { emoji: '🎒', name: 'Mochila Samsonite Pro', price: '$89', off: '40%', bar: 75 },
      { emoji: '🔊', name: 'JBL Charge 5 Speaker', price: '$149', off: '20%', bar: 30 },
      { emoji: '💊', name: 'Smart Watch Fit 3 NFC', price: '$79', off: '50%', bar: 80 },
      { emoji: '🖱️', name: 'Mouse Razer DeathAdder', price: '$59', off: '33%', bar: 55 },
    ];

    let cart = {};
    let favorites = new Set();
    let currentCategory = 'all';

    function getFilteredProducts() {
      return currentCategory === 'all' ? products : products.filter(p => p.category === currentCategory);
    }

    function renderProducts() {
      const grid = document.getElementById('productGrid');
      const filtered = getFilteredProducts();
      grid.innerHTML = filtered.map(p => `
    <div class="product-card" onclick="viewProduct(${p.id})">
      <div class="product-image-wrap">
        <span style="font-size:4rem">${p.emoji}</span>
        ${p.badge ? `<div class="product-badge ${p.badge === 'Nuevo' ? 'new' : p.badge === 'Hot' ? 'hot' : ''}">${p.badge}</div>` : ''}
        <button class="fav-btn ${favorites.has(p.id) ? 'active' : ''}" onclick="toggleFav(event,${p.id})" title="Guardar">${favorites.has(p.id) ? '❤️' : '🤍'}</button>
      </div>
      <div class="product-info">
        <div class="product-seller">${p.seller}</div>
        <div class="product-name">${p.name}</div>
        <div class="product-rating">
          <span class="stars">${'★'.repeat(Math.floor(p.rating))}${'☆'.repeat(5 - Math.floor(p.rating))}</span>
          <span class="rating-count">(${p.reviews.toLocaleString()})</span>
        </div>
        <div class="product-prices">
          <div class="price-original">$${p.original.toFixed(2)}</div>
          <div style="display:flex; align-items:baseline; gap:0.4rem">
            <div class="price-main">$${p.price.toFixed(2)}</div>
            <div class="price-discount">-${p.discount}%</div>
          </div>
          <div class="price-installments">o ${p.installments} sin interés</div>
        </div>
        <div class="product-shipping">✅ ${p.shipping}</div>
        <button class="add-cart-btn ${cart[p.id] ? 'added' : ''}" onclick="addToCart(event,${p.id})" id="btn-${p.id}">
          ${cart[p.id] ? '✅ En el carrito' : '🛒 Agregar al carrito'}
        </button>
      </div>
    </div>
  `).join('');
    }

    function renderDeals() {
      const grid = document.getElementById('dealsGrid');
      grid.innerHTML = deals.map(d => `
    <div class="deal-card" onclick="showToast('¡Oferta agregada al carrito!')">
      <div class="deal-emoji">${d.emoji}</div>
      <div class="deal-name">${d.name}</div>
      <div class="deal-price">${d.price}</div>
      <div class="deal-off">↓ ${d.off} OFF</div>
      <div class="deal-bar-wrap"><div class="deal-bar" style="width:${d.bar}%"></div></div>
      <div style="font-size:0.68rem; color:rgba(255,255,255,0.4); margin-top:3px">${d.bar}% vendido</div>
    </div>
  `).join('');
    }

    function addToCart(e, id) {
      e.stopPropagation();
      const product = products.find(p => p.id === id);
      if (!cart[id]) { cart[id] = { ...product, qty: 0 }; }
      cart[id].qty++;
      updateCartUI();
      const btn = document.getElementById('btn-' + id);
      if (btn) {
        btn.textContent = '✅ En el carrito';
        btn.classList.add('added');
      }
      showToast(`✅ "${product.name.substring(0, 30)}..." agregado`);
    }

    function updateCartUI() {
      const total = Object.values(cart).reduce((a, c) => a + c.qty, 0);
      document.getElementById('cartBadge').textContent = total;
      renderCart();
    }

    function renderCart() {
      const container = document.getElementById('cartItems');
      const footer = document.getElementById('cartFooter');
      const entries = Object.values(cart).filter(c => c.qty > 0);
      if (entries.length === 0) {
        container.innerHTML = `<div class="cart-empty"><div class="empty-icon">🛒</div><p>Tu carrito está vacío.<br>¡Agregá productos!</p></div>`;
        footer.style.display = 'none';
        return;
      }
      footer.style.display = 'block';
      container.innerHTML = entries.map(item => `
    <div class="cart-item">
      <div class="cart-item-emoji">${item.emoji}</div>
      <div class="cart-item-info">
        <div class="cart-item-name">${item.name.substring(0, 40)}...</div>
        <div class="cart-item-price">$${(item.price * item.qty).toFixed(2)}</div>
      </div>
      <div class="cart-qty">
        <button class="qty-btn" onclick="changeQty(${item.id},-1)">−</button>
        <span class="qty-num">${item.qty}</span>
        <button class="qty-btn" onclick="changeQty(${item.id},1)">+</button>
      </div>
      <button class="remove-item" onclick="removeItem(${item.id})" title="Eliminar">🗑️</button>
    </div>
  `).join('');
      const subtotal = entries.reduce((a, c) => a + c.price * c.qty, 0);
      document.getElementById('totalAmount').textContent = '$' + subtotal.toFixed(2);
    }

    function changeQty(id, delta) {
      if (!cart[id]) return;
      cart[id].qty += delta;
      if (cart[id].qty <= 0) { delete cart[id]; }
      updateCartUI();
      const btn = document.getElementById('btn-' + id);
      if (btn && !cart[id]) {
        btn.textContent = '🛒 Agregar al carrito';
        btn.classList.remove('added');
      }
    }

    function removeItem(id) {
      delete cart[id];
      updateCartUI();
      const btn = document.getElementById('btn-' + id);
      if (btn) { btn.textContent = '🛒 Agregar al carrito'; btn.classList.remove('added'); }
    }

    function openCart() {
      renderCart();
      document.getElementById('cartOverlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeCart() {
      document.getElementById('cartOverlay').classList.remove('open');
      document.body.style.overflow = '';
    }

    function handleOverlayClick(e) {
      if (e.target === document.getElementById('cartOverlay')) closeCart();
    }

    function openLogin() {
      window.location.href = 'login.php';
    }

    function closeLogin() {
      // not needed anymore if we redirect, but keep to avoid JS errors
      const el = document.getElementById('loginOverlay');
      if (el) el.classList.remove('open');
      document.body.style.overflow = '';
    }

    function handleLoginClick(e) {
      if (e.target === document.getElementById('loginOverlay')) closeLogin();
    }

    function doLogin() {
      showToast('🎉 ¡Has iniciado sesión con éxito!');
      setTimeout(() => { closeLogin(); }, 1200);
    }

    function renderFavs() {
      const container = document.getElementById('favItems');
      const favArray = Array.from(favorites);
      if (favArray.length === 0) {
        container.innerHTML = `<div class="cart-empty"><div class="empty-icon">❤️</div><p>Aún no tienes favoritos.<br>¡Guarda los que te gusten!</p></div>`;
        return;
      }
      container.innerHTML = favArray.map(id => {
        const item = products.find(p => p.id === id);
        return `
          <div class="cart-item">
            <div class="cart-item-emoji">${item.emoji}</div>
            <div class="cart-item-info">
              <div class="cart-item-name">${item.name.substring(0, 40)}...</div>
              <div class="cart-item-price">$${item.price.toFixed(2)}</div>
            </div>
            <button class="remove-item" onclick="toggleFav(event, ${item.id}); renderFavs();" title="Eliminar">🗑️</button>
          </div>
        `;
      }).join('');
    }

    function openFavorites() {
      renderFavs();
      document.getElementById('favOverlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeFavorites() {
      document.getElementById('favOverlay').classList.remove('open');
      document.body.style.overflow = '';
    }

    function handleFavClick(e) {
      if (e.target === document.getElementById('favOverlay')) closeFavorites();
    }

    function checkout() {
      window.location.href = 'checkout.php';
    }

    function toggleFav(e, id) {
      e.stopPropagation();
      if (favorites.has(id)) { favorites.delete(id); showToast('💔 Eliminado de favoritos'); }
      else { favorites.add(id); showToast('❤️ Guardado en favoritos'); }
      renderProducts();
    }

    function viewProduct(id) {
      const p = products.find(x => x.id === id);
      showToast(`👀 Viendo: ${p.name.substring(0, 40)}...`);
    }

    function filterCategory(cat) {
      currentCategory = cat;
      document.querySelectorAll('.pill').forEach((el, i) => {
        el.classList.toggle('active', (i === 0 && cat === 'all') || el.textContent.trim().toLowerCase().includes(cat));
      });
      const titles = { all: 'Más vendidos', tech: 'Tecnología', moda: 'Moda & Estilo', hogar: 'Hogar & Deco', deporte: 'Deporte', gaming: 'Gaming', autos: 'Automotor', mascotas: 'Mascotas' };
      document.getElementById('productsTitle').innerHTML = `${titles[cat] || 'Productos'} <span class="accent">destacados</span>`;
      renderProducts();
    }

    function doSearch() {
      const q = document.getElementById('searchInput').value.trim();
      if (!q) return;
      showToast(`🔍 Buscando: "${q}"...`);
    }

    document.getElementById('searchInput').addEventListener('keydown', e => { if (e.key === 'Enter') doSearch(); });

    function scrollToProducts() {
      document.getElementById('productGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function showToast(msg) {
      const el = document.createElement('div');
      el.className = 'toast';
      el.textContent = msg;
      document.getElementById('toastContainer').appendChild(el);
      setTimeout(() => el.remove(), 2600);
    }

    // Countdown
    let secs = 4 * 3600 + 23 * 60 + 58;
    function tick() {
      secs--;
      if (secs < 0) secs = 86399;
      const h = String(Math.floor(secs / 3600)).padStart(2, '0');
      const m = String(Math.floor((secs % 3600) / 60)).padStart(2, '0');
      const s = String(secs % 60).padStart(2, '0');
      document.getElementById('hours').textContent = h;
      document.getElementById('minutes').textContent = m;
      document.getElementById('seconds').textContent = s;
    }
    setInterval(tick, 1000);

    // Nav category click
    document.querySelectorAll('.nav-cat').forEach(el => {
      el.addEventListener('click', e => {
        e.preventDefault();
        document.querySelectorAll('.nav-cat').forEach(x => x.classList.remove('active'));
        el.classList.add('active');
      });
    });

    renderProducts();
    renderDeals();
  </script>


</body>

</html>