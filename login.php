<?php require 'header.php'; ?>

<h1 class="loginh1">login om te downloaden</h1>

<form class="loginform" action="includes/logincontroller.php" method="post">
    <input type="hidden" name="type" value="login">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <input type="submit" value="login">
</form>

<?php require 'footer.php'; ?>
