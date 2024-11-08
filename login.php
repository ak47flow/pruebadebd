<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="css/login-style.css">
</head>
<body>
<?php
// Iniciar la sesión
session_start();

// Incluir el archivo de conexión a la base de datos
include '../controller/bdconexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para buscar el usuario
    $sql = "SELECT * FROM distribuidores WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Comparar contraseñas (sin encriptación para este ejemplo)
        if ($password == $row['password']) {
            // Iniciar sesión y redirigir al dashboard
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="container">
    <div class="card">
      <h2 class="card-title">Iniciar sesión</h2>
      
      <!-- Formulario de Login -->
      <form action="login.php" method="POST" class="card-content">
        <div class="input-group">
          <label for="username">Usuario:</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="submit-button">Iniciar sesión</button>
      </form>
    </div>
</div>

</body>
</html>
