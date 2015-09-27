# Protected Visibility

Let's keep making our Rebel ships work a bit differently than the Empire's.
In this dropdown you can see a short summary of each ship that is currently
functional. It shows their name, weapon power, jedi power and strength which
all comes from the `getNameAndSpecs` function. But I would like a way to tell 
which ships in this list align with the rebels, so let's add that word in 
parenthesis at the end.

As usual to do that, we'll override this in `RebelShip`. Copy the `getNameAndSpecs`
function and paste it over here. And then just add '(rebel)' at the end:

[[[ code('7db3c66c91') ]]]

Now you may be thinking "guys, that's some serious code duplication...". Well you're
absolutely right, and we'll get to fixing that!

For now what we've got is pretty straightforward, so let's refresh and... oh,
check out our dropdown. We've got an `Undefinded property RebelShip::$name` error.

## You can't access private things in sub-classes

Back in PhpStorm, you can see `$this->name` is highlighted with an error message of
'Member has private access'. Interesting. So far, I've told you that since `RebelShip`
extends `Ship` it has access to everything inside of it like the properties and methods
as if they also exist inside of `RebelShip`. However, this error really does seem to be
saying something different than that. 

We can see that in `Ship` there is a name property so why isn't this working? The answer
has to do with this word `private` in front of `$name`:

[[[ code('36707e684f') ]]]

All functions and properties so far are either `private` or `public`. If a function or a property
is `private` it means you can only access it from within the ship class:

[[[ code('d7ca235b4a') ]]]

Like here where we say `$this->name`.
As we can see here, `private` functions and properties can't be accessed inside of subclasses. 
So only things inside of the `Ship` class can access this `private $name;` property.  

I always recommend that you make things `private` until you need to access them from outside
of the class you're working in. 

## Introducing: protected

Now, there is another designation between `private` and `public` which is called `protected`. 
`Protected` works exactly like `private` except that subclasses can access it, so when we change
it here the error goes away:

[[[ code('ed86e1cee1') ]]]

Cool! Let's do a temporary fix for the error we're getting by making
all of these things `protected`:

[[[ code('168b3c39f4') ]]]

Everything in our `RebelShip` file looks happy again so let's refresh.
Ah ha! Our dropdown is back in business and showing the rebel designation. 

I just mentioned that our fix was 'temporary' because I don't actually want to make these `protected`
I really prefer to keep things `private` whenever possible. So even though these properties are
`private` we have `public` functions that access them like `getName`, `getStrength`, `getWeaponPower`:

[[[ code('83731d139f') ]]]

Which means that in the subclass we can just use these instead of the properties. Let's go ahead
and just change those in `RebelShip`. And to save me some effort I'll copy and paste these from
the if to the else:

[[[ code('ebf19037ff') ]]]

I like this, I mean I already have these `public` functions so why not use them? It allows me to 
keep these properties `private` which is looking ahead a little bit, but the more things you
have marked as `private` the easier it's going to be to maintain and update your code later.

Back to the browser and refresh, and things still work! 

## private and protected Methods

Let's temporarily add a new `private` function to `Ship` called `getSecretDoorCodeToTheDeathstar()`.
Since only Empire ships should have access to this you can see why setting it as `private` makes sense.
And let's return the secret code 'Ra1nb0ws':

[[[ code('d3f3bf13b0') ]]]

Over in `RebelShip` I should not be able to access this new function since we set it to `private`:

[[[ code('57d574ed0f') ]]]

We see the 'Member has private access' error so when we refresh we can check the dropdown to confirm
that things aren't working. `Fatal error: Call to private method Ship::getSecretDoorCodeToTheDeathstar()`
and we need to view the source to see the full error message. 

But, if we go back and change that function to `protected`, our error is gone, the rebels have access
to the secret door code and life is good:

[[[ code('cfc501a273') ]]]

Remove all that nonsense. The moral of the story is this, make things `private` at first, `proctected` 
once you need to access them in a subclass. And finally `public` when you need to use it outside of its class
and subclass. 
