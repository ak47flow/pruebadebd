<?php
// Iniciar sesión para manejar la autenticación
session_start();

// Incluir el archivo de conexión a la base de datos
include 'bdconexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($user_name && $password) {
        // Preparar la consulta SQL para buscar el distribuidor por nombre de usuario
        $sql = "SELECT * FROM distribuidores WHERE user_name = ?";
        $stmt = $conn->prepare($sql);

        // Verificar que la consulta se haya preparado correctamente
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si el nombre de usuario existe en la base de datos
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verificar la contraseña usando password_verify
            if (password_verify($password, $row['password'])) {
                // Establecer las variables de sesión
                $_SESSION['distribuidor_id'] = $row['id'];
                $_SESSION['nombre'] = $row['nombre'];

                // Redirigir al usuario a la página principal o de dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "No se encontró una cuenta con ese usuario.";
        }

        // Cerrar la conexión y liberar recursos
        $stmt->close();
    } else {
        $error = "Por favor, completa todos los campos.";
    }

    $conn->close();
}

// Mostrar el mensaje de error en caso de fallo
if (isset($error)) {
    echo "<p style='color: red; text-align: center;'>$error</p>";
}
?>
