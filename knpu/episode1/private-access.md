Let me show you a problem with our app, there's nothing stopping me from going
in and setting the strength to something like Jar Jar Binks. Clearly this value
makes absolutely no sense at all for many reasons. 

Sure enough, when we refresh Jar Jar Binks prints out as the strength in the select
menu. The battle class lets us give this really bad data. If we tried to battle, this
would probably break our app since you can't compare a strength of 10 to Jar Jar Binks
mathematically. But if you disagree, I would love to see your math in the comments.

To fix this, I'll get to show you another strength of classes. So far everything has
been `public`. Public name, weapon power and so on but I haven't told you what that means.

There's actually three different words that can go here: `public`, `private` and `protected`
but we'll only worry about the first two for now. As soon as you make a property `private`
it can't be accessed from outside of the class. I'll show you what I mean by this.

Now that it's marked as `private` my editor is highlighting strength saying, "No no no,
you can't access strength anymore." So from outside of the class it's illegal to access
a private property.

And sure enough, when I refresh it says, "Fatal error: Cannot access private property".

This is called a visibility modifier. Once you make something `private` if you want 
someone from the outside to be able to interact with that property you'll need to add
`public` functions to be able to do that. In this case down here, we can create what's
called a `setter`. `public function setStrength($strength)` it will take an argument
called strength, which will be a number. And then we'll set it on that property. You
see that this does not highlight red, so a private property can still be accessed from
within a class using the magic `$this` keyword. It just can't be accessed outside of the 
class.

Here, instead of accessing the strength property directly, we can access the `setStrength`
method. 

When we refresh, it gets further! It gets past that setter and now we're down to line 71.
We're still accessing the strength property, so let's fix that right here. Since we can't
reference that anymore we need to go in and make a public function `getStrength` and it
will go grab the value from that private property and return it to us.

In `index` we can say `getStrength` and that should take care of the problem. Head back
and refresh and it works! Alright!

The reason we did this, is that when you have a public property there's no way to control
who sets it from the outside. Anyone could have set the strength and they could have set
it to any crazy string, negative number or something else that doesn't make sense and we
don't have any control over that. As soon as you make it private it means that outsiders
are going to have to call public methods, and this gives us a cool opportunity to run
a check inside of here to say, "Hey! Is the strength a number? If not, let's throw an 
error." 

In `setStrength` we'll put in an if statement with the is numeric function, and if it's
not numeric then we're going to throw a new exception with a helpful message. In case you 
aren't familiar with exceptions, they're a special internal object to php. It stops the 
flow and shows an error. 

Now when we refresh we get this nice helpful error. This message is for us the developer.
Instead of the application running and tripping up later when we accidentaly put in a 
bad strength we are notified immediately. 

It even tells us that the error happened on ship line 52 and we called the method on
functions line 13. So let's go back into functions line 13 and of course there it is.
We'll change that back to 30 and when we refresh life is good again. 

This idea of making your properties private and then adding getters and setters is 
really common. Even if you don't need the control like this now you might in the future.
If you're already forcing outsiders to call your setter methods and you realize later that
you need to do some sort of check you have the opportunity to do that by modifying your
method. 

A really common thing to do is to always make your properties private. So I'll update
JediFactor, weaponPower and name. The downside of this is that we do want to get in and
set all of these so we'll need a `getName`, `setName`, `getWeaponPower`, `setWeaponPower`
`getJediFactor`, and a `setJediFactor`. That can be a lot to write those methods inside of
here. PHP doesn't give us a way to get around this, so we do need to write those. A lot of
editors allow you to generate these, which is nice. In PHPStorm, go to code generate you 
can pick Getters and Setters and select the weaponPower and jediFactor fields. Name isn't 
in this list is because we already have a getName. I'll go back to code generate again and 
pick just setter this time and it recognizes that the name doesn't have a setter.

Now we have getters and setters on all of these properties. And by the way the name
of this doesn't matter, we could get creative and call this `setWeaponPowerFooBar`, but in
your project try to be clear and concise.

Now that we've made everything private and we have these getters and setters we need to
use those everywhere instead of accessing the properties directly. Let's chance this to
`setName`, this to `setWeaponPower`, and `setJediFactor`. Maybe this feels like extra work
right now, but if we had made it private in the beginning then we wouldn't have to go back
and change them now. Which is what I recommend that you do. 

In `index.php` we have the same thing, we need to call `getWeaponPower` and `getJediFactor`.
We're already calling `getStrength` and down here we're calling the public function
`getNameAndSpecs`.

So let's try that out and see if we missed anything. Refresh and everything looks really 
good and even the select menu shows up perfect. We're all set!

we now have all these wonderful hooks so that if anyone ever needs to get the weaponPower
or set the jediFactor we can do something before returning it. For example, in `getName`
you can actually use a strtoupper so whenever someone calls this we'll return the uppercase
version. As cool as that is, I'll just undo it for now.

With all these private properties, getters and setters our Ship class is looking fit for
action. 

Back in `functions.php` we used to have these 3 other ships. Let's make object representations
of those. We'll say `$ship2 = new Ship()`




