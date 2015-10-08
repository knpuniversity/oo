# Interfaces

Notice, `AbstractShipStorage` unlike `AbstractShip`, doesn't actually have any 
logic in it:

[[[ code('ac1e62b667') ]]]

All it does is have a contract that guarantees anything that extends this has these two
functions. It turns out that when you have an abstract class like this that only contains
abstract functions and no real code, well it's the perfect opportunity to use an Interface. 

An interface works just like an abstract class and here's how it looks. To start,
we need to rename our class to `ShipStorageInterface` since this more closely matches
what it is. And instead of `abstract class` it's now labeled as an `interface`:

[[[ code('b28f1fc946') ]]]

Get it?

As soon as you do that you no longer need `abstract` in front of all the functions,
but these work the same:

[[[ code('14e2bf45e6') ]]]

On the `AbstractShipStorage` file in the tree, go to "Refactor" and click to "Rename"
our file to `ShipStorageInterface`. I really like the consistency. And of course update
our require line for this file in `bootstrap.php`:

[[[ code('1552f24119') ]]]

## Implment an Interface

Stepping back and looking at `ShipStorageInterface`. I want you to think of this as acting just like
an abstract class with two functions that need to be filled in. An important difference is that you
don't extend interfaces. Instead, we'll use a new keyword called `implements` and our updated class name
`ShipStorageInterface`:

[[[ code('f085b626ba') ]]]

This new line says that the `JsonFileShipStorage` must include the functions inside of `ShipStorageInterface`.  

If I deleted `fetchAllShipsData()` you can see that immediately PhpStorm is telling me:

> Hey buddy, you need to implement `fetchAllShipsData()`.

So I'll comply and undelete that.

Update `PdoShipStorage` to `implement ShipStorageInterface`:

[[[ code('9cf63eab71') ]]]

Time to head over to `ShipLoader` and change the `AbstractShipStorage` type hint to `ShipStorageInterface`
which is our way of saying that we don't care what class is passed here as long as it has
the two methods that are in `ShipStorageInterface`:

[[[ code('ad3ea5be8e') ]]]

That's the only thing we care about. Well, that and getting to dinner on time.

Over in the `Container` we can also update the `@return` statement. It doesn't affect
anything really, but it's a good practice to keep it updated. Back to the browser
and refresh! Everything still works perfectly.

Interfaces are just like abstract classes that don't have any functionality, they only contain
abstract functions. If you try to add a real function inside of an interface you can see that
PhpStorm highlights it with the message:

> Interface method can't have body.

And it will freak out when we refresh. 

## What's so Great about an Interface?

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

## Interfaces Document what you need to do

This is also our opportunity to add really good documentation on these. We can label this one as an
integer that should return an array of data. You could even go further and say "Returns an array of ship arrays,
with keys id, name, weaponPower, defense.":

[[[ code('83d4aa46d4') ]]]

Adding as many details as possible here is good, that way if someone implements this interface later
they'll know exactly what to put in their classes. 

## Interfaces in third-party Libraries

One last note about interfaces, they are a bit more advanced. It's not that they are difficult, but in your
code you may not find many reasons to create these. How often is it that you need to make a class
like `ShipLoader` and make it so flexible to work with a PDO ship storage or a Json file ship storage?
In most apps you know which one way you are loading data. So it's actually ok to hardcode the implementation
here with a concrete class like `PdoShipStorage`. 

If you're creating a reusable library that you are going to share with the world then you will need
a lot of flexibility and interfaces would be a good thing to use. 

You may not create very many interfaces, but there is a very good chance that you will use a lot of 
them. For example, you might want to use a third party library in your project and their documentation
will say:

> "If you want to create a custom ship storage object, then you will need to
> implement this interface that comes with the library."

So you will create your own custom class, implement the library's interface which
then tells you which methods to fill in.

Understanding interfaces is really important because you will probably be implementing a lot of them. 

Alright, that's it and I hope you find abstract classes, interfaces and inheritance as cool as I do!

See ya next time!
