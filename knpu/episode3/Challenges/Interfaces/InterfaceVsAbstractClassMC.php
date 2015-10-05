<?php

namespace Challenges\Interfaces;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class InterfaceVsAbstractClassMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
You over-hear the intern Bob telling another teammate about the differences between
abstract classes and interfaces. He's *mostly* right, but he got one detail wrong.
Which of the following is *not* true:
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('Classes can implement many interfaces, but only extend one class.')
            ->addAnswer('Abstract classes can contain concrete methods, but interfaces can\'t.')
            ->addAnswer('Interfaces force the user to implement certain methods, abstract classes do not.', true)
            ->addAnswer(''
                .'Even though Interfaces don\'t use the `abstract` keyword before methods, '
                .'those methods act just like abstract methods in an abstract class. '
            )
        ;
    }


    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
`C` is the only answer that's incorrect: both interfaces and abstract classes can
force you to implement methods in the classes that use them. So in many ways, they
are the same.

So why use one or the other? Well, a class can implement *many* interfaces, which
makes interfaces more attractive, especially for re-usable code. But, an abstract
class can contain *real* methods, which can help you reduce code duplication between
classes. They're similar, but not the same.
EOF;
    }
}
