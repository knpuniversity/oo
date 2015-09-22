# Extends

Welcome back for Episode 3 of our Object Oriented Series! We're ready
to get serious about Inheritance. And not just from that rich uncle of yours. 
I'm talking about extending classes, abstract classes, interfaces, stuff 
that really makes object oriented code nice but doesn't always look easy at first.

Don't worry this will all start to feel really familiar in a suprisingly 
small amount of time!

I'm already in the project that we've been working on through this series.
If you don't have this yet download the code and use what's in the 'start'
directory.

In my terminal I've also started the built in web server with `php -S localhost:8000`.
Be careful to do that in the start directory of the project.

## Creating a new RebelShip class

So far in our project we have just this one lonely ship object. We query things
from the database and we load this ship. But exciting things are happening
and we have a new problem! We want to model two different types of ships. We have
normal ships from the empire and since those are kinda evil we also now want rebel ships
to set them straight!

In the browser you can see we have two rebel ships in here coming from the database.

I would really like rebel ships to fundamentally work differently. For example, they
break down less often and have higher jedi powers. Let me show you what I mean. 

Create a new PHP class called `RebelShip`:

[[[ code('8f42785e26') ]]]

Easy! Since rebel ships aren't exactly like boring old Empire ships let's create
a new class or blueprint that models how these work.

Head on into `bootstrap.php` and require the `RebelShip` file there:

[[[ code('e35b725cee') ]]]

We don't have an `autoloader` yet so we still have to worry about these require statements.

Rebel ships are different than Empire ones but they do share about 99% of their 
attributes. For example, they both have wings, fire power, defense power, etc. 

## Class Inheritance with extends

My first instinct should be to go into `Ship.php` and copy all of the contents and
paste that into `RebelShip.php` since most of it will probably apply. But I shouldn't
need to remind you that this would be a silly amount of duplication in our code which
would make everyone sad. This is our chance to let classes help us not be sad by using
the extends keyword.

By saying `class RebelShip extends Ship` everything that's in the `Ship` class
is automatically inside of `RebelShip`:

[[[ code('89c2892307') ]]]

It's as if all the properties and methods of `Ship` are now a part of the `RebelShip`
blueprint.

In `index.php` we can say `$rebelShip = new RebelShip('My new rebel ship');` and we
can just add this to the `$ships` array:

[[[ code('67cd12d1b3') ]]]

Remember, down here we iterate over the ships and call things like `getName()`,
`getWeaponPower()` and `getJediFactor()` which don't actually live inside of `RebelShip`:

[[[ code('7389e861ec') ]]]

But when we refresh, it works perfectly!

Lesson number 1: when you have one class that extends another, it inherits (you'll hear
that word a lot) all of the stuff inside that parent class. So we can call methods
like `getName()` or `getNameAndSpecs()` on `RebelShip` because it inherits that from `Ship`.

## Adding new Methods?

Really, `RebelShip` works just like a normal class. If you want to, you can add
completely new functions. Let's do that with `public function getFavoriteJedi()` that
has an array of some cool Jedis. Then use `array_rand` to select one of those:

[[[ code('9e556f0242') ]]]

Since this was all done on `RebelShip`, head over to `index.php` and call that method.
`var_dump($rebelShip->getFavoriteJedi()` and you can see with my autocomplete it's showing
me all of my public functions on both `Ship` and `RebelShip`:

[[[ code('c6d83e47c0') ]]]

You can even see that the `RebelShip` methods are displayed bolder and methods from
the parent class are lighter.

When we refresh, we see our favorite random Jedi, it works perfectly! Extending classes is 
great for reusing code without the sad duplication.
