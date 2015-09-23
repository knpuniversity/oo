<?php

namespace Challenges\Extending;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class CallNonexistentMethodMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Look at these two classes:

```php
class Ship
{
    public function getName()
    {
        return 'Starfighter';
    }
}
```

```php
class JediShip extends Ship
{
    public function getFavoriteJedi()
    {
        return 'Yoda';
    }
}
```

Suppose we instantiate both objects:

```php
\$ship = new Ship();
\$jediShip = new JediShip();
```

Which of the following lines will cause an error?
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('`echo $ship->getName();`')
            ->addAnswer('`echo $ship->getFavoriteJedi();`', true)
            ->addAnswer('`echo $jediShip->getName();`')
            ->addAnswer('Both (B) and (C) will cause an error');
    }


    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
The `Ship` object does *not* have a `getFavoriteJedi()` method
on it - only `JediShip` has this. But, since `JediShip extends Ship`,
the `JediShip` *does* have a `getName()` method: it inherits it from
`Ship`.
EOF;
    }
}
