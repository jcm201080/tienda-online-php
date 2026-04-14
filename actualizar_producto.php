
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "config/db.php";

$id = intval($_POST['id'] ?? 0);
$nombre = $conn->real_escape_string($_POST['nombre'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);
$categoria_id = intval($_POST['categoria_id'] ?? 0);

// 🔴 Validación básica
if (!$id) {
    die("ID no recibido");
}

// 🔍 Obtener imagen actual
$sql = "SELECT imagen FROM productos WHERE id = $id";
$res = $conn->query($sql);

if (!$res) {
    die("Error SQL: " . $conn->error);
}

$imagen = '';

if ($res->num_rows > 0) {
    $producto = $res->fetch_assoc();
    $imagen = $producto['imagen'];
}

// 📸 Si sube nueva imagen
if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {

    $imagen = time() . "_" . basename($_FILES['imagen']['name']);

    move_uploaded_file(
        $_FILES['imagen']['tmp_name'],
        "public/img/" . $imagen
    );
}

// 💾 Actualizar producto (YA CON CATEGORIA)
$sql = "UPDATE productos 
        SET nombre='$nombre', 
            precio='$precio', 
            imagen='$imagen', 
            categoria_id=$categoria_id
        WHERE id=$id";

if (!$conn->query($sql)) {
    die("Error al actualizar: " . $conn->error);
}

// 🔄 Redirigir
header("Location: admin_productos.php");
exit;