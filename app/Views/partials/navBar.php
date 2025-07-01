<nav>
    <p><a href="/"><img src="<?= base_url("./icons/home.svg") ?>" alt="Home" width="32px" height="auto"></a></p>
    <p><a href="/about"><img src="<?= base_url("./icons/about.svg") ?>" alt="About" width="32px" height="auto"></a></p>
    <p><a href="/contact"><img src="<?= base_url("./icons/contact.svg") ?>" alt="Contact" width="32px" height="auto"></a></p>

    <div class="authentication-reserved">
        <?= view("partials/authenticationOrReservedPage") ?>
    </div>
</nav>