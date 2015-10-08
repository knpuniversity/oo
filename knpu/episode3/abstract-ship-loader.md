# AbstractShipLoader

Our goal is to make `ShipLoader` load things from the database or from a JSON file.
In the resources directory I've already created a `JsonFileShipStorage` class. 

Copy that into the service directory and let's take a look inside of here:

[[[ code('b8b4437720') ]]]

It has all of the same methods as `PdoShipStorage`. Except that this loads from a JSON file
instead of querying from a database. Let's try and use this in our project. 

First, head over to `bootstrap` of course and require `JsonFileShipStorage.php`:

[[[ code('843be3186e') ]]]

In theory since this class has all the same methods as `PdoShipStorage` we
should be able to pass a `JsonFileShipStorage` object into `ShipLoader` and everything
should just work. Really, the only thing `ShipLoader` should care about is that
it's passed an object that has the two methods it's calling: `fetchAllShipsData()` and
`fetchSingleShipData()`:

[[[ code('0f799456c9') ]]]

In `Container` let's give this a try. Down in `getShipStorage()` let's say, 
`$this->shipStorage = new JsonFileShipStorage()`. And we'll give it a path to our JSON
of `__DIR__.'/../../resources/ships.json'`:

[[[ code('7aee17da8d') ]]]

From this directory I'm going up a couple of levels, into `resources` and pointing
at this `ships.json` file which holds all of our ship info:

[[[ code('360c6e56ae') ]]]

Back to the browser and refresh. Ok no success yet, but as they say, try try again. Before 
we do that, let's check out this error:

> Argument 1 passed to `ShipLoader::__construct()` must be an instance of `PdoShipStorage`,
  instance of `JsonFileShipStorage` given.

What's happening here is that in `ShipLoader` we have this type-hint which says that
we only accept `PdoShipStorage` and our Json file is not an instance of that:

[[[ code('f1692c9d84') ]]]

The easiest way to fix this is to say `extends PdoShipStorage` in `JsonFileShipStorage`:

[[[ code('6b892fbcfd') ]]]

This makes the json file an instance of `PdoShipStorage`. Try refreshing that again. 
Perfect, our site is working.

But having to put that extends in our JSON file kinda sucks, when we do this we're overriding
every single method and getting some extra stuff that we aren't going to use. 

## Creating a "Ship storage" contract

Instead, you should be thinking, "This is a good spot for Abstract Ship Storage!" And well, I
agree so let's create that. Inside the `Service` directory add a new PHP Class called
`AbstractShipStorage`. The two methods that this is going to need to have are: `fetchSingleShipData()`
and `fetchAllShipsData()` so I'll copy both of those and paste them over to our new class.

Of course we don't have any body in these methods, so remove that. Now, set this as an `abstract` class.
Make both of the functions `abstract` as well:

[[[ code('d05d538d30') ]]]

Cool!

Now, `JsonFileShipStorage` can `extend AbstractShipStorage`:

[[[ code('8f1c28dde5') ]]]

And the same thing for `PdoShipStorage`:

[[[ code('13191cd9f6') ]]]

With this setup we know that if we have a `AbstractShipStorage` it will definitely have both of those
methods so we can go into the `ShipLoader` and change this type hint to `AbstractShipStorage` because
we don't care which of the two storage classes are actually passed:

[[[ code('81dd1ee0e7') ]]]

To be very well behaved developers, we'll go into our `Container` and above `getShipStorage()` change
the type hint to `AbstractShipStorage`. Not a requirement, but it is a good idea.

Go back to the browser and refresh... oh, class `AbstractShipStorage` not found because we forgot to require it
in our `bootstrap` file. We will eventually fix the need to have all of these require statements:

[[[ code('f57ad5052c') ]]]

Refresh again and now it works perfectly. 

We created an `AbstractShipStorage` because it allows us to make our `ShipLoader` more generic. It now
doesn't care which one is passed, as long as it extends `AbstractShipStorage`.

But there's an even better way to handle this... interfaces!
