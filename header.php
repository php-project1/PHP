<?php
    require 'includes/config.php';
?>

<!-- Even heel easy html code, omdat de focus nu op het inlogsysteem ligt en niet op fancy looks :)  -->
<html>
<head>
    <title>Amo Login System homepage</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        nav {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <?php
        /*
         * Hier checken we of we al ooit eens een 'id' key hebben opgeslagen in de
         * $_SESSION variabele. de ENIGE plek waar we dit doen is als we onszelf inloggen
         * en onze gegevens kloppen. Kijk maar in de logincontroller.php
         *
         * Als we dus al een id in onze session hebben (dus onze klant is al ingelogd) willen we niet dat onze
         * klanten zich nogmaals kunnen registreren of inloggen...
         *
         */
        if ( isset($_SESSION['id']) ) {
            //echo "You are currently logged in. Want to <a href='register.php'>logout?</a>";
            echo "<form action='includes/loginController.php' method='post'>
                    <input type='hidden' name='type' value='logout'>
                    <input type='submit' name='submit' id='submit'>
                  </form>";
        } else {
            echo "<a href='login.php'>Login</a> &nbsp; or &nbsp; <a href='register.php'> register </a>";
        }

        if (isset($_GET['msg']))
        {
            $msg = $_GET['msg'];
            echo "<p>$msg</p>";
        }
        ?>
    </nav>
</header>