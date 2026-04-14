<?php
session_start();
require_once "config/db.php";

$categorias = $conn->query("SELECT * FROM categorias");

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM productos WHERE id = $id";
$resultado = $conn->query($sql);
$producto = $resultado->fetch_assoc();
?>

<?php require_once "views/partials/header.php"; ?>

<h1>✏️ Editar producto</h1>

<form action="<?= BASE_URL ?>actualizar_producto.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

    <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>

    <label>Tipo de leña</label>
    <select name="categoria_id" required>
        <option value="">Seleccionar</option>

        <?php while($c = $categorias->fetch_assoc()) { ?>
            <option value="<?= $c['id']; ?>"
                <?= ($producto['categoria_id'] == $c['id']) ? 'selected' : '' ?>>
                <?= $c['nombre']; ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <img src="<?= BASE_URL ?>public/img/<?php echo $producto['imagen'] ?: 'default.jpg'; ?>" width="100">

    <br><br>

    <input type="file" name="imagen">

    <br><br>

    <button class="btn">Actualizar</button>

</form>

<?php require_once "views/partials/footer.php"; ?>