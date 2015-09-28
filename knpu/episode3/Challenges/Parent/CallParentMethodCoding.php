<?php

namespace Challenges\Parent;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;
use KnpU\ActivityRunner\Activity\Exception\GradingException;

class CallParentMethodCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
It took too long to travel to planets to destroy them
in the first DeathStar, so Darth wants the laser range
on the new DeathStar to be *twice* as far! Override
the `getLaserRange()` method in `DeathStarII` to make
this happen. But don't repeat the `2000000` value!
Call the parent function and then multiple that value by 2!
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder
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
    public function getLaserRange()
    {
        return 2000000;
    }
}
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'DeathStar.php';
require 'DeathStarII.php';

\$deathStar = new DeathStarII();

?>

<h3>
    Laser Range <?php echo \$deathStar->getLaserRange(); ?>
</h3>
EOF
            )
            ->setEntryPointFilename('index.php')
        ;

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
        $deathStar = $result->getDeclaredVariableValue('deathStar');
        if (!method_exists($deathStar, 'getLaserRange')) {
            throw new GradingException('The `getLaserRange` method does not exist for the `DeathStarII` class - did you create it?');
        }
        if (4000000 != $deathStar->getLaserRange()) {
            throw new GradingException('The `getLaserRange` method in the `DeathStarII` class should return a doubled value of the parent method.');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends DeathStar
{
    public function getLaserRange()
    {
        return parent::getLaserRange() * 2;
    }
}
EOF
            )
        ;
    }
}
