<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['empleado_id'])) {
    header("Location: login.html");
    exit();
}

// Solo permite acceso a Administradores
if ($_SESSION['cargo'] !== 'Administrador') {
    header("Location: dashboard.php?mensaje=Acceso denegado");
    exit();
}
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $cargo = $_POST['cargo'];
    $contraseña =$_POST['contraseña'];

    $sql = "INSERT INTO Empleados (nombre, apellido, cedula, cargo, contraseña) 
            VALUES ('$nombre', '$apellido', '$cedula', '$cargo', '$contraseña')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?mensaje=Empleado registrado correctamente");
    } else {
        header("Location: index.php?mensaje=Error al registrar el empleado");
    }
}

$conn->close();
exit();
?>

