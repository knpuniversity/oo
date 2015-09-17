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

In `Container` let's give this a try. 
