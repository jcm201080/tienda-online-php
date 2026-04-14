<?php
session_start();
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {

            $_SESSION['usuario'] = $usuario;

            header("Location: index.php");
            exit;
        } else {
            echo "Contraseña incorrecta";
        }

    } else {
        echo "Usuario no encontrado";
    }
}
?>

<?php require_once "views/partials/header.php"; ?>

<h2 class="titulo">🔐 Acceso</h2>

<div class="form-container">
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta?</p>
    <a href="registro.php">Crear cuenta</a>
</div>
<?php require_once "views/partials/footer.php"; ?>