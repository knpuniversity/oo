<?php

namespace Challenges\ProtectedVisibility;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class PropertyVisibilityMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Check out the following code:

```php
// Ship.php

class Ship
{
    public \$name;

    protected \$weaponPower;

    private \$defense;

    public function getDefense()
    {
        return \$this->defense;
    }
}
```

```php
// JediShip.php

class JediShip extends Ship
{
    public function getWeaponPower()
    {
        return \$this->weaponPower;
    }
}
```

```php
// index.php

\$jediShip = new JediShip();
\$jediShip->name;
\$jediShip->weaponPower;
```

Which of the above code will give us an error?
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('`$jediShip->weaponPower` in `index.php`', true)
            ->addAnswer('`return $this->defense` in `Ship.php`')
            ->addAnswer('`return $this->weaponPower` in `JediShip.php`')
            ->addAnswer('None of the above is bad code - we\'re awesome!')
        ;
    }


    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
Since the `\$defense` property is `private`, we can only access it from
within the `Ship` class. But that's exactly what we're doing in (B),
so that's fine.

The `\$weaponPower` property is `protected`. That means we can access it
only from inside `Ship`, `JediShip` or any other sub-classes. That's why
(C) is valid. But in (A), we're accessing `weaponPower` from `index.php`.
Accessing a property or method from outside of the class is only allowed
if it is public. This is a bad code.
EOF;
    }
}
