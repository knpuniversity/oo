<?php

namespace Model;

class Ship extends AbstractShip
{
    use SettableJediFactorTrait;

    private $underRepair;

    public function __construct($name)
    {
        parent::__construct($name);

        // randomly put this ship under repair
        $this->underRepair = mt_rand(1, 100) < 30;
    }

    public function isFunctional()
    {
        return !$this->underRepair;
    }

    public function getType()
    {
        return 'Empire';
    }
}
