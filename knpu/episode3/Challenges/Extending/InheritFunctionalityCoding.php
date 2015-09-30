<?php

namespace Challenges\Extending;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;
use KnpU\ActivityRunner\Activity\Exception\GradingException;

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

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php

require 'DeathStar.php';
require 'DeathStarII.php';

// set your \$deathStar variable here
EOF
        );

        $fileBuilder->addFileContents('DeathStarII.php', <<<EOF
EOF
        );

        $fileBuilder->addFileContents('DeathStar.php', <<<EOF
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
        );

        $fileBuilder->setEntryPointFilename('index.php');

        return $fileBuilder;
    }

    public function getExecutionMode()
    {
        return self::EXECUTION_MODE_PHP_NORMAL;
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertVariableExists('deathStar');
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
