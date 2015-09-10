# Override

Let's take out this dummy code and get to the real stuff. Our database
is created via this `init_db` script which you can execute from the 
command line whenever the mood strikes to make sure that your database is
setup correctly. DING!

This creates a table with a `team` column. In here we can see that the first
two team columns are team `rebel` and the second two are team `empire`. Since
these two ships work differently, inside of our `ShipLoader` where we take that
data and turn it into ship objects, I want to create ship objects for the empire
and the rebels. 

So let's do that, `if ($shipData['team'] == 'rebel')` which is the key inside the 
database. Then we'll have `$ship = new RebelShip($shipData['name']);`. Else, we'll
throw in our normal ship line, which represents the Empire ship. Ok, this doesn't
have anything to do with Object Oriented coding, it's just a nice example of a use
case for multiple classes. We have a database table, and you can create different
objects from that table. This is nice because we'll be able to have these two objects
behave differently. 

So far `RebelShip` and `Ship` have all the same stuff except for the one extra method
I have on `RebelShip` that I'm not using yet. 

If we go back and refresh, everything still works perfectly! Now, technically I'm fairly
certain that two of these are `RebelShip` objects and two are `Ship` objects but we can't
really tell right now. Clearly we need to add identifiers so we know who to cheer on.

To do this, start with `public function getType()` to our `Ship` and return a description,
like 'Empire'. Since we added that to `Ship`,  we can call `getType` on both `Ship` and
`RebelShip`.

Now back in `index.php` towards the bottom add a new column for this called `Type` and
`<? php echo $ship->getType(); ?>`. Back to the browser and refresh and everything has 
joined to fight for the Empire! Which makes sense.

Time for the next really powerful thing with inheritance. In addition to adding methods
to a sub class like `RebelShip` 
