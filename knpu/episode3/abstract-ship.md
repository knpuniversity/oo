# Creating an Abstract Ship

There is one more thing that is special about the Rebel Ships. Since, they're
the good guys we're going to give them some extra Jedi power. 

Inside of `Ship` we have a `jediFactor` which is a value that is set from the
database and a `getJediFactor` function. In the `BattleManager` this is used to 
figure out if some super awesome Jedi powers are used during the battle. 

For Rebel Ships, the Jedi Powers work differently than Empire ships. They always
have at least some Jedi Power, sometimes there's a lot and sometimes it's lower,
depending on what side of the galaxy they woke up on that day. So, instead of making 
this a dynamic value that we set in the datbase let's create a `public function getJediFactor` 
that returns the `rand` function with levels between 10 and 30. Setting it up like 
this overrides the function in the `Ship` parent class. 

Back in the browser, when we refresh we can see the Jedi Factor keeps changing on
the first two Rebel ships only. 

Over in PhpStorm, when we look at this function now, `Ship` has a Jedi Factor property
but `RebelShip` doesn't need that at all. Since `RebelShip` is extending `Ship` it is
still inheriting that property. While this doesn't hurt anything it is a bit weird to have
this extra property on our class that we aren't using at all. And this is also true for
the `isFunctional` method. In `RebelShip` it's always true, but in `Ship` it reads from an `underRepair`
property, and again that's just not needed in `RebelShip`. The point being, `Ship` comes with
extra stuff that we are inheriting but not using in `RebelShip`. 

These classes are like blueprints, so maybe, instead of having `RebelShip` extend `Ship` and
inherit all these things it won't use, we should have a third class that would hold the properties
and methods that actually overlap between the two called `AbstractShip`. From here, `Ship` and `RebelShip`
would both extend `AbstractShip` to get access to those common things. 

This is a way of changing the class heirachy so that each class has only what it actually needs.

Let's start this! Create a new PHP Class called `AbstractShip`, since it is the most abstract idea of
a ship in our project. To start, I'm going to copy everything out of the `Ship` class and paste it
into `AbstractShip`. I know this looks like where we just were, but trust me we're going somewhere with
this.

Now, let's write `Ship extends AbstractShip` and do the same thing in `RebelShip` changing it from
`Ship` to `AbstractShip`. Then in `Bootstrap` add our require line for our new class. Perfecto!

After just that change, refresh the browser and see what's happening. Hey nothing is broken,
which makes sense since nothing has really changed in our code's functionality -- yet. 

Let's trim down `AsbstractShip` to only the items that are truly shared between our two ships. 

First, `jediFactor` is specific to `Ship` so let's move it over there. And then we'll update the references
to it in `AbstractShip` to what the two classes share, which is a `getJediFactor` function. So let's copy and
paste that function into `Ship`. `RebelShip` already has one so that class is good to go already. Now in
`AbstractShip` the `getJediFactor` function will either call the version of the function in `Ship` or `RebelShip`
depending on what is being loaded. There are a few other things I want to share with you about this, but
we'll get to those later.

Now let's move `setJediFactor` from `AsbtractShip` into `Ship` and that should do it! Now, `Ship` still has
all the functioanlity that it had before, it extends `AbstractShip`, and only contains it's unique code. 
And `RebelShip` no longer inherits the `jediFactor` property and anything that works with it. Now each file
is simpler, and only has the code that it actually needs. Back to the browser to test that everything still
works. Oh look an error! `Call to undefined method RebelShip::setJediFactor() on ShipLoader line 55`. Let's
check that out. 

Ah, it's because down here when we create a ship object from the database, we always call `setJediFactor`
on it, and that doesn't make sense anymore. So we'll move this up and only call it for the `Ship` class.

Refresh again, no error, perfect!

Back to `AbstractShip`, we have the `underRepair` property which is only used by `Ship`, so let's move that over.
And, let's also move over the `isFunctional` method from `AbstractShip` as well, since `RebelShip` has it's own
`isFunctional` method already. Finally, the last place that this is used is in the construct function. The random
number for under repair is set here, so just remove that one piece but leave the `$this->name = $name;` where it is
since it is shared by both types of ships. In the `Ship` class we'll override the construct function, I'll keep
the same argument. Using our trick from earlier I'll call the `parent::__construct($name);` and then paste in
the under repair calculation line. 

The last thing that's extra right now in the `AbstractShip` class is the `getType` method. Both ships need a 
`getType` function, but this one here is specific to the `Ship` class so we'll cut and paste that over.

Back to the browser and refresh, everything looks great. The Rebel Ships aren't breaking and Jedi Factors are 
random, awesome!

This is the same functionality we had a second ago but the `RebelShip` class is a lot simpler. It only inherits
what it actually uses from `AbstractShip`. Which means that our new class truly is the blueprint for the things that
are shared by all the ship classes. `Ship` extends `AbstractShip` as does `RebelShip` and then each add their own
specific code. 

While this isn't a new concept, it is a new way of thinking of how to organize your "class hierarchy".


