<?php
/**
 * Created by PhpStorm.
 * User: fedje
 * Date: 17-3-2019
 * Time: 19:15
 */

/*
 * Hier checken we of de gebruiker inderdaad is ingelogd ( $_SESSION['id'] wordt alleen aangemaakt
 * als het inloggen in de logincontroller goed is gegaan, neem maar even een kijkje daar.
 * Is dat niet zo, dan helaasch, mag je niet deze site bekijken!
 */
require 'header.php';
if (!isset($_SESSION['id'])) {
    die("I'm sorry, this page is for logged in AMO students only.");
}


?>

<!--<h1>Welcome to AMO Login system Admin Page </h1>-->
    <link rel="stylesheet" type="text/css" href="admin.css">
<div class="grid">
    <h1>A day at the races</h1>
    <p>You'll need to ether login or register to be able to download the file.</p>
    <div>
        <a href="downloadfile/Gokkers.exe" download><img src="imgs/Download.png" alt=""></a>

    </div>
    <img class="dog" src="imgs/video.png" alt="Video of dogs">
</div>


<?php require 'footer.php'; ?>

