<?php
declare(strict_types=1);
namespace spec\VirCom\Behat3ZendFramework3Extension\Context\Argument;

use VirCom\Behat3ZendFramework3Extension\Context\Argument\ArgumentResolver;

use Zend\Mvc\ApplicationInterface;
use Zend\ServiceManager\ServiceManager;

use Behat\Behat\Context\Argument\ArgumentResolver as ArgumentResolverInterface;

use ReflectionClass;

use PhpSpec\ObjectBehavior;

class ArgumentResolverSpec extends ObjectBehavior
{
    /**
     * @var ApplicationInterface
     */
    protected $application;
    
    public function let(
        ApplicationInterface $application
    ) {
        $this->application = $application;
        $this->beConstructedWith($this->application);
    }
    
    public function it_should_be_argument_resolver()
    {
        $this->shouldHaveType(ArgumentResolver::class);
        $this->shouldImplement(ArgumentResolverInterface::class);
    }
    
    public function it_should_resolve_arguments(
            ReflectionClass $reflectionClass,
       ServiceManager $serviceManager
    ) {
        $arguments = [
            '@Config',
            '@My\Example\Service',
            '1',
            'simple string',
        ];
        
        $result = [
            '@Config@',
            '@My\Example\Service@',
            '1',
            'simple string',
        ];
        
        $this->application->getServiceManager()
            ->shouldBeCalled()
            ->willReturn($serviceManager);
        
        $serviceManager->has()
            ->shouldBeCalled()
            ->withArguments([
                substr($arguments[0], 1),
            ])
            ->willReturn(true);
        
        $serviceManager->get()
            ->shouldBeCalled()
            ->withArguments([
                substr($arguments[0], 1),
            ])
            ->willReturn($result[0]);
        
        $serviceManager->has()
            ->shouldBeCalled()
            ->withArguments([
                substr($arguments[1], 1),
            ])
            ->willReturn(true);
        
        $serviceManager->get()
            ->shouldBeCalled()
            ->withArguments([
                substr($arguments[1], 1),
            ])
            ->willReturn($result[1]);
        
        $this->resolveArguments($reflectionClass, $arguments)
            ->shouldReturn($result);
    }
}
