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

## Chapter 6 Adding Abstract

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

## Chapter 7-broken-ship

- Create a new deathstar, implement the methods

### Question 1

I feel like we're *always* designing new Deathstars. Well, time to start
the DeathstarIII! Create a new `DeathstarIII` class, make it extend
`AbstractDeathstar`, and fill in any missing abstract methods. Finally,
print out the description in `index.php`.

**Starting Code**
`AbstractDeathstar.php`
<?php

class AbstractDeathstar()
{
    abstract protected function getLaserRange();
    
    public function getDescription()
    {
        // replace this with a call to get the correct
        // range based on which Deatstar class is used
        $range = getLaserRange();
    
        return <<<EOF
A fantastic death machine, made to be extra cold and
intimidating. It comes complete with a "superlaser"
capable of destroying planets, with a range of $range.    
EOF;
    }
}

`DeathstarIII.php`
    empty

`index.php`
<?php
require 'AbstractDeathstar.php';
require 'DeathstarII|.php';

<h3>
    The Deathstar 3
    
    <!-- print the description here -->
</h3>

## Chapter 8 PdoShipStorage

### Question 1

Tired from working on the Deathstar, you challenged the intern (let's call him
"Bob") to create a class that can reverse a string and upper case every other letter.
"Ha!" John says, "This is simple!". To show off, John creates the `StringTransformer`
class and *even* makes it cache the results to be super-performant.

But wait you say! Combining the string transformation *and* caching into the same
class make `StringTransformer` responsible for two jobs. Help show Bob the intern
a better way, by creating a new `Cache` class with two methods `fetchFromCache($key)`
and `saveToCache($key, $val)`. Then, pass this into `StringTransformer` and use it
to cache, instead of using your own logic:

**Starting Code**
```StringTransformer.php
class StringTransformer
{
    public function transformString($str)
    {        
        $cacheFile = __DIR__.'/cache/'.md5($str);
        
        if (file_exists($cacheFile)) {
            return file_get_contents($cacheFile);
        }
        
        $newString = '';
        foreach (str_split(strrev($str), 2) as $twoChars) {
            var_dump($twoChars);
            // capitalize the first of 2 characters
            $newString .= ucfirst($twoChars);
            
        }

        if (!file_exists(dirname($cacheFile))) {
            mkdir(dirname($cacheFile));
        }
        file_put_contents($cacheFile, $newString);
        
        return $newString;
    }
}
```

```Cache.php
(empty)
```

```index.php
require 'Cache.php';
require 'StringTransformer.php';

$str = 'Judge me by my size, do you?';

$transformer = new StringTransformer();
var_dump($transformer->transformString($str));
```

### Question 2

In the previous challenge, you split the logic from StringTransformer into two
different classes. What are the advantages of this?

A) Each class is smaller and so easier to understand.

B) The Cache class could be re-used to cache other things

C) You could easily use the StringTransformer, but cache using a different
mechanism, like Redis.

D) All of these are real advantages

Answer: D (kind of easy)

**Explanation** All of these are advantages! Before, you might not even realize that
the StringTransformer had caching logic, but now its very obvious: the caching logic
is in a class called `Cache` and you can see that the `StringTransformer` requires
a `Cache` object. You could also use the `Cache` class in other situations to cache
other things. And you could even - with a little bit of work - create a new `Cache`
class that caches via something like Redis, and pass *this* to `StringTransformer`
to cache using a different method.

## Chapter 9-abstract-ship-loader

Tired of their Deathstars being destroyed, the Empire has decided to transform into
a video game company. Awesome! Two different teammates have already created two
classes to model this: `SolidPlanet` and `GasPlanet`. They look and work differently,
but both have `getRadius()` and `getHexColor()` methods. You've built a `PlanetRenderer`
class with a `render()` method, but it's not quite working yet.

Create an `AbstractPlanet` class and update any other code you need to make these
planets render!

**Starting Code**
```SolidPlanet.php
<?php

class SolidPlanet
{
    private $radius;
    private $hexColor;
    
    public function __construct($radius, $hexColor)
    {
        $this->radius = $radius;
        $this->hexColor = $hexColor;
    }
    
    public function getRadius()
    {
        return $this->radius;
    }
    
    public fucntion getHexColor()
    {
        return $this->hexColor;
    }
}
```

```GasPlanet.php
class GasPlanet
{
    private $diameter;
    
    private $mainElement;
    
    public function __construct($mainElement, $diameter)
    {
        $this->diameter = $diameter;
        $this->mainElement = $mainElement;
    }
    
    public function getRadius()
    {
        return $this->diameter/2;
    }
    
    public function getHexColor()
    {
        // a "fake" map of elements to colors
        switch ($this->mainElement) {
            case 'ammonia':
                return '663300';
            case 'hydrogen':
            case 'helium':
                return 'FFFF66';
            case 'methane':
                return '0066FF';
            default:
                return '464646;
        }
    }
}
```

```AbstractPlanet.php
empty
```

```PlanetRenderer.php
<?php
class PlanetRenderer
{
    public function render(SolidPlanet $planet)
    {
        return sprintf(
            '<div style="width: %spx; height: %spx; border-radius: %spx; background-color: #%s;"></div>',
            $planet->getRadius() * 2,
            $planet->getRadius() * 2,
            $planet->getRadius(),
            $planet->getHexColor()
        );
    }
}
```

```index.php
<?php

require 'AbstractPlanet.php';
require 'SolidPlanet.php';
require 'GasPlanet.php';
require 'PlanetRenderer.php';

$planets = array(
    new SolidPlanet(10, 'CC66FF'),
    new SolidPlanet(50, '00FF99'),
    new GasPlanet('ammonia', 100),
    new GasPlanet('methane', 150),
);

$renderer = new PlanetRenderer();

foreach ($planets as $planet) {
    echo $renderer->render($planet);
}
```

## Chapter 10 interfaces

### Question 1

After watching this last episode, you realize that `AbstractPlanet` should really
be an interface. I've given you a head start by creating the `PlanetInterface`.
Now, update all of your code to use it and get these planets rendering again!

**Starting Code**
```SolidPlanet.php
<?php

class SolidPlanet extends AbstractPlanet
{
    private $radius;
    private $hexColor;
    
    public function __construct($radius, $hexColor)
    {
        $this->radius = $radius;
        $this->hexColor = $hexColor;
    }
    
    public function getRadius()
    {
        return $this->radius;
    }
    
    public fucntion getHexColor()
    {
        return $this->hexColor;
    }
}
```

```GasPlanet.php
class GasPlanet extends AbstractPlanet
{
    private $diameter;
    
    private $mainElement;
    
    public function __construct($mainElement, $diameter)
    {
        $this->diameter = $diameter;
        $this->mainElement = $mainElement;
    }
    
    public function getRadius()
    {
        return $this->diameter/2;
    }
    
    public function getHexColor()
    {
        // a "fake" map of elements to colors
        switch ($this->mainElement) {
            case 'ammonia':
                return '663300';
            case 'hydrogen':
            case 'helium':
                return 'FFFF66';
            case 'methane':
                return '0066FF';
            default:
                return '464646;
        }
    }
}
```

```PlanetInterface.php
<?php

interface PlanetInterface
{
    /**
     * Return the radius if the planet, in thousands of kilometers.
     *
     * @return integer
     */
    public function getRadius();
    
    /**
     * Return the hex color (without the #) for the planet.
     *
     * @return string
     */
    public function getHexColor();
}
```

```PlanetRenderer.php
<?php
class PlanetRenderer
{
    public function render(AbstractPlanet $planet)
    {
        return sprintf(
            '<div style="width: %spx; height: %spx; border-radius: %spx; background-color: #%s;"></div>',
            $planet->getRadius() * 2,
            $planet->getRadius() * 2,
            $planet->getRadius(),
            $planet->getHexColor()
        );
    }
}
```

```index.php
<?php

require 'PlanetInterface.php';
require 'SolidPlanet.php';
require 'GasPlanet.php';
require 'PlanetRenderer.php';

$planets = array(
    new SolidPlanet(10, 'CC66FF'),
    new SolidPlanet(50, '00FF99'),
    new GasPlanet('ammonia', 100),
    new GasPlanet('methane', 150),
);

$renderer = new PlanetRenderer();

foreach ($planets as $planet) {
    echo $renderer->render($planet);
}
```

### Question 2

You over-hear the intern Bob telling another teammate about the differences between
abstract classes and interfaces. He's *mostly* right, but he got one detail wrong.
Which of the following is *not* true:

A) Classes an implement many interfaces, but only extend one class.
B) Abstract classes can contain concerete methods, but interfaces can't.
C) Interfaces force the user to implement certain methods, abstract classes do not.
D) Even though Interfaces don't use the `abstract` keyword before methods, those
methods act just like abstract methods in an abstract class.

Answer: (C)

C is the only answer that's incorrect: both interfaces and abstract classes can
force you to implement methods in the classes that use them. So in many ways, they
are the same.

So why use one or the other? Well, a class can implement *many* interfaces, which
makes interfaces more attractive, especially for re-usable code. But, an abstract
class can contain *real* methods, which can help you reduce code duplication between
classes. They're similar, but not the same.


### Question 3

Now you're working on creating different weapons for the spaceships in our game.
By looking at the `WeaponInterface` create a new `LaserWeapon` class that implements
this interface. You can return anything you want from the methods. Use the class
to print out the weapon's range, just to see that things are working:

**Starting Code**
```WeaponInterface.php
<?php

interface WeaponInterface
{
    /**
     * @return integer The weapon's range in kilometers
     */
    public function getWeaponRange();
    
    /**
     * @return bool Is this weapon effective in space
     */
    public function canBeUsedInSpace();
    
    /**
     * @return integer The amount of damage the weapon will cause against the given material
     */
    public function getWeaponStrengthAgainstMaterial($material);
}

```LaserWeapon.php
empty
```

```index.php
require 'WeaponInterface.php';
require 'LaserWeapon.php';

// instantiate a new LaserWeapon here

?>

<h1>
    <!-- print your weapon's getWeaponRange() here -->
</h1>
```
