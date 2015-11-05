<?php

namespace Challenges\AddingAbstract;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class CreateAbstractMethodCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
When Darth is browsing all the different `DeathStar` models, we want to print
out a little description that describes each one. Inside of that description,
we want to include the "laser range", but it's different based on the model.

Create an abstract method called `getLaserRange()` in `AbstractDeathStar`
and then use that in `getDescription()` to set the `\$range` variable.
Then, make sure each DeathStar class has the proper range:

* `DeathStar` laser range = 500
* `DeathStarII` laser range = 900
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('AbstractDeathStar.php', <<<EOF
<?php

abstract class AbstractDeathStar
{
    public function getDescription()
    {
        // replace this with a call to get the correct
        // range based on which DeathStar class is used
        \$range = '???';

        return <<<HEREDOC
A fantastic death machine, made to be extra cold and
intimidating. It comes complete with a "super-laser"
capable of destroying planets, with a range of \$range.
HEREDOC;
    }
}
EOF
            )
            ->addFileContents('DeathStar.php', <<<EOF
<?php

class DeathStar extends AbstractDeathStar
{
}
EOF
            )
            ->addFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends AbstractDeathStar
{
}
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'AbstractDeathStar.php';
require 'DeathStar.php';
require 'DeathStarII.php';

\$deathStar = new DeathStar();
\$deathStar2 = new DeathStarII();

?>

<h3>
    Original DeathStar
    <p><?php echo \$deathStar->getDescription(); ?></p>
</h3>

<h3>
    Second DeathStar
    <p><?php echo \$deathStar2->getDescription(); ?></p>
</h3>
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
        $abstractDeathStarClass = new \ReflectionClass('\AbstractDeathStar');
        if (!$abstractDeathStarClass->hasMethod('getLaserRange')) {
            throw new GradingException(
                'Method `getLaserRange()` does not exist in the `AbstractDeathStar` class. Did you create it?'
            );
        }
        if (!$abstractDeathStarClass->getMethod('getLaserRange')->isAbstract()) {
            throw new GradingException(
                'Method `getLaserRange()` declared in the `AbstractDeathStar` class should be abstract.'
            );
        }
        $deathStar = $result->getDeclaredVariableValue('deathStar');
        $deathStar2 = $result->getDeclaredVariableValue('deathStar2');
        if (500 != $deathStar->getLaserRange() || 900 != $deathStar2->getLaserRange()) {
            throw new GradingException(
                'Method `getLaserRange()` should return `500` for the `DeathStar` class and `900` for the `DeathStarII`.'
            );
        }
        $content = $result->getInputFileContents('AbstractDeathStar.php');
        if (false === strpos($content, 'getLaserRange')) {
            throw new GradingException('Did you call `getLaserRange()` method in the `AbstractDeathStar` class?');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('AbstractDeathStar.php', <<<EOF
<?php

abstract class AbstractDeathStar
{
    abstract public function getLaserRange();

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
            ->setFileContents('DeathStar.php', <<<EOF
<?php

class DeathStar extends AbstractDeathStar
{
    public function getLaserRange()
    {
        return 500;
    }
}
EOF
            )
            ->setFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends AbstractDeathStar
{
    public function getLaserRange()
    {
        return 900;
    }
}
EOF
            )
        ;
    }
}
