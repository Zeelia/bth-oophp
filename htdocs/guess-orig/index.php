<?php
    
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");

session_name("keea18");
session_start();

$number = null;
$tries = 0;

// Restart the game
if (isset($_POST['restart'])) {
    session_destroy();
    header("Location: index.php");
    die();
}

// If the game has been started before, retrieve that session 
if (isset($_SESSION['number'])) {
    $number = $_SESSION['number'];
    $tries = $_SESSION['tries'] ?? 0;
}

// Start a new game (with previous session vars if exists)
$game = new Guess($number, $tries);

// Check if an answer has been submitted
if (isset($_POST['submit'])&&$game->triesLeft()>=1) {
    $guess = $_POST['guess'];
    
    try {
        $result = $game->makeGuess($guess);
    } catch (GuessException $e) {
        $result = "Enter 1 - 100";
    }
    
    $_SESSION['_motd'] = $result;
    
    header("Location: index.php");
    die();
}

// Include the view
if ($game->triesLeft()>0) {
    include("view/game.php");
} else {
    include("view/game_over.php");
}
