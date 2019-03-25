<?php
/*
 * Dit is een webserver only script, waar je alleen mag komen als je via een form
 * data verstuurd, en niet als je via de url hier naar toe komt. Iedereen die dat doet
 * sturen we terug naar index.php
 *
 */

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    header('location: index.php');
    exit;
}

if ( $_POST['type'] === 'login' ) {

    /*
     * Hier komen we als we de login form data versturen.
     * things to do:
     * 1. Checken of gebruikersnaam EN email in de database bestaat met de ingevoerde data
     * 2. Indien ja, een $_SESSION['id'] vullen met de id van de persoon die probeert in te loggen.
     * 3. gebruiker doorsturen naar de admin pagina
     *
     * 3. Indien nee, gebruiker terugsturen naar de login pagina met de melding dat gebruikersnaam en/of
     * wachtwoord niet in orde is.
     *
     */

//    TODO: kijken of email valid is
//    TODO: Vervolgens haal de ww en id op waar de email de ingevoorde email is
//    TODO: daarna de ww controleren
//    TODO: inloggen met sessions .

    $email = htmlentities($_POST['email']);
    $password = htmlentities(rtrim($_POST['password']));



    function EmailChecker($email)
    {
        $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $validEmail;
    }

    function DatabaseQueryEmail($db, $email, $password)
    {
        $sql = "SELECT * FROM logins WHERE email = :email";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':email' => $email
        ]);
        $user = $prepare->fetch(PDO::FETCH_ASSOC);
        $count = $prepare->rowCount();
        if ($count > 0)
        {
            PasswordValidator($password, $user['password'], $user['id'], $user['username']);
        }
        else
        {
            $msg = "Dit account bestaat niet";
            header("location: ../login.php?msg=$msg");
            exit;
        }
    }

    function DatabaseQueryUsername($db, $username, $password)
    {
        $sql = "SELECT * FROM logins WHERE username = :username";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':username' => $username
        ]);
        $user = $prepare->fetch(PDO::FETCH_ASSOC);
        $count = $prepare->rowCount();
        if ($count > 0)
        {
            PasswordValidator($password, $user['password'], $user['id'], $user['username']);
        }
        else
        {
            $msg = "Dit account bestaat niet";
            header("location: ../login.php?msg=$msg");
            exit;
        }
    }

    function PasswordValidator($password, $userPassord, $id, $username)
    {
        if (password_verify($password, $userPassord))
        {
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            header("location: ../admin.php");
            exit;
        }
        else
        {
            $msg = "Gebruikersnaam en/of wachtwoord niet geldig";
            header("location: ../login.php?msg=$msg");
            exit;
        }
    }

    if (!EmailChecker($email))
    {
//        TODO: inloggen met username
//        Maak hier een function voor aan!
        DatabaseQueryUsername($db, $email, $password);
        exit;
    }
    else if (EmailChecker($email))
    {
        DatabaseQueryEmail($db, $email, $password);
    }
    else
    {
        $msg = "Er is iets mis gegaan";
        header("location: ../login.php?msg=$msg");
        exit;
    }
    exit;
}

/*
 * Hier komen we als we de register form data versturen
 * things todo:
 *
 * 1. Checken of er al iemand met dit emailadres of username bestaat
 * 2. Indien nee, eerst checken of de password en password_confirm inderdaad hetzelfde ingevoerde is.
 * 3. Dan gebruiker inserten in de database, zodat deze kan gaan inloggen.
 * 4. Gebruiker doorsturen naar de nieuwe inlog pagina.
 *
 * 5. Indien ja, gebruiker terugsturen naar register form met de melding dat gebruikersnaam en/of wachtworod niet op
 * orde is.
 *
 *
 */

if ($_POST['type'] === 'register') {

    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities(rtrim($_POST['password']));
    $passwordConfirm = htmlentities(rtrim($_POST['password_confirm']));

    //verification
    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm))
    {
        $msg = "1 of meer velden zijn niet ingevuld";
        header("location: ../register.php?msg=$msg");
        exit;
    }

    //check of algemene voorwaarde checkbox is checked
//    if (!isset($_POST['algemene-voorwaarde']))
//    {
//        $msg = "U moet akkoort gaan met de algemene voorwaarden";
//        header("location: ../register.php?msg=$msg");
//        exit;
//    }

    // Password length
    if (strlen($password) <= 6)
    {
        $msg = "wachtwoord moet langer zijn dan 6 karakters";
        header("location: ../register.php?msg=$msg");
        exit;
    }

    //password check
    if ($password != $passwordConfirm)
    {
        $msg = "wachtwoorden komen niet overeen!";
        header("location: ../register.php?msg=$msg");
        exit;
    }

    // email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $msg = "email is not valid";
        header("location: ../register.php?msg=$msg");
        exit;
    }

    function databaseCheckerEmail($db, $email)
    {
        $sql = "SELECT email FROM logins WHERE email = :email";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':email' => $email
        ]);
        if ($prepare->rowCount() > 0)
        {
            $msg = "email already used";
            header("location: ../register.php?msg=$msg");
            exit;
        }
        else
        {
            return false;
        }
    }

    function databaseCheckerUsername($db, $username)
    {
        $sql = "SELECT username FROM logins WHERE username = :username";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':username' => $username
        ]);
        if ($prepare->rowCount() > 0)
        {
            $msg = "user already used";
            header("location: ../register.php?msg=$msg");
            exit;
        }
        else
        {
            return false;
        }
    }

    function password_strength($password) {
        $returnVal = True;
        if ( strlen($password) < 6) {
            $msg = "wachtwoord moet minimaal 6 karakters lang zijn";
            header("location: ../login.php?msg=$msg") ;
            exit;
        }
        if ( !preg_match("#[0-9]+#", $password) )
        {
            $msg = "wachtwoord moet minimaal 1 cijfer hebben";
            header("location: ../login.php?msg=$msg");
            exit;
        }
        if ( !preg_match("#[a-z]+#", $password) )
        {
            $msg = "wachtwoord heeft symbolen die niet zijn toegestaan";
            header("location: ../login.php?msg=$msg");
            exit;
        }
        if ( !preg_match("#[A-Z]+#", $password) )
        {
            $msg = "wachtwoord moet minimaal 1 hoofdletter hebben";
            header("location: ../login.php?msg=$msg");
            exit;
        }
        if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password) )
        {
            $msg = "wachtwoord heeft iligale tekens";
            header("location: ../login.php?msg=$msg");
            exit;
        }
        return $returnVal;
    }

//    TODO:  checken of username al bestaad in database
//    TODO: checken of email al bestaat in database
    $existEmail = databaseCheckerUsername($db, $username);
    $existUsername = databaseCheckerEmail($db, $email);

    if ($existUsername == false && $existEmail == false)
    {
        //    TODO: wachtwoord Hashen
        if (password_strength($password) === true)
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            //    TODO: user inserten in database
            $sql = "INSERT INTO logins (username, email, password) VALUES (:username, :email, :password)";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
            //    TODO: doorsturen naar inlogpagina
            $msg = "account succesful created";
            header("location: ../login.php?msg=$msg");
            exit;
        }
    }
    else
    {
        $msg = "gebruikersnaam of email bestaan al";
        header("location: ../register.php?msg=$msg");
        exit;
    }
    exit;
}

if ($_POST['type'] === 'logout')
{
    session_destroy();
    header('location: ../index.php');
    exit;
}





