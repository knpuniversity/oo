# Service Container

Good news: we've got great flexibility! Bad news: we have to create the service
objects by hand *and* this stuff is duplicated. We need to centralize what 
we've got here.

## Creating a Service Container

To do that, we'll create *one* special class whose only job is to create
these service objects. This class is called a service container, ya know,
because it's basically a container for all the service objects. You'll
see.

In `lib/` create a new file called `Container.php`. Inside create a class
called `Container`:

[[[ code('7c28be947c') ]]]

In `battle.php` and `index.php`, we create a new `PDO` object. Let's have
`Container` do that instead. Create a new `public function getPDO()` inside
`Container`. Copy the code to make this and paste it here. Hmm, we need the
`$configuration` variable, so copy that from `bootstrap.php` and put it
here temporarily. Return `$pdo` at the bottom and perfect the method by
adding some PHPDoc:

[[[ code('3659a96fe1') ]]]

## Using the Container

Ok, nobody needs to do this work by hand anymore. Go to `index.php`. At the
top, create a `$container` variable and set it to `new Container()`. Below
that, replace the `new PDO()` stuff with just `$container->getPDO()`:

[[[ code('231f9410cf') ]]]

Copy those lines and repeat this in `battle.php`:

[[[ code('c528bbd805') ]]]

Before trying this, don't forget to go to `bootstrap.php`: we need to require
the file so we can access the new class:

[[[ code('31b7d0987f') ]]]

Hey, let's give it a shot! Refresh! No problems.

## Centralizing Configuration

Ok, we've started removing duplication. But I made us go one step backwards:
once again, our configuration is buried inside a class - I'd rather have
that somewhere central. Fix this like we always do when we want to remove
some details from a class: create a `public function __construct()` with
a `$configuration` argument. Add the `$configuration` property and assign
it in the construct function:

[[[ code('08b3e796fb') ]]]

Down in `getPDO()`, let's celebrate! Remove the `$configuration` variable
and reference the property instead:

[[[ code('29b682b9a0') ]]]

This is an easy change - `bootstrap.php` already holds the central `$configuration`
array. In `battle.php` pass `$configuration` to the Container:

[[[ code('b9d1292f7d') ]]]

And do the same thing for `index.php`:

[[[ code('1cb257b2f1') ]]]

Time for a sanity check! Refresh! Oh no!

    PDOException on Container.php line 21

Put on your debugging cap! That's the line that creates the new `PDO` object.
Hmm, we didn't change anything - this is fishy. Dump `$this->configuration` and
refresh. Ah, it's `null`. Well, clearly that's not right. I see it. Silly
mistake: in `__construct()`, I wasn't assigning the property. Make sure you
have `$this->configuration = $configuration`:

[[[ code('08b3e796fb') ]]]

We were passing in the configuration, but I had forgot to set it on my property.
Try it again. Excellent!

This keeps my requirement of a centralized configuration array *and* centralizing
where we create service objects. But we still need to move a few more
service objects in here and fix one more issue. Almost there!
