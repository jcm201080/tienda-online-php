<?php
session_start();
require_once "config/db.php";

// Seguridad admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// (Opcional) borrar imagen también
$sql_img = "SELECT imagen FROM productos WHERE id = $id";
$res = $conn->query($sql_img);
$p = $res->fetch_assoc();

if (!empty($p['imagen']) && file_exists("public/img/" . $p['imagen'])) {
    unlink("public/img/" . $p['imagen']);
}

// borrar producto
$sql = "DELETE FROM productos WHERE id = $id";
$conn->query($sql);

header("Location: admin_productos.php");
exit;