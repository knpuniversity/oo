# Broken Ship

Here's the really beautiful thing about abstract classes. You may create some
of these because you have a situation similar to the one we've been working on
in this project. Or, you may be using someone else's code like a third party
library that you downloaded via the Composer package manager. You might even
read in that library's documentation that if you want to create a new ship class
you just need to extend `AbstractShip`. 

What's really great is that `AbstractShip` now tells you exactly what you need
to do to create a new ship class with its three abstract functions that you must
fill in:

[[[ code('4d7153990d') ]]]

A third group has joined the battle and we have a new type of ship. They're not
very good mechanics, so we'll call this a broken ship. This is simple, the ship
is always broken. 

Create a new php class called `BrokenShip`. Of course now make it extend `AbstractShip`:

[[[ code('19f350c07d') ]]]

Let's pretend like we don't know that there are any abstract methods in the parent class.
So we won't do anything here except putting in the extends code. Head over to `bootstrap.php`
and require our useless new `BrokenShip`:

[[[ code('ac130fc069') ]]]
 
Back in `index.php` for now, let's just add `$brokenShip = new BrokenShip();` and add it 
to our ships array:

[[[ code('be307a1387') ]]]

We can do this because we know that `BrokenShip` extends `AbstractShip`. And down here,
when we use those ship objects we're just calling methods on the `AbstractShip`.

Back to the browser, refresh! Yes, what a huge beautiful error. It says:

> Class BrokenShip contains 3 abstract methods and must therefore be declared
> abstract or implement the remaining methods.

And then it goes on and lists the methods. 

In other words, it's saying "Hey buddy! You need to add those three methods into
this class!" It's always giving you an out to declare the class abstract if you want
to, and you might do this if you wanted an abstract class inside an abstract class
with some additional public functions. But we've all seen where that goes in the
move inception. 

In our case we want this to be a concrete class, meaning one that we can instantiate.
When we go over to `AbstractShip` we say "Oh yea, I see there's a `getJediFactor`
function that I need to add." Take off the abstract to turn it into a real function,
and since this ship is always broken we don't care about the Jedi factor so let's
just return 0:

[[[ code('57f9f75188') ]]]

When we refresh after that we get the same error, but we're down to just 2 missing
abstract methods,
`getType` and `isFunctional`.

Head back into `AbstractShip` and grab those, pop off the abstract word at the beginning
after we paste them into `BrokenShip`. And we'll fill in the details of `getType`
by returning 'Broken'. And we'll fill in `isFunctional` by returning false:

[[[ code('866149eaa3') ]]]

Without really knowing anything I extended `AbstractShip` and that class told me
exactly what I needed to have in my subclasses. 

And when we refresh, we have one more error! We're missing argument 1 to
`AbstractShip::__construct`. That's my bad. In `index.php` here `BrokenShip` still
has a constructor argument which is the name so let's not forget to fill that in
with "I am so broken":

[[[ code('6907f7b39d') ]]]

Refresh again, and things look great! We've got our four original ships and our new
broken one. Which is always broken with its little cute cloud. 

We didn't have to update any of our other code because `BrokenShip` extends `AbstractShip`
and has all the same methods as everything else which leaves everything working
just as beautifully as before. Blueprint classes for the win!
