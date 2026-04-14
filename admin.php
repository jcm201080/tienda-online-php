<?php
session_start();
require_once "config/db.php";

$filtro = $_GET['filtro'] ?? '';

// 🔐 SOLO ADMIN
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
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

<h1 class="admin-title">🛠️ Panel de administración</h1>
<form method="GET" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

    <!-- 🔍 BUSCAR CLIENTE -->
    <input type="text" name="cliente" placeholder="Buscar cliente..."
        value="<?= $_GET['cliente'] ?? '' ?>">

    <!-- FILTRO -->
    <select name="filtro">
        <option value="">Todos</option>

        <option value="pendiente" <?= ($filtro=='pendiente') ? 'selected' : '' ?>>
            Pendientes
        </option>

        <option value="enviado" <?= ($filtro=='enviado') ? 'selected' : '' ?>>
            Enviados
        </option>

        <option value="pagado" <?= ($filtro=='pagado') ? 'selected' : '' ?>>
            Pagados
        </option>

        <!-- 🆕 NUEVO -->
        <option value="no_pagado" <?= ($filtro=='no_pagado') ? 'selected' : '' ?>>
            No pagados
        </option>
    </select>

    <button class="btn">🔍 Filtrar</button>

    <!-- RESET -->
    <a href="admin.php" class="btn">❌ Limpiar</a>

</form>
<?php
// TOTAL GANADO (solo pagados)
$sql_total = "SELECT SUM(total) as total FROM pedidos WHERE pago='pagado'";
$res_total = $conn->query($sql_total);
$total_ganado = $res_total->fetch_assoc()['total'] ?? 0;

// PEDIDOS PENDIENTES
$sql_pend = "SELECT COUNT(*) as total FROM pedidos WHERE estado='pendiente'";
$res_pend = $conn->query($sql_pend);
$pendientes = $res_pend->fetch_assoc()['total'];

// PEDIDOS NO PAGADOS
$sql_nopago = "SELECT COUNT(*) as total FROM pedidos WHERE pago='no_pagado'";
$res_nopago = $conn->query($sql_nopago);
$no_pagados = $res_nopago->fetch_assoc()['total'];
?>

<div class="tabla-wrapper">
<table class="tabla-pedidos">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Productos</th>
        <th>Pago</th>
        <th>Acción</th>
        <th>Detalles</th>
    </tr>

<?php


$where = [];

/* FILTRO ESTADO */
if ($filtro == 'pendiente' || $filtro == 'enviado') {
    $where[] = "estado = '$filtro'";
}

/* FILTRO PAGADO */
if ($filtro == 'pagado') {
    $where[] = "pago = 'pagado'";
}

/* 🆕 FILTRO NO PAGADO */
if ($filtro == 'no_pagado') {
    $where[] = "pago = 'no_pagado'";
}

/* 🔍 BUSCAR CLIENTE */
if (!empty($_GET['cliente'])) {
    $cliente = $conn->real_escape_string($_GET['cliente']);
    $where[] = "usuarios.nombre LIKE '%$cliente%'";
}

/* QUERY FINAL */
$sql = "SELECT pedidos.*, usuarios.nombre 
        FROM pedidos
        LEFT JOIN usuarios ON pedidos.usuario_id = usuarios.id";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY fecha DESC";

$resultado = $conn->query($sql);

while($pedido = $resultado->fetch_assoc()) {
?>

<tr>
    <td><?php echo $pedido['id']; ?></td>
    <td><?php echo $pedido['nombre']; ?></td>
    <td><?php echo $pedido['total']; ?>€</td>

    <td>
        <span class="estado <?php echo $pedido['estado']; ?>">
            <?php echo $pedido['estado']; ?>
        </span>
    </td>

    <td>
        <?php
        $sql_detalles = "SELECT d.*, p.nombre 
                         FROM detalle_pedido d
                         JOIN productos p ON d.producto_id = p.id
                         WHERE d.pedido_id = " . $pedido['id'];

        $res_det = $conn->query($sql_detalles);

        while($d = $res_det->fetch_assoc()) {
            echo $d['nombre'] . " (" . $d['cantidad'] . ")<br>";
        }
        ?>
    </td>
    <td>
        <span class="estado <?php echo $pedido['pago']; ?>">
            <?php echo $pedido['pago']; ?>
        </span>
    </td>
    <td>
        <form action="cambiar_estado.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $pedido['id']; ?>">
            <button class="btn enviar">Envio</button>
        </form>
        <br>
        <form action="cambiar_pago.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $pedido['id']; ?>">
            <button class="btn pago">Pago</button>
        </form>
    </td>
    <td>
        <a href="detalle_pedido.php?id=<?php echo $pedido['id']; ?>" class="btn">
            Ver
        </a>
    </td>
</tr>

<?php } ?>
<div class="dashboard">
    <div class="card">
        💸 Total ganado<br>
        <strong><?php echo $total_ganado; ?> €</strong>
    </div>

    <div class="card">
        📦 Pedidos pendientes<br>
        <strong><?php echo $pendientes; ?></strong>
    </div>

    <div class="card">
        ⚠️ No pagados<br>
        <strong><?php echo $no_pagados; ?></strong>
    </div>
</div>
</table>
</div>
</div>

<?php require_once "views/partials/footer.php"; ?>