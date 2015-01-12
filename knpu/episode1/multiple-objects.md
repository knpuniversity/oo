# Multiple Objects

This object-oriented, or OO, stuff gets *really* fun once we have multiple
objects. Afterall, it takes at least 2 ships to start a battle.

But first, let's summarize all of this printing stuff into a normal, traditional,
flat function called `printShipSummary()`. It'll take in a `Ship` object
as an argument, which I'll call `$someShip`. Now, copy all the echo stuff
into the function.

I could've called my `$someShip` argument anything - that's just how arguments
to any function work. Since 

The argument to the function could be called anything. Since I chose to call
it `$someShip`, all of the `$myShip` variables below need to be updated to
`$someShip` also. This is just classic behavior of functions - nothing special.
I'll use a trick in my editor:

[[[ code('eaa832b8ec') ]]]

Ok, saving time!

Back at the bottom of the file, call this like any traditional function, and
pass it the `$myShip` variable, which we know is a `Ship` object:

[[[ code('bd04dc10b9') ]]]

So we're throwing around some objects, but this is just normal, flat, procedural
programming. When we refresh it's exactly the same.

## Create Another Ship

Now, to the good stuff! Let's create a *second* Ship object. The first is
called `Jedi Starship` and has 10 `weaponPower`. Let's create `$otherShip`.
And just like if 2 ships landed in your dock, one ship will have one name,
and another will have something different. Let's call this one: Imperial Shuttle.
Set its `weaponPower` to 5 and a strength of 50:

[[[ code('bebb12f475') ]]]

These two separate objects both have data inside of them, but they function
indepedently. The only thing they share is that they're both `Ship` objects,
which means that they both share the same rules: that they have these 4 properties
and these 3 methods. But the property *values* will be totally different between
the two.

This means that we can print the second Ship's summary and see its specs:

[[[ code('a3a91e5e96') ]]]

Now we get a print-out of two independent Ships where each has different
data.

## Objects Interact

Since the goal of our app is to let two ship's fight each other, things
are getting interesting. For example, we could fight `$myShip` against `$otherShip`
and see who comes out as the winner.

To keep things simple, let's imagine we want to know whose strength is higher.
Of course, we could just write and `if` statement down here and manually
check `$myShip`'s strength against `$otherShip`.

But we could also add a new method inside of the `Ship` class itself. Let's
create a new method that'll tell us if one Ship's strength is greater than
another ship's. We'll call it: `doesGivenShipHaveMoreStrength()`. And of course,
it needs a Ship object as an argument:

[[[ code('20a5ad9c35') ]]]

So just like with our `printShipSummary()` function, when we call this function,
we'll pass it a `Ship` object. What I want to do is compare the Ship object
being passed to whatever Ship object we're calling this method on. Before
I fill in the guts, I'll show you how we'll use it: if `$myShip->doesGivenShipHaveMoreStrength()`
and pass it `$otherShip`. This will tell us if `$otherShip` has more strength
than `$myShip` or not. If it does, we'll echo `$otherShip->name` has more
strength. Else, we'll print the same thing, but say `$myShip` has more strength.

[[[ code('13d2b9a47c') ]]]

Inside of the `doesGivenShipHaveMoreStrength()`, the magic `$this` will refer
to the `$myShip` object, the one whose name is `Jedi Starship`. So all we
need to do is return `$given->strength` greater than my strength:

[[[ code('a0e8698a9d') ]]]

Ok, let's try it! When we refresh, we see that the Imperial Shuttle has more
strength. And that makes sense: the Imperial Shuttle has 50 compared with
0 for `$myShip`, because it's using the default value.

Let me add another separator and let's double-check to see if this is working
by setting the strength of `$myShip` to 100.

Ok, refresh now! Now the Jedi Starship is stronger. Undo that last change.

So how cool is this? Not only can we have multiple objects, but they can
interact with each other through methods like this one. I'll show you more
of this later.

## My Editor is Confused

But before we go on, we need to help my editor. It's confused. Inside `printShipSummary()`,
my editor doesn't seem to recognize the `sayHello()` method on `Ship`, it
thinks it doesn't exist. But down at the bottom of the file, when I call
`doesGivenShipHaveMoreStrength()`, it's not highlighted in yellow - that
means my editor *does* see that this method exists. So what gives? Why doesn't
it recognize the `sayHello()` function?

If you *just* look at the `printShipSummary()` function, all that my editor
knows is that we're passing in *some* argument called `$someShip`, but it
doesn't know *what* it is. Is it a string? A boolean? A `Ship` object? *We*
know that this will be a `Ship` object, because we're creating `Ship` objects
below and passing those as the argument. But our editor has no idea. And
for that reason, it doesn't know to look on the `Ship` class to see that there's
a `sayHello()` function.

Now, you don't need to fix this, it's totally fine. But if you want to, you
can use PHP documentation to give your editor a little hint about what the
heck this `$someShip` variable is. By using this syntax, you can say this
this is a `Ship` object:

[[[ code('4dbf1dcbcc') ]]]

And as soon as I do that, those ugly yellow highlights go away, and I even
get auto-completion on new code I write.

As nice as this is, it makes no *functional* difference - your code isn't
behaving any different than before. This is *just* a "nice" thing you can
do to help your editor.
