<?php session_start(); ?>
<?php require_once "views/partials/header.php"; ?>

<section class="hero">
    <div class="hero-text">
        <h1>🔥 Leña de calidad directamente a tu hogar</h1>
        <p>Tradición, cercanía y servicio en Fuentes de León</p>

        <a href="<?= BASE_URL ?>tienda.php" class="btn">🔥 Ver leña disponible</a>
        <br>
    </div>
</section>

<section class="bloque">
    <div class="bloque-texto">
        <h2>📍 Desde Fuentes de León</h2>
        <p>
        Ubicados en Fuentes de León, uno de los pueblos más altos de la provincia de Badajoz, en plena Sierra Morena,
        rodeados de dehesas, naturaleza y aire puro. Un entorno privilegiado que nos permite ofrecer una leña de calidad excepcional.
        </p>
    </div>
    <div class="bloque-img">
        <img src="<?= BASE_URL ?>public/img/pueblo.jpg">
    </div>
</section>

<section class="bloque reverse">
    <div class="bloque-texto">
        <h2>🌳 Leña de calidad</h2>
        <p>
        Trabajamos con leña de encina, olivo y pino cuidadosamente seleccionada.
        Perfecta para chimeneas, estufas y barbacoas, garantizando una combustión duradera,
        alto poder calorífico y el mejor rendimiento.
        </p>
    </div>
    <div class="bloque-img">
        <img src="<?= BASE_URL ?>public/img/encinas.jpeg">
    </div>
</section>

<section class="bloque">
    <div class="bloque-texto">
        <h2>🚚 Entrega rápida</h2>
        <p>
        Servicio rápido y cercano. Llevamos tu pedido directamente a domicilio en el menor tiempo posible.
        Atención personalizada y trato de confianza.
        </p>
    </div>

    <div class="bloque-img">
        <img src="<?= BASE_URL ?>public/img/pueblo3.jpeg">
    </div>
</section>

<?php require_once "views/partials/footer.php"; ?>