<!DOCTYPE html>
<!-- saved from url=(0048)file:///C:/Users/HP/Downloads/tienda-online.html -->
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MercaShop — Tu tienda en línea</title>
  <link href="./astro_files/css2" rel="stylesheet">
  <style>
    :root {
      --yellow: #b400ff;
      --yellow-dark: #D4BE00;
      --yellow-light: #FFF9C4;
      --blue-deep: #1a1a2e;
      --blue-mid: #16213e;
      --blue-accent: #0f3460;
      --cyan: #00C6FF;
      --white: #ffffff;
      --gray-100: #f7f7f7;
      --gray-200: #eeeeee;
      --gray-400: #aaaaaa;
      --gray-700: #444444;
      --gray-900: #111111;
      --green: #00b140;
      --red: #e74c3c;
      --orange: #ff6900;
      --radius-sm: 8px;
      --radius-md: 14px;
      --radius-lg: 20px;
      --shadow-card: 0 4px 24px rgba(0, 0, 0, 0.08);
      --shadow-hover: 0 8px 40px rgba(0, 0, 0, 0.15);
      --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--gray-100);
      color: var(--gray-900);
      min-height: 100vh;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      background: var(--yellow);
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
    }

    .nav-top {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      height: 64px;
    }

    .logo {
      font-family: 'Syne', sans-serif;
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--blue-deep);
      text-decoration: none;
      white-space: nowrap;
      letter-spacing: -0.5px;
    }

    .logo span {
      color: var(--blue-accent);
    }

    .search-bar {
      flex: 1;
      display: flex;
      align-items: center;
      background: var(--white);
      border-radius: var(--radius-sm);
      overflow: hidden;
      border: 2px solid transparent;
      transition: var(--transition);
      max-width: 680px;
    }

    .search-bar:focus-within {
      border-color: var(--blue-accent);
    }

    .search-bar input {
      flex: 1;
      border: none;
      outline: none;
      padding: 0.6rem 1rem;
      font-size: 0.95rem;
      font-family: 'DM Sans', sans-serif;
      background: transparent;
    }

    .search-bar button {
      background: var(--blue-deep);
      border: none;
      padding: 0.6rem 1.1rem;
      cursor: pointer;
      color: var(--yellow);
      font-size: 1.1rem;
      transition: var(--transition);
    }

    .search-bar button:hover {
      background: var(--blue-accent);
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      margin-left: auto;
      flex-shrink: 0;
    }

    .nav-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      font-size: 0.7rem;
      font-weight: 600;
      color: var(--blue-deep);
      cursor: pointer;
      padding: 0.3rem 0.7rem;
      border-radius: var(--radius-sm);
      border: none;
      background: transparent;
      transition: var(--transition);
      text-decoration: none;
      gap: 2px;
      position: relative;
    }

    .nav-btn:hover {
      background: rgba(0, 0, 0, 0.08);
    }

    .nav-btn .nav-icon {
      font-size: 1.3rem;
    }

    .cart-badge {
      position: absolute;
      top: 2px;
      right: 4px;
      background: var(--red);
      color: white;
      border-radius: 99px;
      font-size: 0.6rem;
      font-weight: 700;
      padding: 1px 5px;
      min-width: 16px;
      text-align: center;
    }

    .nav-bottom {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      padding: 0.4rem 0;
      border-top: 1px solid rgba(0, 0, 0, 0.08);
      overflow-x: auto;
      scrollbar-width: none;
    }

    .nav-bottom::-webkit-scrollbar {
      display: none;
    }

    .nav-cat {
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--blue-deep);
      cursor: pointer;
      white-space: nowrap;
      padding: 0.2rem 0;
      border-bottom: 2px solid transparent;
      transition: var(--transition);
      text-decoration: none;
    }

    .nav-cat:hover,
    .nav-cat.active {
      border-bottom-color: var(--blue-accent);
      color: var(--blue-accent);
    }

    /* ===== HERO / BANNER ===== */
    .hero {
      background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue-accent) 60%, #1a4a8a 100%);
      padding: 3.5rem 2rem;
      display: flex;
      align-items: center;
      gap: 3rem;
      min-height: 320px;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      right: -60px;
      top: -60px;
      width: 400px;
      height: 400px;
      background: var(--yellow);
      border-radius: 50%;
      opacity: 0.07;
    }

    .hero::after {
      content: '';
      position: absolute;
      right: 200px;
      bottom: -80px;
      width: 250px;
      height: 250px;
      background: var(--cyan);
      border-radius: 50%;
      opacity: 0.06;
    }

    .hero-content {
      max-width: 480px;
      z-index: 1;
    }

    .hero-badge {
      display: inline-block;
      background: var(--yellow);
      color: var(--blue-deep);
      font-size: 0.72rem;
      font-weight: 700;
      padding: 0.3rem 0.9rem;
      border-radius: 99px;
      margin-bottom: 1rem;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    .hero h1 {
      font-family: 'Syne', sans-serif;
      font-size: 2.8rem;
      font-weight: 800;
      color: var(--white);
      line-height: 1.1;
      margin-bottom: 1rem;
      letter-spacing: -1px;
    }

    .hero h1 em {
      color: var(--yellow);
      font-style: normal;
    }

    .hero p {
      color: rgba(255, 255, 255, 0.75);
      font-size: 1rem;
      margin-bottom: 1.8rem;
      line-height: 1.6;
    }

    .hero-cta {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .btn-primary {
      background: var(--yellow);
      color: var(--blue-deep);
      border: none;
      padding: 0.85rem 2rem;
      border-radius: var(--radius-sm);
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
      font-family: 'DM Sans', sans-serif;
    }

    .btn-primary:hover {
      background: #f0d800;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 230, 0, 0.3);
    }

    .btn-secondary {
      background: transparent;
      color: var(--white);
      border: 2px solid rgba(255, 255, 255, 0.4);
      padding: 0.85rem 1.8rem;
      border-radius: var(--radius-sm);
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      font-family: 'DM Sans', sans-serif;
    }

    .btn-secondary:hover {
      border-color: var(--white);
      background: rgba(255, 255, 255, 0.1);
    }

    .hero-image {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1;
    }

    .hero-phone-mock {
      width: 200px;
      height: 320px;
      background: rgba(255, 255, 255, 0.06);
      border: 1.5px solid rgba(255, 255, 255, 0.15);
      border-radius: 28px;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 1.5rem 1rem;
      backdrop-filter: blur(10px);
      position: relative;
      animation: float 3.5s ease-in-out infinite;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-12px);
      }
    }

    .mock-product {
      width: 100px;
      height: 100px;
      background: rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      margin-bottom: 0.8rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.8rem;
    }

    .mock-line {
      height: 8px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 4px;
      margin-bottom: 6px;
    }

    .mock-price {
      color: var(--yellow);
      font-family: 'Syne', sans-serif;
      font-size: 1.2rem;
      font-weight: 700;
      margin-top: 0.5rem;
    }

    .mock-btn {
      width: 100%;
      background: var(--yellow);
      color: var(--blue-deep);
      border: none;
      padding: 0.6rem;
      border-radius: 8px;
      font-weight: 700;
      margin-top: auto;
      font-size: 0.8rem;
      cursor: pointer;
    }

    /* ===== TRUST STRIP ===== */
    .trust-strip {
      background: var(--white);
      padding: 1rem 2rem;
      display: flex;
      justify-content: center;
      gap: 2.5rem;
      flex-wrap: wrap;
      border-bottom: 1px solid var(--gray-200);
    }

    .trust-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--gray-700);
    }

    .trust-item span {
      font-size: 1.2rem;
    }

    /* ===== SECTIONS ===== */
    .section {
      padding: 2.5rem 2rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    .section-header {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }

    .section-title {
      font-family: 'Syne', sans-serif;
      font-size: 1.45rem;
      font-weight: 700;
      color: var(--gray-900);
      letter-spacing: -0.3px;
    }

    .section-title .accent {
      color: var(--blue-accent);
    }

    .see-all {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--blue-accent);
      cursor: pointer;
      text-decoration: none;
      border-bottom: 1px dashed var(--blue-accent);
      transition: var(--transition);
    }

    .see-all:hover {
      opacity: 0.7;
    }

    /* ===== CATEGORY PILLS ===== */
    .category-pills {
      display: flex;
      gap: 0.7rem;
      flex-wrap: wrap;
      margin-bottom: 2rem;
    }

    .pill {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      background: var(--white);
      border: 1.5px solid var(--gray-200);
      padding: 0.5rem 1.1rem;
      border-radius: 99px;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      color: var(--gray-700);
      box-shadow: var(--shadow-card);
    }

    .pill:hover,
    .pill.active {
      background: var(--blue-deep);
      color: var(--white);
      border-color: var(--blue-deep);
      transform: translateY(-2px);
    }

    .pill .pill-icon {
      font-size: 1rem;
    }

    /* ===== PRODUCT GRID ===== */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.2rem;
    }

    .product-card {
      background: var(--white);
      border-radius: var(--radius-md);
      overflow: hidden;
      box-shadow: var(--shadow-card);
      transition: var(--transition);
      cursor: pointer;
      display: flex;
      flex-direction: column;
      border: 1px solid transparent;
      position: relative;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
      border-color: var(--gray-200);
    }

    .product-image-wrap {
      background: var(--gray-100);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 180px;
      font-size: 4rem;
      position: relative;
      overflow: hidden;
    }

    .product-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: var(--red);
      color: white;
      font-size: 0.68rem;
      font-weight: 700;
      padding: 0.22rem 0.6rem;
      border-radius: 99px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .product-badge.new {
      background: var(--green);
    }

    .product-badge.hot {
      background: var(--orange);
    }

    .fav-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 32px;
      height: 32px;
      background: var(--white);
      border: 1px solid var(--gray-200);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      cursor: pointer;
      transition: var(--transition);
      opacity: 0;
    }

    .product-card:hover .fav-btn {
      opacity: 1;
    }

    .fav-btn:hover {
      background: #ffe4e4;
      border-color: #ffaaaa;
    }

    .fav-btn.active {
      opacity: 1;
      color: var(--red);
      border-color: #ffaaaa;
      background: #ffe4e4;
    }

    .product-info {
      padding: 1rem;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .product-seller {
      font-size: 0.72rem;
      color: var(--gray-400);
      font-weight: 500;
      margin-bottom: 0.3rem;
    }

    .product-name {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: 0.5rem;
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .product-rating {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      margin-bottom: 0.6rem;
    }

    .stars {
      color: var(--yellow-dark);
      font-size: 0.75rem;
    }

    .rating-count {
      font-size: 0.72rem;
      color: var(--gray-400);
    }

    .product-prices {
      margin-bottom: 0.6rem;
    }

    .price-original {
      font-size: 0.78rem;
      color: var(--gray-400);
      text-decoration: line-through;
    }

    .price-main {
      font-family: 'Syne', sans-serif;
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--gray-900);
      line-height: 1;
    }

    .price-discount {
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--green);
    }

    .price-installments {
      font-size: 0.78rem;
      color: var(--blue-accent);
      font-weight: 500;
    }

    .product-shipping {
      font-size: 0.74rem;
      font-weight: 600;
      color: var(--green);
      margin-top: auto;
      padding-top: 0.5rem;
    }

    .add-cart-btn {
      width: 100%;
      background: var(--blue-deep);
      color: var(--white);
      border: none;
      padding: 0.65rem;
      border-radius: var(--radius-sm);
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      margin-top: 0.8rem;
      transition: var(--transition);
      font-family: 'DM Sans', sans-serif;
    }

    .add-cart-btn:hover {
      background: var(--blue-accent);
      transform: scale(1.02);
    }

    .add-cart-btn.added {
      background: var(--green);
    }

    /* ===== BANNER PROMOS ===== */
    .promo-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.2rem;
      margin-bottom: 2.5rem;
    }

    .promo-card {
      border-radius: var(--radius-md);
      padding: 1.8rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 160px;
      cursor: pointer;
      transition: var(--transition);
      overflow: hidden;
      position: relative;
    }

    .promo-card:hover {
      transform: scale(1.02);
    }

    .promo-card.blue {
      background: linear-gradient(135deg, #0f3460 0%, #1a5276 100%);
    }

    .promo-card.amber {
      background: linear-gradient(135deg, #b7790a 0%, #e67e22 100%);
    }

    .promo-card::before {
      content: attr(data-emoji);
      position: absolute;
      right: 1rem;
      bottom: -10px;
      font-size: 5rem;
      opacity: 0.18;
    }

    .promo-label {
      font-size: 0.7rem;
      font-weight: 700;
      color: rgba(255, 255, 255, 0.7);
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .promo-title {
      font-family: 'Syne', sans-serif;
      font-size: 1.35rem;
      font-weight: 700;
      color: var(--white);
      line-height: 1.2;
      margin: 0.4rem 0;
    }

    .promo-cta {
      background: var(--yellow);
      color: var(--blue-deep);
      border: none;
      padding: 0.5rem 1.2rem;
      border-radius: 99px;
      font-size: 0.8rem;
      font-weight: 700;
      cursor: pointer;
      width: fit-content;
      transition: var(--transition);
      font-family: 'DM Sans', sans-serif;
    }

    .promo-cta:hover {
      transform: scale(1.05);
    }

    /* ===== DEALS STRIP ===== */
    .deals-strip {
      background: var(--blue-deep);
      margin: 0 -2rem;
      padding: 2rem;
    }

    .deals-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .deals-title {
      font-family: 'Syne', sans-serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--yellow);
    }

    .countdown {
      display: flex;
      gap: 0.4rem;
      align-items: center;
    }

    .count-unit {
      background: rgba(255, 255, 255, 0.1);
      color: var(--white);
      border-radius: 6px;
      padding: 0.3rem 0.6rem;
      font-family: 'Syne', sans-serif;
      font-size: 1rem;
      font-weight: 700;
      min-width: 40px;
      text-align: center;
    }

    .count-sep {
      color: var(--yellow);
      font-weight: 700;
    }

    .deals-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 1rem;
    }

    .deal-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      padding: 0.8rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .deal-card:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-3px);
    }

    .deal-emoji {
      font-size: 2.5rem;
      text-align: center;
      margin-bottom: 0.5rem;
    }

    .deal-name {
      font-size: 0.78rem;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 0.4rem;
      font-weight: 500;
    }

    .deal-price {
      font-family: 'Syne', sans-serif;
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--white);
    }

    .deal-off {
      font-size: 0.72rem;
      color: var(--yellow);
      font-weight: 700;
    }

    .deal-bar-wrap {
      height: 4px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 2px;
      margin-top: 0.5rem;
    }

    .deal-bar {
      height: 100%;
      background: var(--yellow);
      border-radius: 2px;
    }

    /* ===== CART MODAL ===== */
    .cart-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 200;
      align-items: flex-start;
      justify-content: flex-end;
    }

    .cart-overlay.open {
      display: flex;
    }

    .cart-panel {
      background: var(--white);
      width: 400px;
      max-width: 100vw;
      height: 100vh;
      display: flex;
      flex-direction: column;
      box-shadow: -8px 0 40px rgba(0, 0, 0, 0.15);
      animation: slideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes slideIn {
      from {
        transform: translateX(100%);
      }

      to {
        transform: translateX(0);
      }
    }

    .cart-header {
      background: var(--yellow);
      padding: 1.2rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .cart-header h2 {
      font-family: 'Syne', sans-serif;
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--blue-deep);
    }

    .close-btn {
      background: none;
      border: none;
      font-size: 1.3rem;
      cursor: pointer;
      color: var(--blue-deep);
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: var(--transition);
    }

    .close-btn:hover {
      background: rgba(0, 0, 0, 0.1);
    }

    .cart-items {
      flex: 1;
      overflow-y: auto;
      padding: 1rem 1.5rem;
    }

    .cart-item {
      display: flex;
      gap: 1rem;
      padding: 0.8rem 0;
      border-bottom: 1px solid var(--gray-200);
      align-items: center;
    }

    .cart-item-emoji {
      font-size: 2.2rem;
      flex-shrink: 0;
    }

    .cart-item-info {
      flex: 1;
    }

    .cart-item-name {
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 0.3rem;
    }

    .cart-item-price {
      font-size: 0.9rem;
      font-weight: 700;
      color: var(--blue-accent);
    }

    .cart-qty {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .qty-btn {
      width: 26px;
      height: 26px;
      border: 1.5px solid var(--gray-200);
      background: var(--white);
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
      font-weight: 700;
    }

    .qty-btn:hover {
      background: var(--gray-100);
      border-color: var(--gray-400);
    }

    .qty-num {
      font-size: 0.9rem;
      font-weight: 700;
      min-width: 18px;
      text-align: center;
    }

    .remove-item {
      font-size: 1rem;
      cursor: pointer;
      color: var(--gray-400);
      background: none;
      border: none;
      padding: 0.2rem;
      transition: var(--transition);
    }

    .remove-item:hover {
      color: var(--red);
    }

    .cart-empty {
      text-align: center;
      padding: 3rem 1rem;
      color: var(--gray-400);
    }

    .cart-empty .empty-icon {
      font-size: 4rem;
      margin-bottom: 1rem;
    }

    .cart-empty p {
      font-size: 0.95rem;
    }

    .cart-footer {
      padding: 1.2rem 1.5rem;
      border-top: 2px solid var(--gray-100);
    }

    .cart-total {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .total-label {
      font-size: 0.9rem;
      color: var(--gray-700);
    }

    .total-amount {
      font-family: 'Syne', sans-serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--gray-900);
    }

    .checkout-btn {
      width: 100%;
      background: var(--blue-deep);
      color: var(--white);
      border: none;
      padding: 1rem;
      border-radius: var(--radius-sm);
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
      font-family: 'DM Sans', sans-serif;
    }

    .checkout-btn:hover {
      background: var(--blue-accent);
    }

    /* ===== LOGIN MODAL ===== */
    .login-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 200;
      align-items: center;
      justify-content: center;
    }

    .login-overlay.open {
      display: flex;
    }

    .login-panel {
      background: var(--white);
      width: 400px;
      max-width: 90vw;
      border-radius: var(--radius-md);
      display: flex;
      flex-direction: column;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      animation: popIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
    }

    @keyframes popIn {
      from {
        transform: scale(0.9);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .login-header {
      background: var(--yellow);
      padding: 1.2rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .login-header h2 {
      font-family: 'Syne', sans-serif;
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--blue-deep);
    }

    .login-body {
      padding: 2rem 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .form-group label {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--gray-700);
    }

    .form-group input {
      padding: 0.8rem 1rem;
      border: 1px solid var(--gray-200);
      border-radius: var(--radius-sm);
      font-size: 0.95rem;
      outline: none;
      transition: var(--transition);
      font-family: 'DM Sans', sans-serif;
    }

    .form-group input:focus {
      border-color: var(--blue-accent);
    }

    .login-btn {
      background: var(--blue-deep);
      color: var(--white);
      border: none;
      padding: 1rem;
      border-radius: var(--radius-sm);
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
      font-family: 'DM Sans', sans-serif;
      margin-top: 0.5rem;
    }

    .login-btn:hover {
      background: var(--blue-accent);
    }

    .login-footer {
      text-align: center;
      font-size: 0.85rem;
      color: var(--gray-700);
      padding-bottom: 2rem;
    }

    .login-footer a {
      color: var(--blue-accent);
      font-weight: 600;
      text-decoration: none;
    }

    /* ===== FAV MODAL ===== */
    .fav-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 200;
      align-items: flex-start;
      justify-content: flex-end;
    }

    .fav-overlay.open {
      display: flex;
    }

    .fav-panel {
      background: var(--white);
      width: 400px;
      max-width: 100vw;
      height: 100vh;
      display: flex;
      flex-direction: column;
      box-shadow: -8px 0 40px rgba(0, 0, 0, 0.15);
      animation: slideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fav-header {
      background: var(--yellow);
      padding: 1.2rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .fav-header h2 {
      font-family: 'Syne', sans-serif;
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--blue-deep);
    }

    .fav-items {
      flex: 1;
      overflow-y: auto;
      padding: 1rem 1.5rem;
    }

    /* ===== TOAST ===== */
    .toast-container {
      position: fixed;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      z-index: 999;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      align-items: center;
    }

    .toast {
      background: var(--blue-deep);
      color: white;
      padding: 0.7rem 1.5rem;
      border-radius: 99px;
      font-size: 0.85rem;
      font-weight: 600;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      animation: toastIn 0.3s ease, toastOut 0.3s ease 2.2s forwards;
      white-space: nowrap;
    }

    @keyframes toastIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes toastOut {
      from {
        opacity: 1;
      }

      to {
        opacity: 0;
      }
    }

    /* ===== FOOTER ===== */
    footer {
      background: var(--blue-deep);
      color: rgba(255, 255, 255, 0.65);
      padding: 3rem 2rem 1.5rem;
      margin-top: 3rem;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 2rem;
      max-width: 1400px;
      margin: 0 auto 2rem;
    }

    .footer-col h4 {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      color: var(--yellow);
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .footer-col a {
      display: block;
      font-size: 0.83rem;
      margin-bottom: 0.5rem;
      color: rgba(255, 255, 255, 0.55);
      cursor: pointer;
      text-decoration: none;
      transition: var(--transition);
    }

    .footer-col a:hover {
      color: var(--white);
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 1.2rem;
      text-align: center;
      font-size: 0.78rem;
      color: rgba(255, 255, 255, 0.35);
      max-width: 1400px;
      margin: 0 auto;
    }

    .footer-logo {
      font-family: 'Syne', sans-serif;
      font-size: 1.4rem;
      font-weight: 800;
      color: var(--yellow);
      margin-bottom: 0.5rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .hero {
        flex-direction: column;
        padding: 2rem 1.2rem;
        min-height: auto;
      }

      .hero-image {
        display: none;
      }

      .hero h1 {
        font-size: 2rem;
      }

      .promo-grid {
        grid-template-columns: 1fr;
      }

      .nav-top {
        padding: 0 0.5rem;
        gap: 0.6rem;
      }

      .logo {
        font-size: 1.1rem;
      }

      .section {
        padding: 1.5rem 1rem;
      }

      .deals-strip {
        margin: 0 -1rem;
        padding: 1.5rem 1rem;
      }
    }
  </style>
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="nav-top">
      <a href="index.php" class="logo">Merca<span>Shop</span></a>
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Buscar productos, marcas y más...">
        <button onclick="doSearch()">🔍</button>
      </div>
      <div class="nav-actions">
        <button class="nav-btn" onclick="openCart()">
          <span class="nav-icon">🛒</span>
          <span>Carrito</span>
          <span class="cart-badge" id="cartBadge">0</span>
        </button>
        <button class="nav-btn" onclick="openFavorites()">
          <span class="nav-icon">❤️</span>
          <span>Favoritos</span>
        </button>
        <?php if(function_exists('isLoggedIn') && isLoggedIn()): ?>
          <a href="<?= isAdmin() ? 'admin/index.php' : 'index.php' ?>" class="nav-btn" style="text-decoration: none;">
            <span class="nav-icon">👤</span>
            <span><?= htmlspecialchars($_SESSION['nombre']) ?></span>
          </a>
          <a href="logout.php" class="nav-btn" style="text-decoration: none; color: var(--red);">
            <span class="nav-icon">🚪</span>
            <span>Salir</span>
          </a>
        <?php else: ?>
          <button class="nav-btn" onclick="openLogin()">
            <span class="nav-icon">👤</span>
            <span>Ingresar</span>
          </button>
        <?php endif; ?>
      </div>
    </div>
    <div class="nav-bottom">
      <a href="index.php" class="nav-cat active">📦 Todas las categorías</a>
      <a href="#" class="nav-cat">📱 Tecnología</a>
      <a href="#" class="nav-cat">👗 Moda</a>
      <a href="#" class="nav-cat">🏠 Hogar</a>
      <a href="#" class="nav-cat">⚽ Deporte</a>
      <a href="#" class="nav-cat">🎮 Gaming</a>
      <a href="#" class="nav-cat">🚗 Autos</a>
      <a href="#" class="nav-cat">🎁 Ofertas</a>
      <a href="#" class="nav-cat">⭐ Top ventas</a>
    </div>
  </nav>

  