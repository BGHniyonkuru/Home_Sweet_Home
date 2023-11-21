<?php 
            /*if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // Le formulaire a été soumis, récupérez les données du formulaire
                $n = isset($_POST['n']) ? $_POST['n'] : "";
                $p = isset($_POST['p']) ? $_POST['p'] : "";
                $adr = isset($_POST['adr']) ? $_POST['adr'] : "";
                $num = isset($_POST['num']) ? $_POST['num'] : "";
                $mail = isset($_POST['mail']) ? $_POST['mail'] : "";
                $mdp1 = isset($_POST['mdp1']) ? $_POST['mdp1'] : "";
            }*/
        ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New client survey</title>
        <script
			  src="https://code.jquery.com/jquery-3.7.1.min.js"
			  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			  crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="./Style/style.css">
        
    </head>

    <body class="groupeX">
        <h1>Home Sweet Home - Create an account</h1>

        <header>
            <nav>
                <ul>
                    <li><a href="./index.php">Homepage</a></li>
                    <li><a href="./Contact/contact.html">Contact</a></li>
                    <li><a href="./connexion.php">Log in</a></li>
                </ul>
            </nav>
        </header>

        <form method="post" action="./enregistrement.php" autocomplete="on" id="registration_form">

            First name : <INPUT type="text" name="n" id="first_name" class="registration-field" required><br />
            
            Last name : <INPUT type="text" name="p" id="last_name" class="registration-field" required><br />

            Address : <INPUT type="text" name="adr" id="address" class="registration-field" required><br />

            Phone number : <INPUT type="number" name="num" id="phone_number" class="registration-field" required><br />

            E-mail : <INPUT type="text" name="mail" id="email" class="registration-field" required><br />

            Password : <INPUT type="password" name="mdp1" id="password1" class="registration-field" required><br />

            Confirm your password : <INPUT type="password" id="password2" class="registration-field" value="" required><br />

            <INPUT type="submit" value="Send"><br />

        </form>

        <script>
            $(document).ready(function(){
                function validateForm(){
                    var isValid = true;

                    function setValidity(element, isValid, message){
                        if (isValid){
                            element.removeClass("invalid").addClass("valid");
                            element.next(".error-message").text("");
                        }
                        else{
                            element.removeClass("valid").addClass("invalid");
                            element.next(".error-message").text("");
                            isValid = false;
                        }
                    }

                    $("#first_name").on("input", function(){
                        var firstName = $(this).val();
                        setValidity($(this), firstName !== "", "First name is required");
                    });

                    $("#last_name").on("input", function(){
                        var lastName = $(this).val();
                        setValidity($(this), lastName !== "", "Last name is required");
                    });

                    $("#address").on("input", function(){
                        var address = $(this).val();
                        setValidity($(this), address !== "", "Address is required");
                    });

                    $("#phone_number").on("input", function(){
                        var phone_number = $(this).val();
                        setValidity($(this), phone_number !== "", "Phone number is required");
                    });
                    
                    $("#email").on("input", function(){
                    var email = $(this).val();
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    setValidity($(this), emailRegex.test(email), "Enter a valid email address");
                });

                $("#password1").on("input", function(){
                    var password1 = $(this).val();
                    var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
                    setValidity($(this), passwordRegex.test(password1), "Password must contain at least 1 letter, 1 number, and 1 special character");
                });

                $("#password2").on("input", function(){
                    var password1 = $("#password1").val();
                    var password2 = $(this).val();
                    setValidity($(this), password1 === password2, "Passwords do not match");
                });

                }

                $(".registration_field").each(function(){
                    if (!$(this).hasClass("valid")){
                        isValid = false;
                    }
                });

                return isValid;

                $("#registration_form").submit(function(){
                return validateForm();
            });
        </script>
            
    </body>
</html>
  

