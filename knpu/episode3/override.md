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
throw in our normal ship line, which represents the Empire ship. 
