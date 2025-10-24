<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido.';
    } elseif (strlen($username) < 3) {
        $error = 'El nombre debe tener al menos 3 caracteres.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$email, $username, $hash]);

            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;

            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate') !== false) {
                $error = 'Email o nombre de usuario ya existe.';
            } else {
                $error = 'Error al registrar usuario.';
            }
        }
    }
}
?>

<!doctype html>
<html>
<head><meta charset="utf-8"><title>Registro</title></head>
<body>
<h2>Registro</h2>
<?php if($error) echo "<p style='color:red;'>".e($error)."</p>"; ?>
<form method="post">
<label>Email:<br><input type="email" name="email" required></label><br><br>
<label>Nombre:<br><input type="text" name="username" required minlength="3"></label><br><br>
<label>Contraseña:<br><input type="password" name="password" required minlength="6"></label><br><br>
<button type="submit">Registrar</button>
</form>
<p><a href="index.php">Volver al chat</a></p>
</body>
</html>
