<?php

namespace Challenges\BrokenShip;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

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

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
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
        $htmlGrader = new HtmlOutputGradingTool($result);
        $deathStar3Class = new \ReflectionClass('\DeathStarIII');
        if (!$deathStar3Class->isSubclassOf('\AbstractDeathStar')) {
            throw new GradingException('The `DeathStarIII` class should extend the `AbstractDeathStar` one.');
        }
        $deathStar3 = $result->getDeclaredVariableValue('deathStar3');
        if (!$htmlGrader->doesOutputContain($deathStar3->getDescription())) {
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
