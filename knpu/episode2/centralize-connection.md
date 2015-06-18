# OO Best Practice: Centralizing the Connection

Ready for the next problem? Our `PDO` object is configurable, but we're still
creating it inside of `ShipLoader`. What's going to happen if we add a `battle`
table and a `BattleLoader`? Will it *also* need to create *its* own PDO object?
Right now - yea. So if we have 50 tables, that means 50 separate connections.
The horror!

I want *one* connection that *every* class uses.

Here's the goal: move the `new PDO()` call *out* of `ShipLoader` so that
it can be created in a central location and used by everyone. How? By using
the same strategy we just learned with configuration. If you want to move
something out of a service class, add it as a `__construct()` argument and
pass it in.

## Adding a $pdo __construct Argument

Let's do it! Instead of passing in the 3 database options, we need to pass
in the *whole* `PDO` object. Replace the 3 arguments with just one: `$pdo`.
Give it a type-hint to be great programmers. Next, remove the three configuration
properties. And back in `__construct()`, we already have a `$pdo` property,
so set that with `$this->pdo = $pdo`.

[[[ code('83a02c2d94') ]]]

Time to simplify the `getPDO()` function. We don't need to worry about creating
the object anymore. Instead, just return the property:

[[[ code('449f484171') ]]]

Again: big picture: if you need to remove something from a service class -
whether it's configuration or an object - remove it, and add it as an argument
to the `__construct()` function.

## Creating PDO

But now, we need go to `index.php` and change the arguments we're
passing to the `new ShipLoader()`. We're not passing these three configuration
pieces anymore. Copy those. Above this, create the `PDO` object. `$pdo = new PDO()`
and paste in the arguments:

[[[ code('6b46191896') ]]]

Below, pass `$pdo` as the only argument to `new ShipLoader()`:

[[[ code('e331d3beb1') ]]]

Ok, let's try it! Still works. Geez - we're unstoppable today.

Unfortunately, this isn't the only place we need this. Copy the `$pdo` and
`$shipLoader` code and paste it into `battle.php`:

[[[ code('38d2e85a12') ]]]

Choose some ships to battle and.... Engage. And *that* still works too!

## The Big Important Takeaway

Ready for the big important takeaway? Don't include configuration *or* create
new service objects from within a service. Even though the `PDO` class comes
from PHP, it *is* a service class: it does work. If we create that service
object from within a class, we can't easily share it *or* control it.

Instead, create all of your service objects in *one* place and then pass
them into each other. This stuff is hard - a lot of systems violate the
heck out of these rules! And that's ok - I want you to learn to become a
*great* object-oriented developer, so we're looking at the *best* way to
do things.

The downside is that the code to create the service objects is getting a bit
complicated. *And* it's duplicated! Dang it - it's not right yet. Let's fix
that next by learning another awesome strategy.
