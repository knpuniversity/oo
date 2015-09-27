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
throw in our normal ship line, which represents the Empire ship:

[[[ code('3b403bbee6') ]]]

Ok, this doesn't have anything to do with Object Oriented coding, it's just a nice example
of a use case for multiple classes. We have a database table, and you can create different
objects from that table. This is nice because we'll be able to have these two objects
behave differently. 

## Overriding Class Methods

So far `RebelShip` and `Ship` have all the same stuff except for the one extra method
I have on `RebelShip` that I'm not using. 

If we go back and refresh, everything still works perfectly! Now, technically I'm fairly
certain that two of these are `RebelShip` objects and two are `Ship` objects but we can't
really tell right now. Clearly we need to add identifiers so we know who to cheer on.

To do this, start by adding `public function getType()` to our `Ship` and return a description,
like 'Empire':

[[[ code('74ee675fef') ]]]

Since we added that to `Ship`,  we can call `getType` on both `Ship` and
`RebelShip`.

Back in `index.php` towards the bottom add a new column for this called `Type` and
`echo $ship->getType();`:

[[[ code('39cff657e3') ]]]

Back to the browser and refresh. Everything has joined to 
fight for the Empire! Which makes sense. Both ship classes use this same method.

Time for the next really powerful thing with inheritance. In addition to adding methods
to a sub class like `RebelShip` you can override methods. Copy the `getType` from `Ship`
and paste it into `RebelShip` and change what it returns to 'Rebel':

[[[ code('1982da2f87') ]]]

`RebelShip` copies the entire blue print of `Ship` but it can replace any of those
pieces. When we refresh now, we have two 'Rebel' ships in addition to our two 'Empire' ships.
Excellent!

## Overridden Methods are not Called

A key part of this is that the parent `getType` class is never called for all rebel ship
objects it is completely replaced. If I echo 'Parent Function' inside of `getType` in the
`Ship` class and refresh, we see our ugly text echoing for the Empire ships and not the Rebel
ships. This is thanks to our parent function not being called in `RebelShip`. 

On to more methods, another one on `Ship` is `isFunctional` which we setup to have a 30%
chance of a ship being broken, which is what our cute cloud here indicates:

[[[ code('bfd983c7ad') ]]]

But, we all know that the Rebels are really scrappy and they don't have the luxury of letting
their ships get broken. Even if they are kinda broken they still fly and make it work. Which
is just one more reason why the rebels are awesome. 

So I need to set this up so the Rebel ships are never showing as broken which we can do
really easily by overriding `isFunctional` inside of `RebelShip`.  Let's update this to
`return true;` which will never show a rebel ship as broken:

[[[ code('1982da2f87') ]]]

When we refresh now the Rebel ships always have sunshine, and the Empire ships sometimes have adorable clouds. 

By having two classes we are starting to shape the different behaviors and properties of each, 
while still keeping most things in common and not duplicated.

