# Static Methods

In `index.php`, the three battle types are hard coded right in the HTML. So what
happens if we decide to add a *fourth* battle type to `BattleManager`. No problem:
add a new constant, then update the `battle()` method logic for whatever cool thing
this new type does.

But surprise! If we forget to *also* add the new type to `index.php`, then nobody's
going to be able to use it. Really, I'd prefer `BattleManager` to be *completely* in charge
of the battle types so that it's the *only* file I need to touch when something changes.

## Using a Handle, Non-Static Method

To do that, create a new function in `BattleManager` that will return all of the
types and their descriptions: call it `public function getAllBattleTypesWithDescription()`.
Here, return an array with the type as the key and the description that should be
used in the drop-down as the value.

Awesome! Next, if we call this method in `index.php`, we can remove the hardcoded
values there. Of course, this method is *non-static*. That means that we need to
call this method on a `BattleManager` *object*. Create a new one by saying
`$battleManager = $container->getBattleManager()`.

Now add `$battleTypes = $battleManager->getAllBattleTypesWithDescription()`. Finally,
scroll down. In place of the hardcoded values, `foreach` over `$battleTypes` as
`$battleType => $typeText`. End the `foreach` and make the option dynamic by printing
`$battleType` and `<?php echo $typeText; ?>`.

Ok! Give it a try! Click the "Battle Again" link. And yes! The drop-down has the
same three values as before.

## Why not make the Method Static?

Here's where things get interesting! We made `getAllBattleTypesWithDescription()`
*non-static*. Could we make it static instead?

To know, ask yourself these two questions:

1. Does it make sense - philosphically - for the `getAllBattleTypesWithDescription()`
   method to be attached to the *class* instead an object? I would say yes: the
   battle types and descriptions will *not* be different for different `BattleManager`
   objects; these are global to the class.

2. Does the method need the `$this` variable? If you need to reference non-static
   properties using `$this`, then the method *must* be non-static. But we're not
   using `$this`.

So let's make this method `static` by saying `public static function`. The only
thing that changes now is *how* we call our method. First, we don't need a `BattleManager`
object at all. Instead, just say `BattleManager::getAllBattleTypesWithDescription()`.

Ok, try it out! It works!

## When to use Static versus Non-Static

So look, this static versus non-static stuff can be tough. And in a lot of other
tutorials, you'll see this taught in reverse: they'll show you static stuff first,
because it's a little easier. *Then* they'll teach non-static properties and methods.

But guess what: that's not how *good* programmers code in the real world: they make
most things *non-static*. And to start, I want you guys to also make everything not
static. Then, as you get more comfortable, you will start to see different situations
where it's okay to make some things static. It's actually much easier to change things
from `non-static` to `static` than the other way around. And when you make things
non-static, it forces you to build better code. And isn't that why we're here?
