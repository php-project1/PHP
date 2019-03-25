<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="login.css">
<h1 class="loginh1">login om te downloaden</h1>

<form class="loginform" action="includes/logincontroller.php" method="post">
    <input type="hidden" name="type" value="login">
    <div class="form-group">
        <input class="form" type="text" name="email" id="email">
    </div>

    <div class="form-group">
        <input class="form" type="password" name="password" id="password">
    </div>

    <input class="formbutton" type="image" src="imgs/Login.png" value="login">
</form>

<?php require 'footer.php'; ?>
