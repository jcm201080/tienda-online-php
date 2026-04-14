<?php
$host = $_SERVER['HTTP_HOST'];

if (
    strpos($host, 'localhost') !== false ||
    strpos($host, '127.0.0.1') !== false ||
    strpos($host, '192.168.') !== false
) {
    define('BASE_URL', '/mi_tienda_php/');
} else {
    define('BASE_URL', '/');
}
?>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Leñas Parra</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
    <?php if($current_page == 'contacto.php'): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/contacto.css">
    <?php endif; ?>
    <?php if($current_page == 'index.php'): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/index.css">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="header">
    <div class="logo">
        <a href="<?= BASE_URL ?>index.php">
            <img src="<?= BASE_URL ?>public/img/logo.jpeg" alt="Leñas Parra">
        </a>
    </div>

    <nav class="menu">
        <a href="<?= BASE_URL ?>index.php" 
        class="<?php if($current_page == 'index.php') echo 'active'; ?>">
        Inicio
        </a>
        <a href="<?= BASE_URL ?>tienda.php" 
        class="<?php if($current_page == 'tienda.php') echo 'active'; ?>">
        Comprar
        </a>

        <a href="<?= BASE_URL ?>carrito.php" 
        class="<?php if($current_page == 'carrito.php') echo 'active'; ?>">
        🛒 Carrito
        </a>

        <a href="<?= BASE_URL ?>contacto.php" 
        class="<?php if($current_page == 'contacto.php') echo 'active'; ?>">
        Contacto
        </a>

        <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'admin'): ?>
            <a href="<?= BASE_URL ?>admin.php" 
            class="<?php if($current_page == 'admin.php') echo 'active'; ?>">
            Admin
            </a>
        <?php endif; ?>

        <?php if(isset($_SESSION['usuario'])): ?>
            <span>👋 Hola, <?php echo $_SESSION['usuario']['nombre']; ?></span>
            <a href="<?= BASE_URL ?>logout.php">Salir</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>login.php">Mi cuenta</a>
        <?php endif; ?>
        
    </nav>
</header>