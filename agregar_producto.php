<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $sql_insert = "INSERT INTO Productos (nombre, descripcion, precio, cantidad) VALUES ('$nombre', '$descripcion', '$precio', '$cantidad')";

    if ($conn->query($sql_insert) === TRUE) {
        header("Location: inventario.php?mensaje=Producto agregado correctamente");
    } else {
        header("Location: inventario.php?mensaje=Error al agregar el producto");
    }
}

$conn->close();
exit();
?>
