<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<body>

<h1>Bienvenido al Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
<p>Este es un dashboard de ejemplo.</p>
<a href="logout.php">Cerrar sesión</a>

</body>
</html>
