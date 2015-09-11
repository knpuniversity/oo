# Broken Ship

Here's the really beautiful thing about abstract classes. You may create some
of these because you have a situation similar to the one we've been working on
in this project. Or, you may be using someone else's code like a third party
library that you downloaded via the Composer package manager. You might even
read in that library's documentation that if you want to create a new ship class
you just need to extend `AbstractShip`. 

What's really great is that `AbstractShip` now tells you exactly what you need
to do to create a new ship class with its three abstract functions that you must
fill in.

A third group has joined the battle and we have a new type of ship. They're not
very good mechanics, so we'll call this a broken ship. This is simple, the ship
is always broken. 

Create a new php class called `BrokenShip`. Of course now make it extend `AbstractShip`.
Let's pretend like we don't know that there are any abstract methods in the parent class.
So we won't do anything here except putting in the extends code. Head over to `Bootstrap.php`
and require our cool new `BrokenShip`. 
