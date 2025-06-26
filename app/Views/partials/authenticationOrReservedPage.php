<?php
$userSession = new App\Libraries\UserSession();

$data = $userSession->getSession();
// var_dump($data);
?>

<?php if ($userSession->checkIfExists()) { ?>
    <p><a href="/reservedPage/normal">Reserved Pages (Welcome Back <?= isset($data["username"]) ? $data["username"] : "" ?>)</a></p>

    <form action="/logout" method="post">
        <button type="submit">Log out</button>
    </form>
<?php } else { ?>
    <p><a href="/login">Login</a></p>
    <p><a href="/signup">Signup</a></p>
<?php } ?>