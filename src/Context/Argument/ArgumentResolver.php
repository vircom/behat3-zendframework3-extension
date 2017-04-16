<?php
declare(strict_types=1);
namespace VirCom\Behat3ZendFramework3Extension\Context\Argument;

use Behat\Behat\Context\Argument\ArgumentResolver as ArgumentResolverInterface;

use Zend\Mvc\ApplicationInterface;

use ReflectionClass;

class ArgumentResolver implements
    ArgumentResolverInterface
{
    /**
     * @var ApplicationInterface
     */
    protected $application;

    /**
     * @param ApplicationInterface $application
     */
    public function __construct(
        ApplicationInterface $application
    ) {
        $this->application = $application;
    }

    /**
     * @param ReflectionClass $classReflection
     * @param array $arguments
     * @return array
     *
     * @SuppressWarnings("unused")
     */
    public function resolveArguments(
        ReflectionClass $classReflection,
        array $arguments
    ): array {
        $result = [];

        foreach ($arguments as $key => $name) {
            $result[$key] = $this->resolveArgument($name);
        }

        return $result;
    }

    /**
     * @param string $argument
     * @return mixed
     */
    protected function resolveArgument(
        string $argument
    ) {
        if (substr($argument, 0, 1) === "@") {
            return $this->application
                ->getServiceManager()
                ->get(substr($argument, 1));
        }

        return $argument;
    }
}
