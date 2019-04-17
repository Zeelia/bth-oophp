<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Number Game</h1><div class="guess">
<?php
    
// Retrieve the message that was saved before the header-redirection
if ($motd!="") {
    echo "<p>". $motd ."</p>";
}

?><p><?= "<b>{$tries}</b> tries left"; ?></p>
         <form action="" method="post">
            <input type="number" id="inp" name="guess" maxlength="2" min="1" max="100" placeholder="<?= rand(1, 100); ?>" pattern="[0-9]*" />
            <input type="submit" name="submit" value="send" />
            <input type="submit" name="cheat" value="cheat" />
        </form></div>
<script type="text/javascript">
    window.onload = document.getElementById('inp').focus();
</script>
