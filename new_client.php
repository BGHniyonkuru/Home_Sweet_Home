<?php
    require "./bd.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New client survey</title>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./Style/style.css">

        <style>
            .valid {
                border: 1px solid green;
                background: green;
            }

            .invalid {
                border: 1px solid red;
                background: red;
            }

            .error-message {
                color: red;
            }
        </style>
    </head>

    <body class="header">
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

        <form method="POST" id="registration_form">
            <label for="first_name">First name : </label>
            <input type="text" name="n" id="n" class="registration-field" required><br />
            
            <label for="last_name">Last name : </label>
            <input type="text" name="p" id="p" class="registration-field" required><br />

            <label for="address">Address : </label>
            <input type="text" name="adr" id="adr" class="registration-field" required><br />

            <label for="phone_number">Phone number : </label>
            <input type="text" name="num" id="num" class="registration-field" required><br />

            <label for="email">E-mail : </label>
            <input type="text" name="mail" id="mail" class="registration-field" required>
            <div id="email-error" class="error-message"></div>

            <label for="password1">Password : </label>
            <input type="password" name="mdp1" id="mdp1" class="registration-field" required><br />

            <label for="password2">Confirm your password : </label>
            <input type="password" name="mdp2" id="mdp2" class="registration-field" value="" required><br />

            <div id="error-messages"></div>

            <input type="button" value="Send" id="submit_button"><br />
        </form>

        <script>
            $(document).ready(function(){
                var isValid = true;

                function setValidity(element, isValid, message) {
                    element.removeClass(isValid ? "invalid" : "valid").addClass(isValid ? "valid" : "invalid");
                    element.next(".error-message").text(isValid ? "" : message);
                }
                
                function validateField(field, message){
                    var value = field.val();
                    setValidity(field, value !== "", message);
                }

                function validateForm(){
                    isValid = true;

                    $("#p, #n, #adr, #num, #mail, #mdp1, #mdp2").each(function () {
                        validateField($(this), $(this).attr("id") + " is required");
                    });

                    $(".registration-field").each(function(){
                        if (!$(this).hasClass("valid")){
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        $("#error-messages").text("Please fix the errors in the form.");
                    } else {
                        $("#error-messages").text("");
                    }
                }

                $("#p, #n, #adr, #num, #mail, #mdp1, #mdp2").on("input", function () {
                    validateField($(this), $(this).attr("id") + " is required");
                });

                $("#mail").on("input", function () {
                    var email = $(this).val();
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    setValidity($(this), emailRegex.test(email), "Enter a valid email address");
                });

                $("#mdp1").on("input", function(){
                    var password1 = $(this).val();
                    var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
                    setValidity($(this), passwordRegex.test(password1), "Password must contain at least 1 letter, 1 number, and 1 special character");
                });

                $("#mdp2").on("input", function(){
                    var password1 = $("#mdp1").val();
                    var password2 = $(this).val();
                    setValidity($(this), password1 === password2, "Passwords do not match");
                });

                $("#mail").on("input", function() {
                    var email = $(this).val();
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if(emailRegex.test(email)){
                        $.ajax({
                            type: "GET",
                            url: "check_email.php",
                            data: {email: email},
                            success: function(response){
                                if(response === "true"){
                                    setValidity($("#mail"), false, "This email already exists.");
                                } else {
                                    setValidity($("#mail"), true, "");
                                }
                            },
                            error: function (error){
                                console.error("AJAX request failed:", error);
                            }
                        });
                    } else {
                        setValidity($(this), false, "Enter a valid email address");
                    }
                });

                $("#submit_button").click(function(e) {
                    e.preventDefault();
                    validateForm();
                    if (isValid) {
                        $.ajax({
                            type: "POST",
                            url: "enregistrement.php",
                            data: $("#registration_form").serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    var  login={
                                        mailc: $('#mail').val(),
                                        mdp1c: $('#mdp1').val(),
                                    };
                                    $.ajax({
                                        type: "POST",
                                        url: "connecter.php",
                                        data: login,
                                        dataType: 'json',
                                        success: function(connexionResponse) {
                                            if (connexionResponse.success) {
                                                setTimeout(function(){
                                                window.location.href = "index.php";
                                            },1000);
                                            } else {
                                                console.log("Login failed:", connexionResponse.message);
                                            }
                                        },
                                        error: function(connexionError) {
                                            console.error("AJAX request for login failed:", connexionError);
                                        }
                                    });
                                } else {
                                    $("#error-messages").text("Something went wrong. Try again");
                                }
                            },
                            error: function(error) {
                                console.error("AJAX request failed:", error);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
