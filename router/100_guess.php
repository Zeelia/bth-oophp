<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play
 */
$app->router->get("guess/init", function () use ($app) {
    // Start a new game
    $game = new keea18\Guess\Guess();

    // Reset
    unset($_SESSION['_motd']);

    // Redirect
    $app->response->redirect("guess/status");
});



/**
 * Play the game
 */
$app->router->get("guess/status", function () use ($app) {
    // If the game has been started before, retrieve that session
    $number = $_SESSION['number'] ?? null;
    $tries = $_SESSION['tries'] ?? 0;

    // Start a new game (with previous session vars if exists)
    $game = new keea18\Guess\Guess($number, $tries);

    $motd = $_SESSION['_motd'] ?? null;

    $data = [
        "tries" => $game->triesLeft(),
        "motd" => $game->getHint($motd),
    ];

    $app->page->add("guess/status", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => "Gissa mitt nummer",
    ]);
});

/**
 * Play the game - Make a guess
 */
$app->router->post("guess/status", function () use ($app) {
    // If the game has been started before, retrieve that session
    $number = $_SESSION['number'] ?? null;
    $tries = $_SESSION['tries'] ?? 0;

    // Start a new game (with previous session vars if exists)
    $game = new keea18\Guess\Guess($number, $tries);
    $guess = $_POST['guess'];
    
    try {
        $result = $game->makeGuess($guess);
    } catch (\keea18\Guess\GuessException $e) {
        $result = "Enter 1 - 100";
    }

    if (isset($_POST['cheat'])) {
        $result = "Number is " . $number;
    }
    
    $_SESSION['_motd'] = $result;

    if ($game->triesLeft()>=1) {
        $app->response->redirect("guess/status");
    } else {
        $app->response->redirect("guess/restart");
    }
});

/**
 * Game over screen
 */
$app->router->get("guess/restart", function () use ($app) {
    $motd = $_SESSION['_motd'] ?? null;

    $data = [
        "motd" => keea18\Guess\Guess::getHint($motd),
    ];

    $app->page->add("guess/restart", $data);

    return $app->page->render([
        "title" => "Gissa mitt nummer",
    ]);
});

/**
 * Restart the game button clicked
 */
$app->router->post("guess/restart", function () use ($app) {
    session_destroy();
    $app->response->redirect("guess/init");
});
