<div class="authentication-container">
    <?= validation_list_errors() ?>

    <?= form_open("/login") ?>
    <label for="username">Username: </label>
    <input type="text" name="username" id="username" required minlength="4" maxlength="128">

    <label for="password">Password: </label>
    <input type="password" name="password" id="password" required minlength="2" maxlength="256">

    <button type="submit" class="login-button">Login!</button>
    <?= form_close() ?>
</div>