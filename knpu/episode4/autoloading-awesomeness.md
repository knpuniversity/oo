# Autoloading Awesomeness

Have you ever heard of an autoloader? Even if you *have*, you might not know what
they do or how they work.

## What does an Autoloader Do?

Autoloaders change everything. In PHP, you can't reference a class or a function
unless you - or someone - requires or includes that file first. That's why - in
`bootstrap.php` - we have a `require` statement for *every* file. Without these,
we can't access the classes inside of them.

This is no bueno: it means that I have to remember to add another line here, whenever
I create a new class. You know why else it's not good? Suppose I don't use all of
these classes during some requests? Well, right now, I'm loading *every* class into
memory, even if we never need to use them. This is actually slowing down my app!

Well, guess what: in modern PHP, you *never* see require or include statements.
They're gone. How is that possible? The Answer is: autoloaders.

First, kill the `BattleManager.php` require statement.

Not surprisingly, we get an error: `Class Battle\BattleManager not found`.

## Adding your Autoloader

How do we fix this? The answer is by calling a very special function from the core
of PHP called `spl_autoload_register()`. Pass this a single argument: a function
with a `$className` argument. We'll use an anonymous function.

Here's the deal: as soon as you call `spl_autoload_register`, right before PHP throws
the dreaded "class not found" error like this, it will call *our* function and pass
it the class name. Then, if we - somehow - can locate the file that contains this
class and require it, PHP will continue on like normal with no error.

In fact, in modern PHP development, this is how *every single class* is loaded. In
some cases, this little function is called *hundreds* of times on every request.

## Making your Autoloader Work (a little)

Let's start coding our autoloader with some simple logic: `if ($className == 'Battle\BattleManager')`,
then we know where that file lives. require `__DIR__.'/lib/Service/BattleManager.php`.
Then, add a `return`: we're done!

For now, if the autoloader function is called for any other class, we'll do nothing.
PHP will throw its normal "class not found" error.

With *just* that, refresh. Mind blown. We just got our app to work *without* manually
requiring the `BattleManager.php` file. Of course, right now, this isn't much better
than having a require statement. Actually, it's *more* work.

## Creating a Smarter Autoloader

How could we make this function smarter? How could we make it automatically find
*new* classes and files as we add them to the system?

Well I have an idea. `BattleManager` lives in the `Service` directory. What if we
changed its namespace to match that? Or to get crazier, what if we gave *every* class
a namespace that matches its directory?

If we did that, the autoload function could use the namespace to locate any file.
The class - `Service\BattleManager` would live at `Service/BattleManager.php`.
It's brilliant!

Now that we've changed the namespace to  `Service,` we need to update any references
to `BattleManager` - like in `index.php`. Change the `use` statement to `Service`.

Yes!

Finally, in `bootstrap.php`, instead of manually checking for *just* this one class,
say that the path is always equal to `__DIR__/lib/` then `str_replace()` - we'll
replace the back slash with a forward slash. Notice I put *two* back-slashes. Since
this is the escape character, if you only have one, it looks like you're escaping
the next quote character. So, to get one slash, we need to use two - it's an ugly
detail. Anyways, replace backslashes with a forward slash and pass that the class
name. Finally, add the `.php` at the end.

Just in case, check to see if that file exists. If it does, `require $path`.

That's it. Go back, refresh, and... everything still works.

And now, we are incredibly dangerous. We can now get rid of every single require
statement really easily. Let's do it!
