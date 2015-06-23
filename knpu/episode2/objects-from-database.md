# Fetching Objects from the Database

Getting our Ship objects is easy: create a `ShipLoader` and call `getShips()`
on it. We don't care *how* `ShipLoader` is getting these - that's *its* problem.

Hardcoding is so 1990, let's load objects from the database! We need to 
get these ships to their battlestations!

## Database Setup

At the root of your project, open up a `resources` directory. Copy `init_db.php` 
out of there to the root of your project and open it up:

[[[ code('c81b1f58d2') ]]]

This script will create a database and add a `ship` table with columns for
`id`, `name`, `weapon_power`, `jedi_factor`, `strength` and `is_under_repair`:

[[[ code('e8178e2540') ]]]

At the bottom, it inserts 4 rows into that table for the 4 ships we have
hardcoded right now:

[[[ code('efb0ce24bd') ]]]

If we run this file, it should get everything powered up. Head to your browser
and run it there:

    http://localhost:8000/init_db.php

If you see - Ding! - you know it worked. If you see a terrible error, check
the database credentials at the top - make sure the user can create a new
database.

If you want to check the database with something like phpMyAdmin, you'll see
one `ship` table with 4 rows.

## Querying for Ships

You look ready to query, copy the two lines that create the PDO
object in `init_db` and head into `ShipLoader`. Keep things simple: `getShips()`
needs to make a query. So for now, paste the PDO lines right here. Update
the database name to be `oo_battle` and I'll fill in `root` as the user with
no password:

[[[ code('c797ee5213') ]]]

Ok, query time! Create a `$statement` variable and set it to `$pdo->prepare()`
with the query inside - `SELECT * FROM ship`:

[[[ code('012bea7cb6') ]]]

If PDO or prepared statements are new to you, don't worry - they're pretty
easy. And besides, using PDO is another chance to play with objects!

Run `$statement->execute()` to send the query into hyperdrive and create a new `$shipsArray`
that's set to `$statement->fetchAll()` with an argument: `PDO::FETCH_ASSOC`.
var_dump this variable:

[[[ code('36ce0ea4df') ]]]

This queries for every row and returns an associative array. The `PDO::FETCH_ASSOC`
part is a class constant - a nice little feature of classes we'll talk about
later.

Let's see what this looks like! Head back to the homepage and refresh!
AND... I was not expecting an error: "Unknown database oo_battles". The
database *should* be called `oo_battle` - silly me! Refresh again!

Ok! 4 rows of data.

## Private Functions are Awesome

Of course, what we *need* are objects, not arrays. But first, a quick piece
of organization. Copy all this good `PDO` stuff and at the bottom, create
a new `private function queryForShips()`. Paste here and return that `$shipsArray`:

[[[ code('785c705c1e') ]]]

Head back up, call this method, then remove the original code:

[[[ code('18fd03ba1f') ]]]

Make sure things still work - cool! Now, why did we do this? Well, we had
a chunk of code that did something - it made a query. Moving it into its
own function has two advantages. First, we can re-use it later if we need
to. But more importantly, it gives the code a name: `queryForShips()`. Now
it's easy to see what it does - a lot easier than when this was stuck
in the middle of other code.

So, creating private functions to help split code into small chunks is awesome.

## Give me Objects!

Back to the ship factory to create ship objects from the array we
have now.

In `getShips()`, I'll rename the variable to `$shipsData` - it sounds cool
to me. Now, loop over `$shipsData` as `$shipData`. Each time we loop, we'll
create a `Ship` object: `$ship = new Ship()` and pass `$shipData['name']`
as the only argument:

[[[ code('54fccc3b27') ]]]

Next, we can use the public functions to set the other data: `$ship->setWeaponPower()`
and pass it `$shipData['weapon_power']`. Do the same for the `jedi_factor`
and `strength` columns: `$ship->setJediFactor()` from the `jedi_factor` key
and `$ship->setStrength()` from the `strength` key. The last column - `is_under_repair`
we'll save that one for later. Can't have all the fun stuff at once! Finish the loop by 
putting `$ship` into the `$ships` array:

[[[ code('5197fa8ce8') ]]]

Wasn't that easy? Now get rid of *all* of the hardcoded `Ship` objects. We
have less code than we started. That's always my preference.

We've only changed this *one* file, but we're ready! Refresh! Welcome to
our dynamic application in under 10 minutes. Ship it!
