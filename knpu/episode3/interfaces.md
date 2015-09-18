# Interfaces

Our goal is to make `ShipLoader` load things from the database or from a JSON file.
In the resources directory I've already created a `JsonFileShipStorage` class. 

Copy that into the service directory and let's take a look inside of here. It has
all of the same methods as `PdoShipStorage`. Except that this loads from a JSON file
instead of querying from a database. Let's try and use this in our project. 

First, head over to `bootstrap` of course and require `JsonFileShipStorage.php`. In
theory since `JsonFileShipStorage` has all the same methods as `PdoShipStorage` we
should be able to pass a `JsonFileShipStorage` object into `ShipLoader` and everything
should just work. We're still calling the same methods like `fetchAllShipsData` and
`fetchSingleShipData` so why should `ShipLoader` care whether this `shipStorage` object
is a `PdoShipStorage` or a `JsonFileShipStorage`. It should only be looking into whether
those two methods exist or not. 

In `Container` let's give this a try. Down in `getShipStorage` instead of creating a 
`PdoShipStorage` let's say, `$this->shipStorage = new JsonFileShipStorage`. And we'll
give it a path to our JSON of `__DIR__./'../../resources/ships.json'`. From this directory
I'm going up a couple of levels, into `resources` and pointing at this `ships.json` file which
holds all of our ship info. 

Just by doing that, when the `ShipLoader` is created it's going to get this json file. 

Back to the browser and refresh. Ok no success yet, but as they say, try try again. Before 
we do that, let's check out this error, "argument 1 passed to ShipLoader::__construct must
be an instance of PdoShipStorage, instance of JsonFileShipStorage given". What's happening
here is that in `ShipLoader` we have this typehint here which says that we only accept
`PdoShipStorage` and our Json file is not an instance of that. 

The easiest way to fix this is to say `extends PdoShipStorage` in our `JsonFileShipStorage`
file. This makes the json file an instance of `PdoShipStorage`. Try refreshing that again. 
Perfect, our site is working again.

But having to put that extends in our JSON file kinda sucks, when we do this we're overriding
every single method and getting some extra stuff that we aren't going to use. 

Instead, you should be thinking, "This is a good spot of Abstract Ship Storage!" And well, I
agree so let's create that. Inside the `Service` directory add a new PHP Class called
`AbstractShipStorage`. The two methods that this is going to need to have are: `fetchSingleShipData`
and `fetchAllShipsData` so I'll copy both of those and paste them over to our new class.

Of course we don't have any body in these methods, so remove that. Now, set this as an `abstract` class.
Also, make both of the functions `abstract` as well. Cool!

Now, `JsonFileShipStorage` can `extend AbstractShipStorage` and the same thing for `PdoShipStorage`. 
With this setup we know that if we have a `AbstractShipStorage` it will definitely have both of those
methods so we can go into the `ShipLoader` and change this type hint to `AbstractShipStorage` because
we don't care which of the two storage classes are actually passed. 

To be very well behaved developers, we'll go into our `Container` and above `getShipStorage` change
the type hint to `AbstractShipStorage`. Not a requirement, but it is a good idea.

Back to our browser and refresh... oh, class `AbstractShipStorage` not found because we forgot to require it
in our `bootstrap` file. We will eventually fix the need to have all of these require statements. 

Refresh again and now it works perfectly. 

We created an `AbstractShipStorage` because it allows us to make our `ShipLoader` more generic. It now
doesn't care which one is passed, as long as it extends `AbstractShipStorage`. 

Notice, `AbstractShipStorage` unlike `AbstractShip` that we created earlier, doesn't actually have any 
logic in it. All it does is have a contract that guarantees anything that extends this has these two
functions. It turns out that when you have an abstract class like this that only contains abstract
functions and no real code, well it's the perfect opportunity to use an Interface. 

An interface works just like an abstract class and here's how it looks. To start, we need to rename
our class to `ShipStorageInterface` since this more closely matches what it is. And instead of
`abstract class` it's now labeled as an `interface`. Get it?

As soon as you do that you no longer need `abstract` in front of all the functions, but these work the same. 
On the `AbstractShipStorage` file in the tree, go to refactor and click to rename our file to `ShipStorageInterface`. 
I really like the consistency. And of course update our require line for this file in `bootstrap.php`. 

Stepping back and looking at `ShipStorageInterface` I want you to think of this as acting just like
an abstract class with two functions that need to be filled in. An important difference is that you
don't extend interfaces. Instead, we'll use a new keyword called `implements` and our updated file name
`ShipStorageInterface`. This new line says that the `JsonFileShipStorage` must include the functions
inside of `ShipStorageInterface`.  

If I deleted `fetchAllShipsData` you can see that immediately PhpStorm is telling me "Hey buddy, 
you need to implement `fetchAllShipsData`" so I'll comply and undelete that. 

Update `PdoShipStorage` to `implement ShipStorageInterface`. Time to head over to `ShipLoader` 
and change the `AbstractShipStorage` type hint to `ShipStorageInterface` which is our way of
saying that we don't care what class is passed here as long as it implements `ShipStorageInterface`. 
And that file only insists that you have these two methods, which then means that `ShipLoader` is
requiring those two methods. 

Over in the `container` we can also update the `@return` statement. It doesn't affect anything really,
but it's a good practice to keep it updated. Back to the browser and refresh! Everything still works
perfectly. 

Interfaces are just like abstract classes that don't have any functionality, they only contain
abstract functions. If you try to add a real function inside of an interface you can see that
PhpStorm highlights it with the message "interface method can't have body" and it will freak out
when we refresh. 

The purpose of an interface is to allow you to make your code very generic since you're not requiring
a concrete class just an interface. Why do interfaces exist? Sheesh you ask a lot of questions!
Well, the answer is that in PHP you can only extend one base class but you can implement many
interfaces. I'm not going to go into detail on `ArrayAccess` interface which comes from the core of PHP
but this is what it looks like to implement multiple interfaces. Allowing multiple interfaces makes
them a bit more flexible than abstract classes.

Another cool thing about interfaces and abstract classes is that they become directions on what all
ship storage objects must look like. So if someone in the future needed to create a new ship storage 
object that loaded things from say XML, all they would need to do is created a class that implements
this interface and boom you're being told exactly what methods that XML ship storage class has to have. 

This is also our opportunity to add really good documentation on these. We can label this one as an
integer that should return an array of data. You could even go further and say "Returns and array of ship arrays,
with keys id, name, weaponPower, defense." Adding as many details as possible here is good, that way if
someone implements this interface later they'll know exactly what to put in their classes. 

One last note about interfaces, they are a bit more advanced. It's not that they are difficult, but in your
code you may not find many reasons to create these. How often is it that you need to make a class
like `ShipLoader` and make it so flexible to work with a PDO ship storage or a Json file ship storage?
In most apps you know which one way you are loading data. So it's actually ok to hardcode the implementation
here with a concrete class like `PdoShipStorage`. 

If you're creating a reusable library that you are going to share with the world then you will need
a lot of flexibility and interfaces would be a good thing to use. 

You may not create very many interfaces, but there is a very good chance that you will use a lot of 
interfaces. For example, you might want to use a third party library in your project and their documentation
will say "If you want to create a custom ship storage object" then you will need to implement this 
interface that comes with the library. So you will create your own custom class, implement the library's
interface which then tells you which methods to fill in. 

Understanding interfaces is really important because you will probably be implementing alot of them. 

Alright, that's it and I hope you find abstract classes, interfaces and inheritance as cool as I do!

See ya next time!

