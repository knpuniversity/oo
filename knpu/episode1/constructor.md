Here's the next challenge, sometimes I want my ships to be broken. So when a ship comes in
it might be able to fight or it might be under repair. This is a property on a ship, a ship
could be under repair or not. So I'll add this as a new private property that has a boolean
which can be true or false.

The challenge is that whenever we create our objects inside of `functions.php` I want to
randomly set a ship to be under repair or not under repair and I want it to happen
automatically. So just by creating a ship I want it to internally figure out if it is under 
repair or not. 

This is where the idea of a constructor comes in. Whenever you create an object you can 
actually hook into that process and say, "Hey whenever you create a ship I want to have a
function that is called so I can do some setup on that ship object." The way you do this is
by creating a very special public function inside of your class called _ _ construct. THe magic
here is that name, it must be _ _ construct. And just by having this it should be called
everytime we say `$ship = new ship`. 

Let's try it, refresh! And that's it it's called four times once for each of our ships. And
it's called right when you say new ship, so if I throw in a die statement right after that
we're still going to see one of those called. 

So now we have a really powerful way to set up our data. Internally we can determine whether
or not the ship is under repair. We'll use `$this ->underRepair = mt_rand(1, 100) < 30;` if
the random number is less than 30 then it will be true and if it's anywhere from 31 to
100 it will be false. So it's a 30% chance that we'll be under repair. 

To see this in action, let's cheat real quick and var_dump the ships array. When we refresh
we can see the first two aren't under repair but the third one is. Refresh again and none
are under repair and a third time gives us the first two under repair and the other two are 
battle worthy. So that's working already!

Next, let's go into `index.php` and up top we have our table information, let's include status
which will tell us if our ship is under repair or not. Now so far, we don't have a way to access
that new property. It's private and we don't have a getter or a setter and you don't need to create
these. We don't want a setter because it's being set automatically inside of the class itself. But 
I do want to figure out if this ship is functional or not. So what I'll do is create a new public
function
