# Handling the Object Id

Ships are loading dynamically, buuuuuut, I've got some bad news: we broke
our app. Start a battle - select the Jedi Starfighter as one of the ships 
and engage.

Huh, so instead of the results, we see:

    Don't forget to select some ships to battle!

Pretty sure we selected a ship... But the URL has a `?error=missing_data` part, 
`index.php` is reading this. It all comes from `battle.php` and it happens 
if we POST here, but we are missing `ship1_name` or `ship2_name`. In other words, 
if we forget to select a ship. But we *did* select a ship! Somehow, these select 
menus are broken. Check out the code: we're looping over `$ships` and using `$key` 
as the option value:

[[[ code('bb5a5ddcc3') ]]]

In `getShips()`, the key *was* a nice, unique string. But now it's just the
auto-increment index. The page fails because the 0 index looks like an empty
string in `battle.php`.

## Adding a Ship id Property

We *still* need something unique so that we can tell `battle.php` exactly
which ships are fighting. Fortunately, the `ship` table has exactly that:
an auto-incrementing primary key `id` column. If we use this as the option value,
we can query for the ships using that in `battle.php`. Blast off! I mean,
we should totally do that.

In `ShipLoader`, we could put the `id` as the key of the array. But instead,
since `id` *is* a column on the `ship` table, why not also make it a property
on the `Ship` class? Open up `Ship` and add a new `private $id`:

[[[ code('31c33764f8') ]]]

And at the bottom, right click, then make the getter and setter for the `id` 
property. Update the PHPDoc to show that `$id` is an integer. Optional, but nice:

[[[ code('4a3960f847') ]]]

Now when we get our `Ship` objects, we need to call `setId()` to populate
that property: `$ship->setId()` and `$shipData['id']`

[[[ code('f682a4fda9') ]]]

Head over to `index.php` to use the fancy new property. Remove the `$key`
in the `foreach` - no need for that. And instead of the key, print `$ship->getId()`.
Also change the `select` name to be `ship1_id` so we don't get confused about
*what* this value is:

[[[ code('4c2c3787ec') ]]]

Make the same changes below: update the select name, remove `$key` from the
loop, and finish with `$ship->getId()`:

[[[ code('13f5e3fd7b') ]]]

Ok, before we touch battle, try this out. No errors! And the select items
have values 1, 2, 3 and 4 - the auto-increment ids in the database. Success!

## Querying for One Ship

We've renamed the `select` fields *and* we're sending a database id. Let's
update `battle.php` for this. First, we need to change the `$_POST` keys:
look for `ship1_id` and `ship2_id`. Update the variables names too - `$ship1Id`
and `$ship2Id`. That'll help us not get confused. Update the variables in
the first `if` statement

[[[ code('0bc7d69511') ]]]

Before, we got *all* the `$ships` then used the array key to find the right
ones. That won't work anymore - the key is just an index, but we have the
id from the database.

Instead, we can use that id to query for a single ship's data. Where
should that logic live? In `ShipLoader`! It's *only* job is to query for
ship information, so it's perfect. 

Create a new public function `findOneById()` with an `$id` argument. Copy
*all* the query logic from `queryForShips()` and put it here. For now don't
worry about all this ugly code duplication. Update the query to be
`SELECT * FROM ship WHERE id = :id` and pass that value to `execute()` with
an array of `id` to `$id`:

[[[ code('364ba02aa6') ]]]

If this looks weird to you - it's a prepared statement. It runs a normal query,
but prevents SQL injection attacks. Change the variable below to be `$shipArray`
and change `fetchAll()` to just `fetch()` to return the *one* row. Dump this
at the bottom:

[[[ code('e223b5d8a7') ]]]

Ok, back to `battle.php`! Let's use this. Now, `$ship1 = $shipLoader->findOneById($ship1Id)`.
And `$ship2 = $shipLoader->findOneById($ship2Id)`. And I need to move this
code further up *above* the `bad_ships` error message. We'll use it in a second:

[[[ code('3e1fbbca2c') ]]]

Try it! Fight some Starfighters against a Cloakshape Fighter. There's the
dump for just *one* row! Sweet, let's finish this!

## Going from Array to Ship Object

The last step is to take this array and turn it into a `Ship` object. And
good news! We've already done this in `getShips()`! And instead of repeating
ourselves, this is another perfect spot for a `private function`. Create
one called `createShipFromData` with an array `$shipData` argument:

[[[ code('3e606e2bf8') ]]]

Copy all the `new Ship()` code and paste it here. Return the `$ship` variable:

[[[ code('de372be605') ]]]

Now, anyone inside `ShipLoader` can call this, pass an array from the database,
and get back a fancy new `Ship` object.

Back in `getShips()`, remove all that code and just use `$this->createShipFromData()`.
Do the same thing in `findOneById()`:

[[[ code('8e93e8a243') ]]]

In `battle.php`, `$ship1` and `$ship2` *should* now be `Ship` objects. The
next if statement is a way to make sure that *valid* ship ids were passed:
maybe someone is messing with our form! With these tough ships in my database
I should hope not. 

I still want this check, so back in `ShipLoader`, add one more thing. If
the `id` is invalid - like 10 or the word "pirate ship" - then `$shipArray`
will be `null`. So, `if (!$shipArray)` then just `return null`:

[[[ code('2256a8b294') ]]]

The method now returns a `Ship` object *or* null. Back in `battle.php`, update
the if to say if `!$ship1 || !$ship2`:

[[[ code('6923a8b5a8') ]]]

And that should do it!

Go back and load the homepage fresh. And start a battle. When we submit,
we'll be POST'ing these 2 ids to `battle.php`. And it works!

Thanks to `ShipLoader`, everyone is talking to the database, but nobody has
to really worry about this.

## PHPDoc for Autocomplete!

Let's fix one little thing that's bothering me. In `index.php`, we call
`getShips()`. But when we loop over `$ships`, PhpStorm acts like all of the
methods on the `Ship` object don't exist: `getName` not found in class.

If you look above `getShips()`, there's *no* PHP documentation. And so PhpStorm
has *no* idea what this function returns. To fix that, add the `/**` above
it and hit enter to generate some basic docs. Now it says `@return array`.
That's true, but it doesn't tell it what's *inside* the array. Change it
to `@return Ship[]`:

[[[ code('95bb19ccee') ]]]

This says: "I return an array of Ship objects". And when we loop over something
returned by `getShips()`, we get happy code completion. Do the same thing
above `findOneById()` - it returns just *one* `Ship` or null:

[[[ code('3f815a1be4') ]]]
