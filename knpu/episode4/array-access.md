# ArrayAccess: Treat your Object like an Array

Let's do something *else* that's not possible. `BattleResult` is an object.
But, use your imagination: its only real job is to hold these three properties,
plus it does have one extra method: `isThereAWinner`. But for the most part, it's
kind of a glorified associative array.

Let's get crazy and *treat* the object like an array: say
`$battleResults['winningShip']->getName()`.

That shouldn't work, but let's refresh and try it. Ah yes:

> Cannot use object of type Model\BattleResult as an array.

It's right - we're breaking the rules.

## The ArrayAccess Interface

After the last chapter, you might expect me to go into `BattleResults` and add some
new magic method down at the bottom that would make this legal. But nope!

There is actually a *second* way to add special behavior to a class, and this method
involves interfaces. Basically, PHP has a group of built-in interfaces and each gives
your class a different super-power if you implement it.

The most famous is probably `\ArrayAccess`.

Of course as soon as you implement any interface, it will require you to add some
methods. In this case, PhpStorm is telling me that I needed `offsetGet`, `offsetUnset`,
`offsetExist` and `offsetSet`.

Ok, let's do that, but with a little help from my editor. In PHPStorm, I can go to
the Code->Generate menu and select Implement Methods. Select these 4.

Cool!

And just by doing this, it's *legal* to treat our object like an array. And when
someone tries to access some array key - like `winningShip` - we'll just return
that property instead.

So, for `offsetExists()`, use a function called `property_exists()` and pass it
`$this` and `$offset`: that will be whatever key the user is trying to access.

For `offsetGet()`, return `$this->$offset` and in `offsetSet()`, say `$this->$offset = $value`.
And finally - even though it would be weird from someone to unset one of our keys,
let's make that legal by removing the property: `unset($this->$offset)`.

Ok, this is a little weird, but it works. Now, just like with magic methods, don't
run and use this everywhere for no reason. But occasionally, it might come in handy.
And more importantly, you *will* see this sometimes in outside libraries. This means
that even though something *looks* like an array, it might actually be an object.
