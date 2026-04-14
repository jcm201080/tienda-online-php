<?php

require_once __DIR__ . "/prompts.php";
require_once __DIR__ . "/../config.php";

function consultarIAGratis($mensaje) {

    $apiKey = HF_API_KEY;

    $contexto = getPromptBase();

    $data = [
        "inputs" => $contexto . "\nCliente: " . $mensaje . "\nRespuesta:"
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api-inference.huggingface.co/models/google/flan-t5-large");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return null;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result[0]['generated_text'])) {
        return $result[0]['generated_text'];
    }

    return null;
}