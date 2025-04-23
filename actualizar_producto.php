<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $sql_update = "UPDATE Productos SET 
                    nombre='$nombre', 
                    descripcion='$descripcion', 
                    precio='$precio', 
                    cantidad='$cantidad' 
                    WHERE id_producto='$id_producto'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: inventario.php?mensaje=Producto actualizado correctamente");
    } else {
        header("Location: inventario.php?mensaje=Error al actualizar el producto");
    }
}

$conn->close();
exit();
?>
