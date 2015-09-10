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
`$val .=`
