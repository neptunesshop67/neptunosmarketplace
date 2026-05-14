<?php
require_once __DIR__ . '/db.php';

$active = basename($_SERVER['PHP_SELF']);
$pageTitle = $pageTitle ?? 'MercaShop Raspberry Pi Marketplace';
$cartCount = cartItemCount();
$user = getCurrentUser($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Marketplace local optimizado para Raspberry Pi con PHP y MariaDB.">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body { min-height: 100vh; }
  </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">
<header class="w-full shadow-sm sticky top-0 z-30 flex flex-col">
  <!-- Purple Top Bar -->
  <div class="bg-[#8b5cf6] w-full py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-3">
      <a href="index.php" class="flex items-center gap-2 text-white font-bold text-2xl tracking-tight">
        <span class="inline-block text-3xl">🛒</span>
        MercaShop
      </a>
      
      <!-- Amazon Style Search Bar -->
      <div class="flex-1 max-w-2xl hidden md:flex rounded-md overflow-hidden shadow-sm border border-transparent focus-within:border-[#3483fa]">
        <input type="text" class="w-full px-4 py-2 text-slate-900 focus:outline-none" placeholder="Buscar productos, marcas y más...">
        <button class="bg-white border-l border-slate-200 px-4 py-2 hover:bg-slate-50">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </button>
      </div>

      <div class="flex items-center gap-4">
        <?php if ($user): ?>
          <span class="text-white text-sm hidden sm:inline-block">Hola, <b><?= htmlspecialchars($user['nombre']) ?></b></span>
          <a href="logout.php" class="text-sm font-semibold text-white hover:text-slate-200">Salir</a>
        <?php else: ?>
          <a href="login.php" class="text-sm font-semibold text-white hover:text-slate-200">Ingresar</a>
          <a href="registro.php" class="text-sm font-semibold text-white hover:text-slate-200">Mis compras</a>
        <?php endif; ?>
        <a href="cart.php" class="flex items-center gap-1 text-white hover:text-slate-200">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
          </svg>
          <span class="font-bold"><?= $cartCount ?></span>
        </a>
      </div>
    </div>
  </div>

  <!-- Amazon Dark Sub Nav -->
  <div class="bg-[#232f3e] w-full text-sm text-white py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center gap-4">
      <a href="index.php" class="flex items-center gap-1 hover:border-white border border-transparent px-2 py-1 rounded-sm <?= $active === 'index.php' ? 'font-bold' : '' ?>">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
        Todo
      </a>
      <a href="ofertas.php" class="hover:border-white border border-transparent px-2 py-1 rounded-sm <?= $active === 'ofertas.php' ? 'font-bold' : '' ?>">Ofertas</a>
      <a href="top_ventas.php" class="hover:border-white border border-transparent px-2 py-1 rounded-sm <?= $active === 'top_ventas.php' ? 'font-bold' : '' ?>">Más vendidos</a>
      <a href="categoria.php?slug=tech" class="hover:border-white border border-transparent px-2 py-1 rounded-sm">Tecnología</a>
      <a href="categoria.php?slug=hogar" class="hover:border-white border border-transparent px-2 py-1 rounded-sm">Hogar</a>
      <a href="categoria.php?slug=deporte" class="hover:border-white border border-transparent px-2 py-1 rounded-sm">Deporte</a>
    </div>
  </div>
</header>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
