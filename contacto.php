<?php session_start(); ?>
<?php require_once "views/partials/header.php"; ?>

<section class="contacto">

    <div class="contacto-container">

        <h1>📞 Contacto</h1>

        <div class="contacto-info">
            <p><strong>Nombre:</strong> José Angel Castaño Lozano</p>
            <p><strong>Teléfono:</strong> <a href="tel:633013315">633 01 33 15</a></p>
            <p><strong>Ubicación:</strong> Fuentes de León (06280, Badajoz)</p>
        </div>

        <!-- Imagen -->
        <div class="contacto-img">
            <img src="<?= BASE_URL ?>public/img/logo.jpeg" alt="Leñador">
        </div>

        <!-- Mapa -->
        <div class="mapa">
            <iframe 
                src="https://www.google.com/maps?q=Fuentes+de+León+Badajoz&output=embed"
                width="100%" 
                height="300" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>

    </div>

</section>

<?php require_once "views/partials/footer.php"; ?>