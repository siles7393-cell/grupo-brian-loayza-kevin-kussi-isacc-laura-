<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Credenciales incorrectas.';
    }
}
?>

<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body>
<h2>Iniciar sesión</h2>
<?php if($error) echo "<p style='color:red;'>".e($error)."</p>"; ?>
<form method="post">
<label>Email:<br><input type="email" name="email" required></label><br><br>
<label>Contraseña:<br><input type="password" name="password" required></label><br><br>
<button type="submit">Entrar</button>
</form>
<p><a href="index.php">Volver al chat</a></p>
</body>
</html>
