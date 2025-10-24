<?php
// guest_init.php - asigna guest_name a la sesión si no hay user
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['guest_name'])) {
        $_SESSION['guest_name'] = 'Guest-' . random_int(1000, 9999);
        $_SESSION['guest_created'] = time();
    }
}
?>
<?php
// config.php - configuración y conexión PDO