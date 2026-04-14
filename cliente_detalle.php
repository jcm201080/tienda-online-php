<?php
session_start();
require_once "config/db.php";

// 🔐 SOLO ADMIN
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);

// 👤 DATOS CLIENTE
$sql_cliente = "SELECT * FROM usuarios WHERE id = $id";
$res_cliente = $conn->query($sql_cliente);
$cliente = $res_cliente->fetch_assoc();

$sql_stats = "SELECT 
    COUNT(*) as pedidos,
    COALESCE(SUM(total),0) as total
FROM pedidos
WHERE usuario_id = $id";

$res_stats = $conn->query($sql_stats);
$stats = $res_stats->fetch_assoc();

$total_gastado = $stats['total'];
$total_pedidos = $stats['pedidos'];

if (!$cliente) {
    echo "Cliente no encontrado";
    exit;
}
?>

<?php require_once "views/partials/header.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css">
<div class="admin-menu">
    <a href="admin.php">📊 Dashboard</a>
    <a href="admin_productos.php">📦 Productos</a>
    <a href="admin_clientes.php">👥 Clientes</a>
</div>

<div class="admin-container">

<h1 class="admin-title">👤 Perfil del cliente</h1>

<div class="card" style="margin-bottom:20px;">
    <p><strong>Nombre:</strong> <?= $cliente['nombre'] ?></p>
    <p><strong>Email:</strong> <?= $cliente['email'] ?></p>
    <p><strong>Dirección:</strong> <?= $cliente['direccion'] ?? 'No definida' ?></p>
    <p><strong>Ciudad:</strong> <?= $cliente['ciudad'] ?? 'No definida' ?></p>
    <p><strong>CP:</strong> <?= $cliente['cp'] ?? 'No definido' ?></p>
</div>

<h2 class="admin-title">📦 Pedidos del cliente</h2>

<div class="dashboard">
    <div class="card">
        📦 Pedidos<br>
        <strong><?= $total_pedidos ?></strong>
    </div>

    <div class="card">
        💸 Total gastado<br>
        <strong><?= number_format($total_gastado,2) ?> €</strong>
    </div>

    <div class="card">
        🏆 Estado<br>
        <strong>
            <?= ($total_gastado > 1000) ? "VIP 🟢" : "Normal" ?>
        </strong>
    </div>
</div>

<div class="tabla-wrapper">
<table class="tabla-pedidos">
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Pago</th>
        <th>Productos</th>
        <th>Factura</th>
    </tr>

<?php

// 📦 PEDIDOS DEL CLIENTE
$nombre = $conn->real_escape_string($cliente['nombre']);

$sql_pedidos = "SELECT * FROM pedidos 
                WHERE usuario_id = $id
                ORDER BY fecha DESC";

$res_pedidos = $conn->query($sql_pedidos);

while($p = $res_pedidos->fetch_assoc()) {
?>

<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['fecha'] ?></td>
    <td><?= $p['total'] ?> €</td>

    <td>
        <span class="estado <?= $p['estado'] ?>">
            <?= $p['estado'] ?>
        </span>
    </td>

    <td>
        <span class="estado <?= $p['pago'] ?>">
            <?= $p['pago'] ?>
        </span>
    </td>

    <td>
        <?php
        $sql_det = "SELECT d.*, p.nombre 
                    FROM detalle_pedido d
                    JOIN productos p ON d.producto_id = p.id
                    WHERE d.pedido_id = " . $p['id'];

        $res_det = $conn->query($sql_det);

        while($d = $res_det->fetch_assoc()) {
            echo $d['nombre'] . " (" . $d['cantidad'] . ")<br>";
        }
        ?>
    </td>
    <td>
        <a href="factura_pedido.php?id=<?= $p['id'] ?>" class="btn">
            📄 Factura
        </a>
    </td>

</tr>

<?php } ?>

</table>
</div>

<br>
<a href="admin_clientes.php" class="btn">⬅️ Volver</a>

</div>

<?php require_once "views/partials/footer.php"; ?>