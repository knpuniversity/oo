<?php

namespace Model;

class BountyHunterShip extends AbstractShip
{
    private $jediFactor;

    public function getJediFactor()
    {
        return $this->jediFactor;
    }

    public function getType()
    {
        return 'Bounty Hunter';
    }

    public function isFunctional()
    {
        return true;
    }

    public function setJediFactor($jediFactor)
    {
        $this->jediFactor = $jediFactor;
    }
}
