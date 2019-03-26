<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="register.css">


<h1>Maak een account aan</h1>

<form action="includes/loginController.php" method="post">

    <input type="hidden" name="type" value="register">

    <div class="form-group">

        <input class="form" type="text" name="username" id="username" placeholder="Username">
    </div>

    <div class="form-group">

        <input class="form" type="email" name="email" id="email" placeholder="email">
    </div>

    <div class="form-group">
        <input class="form" type="password" name="password" id="password" placeholder="Password">
    </div>

    <div class="form-group">
        <input class="form" type="password" name="password_confirm" id="password_confirm" placeholder="Re-Enter Password">
    </div>
    <div class="algput">
        <input class="checkbox" type="checkbox" name="algemene-voorwaarden">
        <button  class="but" onclick="voorwaardeFunction()"><img class="butpic" src="imgs/Algemene_voorwaarden.png"></button>
    </div>
    <input class="formbutton" type="image" src="imgs/Maak_aan.png" value="Register">
</form>

<?php require 'footer.php'; ?>

