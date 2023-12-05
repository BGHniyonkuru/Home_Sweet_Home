<?php
 require "./bd.php";
?>
<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat Box</title>
        <script
			  src="https://code.jquery.com/jquery-3.7.1.min.js"
			  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			  crossorigin="anonymous">
        </script>
        <link rel="stylesheet" type="text/css" href="./Style/style.css"><title> Chat Box </title>
    </head>

    <body>
        <form method="POST" action="" align="center">
            <input type="text" name="pseudo">
            <textarea name="message"></textarea> 
            <br>
            <input type="submit" name = "send">
        </form>
            
        <section id="messages"> </section>
    </body>
</html>