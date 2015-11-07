<?php

namespace Challenges\ProtectedVisibility;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class GetInheritedPropertyCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The construction of the `DeathStarII` continues, but we need access
to the `planetarySuperLaserRange` property from the original, because
we're going to make it fire twice as far! Fix the `DeathStar` class
so that the new `getSpecs()` method works:
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

\$deathStar = new DeathStarII();

?>

<h2>New DeathStar Specs</h2>
<table>
    <?php foreach (\$deathStar->getSpecs() as \$key => \$val): ?>
    <tr>
        <th><?php echo \$key; ?></th>
        <td><?php echo \$val; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
EOF
            )
            ->addFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends DeathStar
{
    public function getSpecs()
    {
        return array(
            'name' => 'DeathStarII',
            'laser_range' => \$this->planetarySuperLaserRange * 2,
        );
    }
}
EOF
            )
            ->addFileContents('DeathStar.php', <<<EOF
<?php

class DeathStar
{
    private \$planetarySuperLaserRange = 2000000;
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
        $class = new \ReflectionClass('\DeathStar');
        if (!$class->hasProperty('planetarySuperLaserRange')) {
            throw new GradingException('The `planetarySuperLaserRange` property does not exist in the `DeathStar` class.');
        }
        $property = $class->getProperty('planetarySuperLaserRange');
        if (!$property->isProtected()) {
            throw new GradingException('The `planetarySuperLaserRange` property should have protected visibility.');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('DeathStar.php', <<<EOF
<?php

class DeathStar
{
    protected \$planetarySuperLaserRange = 2000000;
}
EOF
            )
        ;
    }
}
