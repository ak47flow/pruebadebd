<?php
// Datos de conexión proporcionados por Railway
$servername = "meleko.railway.internal"; // MYSQLHOST
$username = "root";                     // MYSQLUSER
$password = "VEXaKqQRHGUTRcDAjMFDtHATEMZtBOgY"; // MYSQLPASSWORD
$dbname = "railway";                    // MYSQLDATABASE
$port = 3306;                           // MYSQLPORT

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
