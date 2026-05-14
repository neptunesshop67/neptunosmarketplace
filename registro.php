<?php
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$nombre = '';
$email = '';
$blink = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $blink = isset($_POST['blink_galaxy']) ? 1 : 0;

    if ($nombre === '' || $email === '' || $password === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = 'Completa el formulario con datos válidos. La contraseña debe tener al menos 6 caracteres.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'El correo ya está registrado.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, password, rol, blink_galaxy) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$nombre, $email, $passwordHash, 'comprador', $blink]);
            session_regenerate_id(true);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['nombre'] = $nombre;
            $_SESSION['role'] = 'comprador';
            $_SESSION['blink_galaxy'] = $blink;
            header('Location: index.php');
            exit;
        }
    }
}

$pageTitle = 'Registro | MercaShop';
require_once 'includes/header.php';
?>

<div class="flex min-h-[70vh] items-center justify-center">
  <div class="w-full max-w-xl rounded-3xl bg-white p-8 shadow-sm">
    <h1 class="text-3xl font-bold text-slate-900">Crear cuenta</h1>
    <p class="mt-2 text-slate-600">Regístrate para comprar en el marketplace local.</p>
    <?php if ($error): ?>
      <div class="mt-6 rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" class="mt-6 space-y-4">
      <div>
        <label class="block text-sm font-medium text-slate-700">Nombre completo</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700">Correo electrónico</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700">Contraseña</label>
        <input type="password" name="password" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900" required>
      </div>
      <label class="flex items-center gap-3 text-slate-700">
        <input type="checkbox" name="blink_galaxy" value="1" <?= $blink ? 'checked' : '' ?> class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
        Tengo cuenta en Blink Galaxy y quiero recompensa.
      </label>
      <button type="submit" class="w-full rounded-3xl bg-cyan-600 px-6 py-3 text-white font-semibold hover:bg-cyan-700">Registrarme</button>
    </form>
    <p class="mt-6 text-center text-sm text-slate-500">¿Ya tienes cuenta? <a href="login.php" class="font-semibold text-cyan-600 hover:underline">Ingresar</a></p>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
