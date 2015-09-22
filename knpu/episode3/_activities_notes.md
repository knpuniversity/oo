# Activities Notes

## Ch1 extending

### Question 1

Your team has been working hard building the `Deathstar` class, only
to find out that the Rebels have just destroyed it! Time to rebuild!
Create a new class called `DeathstarII` and make it inherit all of
the functionality from the original `Deathstar`. In `index.php`, instantiate
a new `DeathstarII` object and set it to a `$deathstar` variable.
Long live the Empire!

**Starting Code**
`Deathstar.php`
<?php

class Deathstar
{
    public function blastPlanet($planetName)
    {
        echo 'BOOM '.$planetName;
    }
    
    public function getWeakness()
    {
        return 'Thermal Exhaust Port';
    }
}

`DeathstarII.php`
(empty)

`index.php`
<?php
require 'Deathstar.php';
require 'DeathstarII.php';

// set your $deathstar variable here

### Question 2

Look at these two classes:

```php
class Ship
{
    public function getName()
    {
        return 'Ship name';
    }
}
```

```php
class JediShip
{
    public function getFavoriteJedi()
    {
        return 'Yoda';
    }
}
```

Suppose we instantiate both objects:

```php
$ship = new Ship();
$jediShip = new JediShip();
```

Which of the following lines will cause an error?

A) `echo $ship->getName();`
B) `echo $ship->getFavoriteJedi();`
C) `echo $jediShip->getName();`
D) Both (B) and (C) will cause an error

Correct: B

Explanation:

The `Ship` object does *not* have a `getFavoriteJedi()` method
on it - only `JediShip` has this. But, since `JediShip extends Ship`,
the `JediShip` *does* have a `getName()` method: it inherits it from
`Ship`.

## Ch2 Override

### Question 1

Well, we learned some hard lessons after the destruction of the original Deathstar,
and we don't want to repeat them! Override the `getWeakenss()` method in `DeathstarII`
and make it return `null`. Phew, problem solved!

**Starting Code**
`Deathstar.php`
(same as in chapter 1)

`DeathstarII.php`
(same as correct answer in chapter 1)

`index.php`
<?php
require 'Deathstar.php';
require 'DeathstarII.php';

$original = new Deathstar();
$new = new DeathstarII();

<h2>Original Deathstar Weakness: $original->getWeakness(); ?></h2>
<h2>New Deathstar Weakness: $new->getWeakness(); ?></h2>

### Question 2

Look at the following classes:

```php
class Ship
{
    public function printType()
    {
        echo 'Empire Ship';
        
        $this->printMotto();
    }
    
    public function printMotto()
    {
        echo 'I like to fly!';
    }
}
```

```php
class RebelShip
{
    public function printType()
    {
        echo 'Rebel Ship';
    }
}
```

What is the result of the following code:

```
$ship = new Ship();
$rebelShip = new RebelShip();
$ship->printType();
$rebelShip->printType();
```

A) `Empire ShipRebelShip`
B) `Empire ShipI like to flyRebelShip`
C) `Empire ShipI like to flyRebelShipI like to fly`
D) `RebelShipRebelShip`

Explanation:
For `Ship`, `printType()` prints "Empire Ship" and then also
calls `printMotto()`. But for `RebelShip`, `printType()` only
prints "Rebel Ship": it does *nothing* calls the `printMotto()`
function in this case.

## Ch 3 protected-visibility

### Question 1

The construction of the `DeathstarII` continues, but we need access
to the `planetarySuperLaserRange` property from the original, because
we're going to make it fire twice as far! Fix the `Deathstar` class
so that the new `getSpecs()` method works:

**Starting Code**
`Deathstar.php`
<?php

class Deathstar
{
    private $planetarySuperLaserRange = 2000000;
}

`DeathstarII.php`
<?php

class DeathstarII extends Deathstar
{
    public function getSpecs()
    {
        return array(
            'name' => 'DeathstarII',
            'laser_range' => $this->planetarySuperLaserRange * 2,
        );
    }
}

`index.php`
<?php
require 'Deathstar.php';
require 'DeathstarII.php';

$deathstar = new DeathstarII();

<h2>New Deathstar Specs</h2>
<table>
    <?php foreach ($deathstar->getSpecs() as $key => $val): ?>
    <tr>
        <th><?php echo $key; ?></th>
        <td><?php echo $val; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

### Question 2

Check out the following code:

```php
class Ship
{
    public $name;
    protected $weaponPower;
    private $defense;
    
    public function getDefense()
    {
        return $this->defense;
    }
}
```

```php
class JediShip
{
    public function getWeaponPower()
    {
        return $this->weaponPower;
    }
}
```

```
$jediShip = new JediShip();
$jediShip->name;
$jediShip->weaponPower;
```

Which of the above code will give us an error?

A) `$jediShip->weaponPower` in `index.php`
B) `return $this->defense` in `Ship.php`
C) `return $this->weaponPower` in `RebelShip`
D) None of the above is bad code - we're awesome!

Correct: A)

Explanation:

Since the `$defense` property is private, we can only access it from
within the `Ship` class. But that's exactly what we're doing in (B),
so that's fine.

The `$weaponPower` property is protected. That means we can access it
only from inside `Ship`, `JediShip` or any other sub-classes. That's why
(C) is valid. But in (A), we're accessing `weaponPower` from `index.php`.
Accessing a property or method from outside of the class is only allowed
if it is public. This is bad code.
