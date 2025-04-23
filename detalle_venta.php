<?php
include 'conexion.php';

if (isset($_GET['id_venta'])) {
    $id_venta = $_GET['id_venta'];

    // Obtener información de la venta
    $sql_venta = "SELECT V.id_venta, V.fecha, V.total, E.nombre AS empleado 
                  FROM Ventas V
                  JOIN Empleados E ON V.empleado_id = E.id_empleado
                  WHERE V.id_venta = $id_venta";
    $result_venta = $conn->query($sql_venta);
    $venta = $result_venta->fetch_assoc();

    // Obtener detalles de la venta
    $sql_detalle = "SELECT P.nombre AS producto, DV.cantidad, DV.precio_unitario, DV.subtotal
                    FROM Detalle_Ventas DV
                    JOIN Productos P ON DV.producto_id = P.id_producto
                    WHERE DV.venta_id = $id_venta";
    $result_detalle = $conn->query($sql_detalle);
} else {
    die("ID de venta no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Venta</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
    <h1>Detalle de Venta #<?php echo $venta['id_venta']; ?></h1>
    <p><strong>Fecha:</strong> <?php echo $venta['fecha']; ?></p>
    <p><strong>Empleado:</strong> <?php echo $venta['empleado']; ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($venta['total'], 2); ?></p>

    <h2>Productos Vendidos</h2>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
        <?php while ($row = $result_detalle->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['producto']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td>$<?php echo number_format($row['precio_unitario'], 2); ?></td>
                <td>$<?php echo number_format($row['subtotal'], 2); ?></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <button onclick="window.close();">Cerrar</button>
</body>
</html>

<?php
$conn->close();
?>
