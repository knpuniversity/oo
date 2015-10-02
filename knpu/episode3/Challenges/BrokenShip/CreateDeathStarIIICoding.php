<?php

namespace Challenges\BrokenShip;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;
use KnpU\ActivityRunner\Activity\Exception\GradingException;

class CreateDeathStarIIICoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
I feel like we're *always* designing new DeathStars. Well, time to start
the DeathStarIII! Create a new `DeathStarIII` class, make it extend
`AbstractDeathStar`, and fill in any missing abstract methods. Finally,
print out the description in `index.php`.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder
            ->addFileContents('DeathStarIII.php', <<<EOF
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'AbstractDeathStar.php';
require 'DeathStarIII.php';

\$deathStar3 = new \DeathStarIII();

?>

<h3>
    The DeathStar 3 -

    <!-- print the description here -->
</h3>
EOF
            )
            ->addFileContents('AbstractDeathStar.php', <<<EOF
<?php

abstract class AbstractDeathStar
{
    abstract protected function getLaserRange();

    public function getDescription()
    {
        // replace this with a call to get the correct
        // range based on which DeathStar class is used
        \$range = \$this->getLaserRange();

        return <<<HEREDOC
A fantastic death machine, made to be extra cold and
intimidating. It comes complete with a "super-laser"
capable of destroying planets, with a range of \$range.
HEREDOC;
    }
}
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
        $deathStar3Class = new \ReflectionClass('\DeathStarIII');
        if (!$deathStar3Class->isSubclassOf('\AbstractDeathStar')) {
            throw new GradingException('The `DeathStarIII` class should extend the `AbstractDeathStar` one.');
        }
        $deathStar3 = $result->getDeclaredVariableValue('deathStar3');
        if (!$result->doesOutputContain($deathStar3->getDescription())) {
            throw new GradingException('Hmm, did you print the `DeathStarIII` description in `h3` tag?');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('DeathStarIII.php', <<<EOF
<?php

class DeathStarIII extends AbstractDeathStar
{
    protected function getLaserRange()
    {
        return 3000;
    }
}
EOF
            )
            ->setFileContents('index.php', <<<EOF
<?php

require 'AbstractDeathStar.php';
require 'DeathStarIII.php';

\$deathStar3 = new \DeathStarIII();

?>

<h3>
    The DeathStar 3 -

    <?php echo \$deathStar3->getDescription() ?>
</h3>
EOF
            )
        ;
    }
}
