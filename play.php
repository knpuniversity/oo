<?php

class Ship
{
    public $name;

    public function sayHello()
    {
        echo 'Hello!';
    }

    public function getName()
    {
        return 'FAKE NAME';
    }
}

// but it doesn't do anything yet...
$myShip = new Ship();
$myShip->name = 'TIE Fighter';

echo 'Ship Name: '.$myShip->getName();
echo '<hr/>';
$myShip->sayHello();
