# Extends

Welcome back for Episode 3 of our Object Oriented Series! We're ready
to get serious about Inheritance. I'm talking about extending classes,
abstract classes, interfaces, stuff that really makes object oriented
code nice but doesn't always look easy at first.

Don't worry this will all start to feel really familiar in a really 
small amount of time!

I'm already in the project that we've been working on through this series.
If you don't have this yet download the code and use what's in the 'start'
directory.

In a terminal I've also started the built in web server with `php -S localhost:8000`.
Be careful to do that in the start directory of the project.

So far in our project we have just this one lonely ship object. We query things
from the database and we load this ship object. But exciting things are happening
and we have a new problem! We want to model two different types of ships. We have
normal ships and since those are kinda boring we also now want rebel ships!

In the browser you can see we have two rebel ships in here coming from the database,
but these are all eventually going to be ship objects.

I would really like rebal ships to fundamentally work differently. For example, they
break down less often, have higher jedi powers. In a lot of ways a rebel ship is like
a normal one, but there are some behavior differences. Let me show you what I mean. 

Create a new PHP class called `RebelShip`. Easy! Since rebel ships aren't exactly
like boring old normal ships let's create a new class or blueprint that models 
how rebel ships work. 

Head on into `bootstrap.php` and require the `RebelShip` file there. We don't have
an `autoloader` yet so we still have to worry about these require statements. 

A Rebel ship is not exactly the same as a normal Empire ship, but in reality they do
share 99% of their attributes. For example, they both have wings, fire power, defense
power, etc. 

My first instinct should be to go into `Ship.php` and copy all of the contents and
paste that into `RebelShip.php` since most of it will probably apply. But I shouldn't
need to remind you that this would be a silly amount of duplication in our code which
would make everyone sad. This is our chance to let classes help us not be sad by using
the extends keyword.

By saying `class RebelShip extends Ship` everything that's in the `Ship.php` class
is automatically inside of `RebelShip`. It's as if all the properties and methods
of `Ship` are inside of our `RebelShip` class. 

In `Index.php` we can say `$rebelShip = new RebelShip('My new rebel ship');` and we
can just add this to the ships array. Remember, down here we iterate over the ships
and call things like `getName`, `getWeaponPower` and `getJediFactor` which don't
actually live inside of `RebelShip`. But when we refresh, it works perfectly!


