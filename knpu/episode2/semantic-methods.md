# Optional type-hinting & Semantic Methods

I need to show you something - so start another battle between some Jedi
Star Fighters. It works... but if I refresh enough times... come on... yes!
It blows up!

    Argument 2 passed to BattleResult::__construct() must be an instance
    of Ship, null given.

In `BattleResult` - because we're good programmers - we type-hinted the two
`Ship` arguments. Buuuuut, if you look at the `battle()` function, there's
a case where the ships can destroy each other. And when that happens, there
is no winning or losing ship - they're both null. Since - news flash `null`
is *not* a `Ship` object, PHP gets angry and casts down this big error.

When you type-hint an argument, the value *must* be that class - not even
`null` is ok. But sometimes you *do* have a spot where an argument might
be a specific object, or it might be null. To support this, make the argument
optional - add an `= null` after it:

[[[ code('a7ad385698') ]]]

I don't have to, but I'll update `@return` on the methods to be `Ship|null`:

[[[ code('046efa7c01') ]]]

PhpStorm will still give me auto-completion - but this is a signal to other
developers not to blindly call this method and *always* assume it will return
a `Ship` object. We're already coding safely in `battle.php`: we check to
make sure `getWinningShip()` returns something before calling a method on
it. Cool.

## Adding a Semantic isThereAWinner Method

To check if a `BattleResult` has a winner, you can see if `getWinningShip()`
returns null. But we can do even better. Go to `BattleResult` and make a
new public method called `isThereAWinner()`. Here, return
`$this->getWinningShip != null`:

[[[ code('85b9802eef') ]]]

There's at least two great things about this. First, code outside of this
class doesn't need to know *how* to figure out whether or not there was a winner:
that code can be dumb and just call this method. Second, if something happens
in the future and the logic used to figure out if there is a winner changes,
we only need to update the code in this *one* spot: no need to run around
the code base trying to figure out where we have the old logic for seeing
if there was a winner.

Update `battle.php` to use this. The first `if` statement is *really* trying
to figure out whether or not there was a winner. Update this to
`$battleResult->isThereAWinner()`. Use that again right below:

[[[ code('5362095178') ]]]

Go back and refresh! You'll have to trust me that if we refresh this 1000
times, it'll always work - our bug is gone - and we have a nifty new helper
method in `BattleResult`.


