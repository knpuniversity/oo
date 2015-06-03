# Service Classes

Well hey! Welcome back! It's time to put our new object-oriented skills
into practice. We're working on the same out of this world project: it has 
ships, you choose them, then they engage in epic battle!

In an editor, far far away, you'll see a simple application that runs this:
`index.php` is the homepage and `battle.php` does the magic and shows the
results. Last time, we created a single class called `Ship`, which describes
all its properties - it's like a container for one ship's details:

[[[ code('7074e3820c') ]]]

We used this to replace these big associative arrays. Now we deal with cute
`Ship` objects:

[[[ code('d3ead7ddd4') ]]]

## Remove all the Flat Functions!

Having a huge list of flat functions in `functions.php` is not a good recipe
for staying organized. But in just a few minutes, we'll use some new classes
to give our app a whole new level of sophistication. We'll get rid of `battle()`
first.

Look at `Ship`: this is a class that basically just holds data - some people
call that "state", but I'll say "data" - and I'm talking about the values
on a `Ship` object's properties. So a `Ship` object holds data, but it doesn't
really do any work. Sure, it has some methods on it, but these just return
that data, after doing some small logic at best.

Reason #1 for creating a class is this: we need some organized unit to hold
data.

But there's a second big reason to create a class: because you need to do
some work. For example, in `functions.php`, the `battle()` function *does*
work: we give it 2 Ships, it does some calculations, executes logic to see
how different strengths affect each other and ultimately returns the result
of that work.

And we're all familiar with creating functions like this. And here's the 
secret for OO: whenever you get the urge to create a flat function
like `battle()`, don't. Instead, create a class and with a method inside
of it.

## Create the BattleManager Service Class

Let's do this! Since this function is all about battling, let's create a
new class called `BattleManager`:

[[[ code('d23354c844') ]]]

Be as creative as you want with naming: I want to describe that methods in
this class will do things related to battling.

Go copy and remove the flat `battle()` function: paste it into `BattleManager`.
Put `public` in front of `function`. Remember, `public` means that code
*outside* of this class will be able to call this:

[[[ code('ef5f4426c3') ]]]

And yes, you don't *have* to add `public`: functions default to `public`
if you say nothing, but let's keep things clear!

That's all you need to change: functions work the same inside or
outside of a class: they have arguments, they return stuff.

But we do need to change code where we call this function - in `battle.php`.
So how can we call this? Well, when we want to call a method on `Ship`, we
need to have a `Ship` object first. The same is true here: we need a `BattleManager`
object first. Start with a new variable called `$battleManager` and create
a new `BattleManager` object:

[[[ code('eb2307e968') ]]]

And now say `$battleManager`, the arrow, then `battle()`:

[[[ code('9e12ab8acc') ]]]

Let's give this a shot! Refresh `battle.php`. Oh no! Class `BattleManager`
not found! Epic fail!

Not really - at the top of `functions.php`, we have access to the `Ship`
class because we're requiring it. Do the same for `BattleManager`:

[[[ code('71fbe8f69d') ]]]

There *is* a way where you can reference classes like `BattleManager` *without*
needing to worry about the require statements. It's called autoloading, it's
really common, and you'll learn how to master it in a future episode. But
until then: if you have a class, `require` it.

Go back and refresh!

Cool - totally working.

Now we have 2 reasons to create a class. First, if you have some data - like
properties that describe a ship, creating a class for that is nice. You'll
create a `Ship` object whenever you have a set of that data. In `get_ships()`,
we create 4 `Ship` objects. These types of classes are sometimes called models,
because they model something, like a ship.

Second, if you need to make a function that does some work: create a class
and put a method in it, like `BattleManager`. Or, you may put multiple methods
inside one class - as long as they are all thematically similar.

You'll create one of these objects - like `BattleManager` - just one time,
before you need to call a method on it. These are sometimes called service
classes, because they perform work or service. Organizing your code to use
service classes can be tricky, but we'll learn all about that.
