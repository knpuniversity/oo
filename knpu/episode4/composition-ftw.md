# Object Composition FTW!

In modern PHP, you're going to spend a lot of time working with *other* people's
classes: via external libraries that you bring into your project to get things done
faster. Of course, when you do that: you can't actually *edit* their code if you need
to change or add some behavior.

Fortunately, OO code gives us some really neat ways to deal with this limitation.

## Modifying a Class without Modifying it?

For the next few minutes, I want you to pretend like our `PDOShipStorage` is actually
from a third-party library. In other words, we *can't* modify it.

Now, let's say whenever we call `fetchAllShipsData()`, it's *really* important for
us to log to a file, how many ships were found. But if we can't edit this file, how
can we do that?

## Using Inheritance

There's actually two ways to do this, and both are pretty awesome. The first way
is to create a new class that *extends* `PDOShipStorage`, like `LoggablePDOShipStorage`,
and override some methods to add logging.

## Nah, Use Composition

But forget that, let's skip to a better method called composition. First, create
a new class in the `Service` directory called `LoggableShipStorage`, but do *not*
extend `PDOShipStorage`.

Now, the only rule for any ship storage object is that it needs to implement the
`ShipStorageInterface`. Add that, and then go to our handy Code->Generate method
to implement the 2 methods we need.

So far, this is how every ship storage starts.

But `LoggableShipStorage` will *not* actually do any of the ship-loading work - it'll
offload all that hard work to some *other* ship storage object, like `PDOShipStorage`.
To do that, add a new `private $shipStorage` property and a `public function __construct()`
method that accepts one `ShipStorageInterface` argument. Then, set that value onto
the `$shipStorage` property.

For `fetchSingleShipData()`, just `return $this->shipStorage->fetchAllShipsData()`.
Repeat for the other method: `return $this->shipStorage->fetchSingleShipData()`.

We've now created a *wrapper* object that offloads all of the work to an internal
ship storage object. This is composition: you put one object *inside* of another.

To use the new class, open up `Container`. Inside `getShipStorage`, add
`$this->shipStorage = new LoggableShipStorage()` and pass it `$this->shipStorage`,
which is the `PDOShipStorage` object.

We've just pulled a "fast one" on our application: our entire app thinks
we're using `PDOShipStorage`, but we just changed that! If you refresh now, nothing
is different: everything still eventually goes through the `PDOShipStorage` object.

But now, we have the opportunity to add *more* functionality - or to change functionality -
in either of these methods.

## Add some Logging!

To give a really simple example, replace the return statement with `$ships =` and
add `return $ships` below that. Between, we could call some new `log()` method, passing
it a string like: `just fetched %s ships` - passing that a `count()` of `$ships`.

Below, add a new `private function log()` with a `$message` argument. You should
do something more intelligent in a real app, but to prove it's working, echo that
message.

Let's refresh! There's our message!

## Why is Composition Cool?

Wrapping one object inside of another like this is called composition. You see,
when you want to change the behavior of an existing class, the first thing we always
think of is

> Oh, just extend that class and override some methods

But composition is another option, and it *does* have some subtle advantages. If
we had *extended* `PDOShipStorage` and then later wanted to change back to our
`JsonFileShipStorage`, then all of a sudden we would need to change our `LoggableShipStorage`
to extend `JsonFileShipStorage`. But with composition, our wrapper class can work
with *any* `ShipStorageInterface`. We could change just one line to go back to loading
files from JSON and not lose our logging.

This isn't always a ground-breaking difference, but this is what people mean when
they talk about "composition over inheritance".

Alright guys! I have tried to think of all the weird stuff that we haven't talked
about with object oriented coding, and I've run out! You are now *super* qualified
with this stuff - so get out there, find some classes, find some interfaces, make
some traits, do some good, and just keep practicing. It's going to sink in more and
more over time, and serve you for *years* to come, in many different languages.

See you next time!
