<?php

class BattleResult
{
    private $usedJediPowers;
    private $winningShip;
    private $losingShip;

    public function __construct($usedJediPowers, $winningShip, $losingShip)
    {
        $this->usedJediPowers = $usedJediPowers;
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
    }
}
