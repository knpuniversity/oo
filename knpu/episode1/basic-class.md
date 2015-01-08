# Basic Class

Let's create a fresh file that we can play around with - call it `play.php`.
Now we can warn the rebels that It's a TRAAAP! Now put `play.php` in the
URL... and there it is! We've conquered the echo statement!

## Creating a Class

Now to the interesting stuff. The first super-important big awesome-crazy thing
in object-oriented programming is.... a class! To create one, write the keyword
`class` then the name of the class - it can be almost anything alphanumeric.
Finish things off with an open curly brace and a close curly brace.

[[[ code('') ]]] THE EMPTY CLASS

Don't worry about *what* this "class" thing is yet. But I *do* want you to
see that if we refresh, nothing happens yet. Creating a class doesn't actually
*do* anything.

## Creating an Object

Creating a class, check! And with that, we can see the second super-important
big awesome-crazy thing in object-oriented programming: an object! Once you
have a class, you can instantiate a new *object* from that class, and it
looks like this.

Create a variable called `$myShip` and then use the `new` keyword, followed
by the name of the class, then open parenthesis, close parenthesis:

[[[ code('') ]]] INSTANTIATION

It kind of looks like we're calling a function called `Ship()`, except because
we have the `new` in front, PHP knows instead that `Ship` is a class, and
we're instantiating a new object from it.

Before we explain any of this - refresh again. Still no changes. We have
this new thing called an object that's set to `$myShip`, but it doesn't cause
anything to happen.

## The Skinny on Classes and Objects

Ok, let me explain this class and object stuff. When wait I say next finally
"clicks", you'll know that you really *get* object-oriented programming.
So listen carefully, and I'll come back to this later as we add more stuff.

A class is like a blue-print. It's not an actual ship - it's like the plans
laid out on paper that describe the properties of a ship, like any ship should
have a name, it should have a door, which will be open or closed at any time,
or it should have a fuel tank, which will have a certain amount in it at
any time.

Thinking of it this way, an object is the physical representation - it's an
actual ship that's been built. This ship might be called the "Millennium Falcon",
the door might be closed at this moment, and its fuel tank might be half-full.

And even though we only have one class, or blue-print, we might have many
objects, or ships of that type. Another ship might be called the "Slave 1",
its door might be open and its fuel tank might be full. We'll create more
Ship objects later.

So remember, the class is the blue-print: it's just a dead document that
describes different possibility properties of a Ship. The object is the real
thing. Our `Ship` class is empty right now - it doesn't have any properties...
that's not too interesting.

Time to fix that!

hink of a class like a blue-print.
Our `Ship` class describes everything that our ship *could* have, and right
now it's empty. But in a second, we'll add some code that says that Ships
have a 







