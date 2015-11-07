<?php

namespace Challenges\Extending;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class InheritFunctionalityCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Your team has been working hard building the `DeathStar` class, only
to find out that the Rebels have just destroyed it! Time to rebuild!
Create a new class called `DeathStarII` in the `DeathStarII.php` file
and make it inherit all of the functionality from the original `DeathStar`.
In `index.php`, instantiate a new `DeathStarII` object and set it to 
a `\$deathStar` variable. Long live the Empire!
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('index.php', <<<EOF
<?php

require 'DeathStar.php';
require 'DeathStarII.php';

// set your \$deathStar variable here
EOF
            )
            ->addFileContents('DeathStarII.php', <<<EOF
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
        $phpGrader->assertVariableExists('deathStar');
        $deathStar = $result->getDeclaredVariableValue('deathStar');
        if (!$deathStar instanceof \DeathStarII) {
            throw new GradingException('The `$deathStar` variable exists, but is not set to a `DeathStarII` object.');
        }
        if (! $deathStar instanceof \DeathStar) {
            throw new GradingException('The `DeathStarII` class is not extending `DeathStar` one.');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php

require 'DeathStar.php';
require 'DeathStarII.php';

\$deathStar = new DeathStarII();
EOF
        );

        $correctAnswer->setFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends DeathStar
{
}
EOF
        );
    }
}
