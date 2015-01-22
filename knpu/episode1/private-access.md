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
