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
