# Sharpening the Battle Result with a Class

The most obvious time you should create a class is when you are passing around
an associative array of data. Check out the `battle()` function: it returns
an associatve array - with `winning_ship`, `losing_ship` and `used_jedi_powers`
keys:

[[[ code('3dbe0136fd') ]]]

We use this in `battle.php`, set it to an `$outcome` variable, then reference
all those keys to print stuff further down:s

[[[ code('d64dab1bd2') ]]]

Ah man, I *hate* this kind of stuff. It's not obvious at all what's inside 
this `$outcome` variable or whether the keys it has now might be missing or 
different in the future. When you see questionable code like this, you need to be thinking: 
this is perfect for a class.

## Creating the BattleResult Model Class

Let's create one! Now, what to call this new class. Well, this information summarizes
a battle result - let's use that - a new class called `BattleResult`:

[[[ code('7148cfe4d6') ]]]

Ok, let's think about this: it'll need to hold data for the winning ship,
the losing ship and whether jedi powers were used. So, let's create 3 private
properties called `$usedJediPowers`, `$winningShip` and `$losingShip`:

[[[ code('6a1f8cea24') ]]]

Look at `Ship`: our other model-type class that holds data. There are two
ways we can set the data. One way is by making a `__construct()` function.
Here, we're saying: "Hey, when you create a new Ship object, you need to
pass in the name as an argument":

[[[ code('dd176e3d18') ]]]

For the other properties, we created public functions - like `setStrength()`,
`setWeaponPower()` and `getJediFactor()`:

[[[ code('149593f6a7') ]]]

Both ways are fine - but I like to use the ``__construct()`` strategy for
any properties that are required. You *must* give your ship a name - it doesn't
make sense to have a nameless Ship fighting battles. How will they know who to 
write songs about?

A `BattleResult` only makes sense with *all* of this information - that's
perfect for setting via the constructor! Create a new `public function __construct()`
with `$usedJediPowers`, `$winningShip` and `$losingShip`. These argument
names don't need to match the properties, it's just nice. Now, assign each
property to that variable: `$this->usedJediPowers = $usedJediPowers`,
`$this->winningShip = $winningShip` and `$this->losingShip = $losingShip`:

[[[ code('4ceaaafffc') ]]]

Ok, this little data wrapper is done.

## Passing BattleResult around

So let's use it inside `battle()`: instead of returning that array, return
a new `BattleResult` and pass it `$usedJediPowers`, `$winningShip` and `$losingShip`:

[[[ code('ea7db2497c') ]]]

But hey, we're referencing a class, so make sure you require it in `bootstrap.php`:

[[[ code('b493b7f47e') ]]]

So where is `battle()` being called? It's at the top of `battle.php` - and
this `$outcome` variable *used* to be that associative array - now it's a
fancy `BattleResult` object:

[[[ code('99ffb15ab6') ]]]

This means that our code below - the stuff that treats `$outcome` like an
array - should blow up.:

[[[ code('98007503b2') ]]]

Let's see some fireworks! Boom error!

    Cannot use object of type BattleResult as array on line 71.

But we *do* need to get the winning ship from the `BattleResult` object.
Is that possible right now? No - the `$winningShip` property is private.
If we want to access it from outside the class, we need a *public* function
that returns it for us. We did this same thing in `Ship` with methods like
`getName()`.

## Type-Hinting Arguments

But before we add some methods - think about the 3 arguments. What are they?
Well, `$usedJediPowers` is a boolean and the other two are `Ship` objects.
And whenever you have an argument that is an object, you can *choose* to
type-hint it by putting the name of the class in front of it:

[[[ code('f89428f72a') ]]]

But this doesn't change any behavior - it just means that if you pass something
that's *not* a `Ship` object on accident, you'll get a really nice error.
And there's one other benefit - auto-completion in your editor! PhpStorm
now knows what these variables are.

## Adding Getter Methods

Ok, back to what we *were* doing. We need to access the private properties
from *outside* this class. To do that, we'll create some *public* functions.
Start with `public function getWinningShip()`. This will just `return $this->winningship`:

[[[ code('7152410abc') ]]]

We'll do this for *each* property. But actually, I can make PhpStorm write
these methods for me! Suckers! Delete `getWinningShip()`, then right-click, go to
"Generate" and select "Getters". Select all 3 properties, say abracadabra, and let it work
its magic.

It even added some PHPDoc above each with an `@return mixed` - which basically
is PhpStorms' way of saying "I don't know what this method returns". So let's
help it - the first returns a `boolean` and the other two return a `Ship`
object:

[[[ code('974271bb3d') ]]]

This comment stuff is optional - but it helps other developers read our code
*and* gives us auto-completion when we call these methods.

## Name the Methods Awesomely

Check out the first method - `getUsedJediPowers()`. Is it clear what the
method returns? It's kind of bad English, and that's a shame. This method
will return whether or not Jedi powers were used to win this battle. Let's
give it a name that says that - how about `wereJediPowersUsed()`?

[[[ code('44ba05cc13') ]]]

Using `get` and then the method name is a good standard, but you can name
these methods however you want.

## Using BattleResult for Battle #Wins

Now we can *finally* go back to `battle.php` and start using these public
methods. Start by renaming `$outcome` to `$battleResult` - it's more clear
this is a `BattleResult` object:

[[[ code('f4e43df557') ]]]

Below, use `$battleResult->getWinningShip()`:

[[[ code('ec92953751') ]]]

Except, where's my auto-completion on that method? This will work, but PhpStorm
is highlighting the method like it's wrong. It doesn't know that `$battleResult`
is a `BattleResult` object.

Why? Look at `battle()`. We *are* returning a `BattleResult`, but oh no,
the `@return` above this method still advertises that this method returns
an array. Fix that with `@return BattleResult`:

[[[ code('7fe3d54753') ]]]

Ok, now PhpStorm is acting friendly - the angry highightling on the method
is gone. Now update the other spots: `$battleResult->getWinningShip()->getName()`:
thank you auto-complete. Use that same method once more, and in the `if`
statement, use that nice `wereJediPowersUsed()` method. Finish with
`$battleResult->getLosingShip()`:

[[[ code('c6777e6c8e') ]]]

I think we're done. Refresh to try it! Ship it!

And gone are the days of needing to use weird associative arrays: `BattleManager::battle()`
returns a nice `BattleResult` object. And we're in full control of what
public methods we put on that.
