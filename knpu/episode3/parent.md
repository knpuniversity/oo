# Parent

We covered that when you override a function, you override it entirely. In
`RebelShip` we're overriding `getNameAndSpecs` which means that when this
method is called on a `RebelShip` object the `getNameAndSpecs` inside of the
original `Ship` class, i.e. the parent class, is never called. Which, in this 
case is sort of a problem because it leaves us with all this code duplication. 
It would be way better if we could somehow call the parent method, `getNameAndSpecs`
inside of `Ship`, and then just add this '(rebel)' part to the end. 

We saw in the last chapter, that from within `RebelShip` you can call methods that
exist in the parent class as long as they are `public` or `protected`. Which means
we can finally get rid of this duplication by calling the parent `getNameAndSpecs`
method and adding '(rebel)' to the end of it. 

Add `$val = $this->getNameAndSpecs()`. Pass in the `$useShortFormat`and then 
`$val .= ('Rebel');` and finally `return $val;`. Doesn't that look a whole lot nicer?
Yes, yes it does.

Let's give our experiment here a try. Refresh! Hmmm something is wrong... 
`(!) Fatal error: Maximum`, let's view the source code since this error is stuck in
our select box. Ah there we go: `(!) Fatal error: Maximum function nesting level of '200' reached, aborting!`.
This means that we have a loop in our code, on index line 98 we call `getNameAndSpecs` and
then on line 25 of `RebelShip` we call `getNameAndSpecs` again. This isn't working because
when we call `$this->getNameAndSpecs`, it's literally calling this `getNameAndSpecs`method again
inside of `RebelShip` not the parent function in `Ship`. The way you get this to call the parent
function is with a special key word called `parent::`.

Let's try this again in our browser, refresh, and checking our dropdown everything is working again.
Except, maybe I could use a space here to make things look nicer. There we go. 

Don't worry about this Parent keyword too much because the only time you're going to see it is when
you are inside of an overriden function and you want to call the parent version of it. We will see this
`::` thing later when we talk about static things. 
