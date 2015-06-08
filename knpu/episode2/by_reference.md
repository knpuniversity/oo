# Objects are Passed by Reference

Start another battle - how about 3 CloakShape fighters against 4 RZ-1 A-wing
interceptors. Behind the scenes: each ship has a `strength`. The `battle()`
function uses this as the ship's health, and as they battle each other, that
health gets lower and lower until one hits zero.

We need to add a new feature: after the battle: display the final health of the battling
ships. One will be zero or negative, but how much health did the other have left?

In `battle()`, those "ship health" variables are *not* returned in `BattleResult`.
So we *don't* have access to this information. We could add it to `BattleResult`,
but I want to do something more interesting.

After fighting a battle, let's *update* the strength of each ship with their
new health: like `$ship1->setStrength($ship1Health)` and the same for `$ship2`:

[[[ code('5c87711642') ]]]

After all, in real life - if a `$ship` is almost defeated, it's probably
pretty broken - so it's `$strength` should reflect that.

Check this out by dumping `$ship1->getStrength()` and `$ship2->getStrength()`
and die. Refresh! We have -14 and 116, 130 and 0 and so on.

Ok, working nicely, and that's simple. Actually, we just did something really
important. Until now, this function has only *read* data from our ships. But
now, we've *changed* those objects. In other words, in `battle.php`, we start
with two `Ship` objects and pass them into `battle()`:

[[[ code('59ab5f89bc') ]]]

Once that finishes running, those *same* two objects are different now: their 
data has changed.

This is *totally* different than how arrays work: if `$ship1` were an array,
and the `battle()` function changed one of its keys internally, that would
have *no* effect here: `$ship1` would still be the same array with the same
original values.

Objects are passed by reference: it means that there is only *one* `$ship1`
object in existence and when we pass it to a function, we're passing that
*one* object. But when you pass an array or a string to a function, you're
actually passing a copy of the original value. If that value changes inside
the function, it has no affect on the original variable.

Some of you may be familiar with adding an `&` symbol before an argument:
this does the same thing: it makes that argument pass by reference. For objects,
that's not needed, because this is *always* true.

The takeaway is that if you change an object, you're changing that object
*everywhere*. To prove this, take our `$ship1` and `$ship2` - which are *not*
returned by the `battle()` function - and add a new section that prints the
finished strength. Add a `dl` element to make them a little pretty. First,
echo `$ship1->getName()` and then `$ship1->getStrength()`. Do the same thing
for `$ship2`:

[[[ code('c81b1f58d2') ]]]

We're missing auto-complete because we have some bad PHPDoc somewhere. We'll
fix that in a bit.

Time to try it! Since objects are passed by reference, we should see the
new, modified strength values - not the originals. Absolutely perfect.

Now let's get really wild and start fetching our ships from a database.
