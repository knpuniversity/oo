<?php

class Ship
{
    public $name;

    public $weaponPower = 0;

    public $jediFactor = 0;

    public $strength = 0;

    public function sayHello()
    {
        echo 'Hello!';
    }

    public function getName()
    {
        return $this->name;
    }
}

// but it doesn't do anything yet...
$myShip = new Ship();
$myShip->name = 'TIE Fighter';
$myShip->weaponPower = 10;

echo 'Ship Name: '.$myShip->getName();
echo '<hr/>';
$myShip->sayHello();
echo '<hr/>';
var_dump($myShip->weaponPower);
