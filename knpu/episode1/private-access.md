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

