<?php
include 'conexion.php';

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    $sql_delete = "DELETE FROM Productos WHERE id_producto='$id_producto'";

    if ($conn->query($sql_delete) === TRUE) {
        header("Location: inventario.php?mensaje=Producto eliminado correctamente");
    } else {
        header("Location: inventario.php?mensaje=Error al eliminar el producto");
    }
}

$conn->close();
exit();
?>
