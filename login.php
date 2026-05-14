<?php
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Completa todos los campos.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['role'] = $user['rol'];
            $_SESSION['blink_galaxy'] = $user['blink_galaxy'];

            header('Location: index.php');
            exit;
        }

        $error = 'Correo o contraseña incorrectos.';
    }
}

$pageTitle = 'Ingresar | MercaShop';
require_once 'includes/header.php';
?>

<div class="flex min-h-[70vh] items-center justify-center">
  <div class="w-full max-w-xl rounded-3xl bg-white p-8 shadow-sm">
    <h1 class="text-3xl font-bold text-slate-900">Iniciar sesión</h1>
    <p class="mt-2 text-slate-600">Ingresa con tu correo para acceder al marketplace.</p>
    <?php if ($error): ?>
      <div class="mt-6 rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" class="mt-6 space-y-4">
      <div>
        <label class="block text-sm font-medium text-slate-700">Correo electrónico</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900" required>
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700">Contraseña</label>
        <input type="password" name="password" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900" required>
      </div>
      <button type="submit" class="w-full rounded-3xl bg-cyan-600 px-6 py-3 text-white font-semibold hover:bg-cyan-700">Ingresar</button>
    </form>
    <p class="mt-6 text-center text-sm text-slate-500">¿No tienes cuenta? <a href="registro.php" class="font-semibold text-cyan-600 hover:underline">Regístrate</a></p>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
