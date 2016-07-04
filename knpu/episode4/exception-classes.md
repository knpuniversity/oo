# Different Exception Classes

Catching an exception is really powerful. But you can get even fancier.

For right now, `var_dump()` the Exception object. Ok, this object is actually a
`PDOException`. Two Important things: *all* exceptions are objects, and all exception
classes ultimately extend PHP's base `Exception` class. So if you could look at
the source code for `PDOException`, you'd see that it extends `Exception`.

And this ends up giving us a lot more flexibility when working with exceptions.
Why? Remember, we're pretending that - for some reason - we occasionally have some
database problems that cause a `PDOException` to be thrown. When that happens, we
want to recover and just show zero ships. And we've got that.

But what if something *else* goes wrong inside `fetchAllShipsData()` that has *nothing*
to do with talking to the database. Well, that would be truly unexpected, and in
those cases, I want to let the exception be thrown like normal so we can see it
while we're developing.

So here's the question: how can we catch PDOException objects, but not *any* others?
By changing the catch to `\PDOException`.

I'll also change the message to "database exception".

Refresh! Cool: it still catches that exception. But check this out: go back into
`PDOShipStorage` and - before the query - throw a different exception: there's one
called `InvalidArgumentException`. There's nothing special about this class:
PHP has several built-in exceptions, and you can use whatever one feels right for
your scenario.

But, it should *not* be caught by our try-catch. Try it out.

Yes! It totally kills the page.

Exceptions are something that you'll get used to leveraging as you develop more.
But here's the key takeaway: when things go wrong, throw an exception.

## Don't Get Too Clever

Oftentimes, I see people try to *not* throw exceptions. Instead, they try to recover
in some way. Don't do that. I would rather throw an exception, see the
error in my error log and fix it than try to render a broken page and never realize
that there's a bug in my code.

In fact, most frameworks have a pretty easy way to automatically notify you - like
via Slack or by email - whenever an exception is thrown on your site.

Let's fix our code: take out the throw new exception and change the table back to
`ship`. All better.
