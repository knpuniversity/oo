# More Fun with use Statements

I hate needing all these `require` statements. But thanks to our autoloader, the
*only* thing we need to do is give every class the namespace that matches its directory.
This will be a little bit of work because we didn't do it up front - life is much
easier when you use namespaces like this from the very beginning. But, we'll learn
some other stuff along the way.

The `AbstractShip` class lives in the `Model` directory, so give it the namespace
Model. Copy that and do the same thing in `BattleResult`, `BrokenShip`,
`RebelShip`, `Ship` and `FriendShip` -- just kidding there's none of that in epic code
battles.

Perfect. `BattleManager` already has the correct `Service` namespace.
In Container, paste that same one. Repeat that in `JsonFileShipStorage`,
`PdoShipStorage`, `ShipLoader`and `ShipStorageInterface`. These all live in the
`Service` directory.

## Missing use Statements = Common Error

Ok! Let's see what breaks! Go back and refresh. The first error we get is:

> Class Container not found in index.php

Ok, you're going to see *a lot* of class not found errors in your future. When you
see them, read the error very closely: it always contains a hint. This says class
`Container` is not found. Well, we don't have a class called `Container`: our class
is called `Service\Container`. This tells me that in `index.php` on line 6, we're
referencing the class name *without* the namespace. Sure enough, we have `new Container`.

To fix this, we *could* say `Service\Container` here *or* we can add a `use` statement
for `Service\Container`. Let's do that.

And I can already see that we'll have the same problem down below with `BrokenShip`:
PhpStorm is trying to warn me! Add a `use Model\BrokenShip` to take care of that.

We'll probably have the same problem in `battle.php` - so open that up. Yep, add
`use Service\Container`.

Looking good!

## Reading the Error Messages... Closely

Try it again! Ok:

> Class `Service\RebelShip` not found in `ShipLoader`.

Remember what I just said about reading the error messages closely? This one has
a clue: it's looking for `Service\RebelShip`. But we don't have a class called
`Service\RebelShip` - our class is called `Model\RebelShip`. The problem exists
where we're *referencing* this class - so in `ShipLoader` at line 43.

This is the most *common* mistake with namespaces: we have `new RebelShip`, but we
*don't* have a `use` statement on top for this. This is the same problem we just
solved in `index.php`, but with a small difference. Unlike `index.php` and `battle.php`,
this file lives in a namespace called `Service`. That causes PHP to assume that
`RebelShip` *also* lives in that namespace -- you know like roommates.

Here's how it works: when PHP parses this file, it sees the `RebelShip` class on
line 43. Next, it looks up at the top of the file to see if there are any `use`
statements that end in `RebelShip`. Since there aren't, it assumes that `RebelShip`
also lives in the `Service` namespace, so `Service\RebelShip`.

Think about it: this is *just* like directories on your filesystem. If you are inside
of a directory called `Service` and you say `ls RebelShip`,  it's going to look for
`RebelShip` inside of the `Service` directory.

But in `index.php` - since this doesn't hold a class - we didn't give this file a
namespace. If you forget a `use` statement for `BrokenShip` here, this is equivalent
to saying `ls BrokenShip` from the *root* of your file system, instead of from inside
some directory.

In both cases the solution is the same: add the missing `use` statement: `use Model\RebelShip`.
Now PhpStorm *stops* highlighting this as an error. Much better.

We have the same problem below for `Ship`: add `use Model\Ship`. Finally, there's
one more spot in the PHP documentation itself. Because we don't have a `use` statement
in this file yet for `AbstractShip`, PhpStorm assumes that this class is `Service\AbstractShip`.
To fix that, add `use Model\AbstractShip`.

Now, everything looks happy!

The moral of the story is this: whenever you reference a class, don't forget to put
a `use` statement for it. Now, there is *one* exception to this rule. If you reference
a class that happens to be in the *same* namespace as the file you're in - like
`ShipStorageInterface` - then you don't need a `use` statement. Php correctly assumes
that `ShipStorageInterface` lives in the `Service` namespace. But you don't get
lucky like this *too* often.

I already know we need to fix *one* more spot in `BattleManager`. Add a `use` statement
for `Model\BattleResults` and another for `Model\AbstractShip`.

Phew! I promise, this is all a lot easier if you just use namespaces from the beginning!
Let's refresh the page. Our app is back to life, and the `require` statements are
gone!
