# Namespaces make Class Names Longer

We all know that the name of this class is `BattleManager`. When we want to use it,
we reference `BattleManager`. No matter what we do - static or non-static - if we want
to work with this class we call it by its name, `BattleManager`. Simple.

Why am I pointing out the painfully obvious? Because we're about to make this class
name *longer*, but maybe not how you'd expect. We're going to use a namespace.

## Let's see some Namespaces

At first, *why* namespaces exist might not be obvious, so hold onto that question.
Let's see how they work first.

Above any class, you can - if you want to - add a `namespace` keyword followed by
some string. Like, `Battle` or something more complicated like `Battle\HiGuys\NiceNameSpace`.
A namespace is a string, and you can give it different parts by separating each with
a backslash - that's the slash that feels a little wrong when you type it - it's
usually an escape character.

To keep things simple, just set the namespace to `Battle` for now. As soon as we
did that, we actually *changed* the name of this class: it is no longer called
`BattleManager`. In fact, you can see that PhpStorm now highlights our code with
an "Undefined class BattleManager" error. Thanks to the namespace, the class is
*now* called `Battle\BattleManager`.

Refresh to prove it. Great!

So... that's really it! When you add a `namespace` above a class, the full class
name becomes that namespace, a `\`, and then class name. *Every* place we reference
this class name will now need to change - like inside of `Container`. We'll do that
in a few minutes - we've got a few other things to do first.

## So Why do Namespaces Exist?

Now that you know how namespaces work, you're probably wondering, why do these even
exist? How does this help me in my coding? Well, the short answer is... it doesn't
help you. In fact, namespaces weren't *meant* to help you - they were meant to help
external library developers. So I guess, if you're one of those it does help.

In a nut shell, as you go further into development, you'll start to use a lot of
3rd-party, libraries written by other people. That's cool because those libraries
will give *us* new classes to help solve problems.

The reason that namespaces exist is to avoid collisions in those external libraries.
Imagine we're using library A and library B, but that they *both* have a class called
`Battle`. Without namespaces, we'd be lost in space: we wouldn't be able to use
both libraries. But if each library has a unique namespace, we won't collide: they'll
simply be called something like `LibraryA\Battle` and `LibraryB\Battle`.

This means that namespaces *do* help us, but only indirectly. When we're working with
namespaces it just makes our class names longer.

## The use Statement

There is *one* other thing that you need to know with namespace: it's the
mystical `use` statement.

When you want to reference a class, it's perfectly valid to type out the *entire*
long class name right where you need to use it. But in practice, you won't see this
very often. Instead, people typically add a `use` statement at the top of the file
that references the *full* class name: `Battle\BattleManager`.

As soon as you do, when you need to work with the class, you can once again write
out *only* the short class name. And while you'll only have *one* `namespace` per
file, you'll have as many `use` statements as you need.

To be clear, the `use` statement does *not* change how namespaces work: it's just
a shortcut. When PHP executes this file, it sees class `BattleManager` and says:

> Huh, BattleManager? Let me check all of the use statements at the top of this file.

PHP then looks to see if any of the `use` statements *end* in the word `BattleManager`.
If it finds one, it basically copies the long class name and pastes it below
*right* before executing the file. What I just did manually is what PHP basically
does at run-time.

So `use` statements are just this nice, extra feature. And technically, you could
avoid using them and instead write-out full class names right where you need
them.

Ok! We're going to do a lot more with namespaces. But first, we need to turn to
a very related topic called autoloading.
