When we submit the form it goes to `battle.php` and we see this nasty error. It comes
from `functions.php` on line 74 and called on `battle.php` on line 29. Let's start with
`battle.php`, sure enough we can see the problem is with the battle function, let me show
you why.

First, let's dump ship1 and ship2. As a reminder of what's happening here is up top
we call getShips which returns an array of objects then we read the POST data to figure
out which of the ships we want to fight. Then down here we get the ships objects off this
array. So this should dump two objects, and it does, we have the Jedi Starfighter and the
Super Star Destroyer. 

Next, let's look in the battle function which lives in functions.php. Here's the issue
the ship1 and ship2 arguments have "array" in front of them. This tells PHP that this
argument must be an array and if someone passes something other than an array to this 
I want you to throw a huge error. So let's see that error again, it says, "Argument 1
passed to battle() must be of the type array, object given" since we're passing it a ship
object. This is called a type hint and the only purpose of a type hint in PHP is to get 
better errors, it doesn't change the behavior. We can just take the type hint off like 
this and that will fix the error. And down here, knowing that ship1 is actually an object
instead of using the array syntax we can call the getStrength method. Let's go ahead and
dump `$ship1Health` to make sure it's working.

Just by removing the type hint it tells PHP to stop making sure it's an array, just let
whatever type of object in and be ok with it. Refresh, this time it's printing out 60 which 
means it's printing out the ship's mighty strength correctly.

The type hint is a useful thing, not from a functionality standpoint, but for knowing when
you're doing something wrong. Let's go back to `battle.php` and pretend that something went
wrong here by changing our object `$ship1` to the string 'foo'. When we refresh this time we
get this really weird error, "Call to a member function getStrength() on a non-object". You're
going to see this error a lot and it's coming from line 76. It happens whenever you use the 
arrow syntax on something that isn't an object.  It's a fatal error and PHP just dies immediately.
We know because I just passed "foo", that `$ship1` is no longer an object, it's just a string
and when we call this on it everything dies. The issue is that from the error it isnt' exactly
clear where the error is. It's telling us that the problem is on line 76 in `functions.php`, 
and sure that is where the error occurred. But the real problem is in `battle.php` where we
are passing in a bad value to the battle function. 

So in addition to type hinting with the array, when we use objects we can type hint with the 
class name. Which means we can actually type ship here and we can do that here as well. That 
is the exact same thing. It says, "Hey, PHP, if something is passed this argument that's not
a ship object I want you to throw a very clear error." So let's go see this error! Refresh
and there it is. Argument 1 passed to battle() must be an instance of Ship, string given on
line 29 `battle.php`. 

This time it's very clear, it says it should have been a ship object but you're passing a 
string and it points us to the exact right spot. So type hinting is option but it's a really
good idea because it will make your code easier to debug later. It also has a second benefit,
as soon as I type hinted this ship1 variable here, all of a sudden my editor knew what type
of object ship1 was and offered me autocomplete. So `getStrength`, it knows all the methods
that are on that object. 

So now that we know that these are objects, let's fix this method for all the array syntaxes.
Let's see here we have a few more. And then down here, which is called from above we have
one more. And notice that this one is not giving me autocomplete because it's being
type hinted as an array. So this function is called all the way up here, it's passing a
ship1 and ship2, so it's passing a ship object. So let's change that to be a ship instead
of an array. And now we will get that nice autocompletion which will make sure the object is
being passed there. Awesome, this function looks good!

Let's go back and refresh. And of course I get that same error because I forgot to go back 
and put ship1 here. Now let's try that again. We still get an error, but if you look closely 
you'll see that it is happening farther down the page. The battle function is being called 
and it's all working. This new error is from line 61, at this point you can probably even spot
what that is, "Cannot use object of type Ship as an array," that's another syntax thing that
we need to change.

So, let's go down to line 61 and sure enough there it is. We'll call `getName` on our ship1 
and ship2 objects. Now, real quick back up on battle what it returns is this outcome variable
and I'm going to show you what that actually is. So down here let's do a var_dump on `$outcome`,
put a die statement and refresh. 

So the battle function returns an array with three different keys on it: winning_ship which 
is a ship object, losing_ship which is a ship object and whether or not Jedi powers were used 
during that power to have a really awesome comeback win. 

The important part is that winning_ship and losing_ship are ship objects. Let's just remove
this var_dump real quick. Down here when we reference outcome winning_ship we know that this
right here is actually going to be an object. And we want to call `getName();` on it. The same 
thing right here. And then we'll do the same thing here as well. We're convering from that
array syntax to the object syntax. 

Moment of truth, do we have a working battle page? SUCCESS! Super Star Destoyer won. Let's
try it again. We'll throw 10 Jedi Star Ships at our one Super Star Destroyer and it wins again.
Come one Jedi's get it together. If you try enough times the Jedis do come up with a victory.

The key take away here is because we have a ship class it gives us shape and we're starting
to protect our properties so they can't be modified from the outside and then we're exposing
them with these public methods. This is cool because whenever we know we're passing around
a ship object we can type hint it with `Ship` and our editor and PHP knows exactly what type
of object it is and what methods we're going to have on it. We're giving definition to our
data instead of passing around arrays which unknown and probably inconsistent keys. 
 
