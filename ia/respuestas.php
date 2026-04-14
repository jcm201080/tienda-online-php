<?php

function responderIA($mensaje) {

    $mensaje = strtolower($mensaje);

    if (strpos($mensaje, 'hola') !== false) {
        return "¡Hola! 👋 ¿En qué puedo ayudarte? Puedo aconsejarte sobre qué leña elegir o cómo hacer tu pedido.";
    }

    if (strpos($mensaje, 'mejor leña') !== false || strpos($mensaje, 'recomiendas') !== false) {
        return "La leña de encina es la mejor opción 🔥. Dura más tiempo encendida y genera mucho calor, ideal para chimeneas y estufas.";
    }

    if (strpos($mensaje, 'barbacoa') !== false) {
        return "Para barbacoas 🍖 te recomiendo leña de olivo, ya que aporta muy buen aroma a la comida.";
    }

    if (strpos($mensaje, 'chimenea') !== false) {
        return "Para chimenea, la encina es perfecta porque mantiene el calor durante más tiempo.";
    }

    if (strpos($mensaje, 'comprar') !== false || strpos($mensaje, 'pedido') !== false) {
        return "Es muy fácil 😊. Solo tienes que entrar en la tienda, añadir los productos al carrito y finalizar el pedido.";
    }

    if (strpos($mensaje, 'envio') !== false || strpos($mensaje, 'entrega') !== false) {
        return "Realizamos entregas rápidas a domicilio 🚚. El tiempo depende de la zona, pero siempre intentamos que sea lo antes posible.";
    }

    return "No estoy seguro de eso 🤖, pero puedo ayudarte con tipos de leña, recomendaciones o cómo comprar.";
}