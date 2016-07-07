# Traits: "Horizontal" Reuse

Ok team: we need a new ship class - a `BountyHunterShip`. Start simple: in the
model directory, add a new class: `BountyHunterShip`. Once again, PhpStorm already
added the correct namespace for us.

Like every other ship, extend `AbstractShip`. Ah, but we do *not* need a `use` statement
for this: that class lives in the same namespace as us.

Just like with an interface, when you extend an abstract class, you usually need
to implement some methods. Go back to Code->Generate "Implement Methods". Select
the 3 that this class needs.

Great!

Now, bounty hunter ships are interesting for a few reasons. First, they're never broken:
those scrappy bounty hunters can always get the ship started. For `isFunctional()`, return
`true`. For `getType()`, return `Bounty Hunter`.

Simple. But the `jediFactor` will vary ship-by-ship. Add a `JediFactor` property
and return that from inside `getJediFactor()`.

At the bottom of the class add a `public function setJediFactor()` so that we can
change this property: `$this->jediFactor = $jediFactor`.

Cool!

To get one of these into our system, let's do something simple. Open `ShipLoader`.
At the bottom of `getShips()`, add a new ship to the collection:
`$ships[] = new BountyHunterShip()` called 'Slave I' - Boba Fett's famous ship.

Ok, head back and refresh! Yes! Slave I - Bounty Hunter, and it's not broken. That
was easy.

## Code Duplication

So, what's the problem? Look at `BountyHunterShip` and also look at `Ship`: there's
some duplication. Both classes have a `jediFactor` property, a `getJediFactor()`
method that returns this, and a `setJediFactor` that changes it.

Duplication is a bummer. How can we fix this? Well, we could use inheritance. But
in this case, it's weird.

For example, we could make `BountyHunterShip` extend `Ship`, but then it would inherit
this extra stuff that we don't really want or need. We could make it work, but I
just don't like it.

Ok, what about making `Ship` extend `BountyHunterShip`? That just completely *feels*
wrong: philosophically, not all `Ships` are `BountyHunterShips` - it's just not the
right way to model these classes.

Are we stuck? What we want is a way to *just* share these 3 things: the `jediFactor`
property, `getJediFactor()` and `setJediFactor()`. When you only need to share a
few things, the right answer might be a *trait*.

## Hello Mr Trait

Let's see what this trait thing is. In the `Model` directory, create a new PHP class
called `SettableJediFactorTrait`. Now, change the `class` keyword to `trait`. Traits
look and feel *exactly* like a normal class.

In fact, open up `BountyHunterShip` and move the property and first method into the
trait. Also grab `setJediFactor()` and put that in the trait too.

The only difference between classes and traits is that traits can't be instantiated
directly. Their purpose is for sharing code.

In `BountyHunterShip`, we can effectively copy and paste the contents of that
trait into this class by going inside the class and adding `use SettableJediFactorTrait`.

That `use` statement has *nothing* to do with the  namespace `use` statements: it's
just a coincidence. As soon as we do this, when PHP runs, it will copy the contents
of the trait and pastes them into this class right before it executes our code. It's
as if all the code from the trait actually lives inside this class.

And now, we can do the same thing inside of `Ship`: remove the `jediFactor` property
and the two methods. At the top, `use SettableJediFactorTrait`.

Give it a try! Refresh. No errors! In fact, nothing changes at all. This is called
horizontal reuse: because you're not extending a parent class, you're just using methods
and properties from other classes.

This is perfect for when you have a couple of classes that really don't have that
much in common, but *do* have some shared functionality. Traits are *also* cool because
you *cannot* extend multiple classes, but you *can* use multiple traits.
