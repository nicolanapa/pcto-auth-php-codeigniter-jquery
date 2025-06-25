<form action="/signup" method="post">
    <label for="username">Username: </label>
    <input type="text" name="username" id="username" required minlength="4" maxlength="128">

    <label for="password">Password: </label>
    <input type="password" name="password" id="password" required minlength="2" maxlength="256">

    <label for="is-admin">Are you an Admin? </label>
    <input type="checkbox" name="is_admin" id="is-admin" value="true">

    <button type="submit" class="signup-button">Signup!</button>
</form>