<?php

namespace Challenges\AddingAbstract;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class FunctionTypeHintWithClassNameMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Check out these classes that the intern created,
which all have confusing names:

```php
abstract class OtherClass extends GreatClass
{
}
```

```php
abstract class SomeClass extends OtherClass
{
}
```

```php
class GreatClass
{
}
```

```php
class MyClass extends OtherClass
{
}
```

```php
class Puppy extends SomeClass
{
}
```

```php
function doSomething(OtherClass \$thing)
{
    // ...
}
```

Based on the type-hint, which classes could be passed to the `doSomething()` function?
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('`OtherClass` and `SomeClass`')
            ->addAnswer('`OtherClass` and `MyClass`')
            ->addAnswer('`OtherClass`, `MyClass`, `SomeClass` and `Puppy`', true)
            ->addAnswer('`OtherClass` and `GreatClass`')
        ;
    }


    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
Don't let the `abstract` keyword confuse you: it makes
no difference here. Since the type-hint is `OtherClass`,
any `OtherClass` object or sub-classes are accepted.
The sub-classes are `MyClass` and `SomeClass` (directly)
and also `Puppy` (though `SomeClass`).
EOF;
    }
}
