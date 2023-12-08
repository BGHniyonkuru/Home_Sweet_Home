<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log in</title>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./Style/style.css">
    </head>

    <body class="header">
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

        <form id="loginForm">
            E-mail : <input type="text" id="mail" name="mail" value="" required><br />
            Password : <input type="password" id="mdp1" name="mdp1" value="" required><br />
            <input type="button" id="loginButton" value="Log in"><br />
        </form>

        <script>
            $(document).ready(function(){
                $("#loginButton").on("click", function(){
                    var  login={
                                        mailc: $('#mail').val(),
                                        mdp1c: $('#mdp1').val(),
                                    };
                    $.ajax({
                        type: "POST",
                        url: "connecter.php",
                        data: login,
                        dataType: 'json',
                        success: function(response){
                            console.log(response);

                            if (response.success){
                                window.location.href = "index.php";
                            } else {
                                alert("Login failed. " + response.message);
                            }
                        },
                        error: function(error){
                            console.error("AJAX request failed:", error);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
