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
class JediShip extends Ship
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

## Ch4 parent

### Q1

It took too long to travel to planets to destroy them
in the first Deathstar, so Darth wants the laser range
on the new Deathstar to be *twice* as far! Override
the `getLaserRange()` method in `DeathstarII` to this
happen. But don't repeat the 2000000 value! Call the
parent function!

 Make the
`getLaserRange()` method of `DeathstartII` return 2 times


**Starting Code**
`Deathstar.php`
<?php

class Deathstar
{
    public function getLaserRange()
    {
        return 2000000;
    }
}

`DeathstarII.php`
<?php

class DeathstarII extends Deathstar
{
}

`index.php`
<?php
require 'Deathstar.php';
require 'DeathstarII.php';

$deathstar = new DeathstarII();

<h3>
    Laser Range <?php echo $deathstar->getLaserRange(); ?>
</h3>

## Ch 5 abstract-ship

### Q1)

We've just gotten word that the Rebels have *also*
dstroyed the `DeathstarII`. Wow, rotten luck. Anyways,
it sounds like we'll be creating blue prints for many
different types of Deathstar's in the future, to keep
the Rebels guessing.

To make this easier, create an `AbstractDeathstar` class,
move all of the shared code into it, and update
`Deathstar` and `DeathstarII` to extend this new class.
Make sure to get rid of anything in those classes
that you've moved into the new parent class.

--> For this activity, I was thinking about not
grading any output - index.php just exists so they
can play and get some output

**Starting Code**
`Deathstar.php`
<?php

class Deathstar
{
    private $crewSize;
    
    private $weaponPower;
    
    public function setCrewSize($numberOfPeople)
    {
        $this->crewSize = $numberOfPeople;
    }
    
    public function getCrewSize()
    {
        return $this->crewSize;
    }
    
    public function setWeaponPower($power)
    {
        $this->weaponPower = $power;
    }
    
    public function getWeaponPower()
    {
        return $this->weaponPower;
    }
    
    public function makeFiringNoise()
    {
        echo 'BOOM x '.$this->getWeaponPower;
    }
}

`DeathstarII.php`
<?php

class DeathstarII extends Deathstar
{   
    // this Deathstar must *always* have 5000 people on it
    public function getCrewSize()
    {
        return 5000;
    }

    public function makeFiringNoise()
    {
        echo 'SUPER BOOM';
    }
}

`AbstractDeathstar.php`
<empty>

`index.php`
<?php
require 'AbstractDeathstar.php';
require 'Deathstar.php';
require 'DeathstarII.php';

$deathstar1 = new Deathstar();
$deathstar1->setCrewSize(3000);
$deathstar1->setWeaponPower(500);

$deathstar2 = new DeathstarII();
$deathstar2->setWeaponPower(999);

<table>
    <tr>
        <td>&nbsp;</td>
        <th>Deathstar 1</th>
        <th>Deathstar 2</th>
    </tr>
    <tr>
        <th>Crew Size</th>
        <td><?php echo $deathstar1->getCrewSize(); ?></td>
        <td><?php echo $deathstar2->getCrewSize(); ?></td>
    </tr>
    <tr>
        <th>Weapon Power</th>
        <td><?php echo $deathstar1->getWeaponPower(); ?></td>
        <td><?php echo $deathstar2->getWeaponPower(); ?></td>
    </tr>
    <tr>
        <th>Fire!</th>
        <td><?php echo $deathstar1->makeFiringNoise(); ?></td>
        <td><?php echo $deathstar2->makeFiringNoise(); ?></td>
    </tr>
</table>

### Question 2

A co-worker created a few classes and has asked for
your advice about organizing them:

```php
class Ship
{
    private $name;
    
    public function getName()
    {
        return $name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    // other stuff...
}
```

```php
class Person
{
    private $name;
    
    public function getName()
    {
        return $name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // other stuff...
}
```

Your teammate is wondering if this can be organized
better. Which if the following is the best advice?

A) Create a new `AbstractNamedItem` class that has the
`name` property and the `getName()` and `setName()`
methods. Then, make `Person` and `Ship` extend this
class.

B) Make `Ship` extend `Person`, and remove all the
duplicated code in `Person`.

C) Leave things exactly like they are now.

Correct: (C)

Explanation:

Even though both classes share some code, a `Ship`
and a `Person` fundamentally aren't the same thing,
and probably don't have any other overlapping code.
So, you *could* create an `AbstractNamedItem`, but
that's a bit awkward. And remember, you can only
extend *one* class, so make sure your parent class
makes sense.

In this case, the best action is to do nothing: leave
these two blueprints totally independent. In a future
episode, we'll talk about traits: a cool way to help
remove duplication without inheritance.

## Chapter 6

### Question 1

Check out these classes that the intern created,
which all have confusing names:

```php
abstract class OtherClass extends GreatClass
{
}
```

```php
abstract class SomeClass extends OtherClass
{
}
```

```php
class GreatClass
{
}
```

```php
class MyClass extends OtherClass
{
}
```

```php
class Puppy extends SomeClass
{
}
```

function doSomething(OtherClass $thing)
{
    // ...
}

Based on the type-hint, which classes could and
could not be passed to the `doSomething()` function?

A) `OtherClass` and `SomeClass`
B) `OtherClass` and `MyClass`
C) `OtherClass`, `MyClass`, `SomeClass` and `Puppy`
D) `OtherClass` and `GreatClass`

Answer: (C)

Explanation:

Don't let the `abstract` keyword confuse you: it makes
no difference here. Since the type-hint is `OtherClass`,
any `OtherClass` object, or sub-classes are accepted.
The sub-clases are `MyClass` and `SomeClass` (directly)
and also `Puppy` (though `SomeClass`).

### Question 2

When Darth is browing all the different Deathstar models,
we want to print out a little description that describes
each one. Inside of that description, we want to include
the "laser range", but it's different based on the model.
Use an abstract method to return descriptions with the
proper ranges included:

* `Deathstar` laser range = 500
* `DeathstarII` laser range = 900

**Starting Code**
`AbstractDeathstar.php`
<?php

class AbstractDeathstar()
{
    public function getDescription()
    {
        // replace this with a call to get the correct
        // range based on which Deatstar class is used
        $range = '???';
    
        return <<<EOF
A fantastic death machine, made to be extra cold and
intimidating. It comes complete with a "superlaser"
capable of destroying planets, with a range of $range.    
EOF;
    }
}

`Deathstar.php`
<?php

class Deathstar extends AbstractDeathstar
{
}

`DeathstarII.php`
<?php

class DeathstarII extends AbstractDeathstar
{
}

`index.php`
<?php
require 'AbstractDeathstar.php';
require 'Deathstar.php';
require 'DeathstarII.php';

$deathstar = new Deathstar();
$deathstar2 = new DeathstarII();

<h3>
    Original Deathstar
    <p><?php echo $deathstar->getDescription(); ?></p>
</h3>

<h3>
    Deathstar 2
    <p><?php echo $deathstar2->getDescription(); ?></p>
</h3>
