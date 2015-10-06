# Abstracting a Class into 2 Smaller Pieces

To get our ships we use `ShipLoader` which queries the database
and creates ship objects. This `queryForShips()` goes out, selects all
the ships, and then later it is passed to this nice `createShipFromData()`
function down here:

[[[ code('1d6983d2a5') ]]]

This is the one we've been working in that creates the objects. 

* Step 1: Query the database
* Step 2: Turn that data into objects

Suppose that we have a new requirement, sometimes we're going to get the ship
data from the database but other times it will come from a different source, 
like a JSON file. 

In the resources directory there's a new `ship.json` file, as you can see this
holds the same info as we have in the database:

[[[ code('edbcc9df5c') ]]]

Now why would we want our application to sometimes load from the database and other times from a
JSON file? Say that when we're developing locally we don't have access to our database,
so we use a JSON file. But when we push to production we'll switch back to the 
real database. Or, suppose that our ship library is so awesome that someone else wants
to reuse it. However, this fan doesn't use a database, they only load them from
JSON. 

This leaves us needing to make our `ShipLoader` more generic.

Right now, all of the logic of querying things from the database is hardcoded in here. 
So let's create a new class whose only job is to load ship data through the database, or PDO. 

Create a new class called `PdoShipStorage`:

[[[ code('c5b654f23f') ]]]

Looking back inside `ShipLoader` there are two types of queries that we make:

[[[ code('a1d793a973') ]]]

Sometimes we query for all of the ships and sometimes we query for just one ship by ID. 

Back to our `PdoShipStorage` I'll create two methods, to cover both of those actions. First,
create a `public function fetchAllShipsData()` which we'll fill out in just one second. Now,
add `public function fetchSingleShipData()` and pass it the id that we want to query for:

[[[ code('3cd0c8eb48') ]]]

Before we go any further head back to our `bootstrap.php` file and make sure that we require this:

[[[ code('f8879801b8') ]]]

Perfect!

What I want to do is move all the querying logic from `ShipLoader` into this `PdoShipStorage` class.
Let's start with the logic that queries for one ship and pasting that over here:

[[[ code('11bedaf776') ]]]

Notice, that we're not returning an object here this is just a really dumb class
that returns data, an array in our case.

There is one problem, we have a `getPdo()` function inside of `ShipLoader` that references a pdo
property. Point being, our PDO storage needs access to the PDO object, so we're going to use
*dependency injection*, a topic we covered a lot in
[episode 2](https://knpuniversity.com/screencast/oo-ep2) . Add
`public function __construct(PDO $pdo)`  and store it as a property with
`$this->pdo = $pdo;`:

[[[ code('d74b08dbde') ]]]

If this pattern is new to you just head back and watch the dependency injection video
in [episode 2](https://knpuniversity.com/screencast/oo-ep2) of the OO series.

Here we're saying, whomever creates our PDO ship storage class must pass
in the pdo object. This is cool because we need it. Now I can just reference
the property there directly. 

Back in `ShipLoader` copy the entire `queryForShips()` and paste that
into `fetchAllShipsData()` and once again reference the pdo property:


[[[ code('5e14c701da') ]]]

Now we have a class whose only job is to query for ship stuff, we're not using it anywhere yet, but it's fully
ready to go. So let's use this inside of `ShipLoader` instead of the PDO object. Since we don't need PDO to be
passed anymore swap that out for a `PdoShipStorage` object. Let's update that in a few other places and change
the property to be called `shipStorage`:

[[[ code('911d89bd8f') ]]]

Cool!

Down in `getShips()` we used to call `$this->queryForShips();` but we don't need to do that anymore! Instead,
say `$this->shipStorage->fetchAllShipsData();`:

[[[ code('f6cdc244a9') ]]]

Perfect, now scroll down and get rid of the `queryForShips()` function all together:
we're not using that anymore. And while we're cleaning things out also delete this `getPDO()` function.
We can delete this because up here where we reference it in `findOneById()` we'll do the same thing.
Remove all the pdo querying logic, and instead say `shipArray = $this->shipStorage->fetchSingleShipData();`
and pass it the ID:

[[[ code('082ac58db8') ]]]

This class now has no query logic anywhere. 

All we know is that we're passed in some `PdoShipStorage` object and we're able to call methods on it. It can 
make the queries and talk to whatever database it wants to, that's it's responsibility. In here we're just
calling methods instead of actually querying for things. 

`ShipLoader` and `PdoShipStorage` are now fully setup and functional. The last step is going into our container
which is responsible for creating all of our objects to make a couple of changes. For example, when we
have `new ShipLoader` we don't want to pass a pdo object anymore we want to pass in `PdoShipStorage`. 

Just like before, create a new function called `getShipStorage()` and make sure we have our property up above.
The `getShipStorage()` method is going to do exactly what you expect it to do. Instantiate a new `PdoShipStorage`
and return it. The ship's storage class does need PDO as its first constructor argument which we do with
`new PdoShipStorage($this->getPDO());`:

[[[ code('a7873d06b0') ]]]

Up in `getShipLoader()`, now pass `$this->getShipStorage()`:

[[[ code('2e1ad7e32d') ]]]

Everything used to be in `ShipLoader`, including the query logic. We've now split things up so that the query
logic is in `PdoShipStorage` and in `ShipLoader` you're just calling methods on the `shipStorage`. Its real 
job is to create the objects from the data, wherever that data came from. In `Container.php` we've wired
all this stuff up. 

Phew, that was a lot of coding we just did, but when we go to the browser and refresh,
everything still works exactly the same as before. That was a lot of internal refactoring.
In `index.php` as always we still have `$shipLoader->getShips()`:

[[[ code('d366b28426') ]]]

And that function still works as it did before, but the logic is now separated into two pieces.

The cool thing about this is that our classes are now more focused and broken into smaller pieces. Initially
we didn't need to do this, but once we had the new requirement of needing to load ships from a JSON file this
refactoring became necessary. Now let's see how to actually load things from JSON instead of PDO. 
