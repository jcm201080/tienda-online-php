<?php session_start(); ?>
<?php require_once "views/partials/header.php"; ?>
<?php
require_once "config/db.php";

$where = [];

/* FILTRO CATEGORIA */
if (!empty($_GET['categoria'])) {
    $categoria = intval($_GET['categoria']);
    $where[] = "productos.categoria_id = $categoria";
}

/* PRECIO MIN */
if (!empty($_GET['precio_min'])) {
    $precio_min = floatval($_GET['precio_min']);
    $where[] = "productos.precio >= $precio_min";
}

/* PRECIO MAX */
if (!empty($_GET['precio_max'])) {
    $precio_max = floatval($_GET['precio_max']);
    $where[] = "productos.precio <= $precio_max";
}

/* QUERY */
$sql = "SELECT productos.*, categorias.nombre AS categoria, categorias.color
        FROM productos
        LEFT JOIN categorias ON productos.categoria_id = categorias.id";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$resultado = $conn->query($sql);

/* CATEGORIAS PARA FILTRO */
$categorias = $conn->query("SELECT * FROM categorias");
?>

<?php if(isset($_GET['ok'])): ?>
    <div class="alert-success">
        ✅ Producto añadido al carrito
    </div>
<?php endif; ?>

<!-- 🔥 FORMULARIO SIEMPRE VISIBLE -->
<form method="GET" class="filtro-form">

    <select name="categoria">
        <option value="">-- Tipo de leña --</option>

        <?php while($c = $categorias->fetch_assoc()) { ?>
            <option value="<?= $c['id']; ?>"
                <?= (($_GET['categoria'] ?? '') == $c['id']) ? 'selected' : '' ?>>
                <?= $c['nombre']; ?>
            </option>
        <?php } ?>
    </select>

    <input type="number" name="precio_min" placeholder="Precio min" step="0.01"
        value="<?= $_GET['precio_min'] ?? '' ?>">

    <input type="number" name="precio_max" placeholder="Precio max" step="0.01"
        value="<?= $_GET['precio_max'] ?? '' ?>">

    <button class="btn">🔍 Filtrar</button>

</form>

<section class="productos">
<?php
while($fila = $resultado->fetch_assoc()) {
?>
    <div class="producto">

        <?php
        $imagen = !empty($fila['imagen']) ? $fila['imagen'] : 'default.jpg';
        ?>

        <img src="<?= BASE_URL ?>public/img/<?php echo $imagen; ?>" alt="producto">

        
        

        <?php
        $categoria = $fila['categoria'] ?? 'Mixto';
        ?>

        <h2><?php echo $fila['nombre']; ?></h2>

        <span class="tipo" style="background: <?= $fila['color'] ?? '#999' ?>">
            <?= $categoria ?>
        </span>

        <p><?php echo $fila['precio']; ?> €</p>

        <a  href="<?= BASE_URL ?>agregar_carrito.php?id=<?php echo $fila['id']; ?>">
            <button class="carrito">🛒 Añadir carrito</button>
        </a>

    </div>
<?php
}
?>
</section>
<?php require_once "views/partials/footer.php"; ?>
</html>