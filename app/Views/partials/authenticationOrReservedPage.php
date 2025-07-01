<?php
$userSession = new App\Libraries\UserSession();

$data = $userSession->getSession();
$data["is_admin"] ??= "../";
// var_dump($data);
?>

<?php if ($userSession->checkIfExists()) { ?>
    <p><a href="/reservedPage/<?= $data["is_admin"] === "../" ? $data["is_admin"] : ($data["is_admin"] ? "admin" : "normal") ?>"><img src="<?= base_url("./icons/reservedPage.svg") ?>" alt="Contact" width="24px" height="auto"> as <?= $data["username"] ?? "user" ?></a></p>

    <form action="/logout" method="post">
        <button type="submit" class="logout-button">Log out</button>
    </form>
<?php } else { ?>
    <p><a href="/login"><img src="<?= base_url("./icons/login.svg") ?>" alt="Login" width="32px" height="auto"></a></p>
    <p><a href="/signup"><img src="<?= base_url("./icons/signup.svg") ?>" alt="Signup" width="32px" height="auto"></a></p>
<?php } ?>