<?php
$userSession = new App\Libraries\UserSession();

$data = $userSession->getSession();
$data["is_admin"] ??= "../";
// var_dump($data);
?>

<?php if ($userSession->checkIfExists()) { ?>
    <p><a href="/reservedPage/<?= $data["is_admin"] === "../" ? $data["is_admin"] : ($data["is_admin"] ? "admin" : "normal") ?>">Reserved Page (Current User: <?= $data["username"] ?? "user" ?>)</a></p>

    <form action="/logout" method="post">
        <button type="submit">Log out</button>
    </form>
<?php } else { ?>
    <p><a href="/login">Login</a></p>
    <p><a href="/signup">Signup</a></p>
<?php } ?>