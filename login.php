<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['cedula'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM Empleados WHERE cedula = '$cedula'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        
        echo "<pre>";
        var_dump($fila);
        echo "</pre>";

        if ($contraseña == $fila['contraseña']) {
            $_SESSION['empleado_id'] = $fila['id_empleado'];
            $_SESSION['nombre'] = $fila['nombre'];
            $_SESSION['cargo'] = $fila['cargo'];

            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}

$conn->close();
?>


