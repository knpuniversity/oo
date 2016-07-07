# Namespaces and Core PHP Classes

Let's close all our tabs and open up `Container`. In the last course, we created
*two* different ways to load `Ship` objects: one that reads a JSON file - `JSONFileShipStorage`
and another that reads from a database - `PDOShipStorage`.

And you could switch back and forth between these without breaking anything, thanks
to our cool `ShipStorageInterface`. Change it to use the PDO version and refresh.

Woh, new error:

> Class Service\PDO not found on Container.php line 28

Let's check that out.

## use Statements for core PHP Classes?

Here, we see the *exact* same error as before: "Undefined Class PDO". So far, the
answer to this has always been:

> Oh, I must have forgotten a `use` statement. I referenced a class, so I probably
> need to add a `use` statement for it.

But here's the kicker: `PDO` is a *core* PHP class that happens to *not* live in
a namespace. In other words, it's like a file that lives at the root of you file
system: not in any directory.

So when PHP sees `PDO` mentioned, it looks at the top of the class for a `use` statement
that ends in PDO, it doesn't find one, and it assumes that `PDO` lives in the `Service`
namespace. But in fact, `PDO` lives at the root namespace.

The fix is easy: add a `\` at the front of `PDO`. This makes sense: if you think
of namespaces like a directory structure, This is like saying `ls /PDO` . It doesn't
matter *what* directory, or namespace, we're in, adding the `\` tells PHP that this
class lives at the root namespace. Update the other places where we reference this
class.

## The Opening Slash is Portable

This is true for *all* core PHP classes: none of them live in namespaces. So, *always*
include that beginning `\`. Now, technically, if you were inside of a file that did
*not* have a `namespace` - like `index.php` - then you don't need the opening `\`.
But it's *always* safe to say `new \PDO`: it'll work in all files, regardless
of whether or not they have a namespace.

## When Type-Hints Fail

If you refresh now, you'll see another error that's caused by this same problem.
But this one is less clear:

> Argument 1 passed to PDOShipStorage::__construct() must be an instance of
> `Service\PDO`, instance of `PDO` given.

This should jump out at you: "Instance of `Service\PDO`". PHP thinks that argument
1 to `PDOShipStorage` should be this, *nonsense* class. There is no class `Service\PDO`!

Check out `PDOShipStorage`: the `__construct()` argument is type-hinted with `PDO`.
But of course, this *looks* like `Service\PDO` to PHP, and that causes problems.
Add the `\` there as well.

Phew! We spent time on these because these are the mistakes and errors that we *all*
make when starting with namespaces. They're annoying, unless you can debug them quickly.
If you're ever not sure about a "Class Not Found" error, the problem is almost always
a missing `use` statement.

Update the other spots that reference `PDO`.

Finally, refresh! Life is good. You just saw the ugliest parts of namespaces.
