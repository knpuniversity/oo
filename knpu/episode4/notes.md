## PLAN

- add drop-down for 3 modes of fighting
    - normal
    - no jedi
    - jedi only

- add a new argument to battle() for this type,
    keep everything as strings

- refactor these to constants
    - Show how these are no different than flat constants, but they're attached
        to a class, which sort of gives them a "theme". It could also live on
        any class - it totally doesn't matter.

- use constants in index.php
- add new function to fetch all constant values
- use in index.php and battlemangaer
- Change this to be static: change the usage, and even print all the valid
    weapons at the top of the class. Explain how *some* functions, don't
    have anything to do with an object at all - the possible weapon types
    doesn't differ from one ship to another - it's global. In this case, we
    can use static. Static functions are no different than flat functions,
    we just put them on an object because it gives them a nice place to live
    that's thematically consistent with their information. You should *not*
    default to using static methods (explain why lightly).

- self versus static?

## Namespaces and Autoloading

- add some namespaces to our classes (but don't move them)
    -> we still have require statements
- add a namespace to one, update how it's used (make the namespace random)
- introduce a use statement
    -> yep, that's it
- remove require, everything dies
- add our own simple auto-loader
- boy, this autoloader would be a pain to finish
- update namespace to match dir structure on 2 of them
- finish the rest
- use the Composer autoloader, with PSR-4

## Exceptions & Catching
- show an exception: things go wrong
- catch an \Exception
- catch a special type of \Exception

## __toString
- try to print a ship, fails!
- add __toString
- show a list of __ functions

## ArrayAccess - php standard lib
- use Container as an array
- fix it!
- create a ShipCollection class and return that
    from ShipLoader (but why)
- Add iterator

## Traits
- create a new ship object - BountyHunterShip
    - jediFactor is a property
    - never broken
    - do it without a trait at first
- add a trait for the jediFactor property, getter/setter

## composition (over inheritance)
- pretend PdoShipStorage is a 3rd-party class
- we want to log!
- create a new LoggableShipStorage class
- do composition
- this just works! and you can use it with either real implementation
