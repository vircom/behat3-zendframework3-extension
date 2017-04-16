<?php
declare(strict_types=1);
namespace spec\VirCom\Behat3ZendFramework3Extension\ServiceContainer;

use VirCom\Behat3ZendFramework3Extension\ServiceContainer\Behat3ZendFramework3Extension;

use Behat\Testwork\ServiceContainer\Extension;

use PhpSpec\ObjectBehavior;

use Prophecy\Argument;

class Behat3ZendFramework3ExtensionSpec extends ObjectBehavior
{
    public function it_should_be_behat3_zend_framework_extension()
    {
        $this->shouldHaveType(Behat3ZendFramework3Extension::class);
        $this->shouldImplement(Extension::class);
    }
    
    public function it_should_return_config_key()
    {
        $this->getConfigKey()
            ->shouldReturn(Behat3ZendFramework3Extension::SERVICE_CONTAINER_NAME);
    }
}
