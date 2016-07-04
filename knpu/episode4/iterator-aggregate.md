# IteratorAggregate: Loop over an Object!?

Let me show you just *one* other really cool, magic thing - this is my favorite.
Right now, in `ShipLoader`, the `getShips()` method return an array. Instead of doing
that, I'm going to return an object - a `ShipCollection` object. Don't ask why yet.
I'll show you some reasons in a minute.

## Creating ShipCollection

First create a new PHP class called `ShipCollection`. Hey, check it out: PhpStorm
already correctly-guessed that this should have the `Model` namespace: it understands
our PSR-0 naming convention.

Inside, add a `private $ships` property: this will be an array of `Ship` objects.
Then add a `public function __construct()` method, give it a `$ships` argument, and
set that property inside.

Above the `$ships` *just* to help our editor with autocompletion later, add some
PHP Doc that says that this is an array of `AbstractShip`.

Obviously, `ShipCollection` is a class... but its *only* purpose is to be a small
wrapper around an array. In `ShipLoader`, instead of returning the array, return
a `new ShipCollection()` object and pass it `$ships`.

Now, stop: we're referencing `ShipCollection` inside of `ShipLoader`, so we need
a `use` statement for it. Go to the top to add it. But wait! It's already there!
Thank you PhpStorm: it added it automatically for me when I auto-completed the class
name. Whether your editor does this or not, just make sure to *not* forget those
`use` statements!

Finally, above the method, we're *not* returning an array of `AbstractShip` objects
anymore: we're now returning a `ShipCollection`

Cool Now again, don't worry about *why* we're doing this yet. For now, let's try
to fix our app.

## Implementing ArrayAccess First

First, go to `index.php`. Boom!

> Cannot use object of type ShipCollection as array, index.php line 13.

No surprise. After creating the `$brokenShip`, we're trying to add it to the `ShipCollection`
as if it were an array! That's not allowed.... oh wait it is! Open `ShipCollection`
and make it implement `\ArrayAccess`.

Now, at the bottom, I'll open the Code->Generate menu and implement the same 4 methods
as before. This is even easier now: in `offsetExists()`, use
`array_key_exists($offset, $this->ships)`. The other methods are even easier: I'll
fill each in by acting on the `$ships` array property.

Perfect! The `ShipCollection` object can now act like an array.

So refresh again! It works!

## You can't Loop Over an Object :(

Ok, let's start a battle. Woh: check this out - there are *no* ships. What's going
on here?

Look back at `index.php`: eventually we try to *loop* over the `$ships` variable
but this is a `ShipCollection` object! It turns out that after implementing `ArrayAccess`,
we can use the array syntax with an object, but we still *cannot* loop over it like
an array.

## The IteratorAggregate Interface

*Can* we teach PHP *how* to loop over our object? Absolutely: and the answer is
another interface. To implement a second interface, add a comma and then use
`\IteratorAggregate`.

Repeat our trick from before: Code->Generate and then "Implement Methods". This time
we only need to add *one* method: `getIterator()`. The easiest way to make this work
is to return another core helper class: `return new \ArrayIterator()` and pass that
`$this->ships`.

This tells PHP that when we try to loop over this object, it should actually loop
over the `$ships` array property.

Ok, give it a try. Hey guys, we have ships! By adding 2 interfaces, we've made our
ShipCollection object look and act almost *exactly* like an array.

## Why did we Do this?

Ok, let's *finally* answer the question: why did we do this? Because sometimes, it
might be useful to add some helpful *methods* to an array. Well, of course you can't
do that, but you *can* add methods to a class.

For example, add a new method called `public function removeAllBrokenShips()`,
because maybe we want a collection of *only* working ships. By adding this method,
that would be really easy.

Inside, loop over `$this->ships as $key => $ship`. Then, if `!$ship->isFunctional()`,
`unset($this->ships[$key])`.

Let's test this fancy new method out. In `index.php`, call `$ships->removeAllBrokenShips()`.
This looks and acts like an array, but with the super-power to have methods on it.
ooOOOooo.

Refresh and check this out: no more broken ships, ever.

There are more of these interfaces that have special powers, but these are the most
common ones. And the most important thing is just to understand that they exist
and how they work.
