<?php

namespace Challenges\Interfaces;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class ImplementPlanetInterfaceCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
After watching this last episode, you realize that `AbstractPlanet` should really
be an interface. I've given you a head start by creating the `PlanetInterface`.
Now, update all of your code to use it and get these planets rendering again!
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('PlanetInterface.php', <<<EOF
<?php

interface PlanetInterface
{
    /**
     * Return the radius if the planet, in thousands of kilometers.
     *
     * @return integer
     */
    public function getRadius();

    /**
     * Return the hex color (without the #) for the planet.
     *
     * @return string
     */
    public function getHexColor();
}
EOF
            )
            ->addFileContents('SolidPlanet.php', <<<EOF
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
            ->addFileContents('GasPlanet.php', <<<EOF
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
            ->addFileContents('PlanetRenderer.php', <<<EOF
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
            ->addFileContents('index.php', <<<EOF
<?php

require 'PlanetInterface.php';
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
        $solidPlanetClass = new \ReflectionClass('\SolidPlanet');
        if (!$solidPlanetClass->implementsInterface('\PlanetInterface')) {
            throw new GradingException(
                'Class `SolidPlanet` should implement the `PlanetInterface` interface.'
            );
        }
        $gasPlanetClass = new \ReflectionClass('\GasPlanet');
        if (!$gasPlanetClass->implementsInterface('\PlanetInterface')) {
            throw new GradingException(
                'Class `GasPlanet` should implement the `PlanetInterface` interface.'
            );
        }

    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('SolidPlanet.php', <<<EOF
<?php

class SolidPlanet implements PlanetInterface
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

class GasPlanet implements PlanetInterface
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
    public function render(PlanetInterface \$planet)
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
