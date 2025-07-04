<div class="authentication-container">

    <?= validation_list_errors() ?>

    <?= form_open_multipart("/signup") ?>
    <label for="username">Username: </label>
    <input type="text" name="username" id="username" required minlength="4" maxlength="128" value="<?= isset($user) ? $user["username"] : "" ?>">

    <?php if ($signupMode) { ?>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" required minlength="2" maxlength="256">
    <?php } ?>

    <label for="is-admin">Are <?= $signupMode ? "you" : "they" ?> an Admin? </label>
    <input type="checkbox" name="is_admin" id="is-admin" value="true" <?= isset($user) ? ($user["is_admin"] ? "checked" : "") : "" ?>>

    <label for="can-access">Would <?= $signupMode ? "you" : "they" ?> want to access the Reserved Page? </label>
    <input type="checkbox" name="can_access" id="can-access" value="true" <?= isset($user) ? ($user["can_access"] ? "checked" : "") : "false" ?>>

    <label for="image">Image</label>
    <?php /* hidden input with image if it exists */ ?>
    <input type="file" name="image" id="image" accept="image/*" />

    <button type="submit" class="signup-button"><?= $signupMode ? "Signup" : "Edit" ?>!</button>
    <?= form_close() ?>
</div>