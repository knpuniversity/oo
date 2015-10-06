<?php

namespace Challenges\AbstractShipLoader;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;
use KnpU\ActivityRunner\Activity\Exception\GradingException;

class CreateAbstractPlanetCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Tired of their DeathStars being destroyed, the Empire has decided to transform into
a video game company. Awesome! Two different teammates have already created two
classes to model this: `SolidPlanet` and `GasPlanet`. They look and work differently,
but both have `getRadius()` and `getHexColor()` methods. You've built a `PlanetRenderer`
class with a `render()` method, but it's not quite working yet.

Create an `AbstractPlanet` class and update any other code you need to make these
planets render!
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder
            ->addFileContents('AbstractPlanet.php', <<<EOF
EOF
            )
            ->addFileContents('SolidPlanet.php', <<<EOF
<?php

class SolidPlanet
{
    private \$radius;

    private \$hexColor;

    public function __construct(\$radius, \$hexColor)
    {
        \$this->radius = \$radius;
        \$this->hexColor = \$hexColor;
    }

    public function getRadius()
    {
        return \$this->radius;
    }

    public function getHexColor()
    {
        return \$this->hexColor;
    }
}
EOF
            )
            ->addFileContents('GasPlanet.php', <<<EOF
<?php

class GasPlanet
{
    private \$diameter;

    private \$mainElement;

    public function __construct(\$mainElement, \$diameter)
    {
        \$this->diameter = \$diameter;
        \$this->mainElement = \$mainElement;
    }

    public function getRadius()
    {
        return \$this->diameter / 2;
    }

    public function getHexColor()
    {
        // a "fake" map of elements to colors
        switch (\$this->mainElement) {
            case 'ammonia':
                return '663300';
            case 'hydrogen':
            case 'helium':
                return 'FFFF66';
            case 'methane':
                return '0066FF';
            default:
                return '464646';
        }
    }
}
EOF
            )
            ->addFileContents('PlanetRenderer.php', <<<EOF
<?php

class PlanetRenderer
{
    public function render(SolidPlanet \$planet)
    {
        return sprintf(
            '<div style="width: %spx; height: %spx; border-radius: %spx; background-color: #%s;"></div>',
            \$planet->getRadius() * 2,
            \$planet->getRadius() * 2,
            \$planet->getRadius(),
            \$planet->getHexColor()
        );
    }
}
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'AbstractPlanet.php';
require 'SolidPlanet.php';
require 'GasPlanet.php';
require 'PlanetRenderer.php';

\$planets = array(
    new SolidPlanet(10, 'CC66FF'),
    new SolidPlanet(50, '00FF99'),
    new GasPlanet('ammonia', 100),
    new GasPlanet('methane', 150),
);

\$renderer = new PlanetRenderer();

foreach (\$planets as \$planet) {
    echo \$renderer->render(\$planet);
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
        if (!class_exists('\AbstractPlanet')) {
            throw new GradingException('Class `AbstractPlanet` does not exist! Did you create it?');
        }
        $abstractPlanetClass = new \ReflectionClass('\AbstractPlanet');
        if (!$abstractPlanetClass->isAbstract()) {
            throw new GradingException('Class `AbstractPlanet` should be declared as abstract.');
        }
        if (!$abstractPlanetClass->hasMethod('getRadius')) {
            throw new GradingException('Method `getRadius` does not exist in the `AbstractPlanet` class.');
        }
        if (!$abstractPlanetClass->getMethod('getRadius')->isAbstract()) {
            throw new GradingException('Method `getRadius` should be declared as abstract.');
        }
        if (!$abstractPlanetClass->hasMethod('getHexColor')) {
            throw new GradingException('Method `getHexColor` does not exist in the `AbstractPlanet` class.');
        }
        if (!$abstractPlanetClass->getMethod('getHexColor')->isAbstract()) {
            throw new GradingException('Method `getHexColor` should be declared as abstract.');
        }
        $solidPlanet = new \ReflectionClass('SolidPlanet');
        if (!$solidPlanet->isSubclassOf('\AbstractPlanet')) {
            throw new GradingException('Class `SolidPlanet` should inherit the `AbstractPlanet` one.');
        }
        $gasPlanet = new \ReflectionClass('GasPlanet');
        if (!$gasPlanet->isSubclassOf('\AbstractPlanet')) {
            throw new GradingException('Class `GasPlanet` should inherit the `AbstractPlanet` one.');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('AbstractPlanet.php', <<<EOF
<?php

abstract class AbstractPlanet
{
    abstract public function getRadius();

    abstract public function getHexColor();
}
EOF
            )
            ->setFileContents('SolidPlanet.php', <<<EOF
<?php

class SolidPlanet extends AbstractPlanet
{
    private \$radius;

    private \$hexColor;

    public function __construct(\$radius, \$hexColor)
    {
        \$this->radius = \$radius;
        \$this->hexColor = \$hexColor;
    }

    public function getRadius()
    {
        return \$this->radius;
    }

    public function getHexColor()
    {
        return \$this->hexColor;
    }
}
EOF
            )
            ->setFileContents('GasPlanet.php', <<<EOF
<?php

class GasPlanet extends AbstractPlanet
{
    private \$diameter;

    private \$mainElement;

    public function __construct(\$mainElement, \$diameter)
    {
        \$this->diameter = \$diameter;
        \$this->mainElement = \$mainElement;
    }

    public function getRadius()
    {
        return \$this->diameter / 2;
    }

    public function getHexColor()
    {
        // a "fake" map of elements to colors
        switch (\$this->mainElement) {
            case 'ammonia':
                return '663300';
            case 'hydrogen':
            case 'helium':
                return 'FFFF66';
            case 'methane':
                return '0066FF';
            default:
                return '464646';
        }
    }
}
EOF
            )
            ->setFileContents('PlanetRenderer.php', <<<EOF
<?php

class PlanetRenderer
{
    public function render(AbstractPlanet \$planet)
    {
        return sprintf(
            '<div style="width: %spx; height: %spx; border-radius: %spx; background-color: #%s;"></div>',
            \$planet->getRadius() * 2,
            \$planet->getRadius() * 2,
            \$planet->getRadius(),
            \$planet->getHexColor()
        );
    }
}
EOF
            )
        ;
    }
}
