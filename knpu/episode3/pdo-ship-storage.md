# PDO Ship Storage

To get our ships we use `ShipLoader` which queries the database
and creates ship objects. This `queryForShips` goes out, selects all
the ships, and then later it is passed to this nice `createShipFromData`
function down here. This is the one we've been working in that creates the
objects. 

Step 1: Query the database

Step 2: Turn that data into objects

Suppose that we have a new requirement, sometimes we're going to get the ship
data from the database but other times it will come from a different source, 
like a JSON file. 

In th resources directory there's a new `ship.json` file, as you can see this
holds the same info as we have in the database. Now why would we want our
application to sometimes load from the database and other times load from a
JSOn file? Say that when we're developing locally we don't have access to our database,
so we use a JSON file. But when we push to production we'll switch back to the 
real database. Or, supoose that our ship library is so awesome that someone else wants
to reuse it. However, this fan doesn't use a database, they only load them from
JSON. 

This leaves us needing to make our `ShipLoader` more generic in how it loads ships, since
we'll be using both the database and JSON and maybe even something else in the future.

Right now, all of the logic of querying things from the database is hardcoded in here. 
So let's create a new class whose only job is to load ship data through the database, or PDO. 
Let's start through this process, and it will make even more sense as we go along. 

Create a new class called `PdoShipStorage`. Looking back inside `ShipLoader` there are two
types of queries that we make. Sometimes we query for all of the ships and sometimes we query
for just one ship by ID. 

Back to our `PdoShipStorage` I'll create two methods, to cover both of those actions. First,
create a `public function fetchAllShipsData()` which we'll fill out in just one second. Second,
add `public function fetchSingleShipData()` and pass it the id that we want to query for. 

Before we go any further head back to our `boostrap.php` file and make sure that we require this. 
Perfect!

What I want to do is move all the querying logic from `ShipLoader` into this `PdoShipStorage` class.
Let's start with the logic that queries for one ship and pasting that over here. Notice, that we're
not returning object here
