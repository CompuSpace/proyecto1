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

// Obtener productos
$sql_productos = "SELECT id_producto, nombre, descripcion, precio, cantidad FROM Productos ORDER BY nombre ASC";
$result_productos = $conn->query($sql_productos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Productos</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>

    <h1>Inventario de Productos</h1>

    <!-- Formulario para agregar un nuevo producto -->
    

    <!-- Tabla con productos existentes -->
    <h2>Lista de Productos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result_productos->fetch_assoc()) { ?>
            <tr>
                <form action="actualizar_producto.php" method="POST">
                    <td><?php echo $row['id_producto']; ?></td>
                    <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                    <td><input type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>"></td>
                    <td><input type="number" step="0.01" name="precio" value="<?php echo $row['precio']; ?>"></td>
                    <td><input type="number" name="cantidad" value="<?php echo $row['cantidad']; ?>"></td>
                    <td>
                        <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                        <button type="submit">Actualizar</button>
                        <a href="eliminar_producto.php?id_producto=<?php echo $row['id_producto']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar</a>
                    </td>
                </form>
            </tr>
        <?php } ?>
    </table>
<div class=container>
    <h2>Agregar Producto</h2>
    <form action="agregar_producto.php" method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <label>Descripción:</label>
        <input type="text" name="descripcion">
        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required>
        <label>Cantidad:</label>
        <input type="number" name="cantidad" required>
        <button type="submit">Agregar</button>
    </form>
    </div>
    <br>
    <a href="index.php">Volver al Inicio</a>

</body>
</html>

<?php
$conn->close();
?>
<?php
include 'conexion.php';

// Verificar si hay un mensaje en la URL y mostrarlo
if (isset($_GET['mensaje'])) {
    echo "<script>alert('" . htmlspecialchars($_GET['mensaje']) . "');</script>";
}

// Obtener productos
$sql_productos = "SELECT id_producto, nombre, descripcion, precio, cantidad FROM Productos ORDER BY nombre ASC";
$result_productos = $conn->query($sql_productos);
?>
