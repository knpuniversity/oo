# Activities Notes

## Ch1 extending

### Question 1

Your team has been working hard building the `Deathstar` class, only
to find out that the Rebels have just destroyed it! Time to rebuild!
Create a new class called `DeathstarII` and make it inherit all of
the functionality from the original `Deathstar`. In `index.php`, instantiate
a new `DeathstarII` object and set it to a `$deathstar` variable.
Long live the Empire!

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


