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
if (isset($motd)) {
    echo "<p>". $motd ."</p>";
}

?>
         <form action="" method="post">
            <input type="submit" name="restart" id="inp" value="restart" />
        </form></div>
<script type="text/javascript">
    window.onload = document.getElementById('inp').focus();
</script>
