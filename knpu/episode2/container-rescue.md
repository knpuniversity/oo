# Container to the Rescue

Congratulations! What we just did is *incredible*. Every service object we
have - meaning every object that does work like `BattleManager`, `PDO` and
`ShipLoader` - is created by the `Container` class. This is its *only* job.

### Adding Arguments? Simple

The benefits are huge. Here's one. Imagine we need to give `BattleManager`
a few constructor arguments. Once we've done that, the *only* code we
need to touch outside of `BattleManager` is right here inside Container. 
We *don't* need to go anywhere else - like `battle.php` - and change *anything*. 
We just say `$container->getBattleManager()` and the `Container` class will 
take care of all of the work to create that object.

### Objects aren't Created Until/Unless Needed

But wait, there's more! Before, at the top of our files - like `index.php` -
we created *all* of our objects. So if we had 50 different useful service
objects, we'd create them all right here. How wasteful.

But with the `Container` idea, none of these objects are created until and
*unless* you ask for them. For example, `index.php` never calls
`$container->getBattleManager()`. So the `BattleManager` object is never
created. We save precious CPUs and memory.

## Containers: A Pattern

I didn't invent this Container idea - it's a well-known strategy called a
dependency injection container. It's a special class and you always have
just one.

Its only job is to create service objects. And in fact, if you do a good
job, *all* service objects will be created here - you won't instantiate them
*anywhere* else.

## Model Classes versus Service Classes

Remember - *model* objects - like `Ship` and `BattleResult` - are classes
that just hold data and don't really do much work. And you can create *these*
whenever you need them - they're *not* created by the Container. So in `BattleManager`
at the bottom of `battle()`, we needed a new `BattleResult` to be a container
for our data. And in `ShipLoader`, whenever you query for a ship, we create
a new `Ship` model object.

Model objects *can* be created anywhere in your code, whenever you need them.
But these *service* objects - the ones that do work for you and don't really
hold data - these should be created in a central spot. And the `Container`
is a nice way to do that.

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
-- that hold data but don't do anything - and service objects - that do work but
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
