# Protected Visibility

Let's keep making our Rebel ships work a bit differently than the Empire's.
In this dropdown you can see a short summary of each ship that is currently
functional. It shows their name, weapon power, jedi power and strength which
all comes from `getNameAndSpecs` function which prints those details out when
it's called. But I would like a way to tell which ships in this list rebel, so
let's add that word in paranthesis at the end. 

As usual to do that, we'll override this in `RebelShip`. Copy the `getNameAndSpecs`
function and paste it over here. And then just add '(rebel)' to the end here. Now
you may be thinking "guys, that's some serious code duplication...". Well you're
absolutely right, and we'll get to fixing that!

For now what we've got is pretty straightforward, so let's refresh and ....oh
chech out our dropdown. We've got an `Undefinded property RebelShip::$name`.

Back in PhpStorm, you can see `$this->name` is highlighted with an error message of
'Member has private access'. Interesting. So far, I've told you that since `RebelShip`
extends `Ship` it has access to everything inside of it like the properties and methods
as if they also exist inside of `RebelShip`. However, this error really does seem to be
saying something different than that. 

We can see that in `Ship` there is a name property so why isn't this working? 
