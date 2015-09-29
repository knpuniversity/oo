<?php

namespace Challenges\AbstractShip;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class InheritanceOverheadMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
A co-worker created a few classes and has asked for
your advice about organizing them:

```php
class Ship
{
    private \$name;

    public function getName()
    {
        return \$name;
    }

    public function setName(\$name)
    {
        \$this->name = \$name;
    }

    // other stuff...
}
```

```php
class Person
{
    private \$name;

    public function getName()
    {
        return \$name;
    }

    public function setName(\$name)
    {
        \$this->name = \$name;
    }

    // other stuff...
}
```

Your teammate is wondering if this can be organized better.
Which if the following is the best advice?
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer(<<<EOF
Create a new `AbstractNamedItem` class that has the
`name` property and the `getName()` and `setName()`
methods. Then, make `Person` and `Ship` extend this
class.
EOF
            )
            ->addAnswer(<<<EOF
Make `Ship` extend `Person`, and remove all the
duplicated code in `Person`.
EOF
            )
            ->addAnswer('Leave things exactly like they are now.', true)
        ;
    }


    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
Even though both classes share some code, a `Ship`
and a `Person` fundamentally aren't the same thing,
and probably don't have any other overlapping code.
So, you *could* create an `AbstractNamedItem`, but
that's a bit awkward. And remember, you can only
extend *one* class, so make sure your parent class
makes sense.

In this case, the best action is to do nothing: leave
these two blueprints totally independent. In a future
episode, we'll talk about traits: a cool way to help
remove duplication without inheritance.
EOF;
    }
}
