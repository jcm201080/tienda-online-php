<?php
session_start();
require_once "config/db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id = $id";
$resultado = $conn->query($sql);
$producto = $resultado->fetch_assoc();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si el producto ya existe → sumar cantidad
if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad']++;
} else {
    $producto['cantidad'] = 1;
    $_SESSION['carrito'][$id] = $producto;
}

header("Location: tienda.php?ok=1");
exit;
?>