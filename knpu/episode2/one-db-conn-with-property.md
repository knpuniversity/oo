# Making only one DB Connection with a Property

I can't stand it any longer. The app is small, but our database credentials
are already duplicated *and* hidden inside this one class. What if we added
a second table - like `battle` - and a `BattleLoader` class? At this rate,
we'd be copying and pasting the database password *there* too. Gross.

## Isolate the PDO Creation in ShipLoader

Enough is enough. Let's fix this little by little. First, I don't want to
duplicate the `new PDO` code twice in this class. To fix that, create a
`private function getPDO()` - private because - at least so far - we only
want to call this from inside `ShipLoader`. Copy the `new PDO` line and
the one below it and put them here. Return `$pdo` and let's even add some
nice PHPDoc:

[[[ code('a9efcff7c1') ]]]

You know what's next: use this above with: `$pdo = $this->getPDO()`. Repeat
this in the other spot:

[[[ code('9a532aa839') ]]]

Head back to the homepage! Ha! Nothing broken yet.

## Prevent Multiple PDO Objects

Ok, a little bit better. Here's the next problem: what if a single page calls
`findOneById()` multiple times? Well, `getPDO()` would be called twice, two
`PDO` objects would be created *and* this would mean that *two* database
connections would be made. Such waste! We only need one connection and we only
need *one* `PDO` object.

How can we guarantee that only one PDO object is created?

By using a property! But in a way that we haven't seen yet. Up until now,
we've only put properties on our model classes - like `Ship` - and that has
been to hold data about the object, like `name`, `weaponPower`, etc.

In service classes - any class whose main job is to do *work* instead of
hold data - you use properties for two reasons: to hold options about *how* the class should
behave. And to hold other tools - like a PDO object.

Create a `private $pdo` property:

[[[ code('83cffedaaf') ]]]

Now, we can use a little trick thanks to OO! Down in `getPDO()`, add an `if`
statement to check if the `pdo` property is equal to `null`. Why of course
it is! So far, nothing is setting it, so it's *always* null. But now, if
it *is* null, move the `new PDO()` code into this and then assign this to
the `pdo` property. Finish by returning `$this->pdo`:

[[[ code('55958e3bbc') ]]]

The first time you call this, `$this->pdo` is null so we create a new `PDO`
object and set the property. Then, if someone calls this during the same
request, the `pdo` property will already be an object, so it'll skip creating
a second one and just return it. Boom!

This is the first time we've seen a service class - something that does work
for us - have a property. And in service classes, properties aren't about
holding data that describe something - like a `Ship` - they're used to store
options about how the class should work or other useful objects that class
needs.

We shouldn't notice *any* difference - so refresh to try it. Yes! Think about
it: thanks to objects, we were able to reduce the number of database connections
being created by touching one file and not breaking anything.
