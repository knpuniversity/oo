<?php

namespace Challenges\Override;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class CallOverriddenMethodMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Look at the following classes:

```php
class Ship
{
    public function printType()
    {
        echo 'Empire Ship';

        \$this->printMotto();
    }

    public function printMotto()
    {
        echo 'I like to fly!';
    }
}
```

```php
class RebelShip extends Ship
{
    public function printType()
    {
        echo 'Rebel Ship';
    }
}
```

What is the result of the following code:

```
\$ship = new Ship();
\$rebelShip = new RebelShip();
\$ship->printType();
\$rebelShip->printType();
```
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('`Empire ShipRebelShip`')
            ->addAnswer('`Empire ShipI like to fly!RebelShip`', true)
            ->addAnswer('`Empire ShipI like to fly!RebelShipI like to fly`')
            ->addAnswer('`RebelShipRebelShip`')
        ;
    }


    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
For `Ship`, `printType()` prints "Empire Ship" and then also
calls `printMotto()`. But for `RebelShip`, `printType()` only
prints "Rebel Ship". *Nothing* calls the `printMotto()`
function in this case.
EOF;
    }
}
