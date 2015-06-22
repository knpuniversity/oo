# Container: Force Single Objects, Celebrate

Home stretch! Our goal is to make `Container` responsible for creating *every*
service object: like `PDO`, but also `ShipLoader` and `BattleManager`.

## Guaranteeing only One PDO Object

Here's our issue: if we called `$container->getPDO()` twice on
the same request, we'd *still* end up with multiple PDO objects, and so,
multiple database connections. Ok, if we're careful, we can avoid this.
We can do better: let's *guarantee* that only one PDO object is ever created.

We did this before in `ShipLoader`. Create a `private $pdo` property at the
top of `Container`. In `getPDO()`, add an `if` statement to see if the property
is null. If it is, create the `new PDO()` object and set it on the property.
Return `$this->pdo` at the bottom:

[[[ code('f484be325a') ]]]

Again, the first time we call this: the `pdo` property is null, so we create
the object and set the property. The second, third and fourth time we call
this, the object is already there, so we just return it.

Oh, and while I'm here, I'll paste back one line I lost on accident earlier:

[[[ code('407f106064') ]]]

This just sets up PDO to throw nice exceptions if something goes wrong so
I can see them.

## Move ShipLoader to the Container

Keep going! We don't want to instantiate a `ShipLoader` object manually in
`battle.php` and `index.php`. Let's just do it inside `Container`.

Follow the same pattern: create a `private` property called `$shipLoader`,
and a `public function getShipLoader()`:

[[[ code('55f9cb8376') ]]]

In here, add the same `if` statement: `if ($this->shipLoader === null)`,
then `$this->shipLoader = new ShipLoader()`. Remember, *it* has a required
argument for the PDO object. That's easy, just say `$this->getPDO()`.
At the bottom return `$this->shipLoader` and add the PHPDoc above it:

[[[ code('7c9c2760c0') ]]]

Use it! In `index.php`, say `$shipLoader = $container->getShipLoader()`.
And I have a bonus for you! We don't need the `$pdo` variable anymore - we
only did that to pass it to `ShipLoader`. Simplify!

[[[ code('99c0f36897') ]]]

Copy the new `$shipLoader` line and repeat this in `battle.php`:

[[[ code('8d2273c9c6') ]]]

Ok, make sure this is all working. Refresh! Somebody make a sad trombone
noise:

    Call to a member function getShips() on a non-object index.php line 6.

Ok, trusty debugging cap back on. On line 6, we're calling `getShips()` on the
`$shipLoader`, which is apparently null. So `$container->getShipLoader()`
must *not* be returning the object for some reason. How rude.

Oh, and the problem is me! I added an extra `!` in my `if` statement so that
it never got inside. Lame. Make sure your's looks like mine does now:

[[[ code('7c9c2760c0') ]]]

Ok, *now* it works.

## Move BattleManager to the Container

Only one more service to go! In `battle.php`, we create the `BattleManager`.
Let's move it! Add the `private $battleManager` property and then the
`public function getBattleManager()`. Copy the ship loader code to save
time... and so I don't mess up again. Update it for `battleManager`:
`$this->battleManager = new BattleManager()`. And return `$this->battleManager`:

[[[ code('6d0b40b6ed') ]]]

Go use it in `battle.php`: `$battleManager = $container->getBattleManager()`:

[[[ code('fbbe3f554c') ]]]

Ok, let's try the *whole* thing! Start a battle... and Engage. Ok, the bad
guys won, but our app still works. And the code behind it is so much more awesome.
