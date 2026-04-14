<?php
session_start();
require_once "config/db.php";

// 🔐 SOLO ADMIN
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
    exit;
}

$busqueda = $_GET['buscar'] ?? '';
?>

<?php require_once "views/partials/header.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css">

<div class="admin-menu">
    <a href="admin.php">📊 Dashboard</a>
    <a href="admin_productos.php">📦 Productos</a>
    <a href="admin_clientes.php">👥 Clientes</a>
</div>

<div class="admin-container">

<h1 class="admin-title">👥 Gestión de clientes</h1>

<form method="GET" style="margin-bottom:20px; display:flex; gap:10px;">
    <input type="text" name="buscar" placeholder="Buscar cliente..."
        value="<?= $busqueda ?>">

    <button class="btn">🔍 Buscar</button>
    <a href="admin_clientes.php" class="btn">❌ Limpiar</a>
</form>

<div class="tabla-wrapper">
<table class="tabla-pedidos">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Pedidos</th>
        <th>Total gastado</th>
        <th>Acciones</th>
    </tr>

<?php

$where = [];

if (!empty($busqueda)) {
    $b = $conn->real_escape_string($busqueda);
    $where[] = "u.nombre LIKE '%$b%' OR u.email LIKE '%$b%'";
}

$sql = "
SELECT 
    u.id,
    u.nombre,
    u.email,
    COUNT(p.id) as total_pedidos,
    COALESCE(SUM(p.total),0) as total_gastado
FROM usuarios u
LEFT JOIN pedidos p ON u.id = p.usuario_id
WHERE u.rol != 'admin'
";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " GROUP BY u.id ORDER BY u.id DESC";

$result = $conn->query($sql);

while($c = $result->fetch_assoc()) {
?>

<tr>
    <td><?= $c['id'] ?></td>
    <td><?= $c['nombre'] ?></td>
    <td><?= $c['email'] ?></td>
    <td><?= $c['total_pedidos'] ?></td>
    <td>
        <?= number_format($c['total_gastado'], 2) ?> €
        <?php if($c['total_gastado'] > 1000): ?>
            <span style="color:green; font-weight:bold;"> 🏆 VIP</span>
        <?php endif; ?>
    </td>

    <td>
        <a href="cliente_detalle.php?id=<?= $c['id'] ?>" class="btn">
            Ver
        </a>
    </td>
</tr>

<?php } ?>

</table>
</div>
</div>

<?php require_once "views/partials/footer.php"; ?>