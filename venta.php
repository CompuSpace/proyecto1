<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header("Location: login.php?error=Debe iniciar sesión");
    exit();
}
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script>
        function cargarFechaHora() {
            var ahora = new Date();
            document.getElementById("fecha").value = ahora.toISOString().slice(0, 10);
            document.getElementById("hora").value = ahora.toTimeString().slice(0, 8);
        }

        function agregarProducto() {
            let contenedor = document.getElementById("productos");
            let index = contenedor.children.length;

            let nuevoProducto = document.createElement("div");
            nuevoProducto.innerHTML = `
                <label>Producto:</label>
                <select name="producto_id[]" required>
                    <?php
                    $sql = "SELECT id_producto, nombre, cantidad FROM Productos WHERE cantidad > 0";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_producto'] . "'>" . $row['nombre'] . " (Stock: " . $row['cantidad'] . ")</option>";
                    }
                    ?>
                </select>

                <label>Cantidad:</label>
                <input type="number" name="cantidad[]" min="1" required>

                <label>Precio Unitario:</label>
                <input type="number" name="precio[]" step="0.01" required>

                <button type="button" onclick="this.parentNode.remove();">Eliminar</button>
                <br><br>
            `;
            contenedor.appendChild(nuevoProducto);
        }
    </script>
</head>
<body onload="cargarFechaHora()">

    <h2>Registrar Venta</h2>
    <form action="registrar_venta.php" method="post">
    <div class=contenedor_venta>
        <div class=form_venta>
        <!-- Contenedor de productos -->
          <div id="productos">
            <h3>Productos</h3>
          </div>
          <button type="button" onclick="agregarProducto()">Agregar Producto</button>
        </div>
        <div class=form_venta2>
        <!-- Fecha y hora automáticas -->
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" readonly><br><br>

        <label for="hora">Hora:</label>
        <input type="text" id="hora" name="hora" readonly><br><br>

        <!-- ID Empleado desde la sesión -->
        <label for="empleado_id">Empleado:</label>
        <input type="text" id="empleado_id" name="empleado_id" value="<?php echo $_SESSION['empleado_id']; ?>" readonly><br><br>
        
        </div>
        <div class=boton>
        <button type="submit">Registrar Venta</button>
        </div>
        </div>
    </form>
    <br><a href="index.php">Volver al Inicio</a>

</body>
</html>

<?php
$conn->close();
?>

