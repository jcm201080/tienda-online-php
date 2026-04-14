<?php require_once "views/partials/header.php"; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>public/css/registro.css">
<?php
session_start();
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $cp = $_POST['cp'];

    $sql = "INSERT INTO usuarios (nombre, email, password, telefono, direccion, ciudad, cp)
    VALUES ('$nombre', '$email', '$password', '$telefono', '$direccion', '$ciudad', '$cp')";

    if ($conn->query($sql)) {
        echo "Usuario registrado correctamente";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Registro</h2>

<form method="POST" class="form-registro">

    <label>Nombre:</label>
    <input type="text" name="nombre" placeholder="Tu nombre completo" required>

    <label>Email:</label>
    <input type="email" name="email" placeholder="ejemplo@email.com" required>

    <label>Teléfono:</label>
    <input type="text" name="telefono" placeholder="Ej: 600123123" required>

    <label>Dirección:</label>
    <input type="text" name="direccion" placeholder="Calle, número...">

    <label>Ciudad:</label>
    <input type="text" name="ciudad">

    <label>Código postal:</label>
    <input type="text" name="cp">

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <button type="submit">Registrarse</button>

</form>
<?php require_once "views/partials/footer.php"; ?>