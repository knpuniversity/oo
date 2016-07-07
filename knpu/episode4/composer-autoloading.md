# Composer Autoloading

Ok, guys: confession time. This cool little autoloader idea where we make our class
name match our file name and our namespace match our directory structure ... well,
that was *not* my idea. In fact, this idea has been around in PHP for years, and
every modern project follows it. That's nice for consistency and organization, but
it's also nice for a much more important reason: we can write a single autoloader
function that can find *anyone's* code: our code or third-party code that we include
in our project.

## The Famous PSR-0

The idea of naming your classes and files in this way is called `PSR-0`. You see,
there's a lovable group called the PHP FIG. It's basically the United Nations of
PHP: they come together to agree on standards that everyone should follow. PSR-0
was the first standard... called 0 because we geeks start counting, well, at 0.

It simply says that Thou shalt call your class names the same as your filenames plus
`.php` and you shall have your directory structures match up with your namespaces.

## Hello Composer

Why do we care? Because instead of having to write this autoloader by hand, you can
actually include an *outside* library that takes care of all of it for us. The library
is called Jordi, I mean, [Composer](https://getcomposer.org/): you may have heard of it.

Let's get it: Go to [getcomposer.org](https://getcomposer.org/) and hit
download. Copy the lines up here: if you're on Windows, you may see slightly different
instructions. Then move into your terminal, open a new tab, and paste those in.

This is downloading Composer, which is just a single, executable file. Usually people
use Composer to download external libraries they want to use in their project. It's
PHP's package manager.

But it has a second superpower: autoloading. When this command finishes, you'll end
up with a composer.phar file. This is a php executable. We'll come back to it in
a second.

## Configuring Autoloading

To tell Composer to do the autoloading for us, all you need is a small configuration
file called composer.json. Inside, add an `autoload` key, then a `psr-4` key, and
empty quotes set to `lib`.

That's it.

Remember how I said this rule is called PSR-0? Well PSR-4 is a slight amendment to
PSR-0, but they both refer to the same thing. This tells Composer that we want to
autoload using the PSR-0 convention, and that it should look for *all* classes inside
the `lib` directory. That's it.

Back in your terminal, run:

```bash
php composer.phar install
```

This command normally downloads any external packages that we need - but we haven't
defined any. But it *also* generates some autoload files inside a new `vendor/` directory.

To use those, open `bootstrap.php`, delete all the manual autoload stuff, and replace
it with just `require __DIR__vendor/autoload.php`, which is one of the files that
composer just generated. That's it.

You also usually don't commit the `vendor/` directory to your git repository: team
members just run this same command when they download the project.

Let's see if it works! Go back and refresh! It does! And as we add more classes and
more directories to `lib/`, everything will keep working. AND, if you guys want to
start downloading external libraries into your project via Composer, you can do that
too and immediately reference those classes without needing to worry about require
statements or autoloaders. Composer takes care of everything. Thanks Jordi!
