# Using Objects

This `play.php` file is cute, but it's not our real application. But hey,
we *did* make this nice `Ship` class, so let's use. It'll clean up our code
and give us more power. Sounds good to me!

## Moving Ship into Ship.php

But first, the `Ship` class lives inside `play.php`, and this is just a garbage
file we won't use anymore. Usually, a class will live all alone in its own
file. Create a `lib/` directory, and a file called `Ship.php`. There's no
technical reason why I called the directory `lib/`, it just sounds nice. And
the same goes for the filename - we could call it anything. But to keep my
sanity, putting the `Ship` class inside `Ship.php` makes a lot more sense
than putting it inside of a file called `ThereIsDefinitelyNotAShipClassInHere.php`.
So even though nothing technical forces us to do this, put one class per file,
and then go celebrate how clean things look.

Go copy the `Ship` class, and put it into `Ship.php`. Don't put a closing
PHP tag, because you don't need it. PHP will reach the end of the file, and
close it automatically.

NOTE TO LEANNA: The last sentence above isn't said, so listen for the first
sentence to get your place
