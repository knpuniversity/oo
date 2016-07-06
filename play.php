<?php

class Ship
{
    public $name;
}

// but it doesn't do anything yet...
$myShip = new Ship();
$myShip->name = 'TIE Fighter';

echo 'Ship Name: '.$myShip->name;
