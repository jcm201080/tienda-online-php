<?php
session_start();
require_once "config/db.php";

$categorias = $conn->query("SELECT * FROM categorias");

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
    exit;
}

$where = [];
$params = [];

/* BUSCAR POR NOMBRE */
if (!empty($_GET['buscar'])) {
    $buscar = $conn->real_escape_string($_GET['buscar']);
    $where[] = "nombre LIKE '%$buscar%'";
}

/* PRECIO MIN */
if (!empty($_GET['precio_min'])) {
    $precio_min = floatval($_GET['precio_min']);
    $where[] = "precio >= $precio_min";
}

/* PRECIO MAX */
if (!empty($_GET['precio_max'])) {
    $precio_max = floatval($_GET['precio_max']);
    $where[] = "precio <= $precio_max";
}

/* FILTRO POR TIPO */
if (!empty($_GET['categoria'])) {
    $categoria = intval($_GET['categoria']);
    $where[] = "productos.categoria_id = $categoria";
}

/* CONSTRUIR QUERY */
$sql = "SELECT productos.*, categorias.nombre AS categoria, categorias.color
        FROM productos
        LEFT JOIN categorias ON productos.categoria_id = categorias.id";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$resultado = $conn->query($sql);
?>

<?php require_once "views/partials/header.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css">
<div class="admin-menu">
    <a href="<?= BASE_URL ?>admin.php">📊 Dashboard</a>
    <a href="<?= BASE_URL ?>admin_productos.php">📦 Productos</a>
    <a href="admin_clientes.php">👥 Clientes</a>
</div>

<h1>📦 Gestión de productos</h1>

<a href="<?= BASE_URL ?>crear_producto.php" class="btn crear">➕ Añadir producto</a>
<a href="<?= BASE_URL ?>admin_categorias.php" class="btn crear">⚙️ Categorías</a>

<form method="GET" class="filtro-form">
    <input type="text" name="buscar" placeholder="Buscar producto..." value="<?= $_GET['buscar'] ?? '' ?>">

    <input type="number" name="precio_min" placeholder="Precio min" step="0.01" value="<?= $_GET['precio_min'] ?? '' ?>">

    <input type="number" name="precio_max" placeholder="Precio max" step="0.01" value="<?= $_GET['precio_max'] ?? '' ?>">
    <!-- 🔥 NUEVO FILTRO -->
    <select name="categoria">
        <option value="">-- Categoría --</option>

        <?php while($c = $categorias->fetch_assoc()) { ?>
            <option value="<?= $c['id']; ?>"
                <?= (($_GET['categoria'] ?? '') == $c['id']) ? 'selected' : '' ?>>
                <?= $c['nombre']; ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit" class="btn">🔍 Buscar</button>
</form>
<?php if(isset($_GET['ok'])): ?>
    <div class="alert-success">
        ✅ Producto creado correctamente
    </div>
<?php endif; ?>

<table>
<tr>
    <th>Imagen</th>
    <th>Nombre</th>
    <th>Precio</th>
    <th>Categoría</th>
    <th>Acciones</th>
</tr>

<?php while($p = $resultado->fetch_assoc()) { ?>
<tr>
    <td>
        <?php
        $img = !empty($p['imagen']) ? basename($p['imagen']) : 'default.jpg';
        ?>

        <img src="<?= BASE_URL ?>public/img/<?php echo $img; ?>" width="80">
    </td>
    <td><?php echo $p['nombre']; ?></td>
    <td><?php echo $p['precio']; ?>€</td>
    <td>
        <span class="tipo" style="background: <?= $p['color'] ?? '#999' ?>">
            <?= $p['categoria'] ?>
        </span>
    </td>
    <td>
        <a href="<?= BASE_URL ?>editar_producto.php?id=<?php echo $p['id']; ?>" class="btn editar">✏️</a>
        <a href="<?= BASE_URL ?>eliminar_producto.php?id=<?php echo $p['id']; ?>" 
        onclick="return confirm('¿Seguro que quieres eliminar este producto?');">
        🗑️
        </a>        
    </td>
</tr>
<?php } ?>

</table>

<?php require_once "views/partials/footer.php"; ?>