<?php
require_once "config/db.php";

$id = intval($_GET['id']);

// Pedido
$sql = "SELECT * FROM pedidos WHERE id = $id";
$res = $conn->query($sql);
$pedido = $res->fetch_assoc();

if (!$pedido) {
    echo "Pedido no encontrado";
    exit;
}

// Productos
$sql_det = "SELECT d.*, p.nombre 
            FROM detalle_pedido d
            JOIN productos p ON d.producto_id = p.id
            WHERE d.pedido_id = $id";

$res_det = $conn->query($sql_det);
?>

<h1>🧾 Factura Pedido #<?= $pedido['id'] ?></h1>

<p><strong>Cliente:</strong> <?= $pedido['nombre'] ?></p>
<p><strong>Fecha:</strong> <?= $pedido['fecha'] ?></p>
<p><strong>Dirección:</strong> <?= $pedido['direccion'] ?></p>

<hr>

<table border="1" cellpadding="8">
<tr>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Total</th>
</tr>

<?php
while($d = $res_det->fetch_assoc()) {
    $total = $d['cantidad'] * $d['precio'];
    echo "<tr>
        <td>{$d['nombre']}</td>
        <td>{$d['cantidad']}</td>
        <td>{$d['precio']}€</td>
        <td>{$total}€</td>
    </tr>";
}
?>

</table>

<h2>Total: <?= $pedido['total'] ?> €</h2>

<br>
<button onclick="window.print()">🖨️ Imprimir</button>