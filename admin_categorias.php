<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
    exit;
}

// 🟡 EDITAR
if (isset($_POST['editar'])) {
    $id = intval($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $color = $_POST['color'];

    $conn->query("UPDATE categorias SET nombre='$nombre', color='$color' WHERE id=$id");
}

// 🟢 CREAR
if (isset($_POST['crear'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $color = $_POST['color'];

    $conn->query("INSERT INTO categorias (nombre, color) VALUES ('$nombre', '$color')");
}

// 📋 LISTAR
$categorias = $conn->query("SELECT * FROM categorias");
?>

<?php require_once "views/partials/header.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css">

<div class="admin-container">

<h1>⚙️ Categorías</h1>

<!-- 🔹 CREAR -->
<form method="POST" class="form-categoria">
    <input type="text" name="nombre" placeholder="Nombre categoría" required>
    <input type="color" name="color" value="#888888">
    <button class="btn" name="crear">➕ Añadir</button>
</form>

<hr>

<table>
<tr>
    <th>Nombre</th>
    <th>Color</th>
    <th>Acciones</th>
</tr>

<?php while($c = $categorias->fetch_assoc()) { ?>
<tr>

    <form method="POST">

        <td>
            <input type="text" name="nombre" value="<?= $c['nombre'] ?>">
        </td>

        <td>
            <input type="color" name="color" value="<?= $c['color'] ?>">
        </td>

        <td>
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button class="btn editar" name="editar">💾</button>
        </td>

    </form>

</tr>
<?php } ?>

</table>

</div>

<?php require_once "views/partials/footer.php"; ?>