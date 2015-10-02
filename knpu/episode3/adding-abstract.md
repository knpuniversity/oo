# Abstract Classes

Since everything seems to be working on our site, let's start a battle!
Four Jedi Starfighters against three Super Star Destroyers. Engage.

Ahh an error!
 
> Argument 1 passed to BattleManager::battle() must be an instance of Ship, instance of RebelShip given

And this is apparently happening on `battle` line 32:

[[[ code('57b0e805a3') ]]]

And `BattleManager` line 10:

[[[ code('cd294c4edc') ]]]

Back to our IDE and open up `battle.php`. 

## Trouble With Type Hints

Down on line 32, what we see is that `$ship1` is actually a `RebelShip`
object, which makes sense since one of the ships I selected was a Rebel. But
it expected that to be a normal `Ship` class. Over in `BattleManager` look
at the battle function to see the problem! We type hinted our arguments with the
`Ship` class:

[[[ code('49a9bcd3f8') ]]]

Which tells PHP to only allow `Ship` classes or subclasses to be passed here.

The issue is that `RebelShip` is no longer a subclass of `Ship` and so now we have this
error. The good news, the fix is simple! We don't care if we get a ship object in battle anymore.
What we actually care about is that we get an `AbstractShip` object or any of its subclasses
which we know includes `Ship` and `RebelShip`:

[[[ code('0b4a317769') ]]]

Refresh and give this another try, we get the exact same error. Let's see we're being
notified about something in `BattleManager` on line 58. Scroll down and look there:

[[[ code('af80ad544b') ]]]
 
Ah yes, it's this type hinting right here. This function is called up here, and we pass it the
ship object, so let's update this one to be expecting an `AbstractShip`:

[[[ code('4f0be4616c') ]]]

Let's try this again! Cool, one more error! This one is having issues with `BattleResult::__construct()`.
In our IDE we can see that when we instantiate the `BattleResult` object we pass it the `$winningShip` and
the `$losingShip`:

[[[ code('3595ea08c9') ]]]

Over in `BattleResult` we see that these are also typehinted with `Ship`. Update those two:

[[[ code('d6a843d6c5') ]]]
 
This is nice, our code is a lot more flexible now. Before, it had to be a `Ship` instance. Now
we don't care what class you have as long as it extends `AbstractShip`. 

Refresh again! Awesome, battling is back on.

## What Methods are *really* on AbstractShip?

Now we have a few minor, but interesting, problems. First, in `AbstractShip` head down to
`getNameAndSpecs()` and we see that `getJediFactor()` is highlighted with an error that says
"Method `getJediFactor()` not found in class AbstractShip". Now, this is working because we do have
a `getJediFactor()` method in `Ship` and `RebelShip`. When we call `getNameAndSpecs()` it's able to 
call `getJediFactor()`. But this should look a little fishy to you. There is no `getJediFactor()` 
function inside of `AbstractShip`, so just looking at this class you should feel suspicious and 
question whether or not this works. 

Here's what's going on, we have an implied rule that says, "Yo, every class that extends `AbstractShip`
must have a `getJediFactor()` function." If it doesn't everything is going to break when we call this
function with a 'method not found' error. We aren't enforcing this rule. So we could easily create a new 
ship class, extend `AbstractShip`, and forget to add a `getJediFactor()` function. Our application would 
break and no battles would be happening. Sad times. 

## Abstract Functions to the Rescue

You're in luck, there's a feature called Abstract Classes that can handle this issue for us. I'll scroll
up, but really the position of this doesn't matter. Add a new `abstract public function getJediFactor();`:

[[[ code('22bc59e670') ]]]

You may notice there are two different things about this. One is the word `abstract` before `public function`
and the other is that I just have a semicolon on the end, I didn't actually make a function. The best part, 
this line doesn't add any functionality to our app, but it does force any class that extends this
to have this method. 

For example, if `RebelShip` didn't have this `getJediFactor()` method, then when we refresh the browser
we'll get a huge error that says: "Hey! RebelShip must have a getJediFactor function!". This is because 
it has been defined as an abstract function inside of the parent class.

Up until now we could have instantiated an abstract ship directly with `new AbstractShip()` we didn't
actually want to but it was possible. But, once you have an abstract function in here, that is no longer 
an option, it's only purpose then becomes to be a blueprint for other classes to extend.

## Marking a Class as Abstract

Up here at the top of the file you can see that there is an error highlight with a message that says
"Class must be declared abstract or implement method `getJediFactor()`". Once your class has an
abstract function you need to add the `abstract` keyword in front of it, which enforces the rule that
you can't say `new AbstractShip()`:

[[[ code('3b2ba9d405') ]]]

Now when we scroll down, we can see that `getJediFactor()` isn't highlighted anymore since we know that
inside `AbstractShip` any subclasses will be forced to have that. Back to the browser and refresh! 
Everything still works just fine.

Related to this, there is one more little thing we need to fix up. Start in `ShipLoader`, notice that our
`getShips()` and `findOneById()` functions still have PHPDoc above them that say they return a ship object.
That's not the biggest deal, but it would be more accurate if it said `AbstractShip` - because this actually
returns a mixture of `RebelShip` and `Ship` objects:

[[[ code('99148c2fa8') ]]]

Now check this out, inside of `index.php`, remember this `$ships` variable we get by calling
that `getShips()` function?

[[[ code('84b483c9ce') ]]]

So that returns an array of `AbstractShip` objects. When we loop over it, the `isFunctional()` and 
the `getType()` functions aren't found:

[[[ code('b2ad47484e') ]]]

The message here says "Method `getType()` not found in class `AbstractShip`".
This is just like the `getJediFactor()` problem we just fixed. We don't have a `getType()` function inside of here.
Both of our subclasses do, which is why our app still works, but technically we're not enforcing that. Any new
subclasses to `AbstractShip` could easily end up missing these functions which would again stop all the battles.

What we need is another abstract public function for `getType()` and `isFunctional()`:

[[[ code('8add72d8cd') ]]]

This doesn't change anything in our application, it just forces our subclasses to have those methods.
And now `index.php` is really happy again!

That's the power of abstract classes, you can have a whole bunch of shared logic in there, but if there are a
couple of pieces that you can't fill in in your abstract class because they are specific to your subclasses,
no problem! Just put them in there as abstract functions and your subclasses will be forced to have those.
 
In my example these are abstract public functions but you could also have abstract protected functions as well.
Which one you use just depends on your use case. It's a very powerful feature of object oriented code.
