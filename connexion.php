<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New client survey</title>
        <link rel="stylesheet" type="text/css" href="./Style/style.css">
        
    </head>

    <body class="groupeX">
        <h1>Home Sweet Home - Log in</h1>

        <header>
            <nav>
                <ul>
                    <li><a href="./index.php">Homepage</a></li>
                    <li><a href="./new_client.php">Create an account</a></li>
                    <li><a href="./Contact/contact.html">Contact</a></li>
                </ul>
            </nav>
    </header>

    <form method="post" action="./connecter.php">

            E-mail : <INPUT type="text" name="mail" value="" required><br />
            
            Password : <INPUT type="text" name="mdp" value="" required><br />

            <INPUT type="submit" value="Log in"><br />

    </form>

    

    </body>

</html>