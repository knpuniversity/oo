<?php

namespace Challenges\Interfaces;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class ImplementWeaponInterfaceCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Now you're working on creating different weapons for the spaceships in our game.
By looking at the `WeaponInterface` create a new `LaserWeapon` class that implements
this interface. You can return anything you want from the methods. Use the class
to print out the weapon's range, just to see that things are working:
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('LaserWeapon.php', <<<EOF
EOF
            )
            ->addFileContents('WeaponInterface.php', <<<EOF
<?php

interface WeaponInterface
{
    /**
     * @return integer The weapon's range in kilometers
     */
    public function getWeaponRange();

    /**
     * @return bool Is this weapon effective in space
     */
    public function canBeUsedInSpace();

    /**
     * @return integer The amount of damage the weapon will cause against the given material
     */
    public function getWeaponStrengthAgainstMaterial(\$material);
}
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'WeaponInterface.php';
require 'LaserWeapon.php';

// instantiate a new LaserWeapon here

?>

<h1>
    Laser weapon range:
    <!-- print your weapon's getWeaponRange() here -->
</h1>
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
        if (!class_exists('\LaserWeapon')) {
            throw new GradingException('Class `LaserWeapon` could not be found. Did you create it?');
        }
        $laserWeaponClass = new \ReflectionClass('\LaserWeapon');
        if (!$laserWeaponClass->implementsInterface('\WeaponInterface')) {
            throw new GradingException(
                'Class `LaserWeapon` should implement the `WeaponInterface` interface.'
            );
        }
        $laserWeapon = $laserWeaponClass->newInstance();
        $htmlGrader->assertOutputContains(
            $laserWeapon->getWeaponRange(),
            'Seems you forgot to output the laser weapon range. Did you print the result of the `getWeaponRange()` method?'
        );
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('LaserWeapon.php', <<<EOF
<?php

class LaserWeapon implements WeaponInterface
{
    /**
     * @return integer The weapon's range in kilometers
     */
    public function getWeaponRange()
    {
        return 2000;
    }

    /**
     * @return bool Is this weapon effective in space
     */
    public function canBeUsedInSpace()
    {
        return true;
    }

    /**
     * @return integer The amount of damage the weapon will cause against the given material
     */
    public function getWeaponStrengthAgainstMaterial(\$material)
    {
        switch (\$material) {
            case 'deathstar':
                \$damageAmount = 50;
                break;
            case 'spaceship':
                \$damageAmount = 100;
                break;
            default:
                \$damageAmount = 200;
        }

        return \$damageAmount;
    }
}
EOF
            )
            ->setFileContents('index.php', <<<EOF
<?php

require 'WeaponInterface.php';
require 'LaserWeapon.php';

\$laserWeapon = new LaserWeapon();

?>

<h1>
    Laser weapon range:
    <?php echo \$laserWeapon->getWeaponRange(); ?>
</h1>
EOF
            )
        ;
    }
}
