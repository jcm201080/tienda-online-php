
<?php session_start(); ?>
<?php require_once "views/partials/header.php"; ?>
<div class="carrito-container">
<h1>🛒 Tu carrito</h1>

<?php
$total = 0;

if (!empty($_SESSION['carrito'])) {

    echo "<table class='tabla-carrito'>";
    echo "<tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Eliminar</th>
          </tr>";

    foreach ($_SESSION['carrito'] as $producto) {

        $cantidad = $producto['cantidad'] ?? 1;
        $subtotal = $producto['precio'] * $cantidad;
        $total += $subtotal;

        echo "<tr>";

        echo "<td>{$producto['nombre']}</td>";
        echo "<td>{$producto['precio']}€</td>";

        echo "<td>
            <a class='btn-cantidad' href='actualizar_carrito.php?id={$producto['id']}&accion=restar'>−</a>
            <span class='cantidad'>$cantidad</span>
            <a class='btn-cantidad' href='actualizar_carrito.php?id={$producto['id']}&accion=sumar'>+</a>
        </td>";

        echo "<td>{$subtotal}€</td>";

        echo "<td>
            <a class='btn-eliminar' href='actualizar_carrito.php?id={$producto['id']}&accion=eliminar'>✕</a>
        </td>";

        echo "</tr>";
    }

    echo "</table>";

    echo "<h2 class='total'>Total: $total €</h2>";

} else {
    echo "<p>Carrito vacío</p>";
}
?>

<hr>


<?php if(isset($_SESSION['usuario'])): ?>

    <h2>Finalizar compra</h2>

    <p>👤 <?php echo $_SESSION['usuario']['nombre']; ?></p>

    <p>📍 Dirección: 
    <?php echo $_SESSION['usuario']['direccion'] ?? 'No definida'; ?>
    </p>

    <p>🏙️ Ciudad: 
    <?php echo $_SESSION['usuario']['ciudad'] ?? 'No definida'; ?>
    </p>

    <p>📮 CP: 
    <?php echo $_SESSION['usuario']['cp'] ?? 'No definido'; ?>
    </p>

    <br>

    <form action="procesar_pedido.php" method="POST">
        <input type="hidden" name="direccion" value="<?php echo $_SESSION['usuario']['direccion'] ?? ''; ?>">
        <button type="submit">Confirmar pedido</button>
    </form>

<?php else: ?>

    <div style="text-align:center; margin-top:20px;">
        <p>🔒 Para finalizar la compra necesitas una cuenta</p>

        <a href="login.php">
            <button>Iniciar sesión</button>
        </a>

        <p>¿No tienes cuenta?</p>
        <a href="registro.php">Crear cuenta</a>
    </div>

<?php endif; ?>

<br>
<a href="index.php">⬅️ Seguir comprando</a>
</div>
<?php require_once "views/partials/footer.php"; ?>