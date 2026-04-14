<?php
header('Content-Type: application/json');

require_once "respuestas.php";
require_once __DIR__ . "/ia_huggingface.php";

try {

    $mensaje = $_POST['mensaje'] ?? '';

    $respuesta = consultarIAGratis($mensaje);

    if (!$respuesta) {
        $respuesta = responderIA($mensaje);
    }

    echo json_encode([
        "respuesta" => $respuesta
    ]);

} catch (Throwable $e) {

    echo json_encode([
        "respuesta" => "Error en IA 🤖",
        "error" => $e->getMessage()
    ]);
}