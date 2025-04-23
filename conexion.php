<?php
$servidor = "localhost";  // Cambia si usas un servidor diferente
$usuario = "root";        // Usuario de la base de datos
$clave = "";              // Contraseña (déjala vacía si no tiene)
$base_datos = "almacen"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servidor, $usuario, $clave, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Para usar caracteres especiales en UTF-8
$conn->set_charset("utf8");
?>

