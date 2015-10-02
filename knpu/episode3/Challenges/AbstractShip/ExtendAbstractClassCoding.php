<?php

namespace Challenges\AbstractShip;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;
use KnpU\ActivityRunner\Activity\Exception\GradingException;

class ExtendAbstractClassCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
We've just gotten word that the Rebels have *also*
destroyed the `DeathStarII`. Wow, rotten luck. Anyways,
it sounds like we'll be creating blue prints for many
different types of DeathStar's in the future, to keep
the Rebels guessing.

To make this easier, create an `AbstractDeathStar` class,
move all of the shared code into it, and update
`DeathStar` and `DeathStarII` to extend this new class.
Make sure to get rid of anything in those classes
that you've moved into the new parent class.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder
            ->addFileContents('AbstractDeathStar.php', <<<EOF
EOF
            )
            ->addFileContents('DeathStar.php', <<<EOF
<?php

class DeathStar
{
    private \$crewSize;

    private \$weaponPower;

    public function setCrewSize(\$numberOfPeople)
    {
        \$this->crewSize = \$numberOfPeople;
    }

    public function getCrewSize()
    {
        return \$this->crewSize;
    }

    public function setWeaponPower(\$power)
    {
        \$this->weaponPower = \$power;
    }

    public function getWeaponPower()
    {
        return \$this->weaponPower;
    }

    public function makeFiringNoise()
    {
        echo 'BOOM x '.\$this->weaponPower;
    }
}
EOF
            )
            ->addFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends DeathStar
{
    // this DeathStar must *always* have 5000 people on it
    public function getCrewSize()
    {
        return 5000;
    }

    public function makeFiringNoise()
    {
        echo 'SUPER BOOM';
    }
}
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'AbstractDeathStar.php';
require 'DeathStar.php';
require 'DeathStarII.php';

\$deathStar1 = new DeathStar();
\$deathStar1->setCrewSize(3000);
\$deathStar1->setWeaponPower(500);

\$deathStar2 = new DeathStarII();
\$deathStar2->setWeaponPower(999);

?>

<table>
    <tr>
        <td>&nbsp;</td>
        <th>DeathStar 1</th>
        <th>DeathStar 2</th>
    </tr>
    <tr>
        <th>Crew Size</th>
        <td><?php echo \$deathStar1->getCrewSize(); ?></td>
        <td><?php echo \$deathStar2->getCrewSize(); ?></td>
    </tr>
    <tr>
        <th>Weapon Power</th>
        <td><?php echo \$deathStar1->getWeaponPower(); ?></td>
        <td><?php echo \$deathStar2->getWeaponPower(); ?></td>
    </tr>
    <tr>
        <th>Fire!</th>
        <td><?php echo \$deathStar1->makeFiringNoise(); ?></td>
        <td><?php echo \$deathStar2->makeFiringNoise(); ?></td>
    </tr>
</table>
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
        if (!class_exists('\AbstractDeathStar')) {
            throw new GradingException('Class `AbstractDeathStar` does not exist! Did you create it?');
        }
        $abstractClass = new \ReflectionClass('\AbstractDeathStar');
        if (!$abstractClass->isAbstract()) {
            throw new GradingException('The `AbstractDeathStar` class should be declared as abstract.');
        }
        if (false
            || !$abstractClass->hasMethod('setWeaponPower')
            || !$abstractClass->hasMethod('getWeaponPower')
            || !$abstractClass->hasMethod('makeFiringNoise')
        ) {
            throw new GradingException(''
                .'The `AbstractDeathStar` class should have `getWeaponPower`, `setWeaponPower`, '
                .'and `makeFiringNoise` methods. '
            );
        }
        if ($abstractClass->hasMethod('setCrewSize')) {
            throw new GradingException(''
                .'The `AbstractDeathStar` class should not have a `setCrewSize` method! '
                .'The `DeathStarII` just has a hardcoded crew size, so does not need this setter. Move it to `Deathstar`'
            );
        }
        $deathStarClass = new \ReflectionClass('\DeathStar');
        $deathStarIIClass = new \ReflectionClass('\DeathStarII');
        if (!$deathStarClass->isSubclassOf('\AbstractDeathStar') || !$deathStarIIClass->isSubclassOf('\AbstractDeathStar')) {
            throw new GradingException('The both `DeathStar` and `DeathStarII` classes should extend `AbstractDeathStar` one.');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('AbstractDeathStar.php', <<<EOF
<?php

abstract class AbstractDeathStar
{
    private \$weaponPower;
    
    public function setWeaponPower(\$power)
    {
        \$this->weaponPower = \$power;
    }

    public function getWeaponPower()
    {
        return \$this->weaponPower;
    }

    public function makeFiringNoise()
    {
        echo 'BOOM x '.\$this->weaponPower;
    }
}
EOF
            )
            ->setFileContents('DeathStar.php', <<<EOF
<?php

class DeathStar extends AbstractDeathStar
{
    private \$crewSize;
    
    public function setCrewSize(\$numberOfPeople)
    {
        \$this->crewSize = \$numberOfPeople;
    }
    
    public function getCrewSize()
    {
        return \$this->crewSize;
    }
}
EOF
            )
            ->setFileContents('DeathStarII.php', <<<EOF
<?php

class DeathStarII extends AbstractDeathStar
{
    // this DeathStar must *always* have 5000 people on it
    public function getCrewSize()
    {
        return 5000;
    }

    public function makeFiringNoise()
    {
        echo 'SUPER BOOM';
    }
}
EOF
            )
        ;
    }
}
