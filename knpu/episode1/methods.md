# Class Methods

Array and objects have a lot in comming: arrays have keys, objects and properties,
but both store data. The only real difference is that the object has a class
that tells us which properties it can have.

But objects have one other big, incredible, mind-blowing advantage: methods.
A method is a fancy word for a function, and we're all comfortable with those.
The difference is that a method lives *inside* of a class.

To create a method, start with `public function`. After this, it looks like
a normal function - let's call ours `sayHello`, and add the normal parenthesis
and curly braces stuff. Inside, we can do anything - so let's echo `Hello`:

[[[ code('10b5da3cba') ]]]

To call the method, let's use our object "arrow" syntax. Let's add an `<hr/>`
so I don't confuse myself, then echo `$myShip`, the arrow, then `sayHello()`:

[[[ code('c29be467bc') ]]]

The only difference between accessing a property and a method is the open
parenthesis and close parenthesis, so don't forget that. And a method is
*just* like a traditional function, except it lives inside of the class,
so you have to call it on the object. And when we refresh, success!

This is kind of *amazing* because we've have little packages of data that
can now perform actions and *do* things through methods. Arrays can't do
*anything* like that.

## Referencing Properties from Inside a Class

So let's add another - a `getName()` method. Remember how functions can return
a value? Sure, methods can do that too. Let's not *actually* return the name
of *this* ship yet, let's fake it:

[[[ code('993cb59a6b') ]]]

Down below, we call it the exact same way, except we can echo what it returns:

[[[ code('00e766afc5') ]]]

Now refresh! There's our fake name. Of course, what I *really* want to do
is return the name of the ship that I'm calling this method on. I know, not
the most interesting function, but it gives us a new problem. When we have
the `$myShip` variable, we *know* how to access a property - just use the
arrow syntax on it. But when we're *inside* of the class, how can we get
the value of the `name` property?

The answer is with a very special variable called `$this`:

[[[ code('68d2dd95e1') ]]]

Here's the rule: when you're inside of a method, you magically have access
to a variable called `$this`. And `$this` is whatever `Ship` object that
we're calling the method on, in our case our favorite `$myShip` object whose
name is "Jedi Starship". In *all* cases, the variable is called `$this`,
that's just what the PHP elders decided this magic name should be.

When we refresh, hey - there's our ship's *real* name!

## Adding more Properties

Our `Ship` class has just one property. Let's go back at look at the `get_ships()`
function I wrote before we started. Here, each ship has a key for `name`,
`weapon_power`, `jedi_factor` and `strength`. Let's add three more properties
to *our* class: `weaponPower`, `jediPower` and `strength`. I camel-cased
`weaponPower` and `jediPower` - that's kind of a standard, but you can do
whatever you want:

[[[ code('af12d12d9f') ]]]

### Default Property Values

You can also give a property a default value. So if you create a new `Ship`
object and we never set the `weaponPower`, let's default its value to zero.
Let's do that for `jediFactor` and `strength` too.

[[[ code('fc6ebd1126') ]]]

These new properties aren't special, so we can use them like before. Let's
`var_dump` the `weaponPower` property:

[[[ code('ea0a7d3dec') ]]]

When we refresh, it dumps zero. Cool! That's using our default value because
we never actually set the `weaponPower`. Let's set it now - `$myShip->weaponPower = 10;`:

[[[ code('f0bc0f5ccb') ]]]

Now we see 10.

### Methods that Do work

Our two methods are simple. So now let's add something useful. We'll be printing
out the details of our ships all over the place, so I need a way to see the
`weaponPower`, the `strength` and the `jediFactor` all at once - like a little
summary. One handy way to do this is with a new method that creates that
summary string and returns it to us.

Make a new function `getNameAndSpecs()`. Let's use the nice `sprintf` function
with %s wildcards for the ship's name, followed by the `weaponPower`, `jediFactor`
and `strength`. Now, we need to pass it what to fill in for those `%s` placeholders.
To reference the name, use the magic `$this` variable: `$this->name`. Do
the same thing for `weaponPower`, `jediFactor` and `strength`:

[[[ code('d4492fb84f') ]]]

And of course, make sure you have a `return` statement in front of all of
this! Let's enjoy our hard work by echo'ing the method below: `$myShip`,
arrow, `getNameAndSpecs` then the open and close parenthesis so PHP knows
this is a method, not a property by that name.

[[[ code('d35f89acb5') ]]]

Ready to try it! Refresh! There's our weird-little summary. We can use this
across our app, and if we ever want to change how it looks, we only need
to update one spot.

### Method Arguments

Being PHP pro's, we of course know that functions can have arguments. Once
again, a method in a class is no different. Isn't that nice? Let's say that
sometimes we need an even *shorter* summary. Add an argument to the method
called `$useShortFormat`. Now, use an `if` statement to choose between two
different formats:

[[[ code('399e4c4de4') ]]]

We'll just take out the w, j and s and put slashes instead. Cool! Now my
editor is angry because `getNameAndSpecs()` requires an argument. So pass
`false` when we call it, then call it again and use `true`.

[[[ code('927f010e83') ]]]

Refresh! Perfect!
