# Abstract Ship

There is one more thing that is special about the Rebel Ships. Since, they're
the good guys we're going to give them some extra Jedi power. 

Inside of `Ship` we have a `jediFactor` which is a value that is set from the
database and a `getJediFactor` function. In the `BattleManager` this is used to 
figure out if some super awesome Jedi powers are used during the battle. 

For Rebel Ships, the Jedi Powers work differently than Empire ships. They always
have at least some Jedi Power, sometimes there's a lot and sometimes it's lower,
depending on what side of the bed they woke up on that day. So, instead of making 
this a dynamic value that we set in the datbase let's create a `public function
getJediFactor` that returns the `rand` function with levels between 10 and 30. 
Setting it up like this overrides the function in the `Ship` parent class. 

Back in the browswer, when we refresh we can see the Jedi Factor keeps changing on
the first two Rebel ships only. 

Back in PhpStorm, when we look at this function now, `Ship` has a Jedi Factor property
but `RebelShip` doesn't need that at all. But since `RebelShip` is extending `Ship` it is
still inheriting that property. While this doesn't hurt anything it is a bit weird to have
this extra property on our class that we aren't using at all. And this is also true for
the `isFunctional`. In `RebelShip` it's always true, but in `Ship` it reads from an `underRepair`
property, which is not something that we need in `RebelShip`. The point being, `Ship` comes with
extra stuff that we aren't using in `RebelShip`. 

These classes are like blueprints

