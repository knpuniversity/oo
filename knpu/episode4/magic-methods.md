# Magic Methods: __toString() __get, __set()

If I give you an object, could you print it? What I mean is, in `battle.php`, after
we determine the winners, we echo `$ship1->getName()`, which is of course a string.

But could we just print `$ship1` and `$ship2`?. Does it make sense to print an object?
The answer is... no. Try to battle:, you get a very clear error that says:

> Object of class `Model\RebelShip` could not be converted to string.

Remember this error: you'll eventually try to print an object on accident and see
this!

## But you CAN Print an Object

Why am I telling you this seemingly small and obvious fact? Because I'm lying! You
*can* print objects! You just have to do a little bit more work.

Here's the big picture: there are ways to give a class super-powers - like the ability
to be printed or - as we'll see next - the ability to pretend like it's an array.

Open up `AbstractShip`. To make objects of this class printable, go to the bottom
and create a new `public function __toString()`. Inside, `return $this->getName()`.

Go back, refresh, and now it works just fine.

By adding the `__toString()` method - we gave PHP the ability to convert our object
into a string. The `__toString()` *must* be called exactly like this, and there are other
methods that take on special meaning. They all start with `__`, and we've already
seen one: `__construct()`. These are collectively called Magic Methods.

## The Magic __get()

There are actually just a few magic methods: let's look at another common one.
In `battle.php`, scroll down a little bit to where it shows the ship health. Change
this: instead of `$ship1->getStrength()`, say `$ship1->strength`.

This should *not* work, and PHPStorm tells us why: the member - meaning property -
has private access. We can't access a `private` property from outside the class.

But once again - via a magic method - you can bend the rules. This time, add a
`public function __get()` with a single argument: `$propertyName`. For now, just
dump that.

Refresh to see what happens. Interesting! It dumps the string `strength`. Here's
the magic: if you reference a property on your object that is not accessible - either
because it doesn't exist or is private or protected - *and* you have an `__get()`
method, then PHP will call that and pass you the property name.

Then - if you want - you can return its value. Add `return $this->$propertyName`.
This looks weird: PHP will see `$propertyName`, evaluate that to `strength`, and
then return `$this->strength`.

Refresh again. It *works*!

Not surprisingly, there's also a method called `__set()`, which allows you to *assign*
a value to a non-existent property, like `$ship->strength = 100`.

## Don't be Too Clever

Now, *just* because you have all this new power *doesn't* mean you should use it.
As soon as you add things like `__get()`, it starts to break your object oriented
rules. All of a sudden, even though it *looks* like `strength` is private, I actually
*can* get it... so it's not really private.

You also won't get reliable auto completions from your editor - it has a hard time
figuring out what you're doing in these magic methods.

So my recommendation is: avoid using magic methods, except for `__toString()` and
`__construct()`.

But, you *do* need to know these exist: even if *you* don't use them, other libraries
will, which might be confusing if you're not watching for it.

But beyond magic methods, there *are* other super powers you can give your objects
that I *do* love. Let's look at those.
