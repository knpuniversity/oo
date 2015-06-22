# OO Best Practice: Centralizing Configuration

Ok, next problem: at the bottom of `ShipLoader`, our database connection
information is hardcoded. That's a problem for two reasons. First, if this
works on my computer, it probably won't work on production, unless everything
matches up. And second, what if we need a database connection inside some
other class? Right now, we'd just have to copy and paste those credentials
into yet *another* spot. Eww.

Here's the goal: move the database configuration *out* of this class to somewhere
more central so it can be re-used. And good news: the way you do this is
*fundamentally* important to using object-oriented code correctly. 

## How to Make the OO Kittens Sad

But first, let me tell you what you *shouldn't* do. You *shouldn't* just
move this configuration to another file and then use some `global` keywords
to get that information here. You *will* see this kind of stuff - heck you
might see it all the time depending on your project. The problem is that
your code gets harder to read and maintain: "Hey, where the heck is this
`$dbPassword`" variable created? And what if you wanted to re-use this
class in another project? It better have global variables with the exact
same names.

Learning the better way is the difference between an "ok" object-oriented
developer and a great one: and even though this is only episode 2, you're
about to learn it.

## The Secret: Pass Objects the Config they Need

The secret is this: if a service class - like `ShipLoader` - needs information -
like a database password - we need to pass that information *to* `ShipLoader`
instead of expecting it to use a global keyword or some other method to "find"
it on its own. The most common way to do this is by creating a constructor.

## Create a Constructor for Options

Create a `public function __construct()` and make an argument for *each*
piece of configuration this class needs. `ShipLoader` needs  *three* pieces
of configuration. First, the database DSN - which is the connection parameter,
thing `mysql:host=localhost`. It also needs the `$dbUser` and the `$dbPassword`:

[[[ code('fb52759207') ]]]

And just like any class, you'll set each of these on a private property. Create
a `private $dbDsn`, `$dbUser` and `$dbPass`. In `__construct()`, assign
each argument to the property. I made my arguments - like `$dbUser` the same
as my property name - but that's not needed, it's just nice for my own sanity:

[[[ code('52d65dfd9d') ]]]

If this feels silly, pointless or you don't get it yet. That's GREAT. Keep
watching. Thanks to this change, whoever creates a `new ShipLoader()` is
*forced* to pass in these 3 configuration arguments. We don't care who creates
`ShipLoader`, but when they do, we store the configuration on three properties
and can use that stuff in our methods below.

At the bottom - let's do that. Copy the long database DSN string from `new PDO()`
and replace it with `$this->dbDsn`. Make the second argument `$this->dbUser`
and the third `$this->dbPass`:

[[[ code('32db8ce667') ]]]

And this class is done!

## Passing Configuration *to* the Class

But now, when we create `ShipLoader`, we need to pass arguments. In `index.php`,
PhpStorm is angry - `required parameter $dbDsn` - we're missing the first
argument. We could just paste our database credentials right here. But we'll
probably want them somewhere central.

Open `bootstrap.php` and create a new `$configuration` array. We'll use this
now as sort of a "global configuration" variable. Put the 3 database
credential things here - `db_dsn` - then paste the string - `db_user` is `root`
and `db_pass` is an empty string:

[[[ code('f51d5d28ef') ]]]

Since we're requiring this from `index.php`, we can just use it there:
`$configuration['db_dsn]` is the first argument then use `db_user` as the
second argument and `db_pass` to finish things off:

[[[ code('eee55d5742') ]]]

Yes! Now the app's configuration is all in one file. In `index.php`, we *pass*
this stuff to `ShipLoader` via its `__construct()` method. Then `ShipLoader`
doesn't have *any* hardcoded configuration. Anything that was hardcoded before
was replaced by a `__construct()` argument and a private property.

Make sure our ships are still battling. Refresh! *Still* not broken! 

## The Big Important Rule

Here's the rule to remember: don't put configuration inside of a service
class. Replace that hardcoded configuration with an argument. This allows
anyone using your class to pass in whatever *they* want. The hardcoding
is gone, and your class is more flexible.

Oh, and by the way - this little strategy is called dependency injection.
Scary! It's a tough concept for a lot of people to understand. If it's
not sinking in yet, don't worry. Practice makes perfect.
