<?php

namespace Model;

class ShipCollection
{
    /**
     * @var AbstractShip[]
     */
    private $ships;

    public function __construct(array $ships)
    {
        $this->ships = $ships;
    }
}
