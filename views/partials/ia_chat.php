<div class="ia-toggle" onclick="toggleIA()">🤖</div>

<div class="ia-box" id="ia-box">
    <div id="ia-chat"></div>

    <input type="text" id="ia-input" placeholder="Pregúntame...">
    <button onclick="enviarMensaje()">Enviar</button>
</div>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>

<script src="<?= BASE_URL ?>public/js/ia.js"></script>