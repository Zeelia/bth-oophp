<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=2, maximum-scale=2, user-scalable=0">
        <link rel="stylesheet" href="style/style.css" title="main" type="text/css" media="screen" charset="utf-8">
    </head>
    <body onload="document.getElementById('inp').focus();">
<?php
    
// Retrieve the message that was saved before the header-redirection
if (isset($_SESSION['_motd'])) {
    echo "<p>".$game->getHint($_SESSION['_motd'])."</p>";
    unset($_SESSION['_motd']);
} else {
    echo "<p>Number Game</p>";
}

?>
         <form action="#" method="post">
            <input type="submit" id="inp" name="restart" value="restart" />   
        </form>
    </body>
</html>
