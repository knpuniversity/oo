<?php

namespace Challenges\PdoShipStorage;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;
use KnpU\ActivityRunner\Activity\Exception\GradingException;

class DecomposeStringTransformerCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Tired from working on the DeathStar, you challenged the intern (let's call him
"Bob") to create a class that can reverse a string and upper case every other letter.
"Ha!" John says, "This is simple!". To show off, John creates the `StringTransformer`
class and *even* makes it cache the results to be super-performant.

But wait you say! Combining the string transformation *and* caching into the same
class make `StringTransformer` responsible for two jobs. Help show Bob the intern
a better way, by creating a new `Cache` class with two methods `fetchFromCache(\$key)`
and `saveToCache(\$key, \$val)`. Then, pass this into `StringTransformer` and use it
to cache, instead of using your own logic:
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder
            ->addFileContents('Cache.php', <<<EOF
EOF
            )
            ->addFileContents('StringTransformer.php', <<<EOF
<?php

class StringTransformer
{
    public function transformString(\$str)
    {
        \$cacheFile = __DIR__.'/cache/'.md5(\$str);

        if (file_exists(\$cacheFile)) {
            return file_get_contents(\$cacheFile);
        }

        \$newStr = '';
        foreach (str_split(strrev(\$str), 2) as \$twoChars) {
            // capitalize the first of 2 characters
            \$newStr .= ucfirst(\$twoChars);
        }

        if (!file_exists(dirname(\$cacheFile))) {
            mkdir(dirname(\$cacheFile));
        }
        file_put_contents(\$cacheFile, \$newStr);

        return \$newStr;
    }
}
EOF
            )
            ->addFileContents('index.php', <<<EOF
<?php

require 'Cache.php';
require 'StringTransformer.php';

\$str = 'Judge me by my size, do you?';

\$transformer = new StringTransformer();
var_dump(\$transformer->transformString(\$str));
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
        if (!class_exists('\Cache')) {
            throw new GradingException('Class `Cache` does not exist. Did you create it?');
        }
        $cacheClass = new \ReflectionClass('\Cache');
        if (!$cacheClass->hasMethod('fetchFromCache')) {
            throw new GradingException('Method `fetchFromCache` does not exist in the `Cache` class.');
        }

        if (!$cacheClass->hasMethod('saveToCache')) {
            throw new GradingException('Method `saveToCache` does not exist in the `Cache` class.');
        }

        $result->assertVariableExists('transformer', 'I don\'t see the $transformer variable in index.php anymore - did you delete it?');
        $transformer = $result->getDeclaredVariableValue('transformer');
        $transformerClass = new \ReflectionObject($transformer);

        if (!$transformerClass->hasMethod('__construct')) {
            throw new GradingException('Make sure you give the `StringTransformer` class a `__construct()`. It should have one argument: a `Cache` object.');
        }

        $result->assertInputDoesNotContain(
            'StringTransformer.php',
            'file_get_contents',
            'I still see `file_get_contents()` inside of `StringTransformer`. Make sure you\'ve moved all of the caching logic into the Cache class'
        );

        // todo - create a mocked Cache, pass it into
        // $transformer and assert that its cache methods are called
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('Cache.php', <<<EOF
<?php

class Cache
{
    public function fetchFromCache(\$key)
    {
        \$cacheFile = \$this->getCacheFilename(\$key);

        if (file_exists(\$cacheFile)) {
            return file_get_contents(\$cacheFile);
        }

        return false;
    }

    public function saveToCache(\$key, \$val)
    {
        \$cacheFile = \$this->getCacheFilename(\$key);

        if (!file_exists(dirname(\$cacheFile))) {
            mkdir(dirname(\$cacheFile));
        }

        return file_put_contents(\$cacheFile, \$val);
    }

    /**
     * Extra credit private method to avoid duplication
     */
    private function getCacheFilename(\$key)
    {
        return __DIR__.'/cache/'.md5(\$key);
    }
}
EOF
            )
            ->setFileContents('StringTransformer.php', <<<EOF
<?php

class StringTransformer
{
    private \$cache;

    public function __construct(Cache \$cache)
    {
        \$this->cache = \$cache;
    }

    public function transformString(\$str)
    {
        if (\$result = \$this->cache->fetchFromCache(\$str)) {
            return \$result;
        }

        \$newStr = '';
        foreach (str_split(strrev(\$str), 2) as \$twoChars) {
            // capitalize the first of 2 characters
            \$newStr .= ucfirst(\$twoChars);
        }

        \$this->cache->saveToCache(\$str, \$newStr);

        return \$newStr;
    }
}
EOF
            )
            ->setFileContents('index.php', <<<EOF
<?php

require 'Cache.php';
require 'StringTransformer.php';

\$str = 'Judge me by my size, do you?';

\$transformer = new StringTransformer(new Cache());
var_dump(\$transformer->transformString(\$str));
EOF
            )
        ;
    }
}
