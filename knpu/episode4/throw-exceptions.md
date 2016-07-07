# Throwing an Exception (and a Party)

Let's talk about something totally different: a powerful part of object-oriented
code called *exceptions*.

In `index.php`, we create a `BrokenShip` object. I'm going to do something crazy,
guys. I'm going to say, `$brokenShip->setStrength()` and pass it... `banana`.

That strength makes no sense. And if we try to battle using this ship, we should
get *some* sort of error. But when we refresh... well, it *is* an error: but not
exactly what I expected.

This error is coming from `AbstractShip` line 65. Open that up. I want you to look
at 2 exceptional things here.

First, we planned ahead. When we created the `setStrength()` method, we said:

> You know what? This needs to be a number, so if somebody passes something
> dumb like "banana," then let's check for that and trigger an error.

Second, in order to trigger an error, we threw an *exception*. And that's actually
what I want to talk about: Exceptions are classes, but they're completely special.

But first, `Exception` is a core PHP class, and when we added a `namespace` to this
file, we forgot to change it to `\Exception`.

That's better. Now refresh again. *This* is a much better error:

> Uncaught Exception: Invalid strength passed: banana

## When things go Wrong: Throw an Exception

When things go wrong, we throw exceptions. Why? Well, first: it stops execution of
the page and immediately shows us a nice error.

**TIP
If you install the XDebug extension, exception messages are more helpful, prettier
and will fix your code for you (ok, that last part is a lie).
***

## Catching Exceptions: Much Better than Catching a Cold

Second, exceptions are *catchable*. Here's what that means.

Suppose that I wanted to kill the page right here with an error. I actually have
two options: I can throw an exception, *or* I could print some error message and
use a `die` statement to stop execution.

But when you use a `die` statement, your script is *truly* done: none of your other
code executes. But with an exception, you can actually try to *recover* and keep
going!

Let's look at how. Open up `PDOShipStorage`. Inside `fetchAllShipsData`, change the
table name to `foooo`. That clearly will *not* work. This method is called by `ShipLoader`,
inside `getShips`

When we try to run this, we get an *exception*:

> Base table or view not found

The error is coming from `PDOShipStorage` on line 18, but we can also see the line
that called this: `ShipLoader` line 23.

Now, what if we knew that *sometimes*, for some reason, an exception like this might
be thrown when we call `fetchAllShipsData`. And when that happens, we *don't* want
to kill the page or show an error. Instead, we want to - temporarily - render the
page with zero ships.

How can we do this? First, surround the line - or lines - that might fail with a
try-catch block. In the `catch`, add `\Exception $e`. Now, if the `fetchAllShipsData()`
method throws an exception, the page will *not* die. Instead, the code inside `catch`
will be called and then execution will keep going like normal.

That means, we can say `$shipData = array()`.

## Using the Exception Object

And just like that, the page works. That's the power of exceptions. When you throw
an exception, any code that calls your code has the opportunity to catch the exception
and say:

> No no no, I don't want the page to die. Instead, let's do something else.

Of course, we probably also don't want this to fail silently without us knowing,
so you might trigger an error and print the message for our logs. Notice, in catch,
we have access to the `Exception` object, and every Exception has a `getMessage()`
method on it. Use that to trigger an error to our logs.

Ok, refresh! Right now, we see the error on top of the page. But that's just because
of our error_reporting settings in `php.ini`. On production, this wouldn't display,
but *would* write a line to our logs.
