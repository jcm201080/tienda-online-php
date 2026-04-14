<?php
session_start();
require_once "config/db.php";
?>
<?php require_once "views/partials/header.php"; ?>
<?php
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<h2>⚠️ No hay productos en el carrito</h2>";
    echo "<a href='index.php'>Volver a la tienda</a>";
    exit;
}
require_once "config/db.php";

$usuario_id = $_SESSION['usuario']['id'];
$nombre = $_SESSION['usuario']['nombre'];
$direccion = $_POST['direccion'] ?? $_SESSION['usuario']['direccion'];

$carrito = $_SESSION['carrito'];

$total = 0;

// Calcular total
foreach ($carrito as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

// Insertar pedido
$sql = "INSERT INTO pedidos (nombre, direccion, total, usuario_id)
VALUES ('$nombre', '$direccion', $total, $usuario_id)";

$conn->query($sql);

$pedido_id = $conn->insert_id;

// Insertar detalle
foreach ($carrito as $producto) {
    $id_producto = $producto['id'];
    $cantidad = $producto['cantidad'];
    $precio = $producto['precio'];

    $sql = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio)
            VALUES ($pedido_id, $id_producto, $cantidad, $precio)";

    $conn->query($sql);
}

// Vaciar carrito
unset($_SESSION['carrito']);

echo "<h1>✅ Pedido realizado correctamente</h1>";
echo "<a href='index.php'>Volver a la tienda</a>";
?>

<?php require_once "views/partials/footer.php"; ?>