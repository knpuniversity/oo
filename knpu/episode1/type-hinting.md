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
of object ship1 was and offered me autocomplete. So getStrength, it knows all the methods
that are on that object. 

