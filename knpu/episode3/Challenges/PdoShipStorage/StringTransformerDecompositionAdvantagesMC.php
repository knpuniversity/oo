<?php

namespace Challenges\PdoShipStorage;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class StringTransformerDecompositionAdvantagesMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
In the previous challenge, you split the logic from `StringTransformer`
into two different classes. What are the advantages of this?
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('Each class is smaller and so easier to understand')
            ->addAnswer('The `Cache` class could be re-used to cache other things')
            ->addAnswer('You could easily use the `StringTransformer`, but cache using a different mechanism, like *Redis*')
            ->addAnswer('All of these are real advantages', true)
        ;
    }


    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
All of these are advantages! Before, you might not even realize that
the `StringTransformer` had caching logic, but now its very obvious:
the caching logic is in a class called `Cache` and you can see that
the `StringTransformer` requires a `Cache` object. You could also use
the `Cache` class in other situations to cache other things. And you
could even - with a little bit of work - create a new `Cache` class
that caches via something like Redis, and pass *this* to `StringTransformer`
to cache using a different method.
EOF;
    }
}
