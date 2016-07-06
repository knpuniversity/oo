<?php

namespace Model;

class BattleResult
{
    private $usedJediPowers;
    private $winningShip;
    private $losingShip;

    /**
     * @param AbstractShip $winningShip
     * @param AbstractShip $losingShip
     * @param boolean $usedJediPowers
     */
    public function __construct($usedJediPowers, AbstractShip $winningShip = null, AbstractShip $losingShip = null)
    {
        $this->usedJediPowers = $usedJediPowers;
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
    }

    /**
     * @return boolean
     */
    public function wereJediPowersUsed()
    {
        return $this->usedJediPowers;
    }

    /**
     * @return Ship|null
     */
    public function getWinningShip()
    {
        return $this->winningShip;
    }

    /**
     * @return Ship|null
     */
    public function getLosingShip()
    {
        return $this->losingShip;
    }

    /**
     * Was there a winner? Or did everybody die :(
     *
     * @return bool
     */
    public function isThereAWinner()
    {
        return $this->getWinningShip() !== null;
    }
}
