<?php
session_start();

$id = $_GET['id'] ?? null;
$accion = $_GET['accion'] ?? null;

if ($id && isset($_SESSION['carrito'][$id])) {

    if ($accion == 'sumar') {
        $_SESSION['carrito'][$id]['cantidad']++;
    }

    if ($accion == 'restar') {
        $_SESSION['carrito'][$id]['cantidad']--;

        if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
            unset($_SESSION['carrito'][$id]);
        }
    }

    if ($accion == 'eliminar') {
        unset($_SESSION['carrito'][$id]);
    }
}

header("Location: carrito.php");
exit;