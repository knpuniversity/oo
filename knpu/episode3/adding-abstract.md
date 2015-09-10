# Adding Abstract

 Since everything seems to be working on our site, let's start a battle!
 Four Jedi Starfighters against three Super Star Destroyers. Engage.
 
 Ahh an error! `Argument 1 passed to BattleManager::battle() must be an instance
 of Ship, instance of RebelShip given` which it says is happening on `battle`
 line 32 and `BattleManager` line 10. Back to our IDE and open up `battle.php`. 
 
 Down on line 32, what we see is that `$ship1` object is actually a `RebelShip`
 object, which makes sense since one of the ships I selected was a Rebel. But
 it expected that to be a normal `Ship` class. Over in `BattleManager` and look
 at the battle function we see the problem! We type hinted our arguments with the
 `Ship` class which tells PHP to only allow ship classes or subclasses of ship to be
 passed here. 
 
 The issue is that `RebelShip` is no longer a subclass of `Ship` and so now we have this
 error. But good news, the fix is simple! We don't care if we get a ship object in battle anymore.
 What we actually care about is that we get an `AbstractShip` object or any of its subclasses
 which we know includes `Ship` and `RebelShip`. 
