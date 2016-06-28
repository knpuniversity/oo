# Static Methods

A really important thing just happened: for the first time *ever*, we referred to
something on our class by using its *class name*. To use the constant, we said
`BattleManager::TYPE_NO_JEDI`.

That makes sense, but notice: it's *completely* different than how we've referred
to class properties and methods so far. Normally, we create a new object
by saying `new BattleManager()`. For us, this lives inside the `Container`. But here's
the important part: to reference a method or property, we use the *object* by saying
`$battleManager->` followed by the method name. 

For constants, it's totally different. We don't ever need to instantiate an object.
Instead, at any point, you can just say the class name `::TYPE_NO_JEDI`.

So sometimes, we need to create an object and reference that *object*. But other
times, we don't need an object: we just use the class name. What's going on?

# Static versus Non Static

Here's the deal: constants are *static*, and so far, all of our properties and methods
are *non-static*. 

You see, whenever you add something to a class - like a property or a method - you
can choose to attach it to an individual instance of the object or to the class
itself. When you choose to attach something to a class, it's said to be "static".

Let's look at a real example. In `AbstractShip`, the properties `id`, `name`,
`weaponPower` and `strength` are *not* static. That means that if you have two `Ship`
objects, each has a different `id`, `name`, `weaponPower` and `strength`. If you
change the `name` in one `Ship` it does *not* affect any other ship objects.

But, if we were to change these properties to `static` - which *is* something you
can do - then suddenly the `name` property would be global to *all* ships, meaning
two ship objects could *not* have different names. This would be the *one* name for
all `AbstractShip`.

Remember - a `class` is like a blueprint for a ship, and an object is like a real,
physical ship. Since each real ship has a different name, it makes sense to make
the `$name` property *non-static*. This attaches the name to each individual object.

But other times, it may make sense to attach a property to the *blueprint* itself,
meaning to the class. For example, suppose that the very design of the ships guarantees
that each should have a minimum strength of 100. Since that is a property of
ships in general, we might add a new `private static` property called `$minimumStrength`
and use that to prevent individual ships from setting their specific `$strength`
lower than this.

## Class Constants are Static

So, with properties or methods, you can choose static or non-static. But constants,
well, they're static by their very nature. And that makes sense: the TYPE constants
in `BattleManager` are global to the `BattleMangaer` class in general - it wouldn't
make sense for them to be different for different objects.

When you reference something statically, you always reference it by saying the class
name, `::`, and then whatever you're referencing.

## The Special Self Keyword

Before we try an example, there's another special property of static things. Notice
that we're inside `BattleManager` and we're referencing the `BattleManager` class.
If you want to, you can change this to, `self::TYPE_NO_JEDI`. In the same way that
`$this` refers to the current object, `self` refers to the *class* that we're inside
of. So this didn't change our behavior: it's just a nice shortcut.

Now, let's see a real-life static method in action.
