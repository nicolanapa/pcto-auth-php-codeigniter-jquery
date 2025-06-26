<?php
$userSession = new App\Libraries\UserSession();

$data = $userSession->getSession();
?>

<?php if ($userSession->checkIfExists()) { ?>
    <p><a href="/reservedPage/normal">Reserved Pages (Welcome Back <?= $data["username"] ?>)</a></p>
<?php } else { ?>
    <p><a href="/login">Login</a></p>
    <p><a href="/signup">Signup</a></p>
<?php } ?>