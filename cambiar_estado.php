<?php
session_start();
require_once "config/db.php";

$id = $_POST['id'];

$sql = "SELECT estado FROM pedidos WHERE id = $id";
$result = $conn->query($sql);
$pedido = $result->fetch_assoc();

$nuevo_estado = ($pedido['estado'] == 'pendiente') ? 'enviado' : 'pendiente';

$sql = "UPDATE pedidos SET estado='$nuevo_estado' WHERE id=$id";
$conn->query($sql);

header("Location: admin.php");
exit;
?>