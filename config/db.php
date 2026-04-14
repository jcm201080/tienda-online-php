<?php

$host = $_SERVER['HTTP_HOST'];

if (
    strpos($host, 'localhost') !== false ||
    strpos($host, '127.0.0.1') !== false ||
    strpos($host, '192.168.') !== false
) {
    // LOCAL (XAMPP)
    $user = "root";
    $password = "";
    $dbname = "tienda_lena";
} else {
    // VPS
    $user = "tienda_user";
    $password = "1234";
    $dbname = "tienda";
}

$conn = new mysqli("localhost", $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

// 🔧 AUTOARREGLAR BD (columna telefono en usuarios)
$check_tel = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'telefono'");

if ($check_tel && $check_tel->num_rows == 0) {
    $sql_tel = "ALTER TABLE usuarios ADD telefono VARCHAR(20) AFTER email";
    if (!$conn->query($sql_tel)) {
        error_log("Error al crear columna telefono: " . $conn->error);
    }
}

// 🔧 AUTOARREGLAR BD (tabla categorias)
$sql_categorias = "CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
)";

if (!$conn->query($sql_categorias)) {
    error_log("Error al crear tabla categorias: " . $conn->error);
}


// 🔧 INSERTAR CATEGORIAS INICIALES
$check_cat = $conn->query("SELECT COUNT(*) as total FROM categorias");
$row = $check_cat->fetch_assoc();

if ($row['total'] == 0) {
    $conn->query("INSERT INTO categorias (nombre) VALUES 
        ('Encina'),
        ('Pino'),
        ('Olivo')
    ");
}

// 🔧 AUTOARREGLAR BD (columna categoria_id en productos)
$check_cat_id = $conn->query("SHOW COLUMNS FROM productos LIKE 'categoria_id'");

if ($check_cat_id && $check_cat_id->num_rows == 0) {
    $sql_cat_id = "ALTER TABLE productos ADD categoria_id INT";
    if (!$conn->query($sql_cat_id)) {
        error_log("Error al crear columna categoria_id: " . $conn->error);
    }
}

// 🔧 AUTOARREGLAR BD (columna color en categorias)
$check_color = $conn->query("SHOW COLUMNS FROM categorias LIKE 'color'");

if ($check_color && $check_color->num_rows == 0) {
    $sql_color = "ALTER TABLE categorias ADD color VARCHAR(20)";
    if (!$conn->query($sql_color)) {
        error_log("Error al crear columna color: " . $conn->error);
    }
}