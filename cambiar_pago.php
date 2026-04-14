<?php
session_start();
require_once "config/db.php";

$id = $_POST['id'];

$sql = "SELECT pago FROM pedidos WHERE id = $id";
$result = $conn->query($sql);
$pedido = $result->fetch_assoc();

$nuevo = ($pedido['pago'] == 'pagado') ? 'no_pagado' : 'pagado';

$conn->query("UPDATE pedidos SET pago='$nuevo' WHERE id=$id");

header("Location: admin.php");
exit;
?>