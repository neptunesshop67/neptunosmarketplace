<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('marketplace_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

$dbHost = '127.0.0.1'; // Usa 127.0.0.1 o localhost para XAMPP local
$dbName = 'marketplace_pi';
$dbUser = 'root';
$dbPass = ''; // Cambia si tu sistema MySQL usa contraseña.
$dbCharset = 'utf8mb4';

$dsn = "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo "<h1>Error de conexión</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

function isAdmin(): bool
{
    return !empty($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function cartItemCount(): int
{
    return array_sum(array_values($_SESSION['cart'] ?? []));
}

function cartTotal(PDO $pdo): float
{
    $total = 0.0;
    if (empty($_SESSION['cart'])) {
        return $total;
    }

    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, precio FROM productos WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        $qty = $_SESSION['cart'][$product['id']] ?? 0;
        $total += ((float) $product['precio']) * $qty;
    }

    return $total;
}

function getCurrentUser(PDO $pdo): ?array
{
    if (!isLoggedIn()) {
        return null;
    }
    $stmt = $pdo->prepare('SELECT id, nombre, email, rol, blink_galaxy FROM usuarios WHERE id = ? LIMIT 1');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch() ?: null;
}
