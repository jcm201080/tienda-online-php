
<?php
session_start();
require_once "config/db.php";

// 🔐 SOLO ADMIN
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
    exit;
}
$categorias = $conn->query("SELECT * FROM categorias");

?>

<?php require_once "views/partials/header.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css">

<div class="admin-container">

    <!-- 🔥 menú admin -->
    <div class="admin-menu">
        <a href="<?= BASE_URL ?>admin.php">📊 Dashboard</a>
        <a href="<?= BASE_URL ?>admin_productos.php">📦 Productos</a>
        <a href="#">👥 Clientes</a>
    </div>

    <h1>➕ Crear producto</h1>

    <form action="<?= BASE_URL ?>guardar_producto.php" method="POST" enctype="multipart/form-data" class="form-producto">

        <label>Nombre del producto</label>
        <input type="text" name="nombre" placeholder="Ej: Leña de encina" required>

        <label>Precio (€)</label>
        <input type="number" step="0.01" name="precio" placeholder="Ej: 120.00" required>

        <label>Categoría</label>
        <select name="categoria_id" required>
            <option value="">Seleccionar</option>

            <?php while($c = $categorias->fetch_assoc()) { ?>
                <option value="<?= $c['id']; ?>">
                    <?= $c['nombre']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Imagen</label>
        <input type="file" name="imagen" accept="image/*">

        <img id="preview" src="<?= BASE_URL ?>public/img/default.jpg" width="120" style="margin-top:10px; border-radius:8px;">

        <br><br>

        <button class="btn">💾 Guardar producto</button>

    </form>

</div>

<script>
document.querySelector('input[name="imagen"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
</script>

<?php require_once "views/partials/footer.php"; ?>