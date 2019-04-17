<?php

namespace keea18\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number;
    private $tries;
    private $maxTries;
    
    /* Game states */
    const HIGH = 1;
    const LOW = 2;
    const WIN = 3;
    const LOSE = 4;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries    Amount of tries played by the player
     * @param int $maxTries  Maximum amount of tries available to the user,
     *                    default 6.
     */
    
    public function __construct(int $number = null, int $tries = 0, int $maxTries = 6)
    {
        if ($number==null) {
            /* RESET SOME STUFF */
            $number = $this->random();
            $_SESSION['number'] = $number;
            $_SESSION['tries'] = $tries;
        }
        $this->number = $number;
        $this->tries = $tries;
        $this->maxTries = $maxTries;
    }
    
    
    



    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return The secret number between 1 - 100
     */
    
    public function random()
    {
        return rand(1, 100);
    }
    



    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    
    public function triesLeft()
    {
        return ($this->maxTries - $this->tries);
    }
    



    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    
    public function getAnswer()
    {
        return $this->number;
    }
    



    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    
    public function makeGuess($number)
    {
        if ($this->triesLeft()<=0) {
            return Guess::LOSE;
        }
        if ($number<=0||$number>100) {
            throw new GuessException();
        }
        
        $this->tries++;
        $_SESSION['tries'] = $this->tries;
        
        if ($number == $this->number) {
            $this->winCondition();
            return Guess::WIN;
        } else if ($number > $this->number) {
            return Guess::HIGH;
        } else {
            return Guess::LOW;
        }
    }
    
    /**
        * Private function to be called when the player wins
        * @returns void
        */
    private function winCondition()
    {
        $this->tries = $this->maxTries;
        $_SESSION['tries'] = $this->maxTries;   //Don't allow the player to try anymore
    }
    
    /**
        * Get a hint / show status of current game (win, loss)
        * @return   string  Status of guess
        */
    public static function getHint($status)
    {
        switch ($status) {
            case Guess::LOW:
                return "<b>too low</b>";
                break;
            case Guess::HIGH:
                return "<b>too high</b>";
                break;
            case Guess::WIN:
                return "Congratulations!";
                break;
            default:
                return $status;
        }
    }
}
