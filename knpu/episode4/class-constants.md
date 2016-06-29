# The Wonder of Class Constants

Hey friends! I'm so glad you're here for part *4* of "Baking Delicious Chocolate Chip Cookies". 
Wait, they're telling me that's not right. Oh, ok, I'm so glad you're here
for part *4* of our Object Oriented Programming series!

After the first 3 parts, you guys are already dangerous, so I'm impressed you're
still showing up and aren't off coding something cool. You made the right
choice: in this course we're going to really have fun with some of the coolest parts
of OO, showing off features that we haven't mentioned yet. This is packed with the
*final* pieces that will let you recognize all the different OO things that you see
in other people's code. There's lots to get through, so let's go!

## Get the Starting Code!

If you're serious about getting *really* good at this stuff, code along with me.
To do that, download the source code from this page, unzip it, and move into the
start directory. When you do that, you'll have the same code that I have here. Open
up the README file and follow the instructions inside to get things setup.

When that's done, open your favorite terminal application, move into the directory,
and - like we've done in the previous courses - start the built in php web server
by running:

```bash
php -S localhost:8000
```

This is a great server to use for development. Then, in our browser, we can go to
`http://localhost:8000`. Here is our beautiful Battles app!

## New Feature! Battle Types

People have been *clamoring* for a new feature: a way to battle that *forces* Jedi
powers to be used or completely avoided. Let's add this - it'll show off a new cool
thing: class constants.

Open `index.php` and scroll down. Right *after* the ship `select` boxes, but *before*
the submit button, I'll paste some HTML for a *new* select box.

Let's refresh and see what it looks like. Ok, it's a new drop-down called "Battle Type"
with option for "Normal", "No Jedi Powers" and "Only Jedi Powers". If you look at
the code, this is a single `select` field that has a name of `battle_type`.

Here's the idea: each *type* will cause the `BattleManager` to battle these two ships
in *slightly* different ways. Let's hook this up as *simply* as possible.

Since the field is named `battle_type`, open `battle.php` - the file that handles
the submit. Right before calling the `battle()` method, create a new variable called
`$battleType` set to `$_POST['battle_type']`. Then, pass `$battleType` as a new *fifth*
argument to the `battle()` method.

## Hooking up the Logic: No Magic Yet

Let's add that! Open `BattleManager` and find `battle()`. Give this a new
fifth argument: `$battleType`. Great! *We* know that this will be one of three
special strings, either `normal`, `no_jedi` or `only_jedi`. We can use those to change
the behavior.

First, the two blocks near the top should *only* be run if Jedi powers are being
used. Add to the if statement: if `$battleType != 'no_jedi'`, then we can run this.
Copy that and add it to the second block.

Perfect! If the battle type is `normal` or `only_jedi`, these blocks will execute.

Next, the last two lines are when the two ships battle each other normally. If we're
on `only_jedi` mode, this shouldn't happen. Surround them with an `if` statement:
`if ($battleType != 'only_jedi')` then run these lines.

Awesome! Now, there's just *one* little last detail: if two ships are fighting in
`only_jedi` mode, and both have *zero* Jedi powers, they'll get caught in this loop
and fight forever! To prevent that, above the `while`, add a new `$i = 0` variable.

Then, at the bottom, if `$i = 100`, we're probably stuck in a loop. Just set
`$ship1Health = 0;` and `$ship2Health = 0` and increment `$i` below that.

Done!

Give it a try!. Select one Jedi Starfighter, one CloakShape fighter, and choose
"Only Jedi Powers". Hit engage and ... the Jedi Starfighter used its Jedi powers
for a stunning victory! If we refresh, one of the ships will use its Jedi powers
*every* single time.

## Magic Strings Make Kittens Cry

Feature complete! And it was easy. So... what's the problem? Look at these strings:
`normal`, `no_jedi` and `only_jedi`: they're kind of magic. I mean, we chose them
randomly and if you misspell one somewhere, you won't get an error, but things won't
work right. 

To make things worse, in `BattleManager`, when you see these strings, it's not clear
what *other* strings might be possible. Are there other battle types we're forgetting
to handle? And if we wanted to add or remove a battle type, what other files would
we need to change? It's really common to have "magic strings" like these, but they
can become hard to keep track of: you end up referencing these exact little strings
in many places.

## Class Constants to the Rescue

Of course, object-oriented code has a answer! It's called "class constants",
and it works like this. Inside any class, you can use a special keyword called
`const` followed by a word - which is usually in all uppercase - like `TYPE_NORMAL`
and equals a value - `normal`. Repeat this for `const TYPE_NO_JEDI = 'no_jedi'`
and `const TYPE_ONLY_JEDI = 'only_jedi'`.

Constants are like variables, except they can never be changed. You can call the
constants anything - by adding `TYPE_` before each one, it helps me remember what
these are used for - battle types. You can also add these to *any* class. I choice
`BattleManager` because these types are used here.

## Using Class Constants

As soon as you do this, you can replace the random string with `BattleManager::TYPE_NO_JEDI`.
Below that, use `BattleManager::TYPE_ONLY_JEDI`. That will work the *exact* same
way as before. In `index.php`, do the same thing: `<?php echo BattleManager::TYPE_NORMAL`.
Copy that and replace it with `TYPE_NO_JEDI` and `TYPE_ONLY_JEDI`.

To prove it still works, refresh this page. Everything's still happy!

In a sense, nothing changed! But now, these magic strings have a *single* home: at
the top of `BattleManager`. If we ever needed to *change* these strings, we can do 
it in just *once* place.

This *also* gives these strings some context - these are obviously related to
`BattleManager`, and we can probably look here to see how they're used. We can also
*document* what they mean by adding some details above each type.

Now, check this out. When some *other* developer looks inside `index.php`, instead
of seeing some magic, meaningless strings like before, they'll see these constants
and think:

> Oh, `BattleManager::TYPE_NORMAL`. Let me go look in that class to see what this
> means. Oh hey, there's even some documentation!

So anytime you have a special string or other value that has some special meaning
but will never change, make it a constant and stay happy.
