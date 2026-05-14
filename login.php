<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['role'] = $user['rol'];
        
        if ($user['rol'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}

require_once 'includes/header.php';
?>

<div class="section" style="max-width: 400px; margin: 4rem auto; background: var(--white); padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card);">
    <h2 style="text-align:center; color: var(--blue-deep); margin-bottom: 1.5rem;">👤 Iniciar sesión</h2>
    
    <?php if(isset($error)): ?>
        <div style="background: #ffe4e4; color: var(--red); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group" style="margin-bottom: 1rem;">
            <label>Correo electrónico</label>
            <input type="email" name="email" required placeholder="ejemplo@correo.com">
        </div>
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label>Contraseña</label>
            <input type="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn-primary" style="width: 100%;">Ingresar</button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem; font-size: 0.85rem;">
        ¿No tienes cuenta? <a href="registro.php" style="color: var(--blue-accent); font-weight: 600;">Regístrate</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
