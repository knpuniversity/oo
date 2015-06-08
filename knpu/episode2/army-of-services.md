# An Army of Service Classes

Yay! We got rid of a flat function. Woh - not so fast: inside `battle()`,
we're *calling* a flat function: `didJediDestroyShipUsingTheForce()`:

[[[ code('261d176cc4') ]]]

No bueno!

## Refactoring to private Functions

This lives at the bottom of `functions.php`. In our app, this is *only* called
from inside `battle()`, and since it obviously relates to battles, let's
move it into `BattleManager`. Make it a `private function`:

[[[ code('79155df785') ]]]

Why did I make it private? Well, do we need use this function from outside
of this class? No - the only code using it is up in `battle()`, so this is
a perfect candidate to be `private`.

Above in `battle()`, update the calls to be `$this->didJediDestroyShipUsingTheForce()`.
The "force" of our app is happy again:

[[[ code('4545d5181c') ]]]

Now, if someday we *did* want to use this function from outside of `BattleManager`,
*then* we could change it to `public`. Ok, so why not just make everything
`public` - isn't that more flexible? Yes, but making this private
is *nice*: it means that if I want to change this function - add arguments
or even change what it returns - I know that the *only* code that will be
affected will be right inside this class. If it's public, who knows what
code I might break in my app?

Start with `private`, make it `public` only if you need. The same rule goes
for `protected` - something we'll talk about later with inheritance.

Let's make sure we didn't bust things. Refresh!

Yes!

## Service 2: ShipLoader

In `functions.php`, only the flat `get_ships()` function remains. You guys
know what do to: move it into a class!

Should we move it into `BattleManager`? No - it doesn't relate to battles. 
Instead, create a new class for this - how about `ShipLoader`:

[[[ code('92feab2a7d') ]]]

Let's work our magic: go grab `get_ships()` and move it into `ShipLoader`.
Remove the old commented code and make the function `public`. Also, rename
it from `get_ships()` to `getShips()` - that's a more common naming standard
for methods in a class:

[[[ code('00ca2e1549') ]]]

Yep, that's great! Now we need to update the code that *calls* this function.
But first, open `functions.php` and `require` the new `ShipLoader.php`:

[[[ code('1c580b21f7') ]]]

`getShips()` is used in `battle.php` and `index.php` - start there. To
call the method, create a `$shipLoader` variable and create a new `ShipLoader()`
object. Now, just `$shipLoader->getShips()`:

[[[ code('821a6c8eb8') ]]]

Do the same thing in `battle.php`:

[[[ code('40e2627b8f') ]]]

I think it's time to try it. Click to create a new battle. Looks pretty good.
Setup a new battle and, Engage. Ok! `battle.php` works too!

## No More functions.php

AND, all the flat functions are gone! Object-orient all the things! So if
you look in `functions.php`, well, there aren't any functions here: just
`require` statements, and even those we'll get rid of eventually. To celebrate,
give this a more appropriate name: `bootstrap.php`. Update this in `battle.php`:

[[[ code('589743514c') ]]]

and `index.php`:

[[[ code('bd37404fa6') ]]]

Refresh once more! Let's keep going.
