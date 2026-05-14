<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $password]);
        
        // Auto login
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['nombre'] = $nombre;
        $_SESSION['role'] = 'cliente';

        header("Location: index.php");
        exit;
    } catch (\PDOException $e) {
        $error = "El correo ya está registrado o hubo un error.";
    }
}

require_once 'includes/header.php';
?>

<div class="section" style="max-width: 400px; margin: 4rem auto; background: var(--white); padding: 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-card);">
    <h2 style="text-align:center; color: var(--blue-deep); margin-bottom: 1.5rem;">Crear Cuenta</h2>
    
    <?php if(isset($error)): ?>
        <div style="background: #ffe4e4; color: var(--red); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group" style="margin-bottom: 1rem;">
            <label>Nombre completo</label>
            <input type="text" name="nombre" required placeholder="Juan Pérez">
        </div>
        <div class="form-group" style="margin-bottom: 1rem;">
            <label>Correo electrónico</label>
            <input type="email" name="email" required placeholder="ejemplo@correo.com">
        </div>
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label>Contraseña</label>
            <input type="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn-primary" style="width: 100%;">Registrarme</button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem; font-size: 0.85rem;">
        ¿Ya tienes cuenta? <a href="login.php" style="color: var(--blue-accent); font-weight: 600;">Inicia sesión</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
