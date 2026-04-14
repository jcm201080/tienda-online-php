<?php
require_once "config/db.php";

$nombre = $conn->real_escape_string($_POST['nombre']);
$precio = floatval($_POST['precio']);
$categoria_id = intval($_POST['categoria_id']);

$imagen = '';

if (!empty($_FILES['imagen']['name'])) {

    $imagen = time() . "_" . basename($_FILES['imagen']['name']);

    move_uploaded_file(
        $_FILES['imagen']['tmp_name'],
        "public/img/" . $imagen
    );
}

// ✅ IMPORTANTE: ya no usamos "tipo"
$sql = "INSERT INTO productos (nombre, precio, imagen, categoria_id) 
        VALUES ('$nombre', '$precio', '$imagen', $categoria_id)";

$conn->query($sql);

header("Location: admin_productos.php?ok=1");
exit;