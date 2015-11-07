<?php

namespace Challenges\Override;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class OverrideInheritMethodCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Well, we learned some hard lessons after the destruction of the original `DeathStar`,
and we don't want to repeat them! Override the `getWeakness()` method in `DeathStarII`
and make it return `null`. Phew, problem solved!
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends DeathStar
{
}
EOF
            )
            ->addFileContents('DeathStar.php', <<<EOF
<?php

class DeathStar
{
    public function blastPlanet(\$planetName)
    {
        echo 'BOOM '.\$planetName;
    }

    public function getWeakness()
    {
        return 'Thermal Exhaust Port';
    }
}
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'DeathStar.php';
require 'DeathStarII.php';

\$original = new DeathStar();
\$new = new DeathStarII();

?>

<h2>Original DeathStar Weakness: <?php echo \$original->getWeakness(); ?></h2>
<h2>New DeathStar Weakness: <?php echo \$new->getWeakness(); ?></h2>
EOF
            )
            ->setEntryPointFilename('index.php')
        ;

        return $builder;
    }

    public function getWorkerConfig(WorkerLoaderInterface $loader)
    {
        return $loader->load(__DIR__.'/../php_worker.yml');
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $phpGrader = new PhpGradingTool($result);
        $phpGrader->assertVariableExists('original');
        $phpGrader->assertVariableExists('new');
        $original = $result->getDeclaredVariableValue('original');
        $new = $result->getDeclaredVariableValue('new');
        if (!$original instanceof \DeathStar) {
            throw new GradingException('The `$original` variable exists, but is not set to a `DeathStar` object.');
        }
        if (!$new instanceof \DeathStarII) {
            throw new GradingException('The `$new` variable exists, but is not set to a `DeathStarII` object.');
        }
        if (!$new instanceof \DeathStar) {
            throw new GradingException('The `DeathStarII` class is not extending `DeathStar` one.');
        }
        if ('Thermal Exhaust Port' != $original->getWeakness()) {
            throw new GradingException(
                'The return value of `getWeakness()` method in a `DeathStar` class was changed. You should override it.'
            );
        }
        if (null !== $new->getWeakness()) {
            throw new GradingException(
                'The `getWeakness()` method of `DeathStarII` class does not return `null`.'
            );
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends DeathStar
{
    public function getWeakness()
    {
        return null;
    }
}
EOF
        );
    }
}
