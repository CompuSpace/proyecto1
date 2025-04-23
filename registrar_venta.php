<?php
date_default_timezone_set('America/Bogota');
session_start();
include 'conexion.php';

if (!isset($_SESSION['empleado_id'])) {
    header("Location: login.php?error=Debe iniciar sesión");
    exit();
}

// Verificar que los datos se enviaron
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['empleado_id'], $_POST['producto_id'], $_POST['cantidad'], $_POST['precio'])
        && is_array($_POST['producto_id'])
        && is_array($_POST['cantidad'])
        && is_array($_POST['precio'])
    ) {
        // Obtener datos
        $empleado_id = $_POST['empleado_id'];
        $productos = $_POST['producto_id'];
        $cantidades = $_POST['cantidad'];
        $precios = $_POST['precio'];
        $fecha = date("Y-m-d H:i:s");

        // Calcular el total de la venta
        $total = 0;
        for ($i = 0; $i < count($productos); $i++) {
            $total += $cantidades[$i] * $precios[$i];
        }

        // Iniciar transacción
        $conn->begin_transaction();

        try {
            // Insertar la venta
            $sql = "INSERT INTO ventas (empleado_id, fecha, total) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isd", $empleado_id, $fecha, $total);
            $stmt->execute();
            $id_venta = $stmt->insert_id;

            // Insertar cada producto en detalle de venta y actualizar stock
            $sql_detalle = "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
            $stmt_detalle = $conn->prepare($sql_detalle);

            $sql_update = "UPDATE Productos SET cantidad = cantidad - ? WHERE id_producto = ?";
            $stmt_update = $conn->prepare($sql_update);

            for ($i = 0; $i < count($productos); $i++) {
                $producto_id = $productos[$i];
                $cantidad = $cantidades[$i];
                $precio_unitario = $precios[$i];

                // Insertar en detalle_venta
                $stmt_detalle->bind_param("iiid", $id_venta, $producto_id, $cantidad, $precio_unitario);
                $stmt_detalle->execute();

                // Actualizar el stock del producto
                $stmt_update->bind_param("ii", $cantidad, $producto_id);
                $stmt_update->execute();
            }

            // Confirmar transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header("Location: index.php?mensaje=Venta registrada correctamente");
            exit();
        } catch (Exception $e) {
            $conn->rollback(); // Deshacer cambios en caso de error
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Datos inválidos.";
    }
} else {
    echo "Error: No se recibió el formulario.";
}

$conn->close();
?>
