# Container: Force Single Objects, Celebrate

Home stretch! Our goal is to make `Container` responsible for creating *every*
service object: like `PDO`, but also `ShipLoader` and `BattleManager`.

## Guaranteeing only One PDO Object

But first, we have a problem: if we called `$container->getPDO()` twice on
the same request, we'd *still* end up with multiple PDO objects, and so,
multiple database connections. Ok, if we're careful, we can avoid this.
Let's do better: let's *guarantee* that only one PDO object is ever created.

We did this before in `ShipLoader`. Create a `private $pdo` property at the
top of `Container`. In `getPDO()`, add an `if` statement to see if the property
is null. If it is, create the `new PDO()` object and set it on the property.
Return `$this->pdo` at the bottom:

[[[ code('f484be325a') ]]]

Again, the first time we all this: the `pdo` property is null, so we create
the object and set the property. The second, third and fourth time we call
this, the object is already there, so we just return it.

Oh, and while I'm here, I'll paste back one line I lost on accident earlier:

[[[ code('407f106064') ]]]

This just sets up PDO to throw nice exceptions if something goes wrong so
I can see them.

## Move ShipLoader to the Container

Keep going! We don't want to instantiate a `ShipLoader` object manually in
`battle.php` and `index.php`. Let's do it inside `Container`.

Follow the same pattern: create a `private` property called `$shipLoader`,
and a `public function getShipLoader()`:

[[[ code('55f9cb8376') ]]]

In here, add the same `if` statement: `if ($this->shipLoader === null)`,
then `$this->shipLoader = new ShipLoader()`. Remember, *it* has a required
argument for the PDO object. But that's no problem, just say `$this->getPDO()`.
At the bottom return `$this->shipLoader` and add the PHPDoc above it:

[[[ code('7c9c2760c0') ]]]

Use it! In `index.php`, say `$shipLoader = $container->getShipLoader()`.
And I have a bonus for you! We don't need the `$pdo` variable anymore - we
only did that to pass it to `ShipLoader`. Simplify!

[[[ code('99c0f36897') ]]]

Copy the new `$shipLoader` line and repeat this in `battle.php`:

[[[ code('8d2273c9c6') ]]]

Ok, make sure this is all working. Refresh! Somebody make a sad trombone
noise:

    Call to a member function getShips() on a non-object index.php line 6.

Ok, debugging cap back on. On line 6, we're calling `getShips()` on the
`$shipLoader`, which is apparently null. So `$container->getShipLoader()`
must *not* be returning the object for some reason. How rude.

Oh, and the problem is me! I added an extra `!` in my `if` statement so that
it never got inside. Lame. Make sure your's looks like mine:

[[[ code('7c9c2760c0') ]]]

Ok, *now* it works.

## Move BattleManager to the Container

Ok, only one more service to go! In `battle.php`, we create the `BattleManager`.
Let's move it! At the `private $battleManager` property and then the
`public function getBattleManager()`. Copy the ship loader code to save
time... and so I don't mess up again. Update it for `battleManager`:
`$this->battleManager = new BattleManager()`. And return `$this->battleManager`:

[[[ code('6d0b40b6ed') ]]]

Go use it in `battle.php`: `$battleManager = $container->getBattleManager()`:

[[[ code('fbbe3f554c') ]]]

Ok, let's try the *whole* thing! Start a battle... and Engage. Ok, the bad
guys won, but our app still. And the code behind it is so much more awesome.

## Container to the Rescue

Congratulations! What we just did is *incredible*. Every service object we
have - meaning every object that does work like `BattleManager`, `PDO` and
`ShipLoader` - is created by the `Container` class. This is its *only* job.

### Adding Arguments? Simple

The benefits are huge. Here's one. Imagine we need to give `BattleManager`
a few constructor arguments. Once we've done that, the only other code we
need to touch is right here inside Container. We *don't* need to go everywhere
in our code - like `battle.php` - and change *anything*. We just say
`$container->getBattleManager()` and the `Container` class will take care
of all of the work to create that object.

### Objects aren't Created Until/Unless Needed

But wait, there's more! Before, at the top of our files - like `index.php` -
we created *all* of our objects. So if we had 50 different useful service
objects, we'd create them all right here.

But with the `Container` idea, none of these objects are created until and
*unless* you ask for them. For example, `index.php` never calls
`$container->getBattleManager()`. So the `BattleManager` object is never
created. We save previous CPUs and memory.

## Containers: A Pattern

I didn't invent this Container idea - it's a well-known strategy called a
dependency injection container. It's a special class and you always have
just one.

Its only job is to create service objects. And in fact, if you do a good
job, *all* service objects will be created here - you won't instantiate them
*anywhere* else.

## Model Classes versus Service Classes

Remember - *model* objects - like `Ship` and `BattleResult` - are the classes
that just hold data and don't really do much work. And you can create these
whenever you need them - they're *not* created by the Container. So in `BattleManager`
at the bottom of `battle()`, we needed a new `BattleResult` to be a container
for our data. And in `ShipLoader`, whenever you query for a ship, we create
a new `Ship` model object.

Model objects *can* be created anywhere in your code, whenever you need them.
But these service objects - the ones that do work for you and don't really
hold data - these should be created in a central spot. And the `Container`
idea is a nice way to do that.

### Reorganizing Models and Services

To make this more clear in our app, let's redecorate. Create a `lib/Service`
directory and a `lib/Model` directory. Move `BattleManager`, `ShipLoader`
and `Container` - it's a little different, but it's still technically a service - 
into `lib/Service`. And move `BattleResult` and `Ship` - our simple "model"
objects into `lib/Model`:


```
mv lib/BattleManager.php lib/Service
mv lib/ShipLoader.php lib/Service
mv lib/Container.php lib/Service

mv lib/Ship.php lib/Model
mv lib/BattleResult.php lib/Model
```

To make this work, we just need to update the `require` paths in `bootstrap.php`:

[[[ code('58326f469c') ]]]

And yes, in a future episode, we're going to fully get rid of these. And
it will be great.

Refresh! Still working!

## Best Practices vs the Real World

In this episode, instead of learning more OO concepts, we went straight to
the hard stuff and learned how to *organize* our code into model classes
that hold data and service classes that do work. We also learned that when
you're in a service class - like `ShipLoader` - instead of hardcoding configuration
or creating other service objects inside, we can move those outside of the
class and add anything we need as an argument to the `__construct()` function.
Then, we'll *pass* that information to the class. That's dependency injection,
and it's one of the harder things to grasp about OO. So if it doesn't totally
make sense yet - stick with us - we'll keep practicing.

Now a quick warning. When you look at other projects, this idea of model objects
- that hold data but don't do anything - and service objects - that do work but
don't really hold any data - is not always followed. Sometimes you'll see
these mixed together you might have a class like `Ship` that has methods
in it that do work - like `battle()` or even `save()` that would save the
Ship's data to the database.

What I'm showing you are "best practices". When you get out into the wild,
it's not always this clean. And that's ok - over time, you'll learn to bend
the rules when it makes sense. But in your mind, keep these two *types* of
classes separate and recognize if a class is a model, a service or both.

Ok guys - in the next episodes, we're going to dive into more great concepts
of OO - like interfaces, abstract classes, and static calls. These will really
take your mad-skills to the next level.

So join us, and I'll seeya guys next time!
