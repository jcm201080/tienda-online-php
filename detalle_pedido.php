<?php session_start(); ?>
<?php require_once "views/partials/header.php"; ?>
<?php require_once "config/db.php"; ?>

<?php
$id = $_GET['id'];

$sql = "SELECT * FROM pedidos WHERE id=$id";
$pedido = $conn->query($sql)->fetch_assoc();
?>

<div class="detalle-container">

<h1>📦 Pedido #<?php echo $pedido['id']; ?></h1>

<p><strong>Cliente:</strong> <?php echo $pedido['nombre']; ?></p>
<p><strong>Dirección:</strong> <?php echo $pedido['direccion']; ?></p>
<p><strong>Total:</strong> <?php echo $pedido['total']; ?>€</p>

<h3>🪵 Productos:</h3>

<?php
$sql_detalles = "SELECT d.*, p.nombre 
                 FROM detalle_pedido d
                 JOIN productos p ON d.producto_id = p.id
                 WHERE d.pedido_id = $id";

$res = $conn->query($sql_detalles);

while($d = $res->fetch_assoc()) {
    echo "<p>" . $d['nombre'] . " x " . $d['cantidad'] . "</p>";
}
?>

<br>
<a href="admin.php">⬅️ Volver</a>

</div>

<?php require_once "views/partials/footer.php"; ?>