# Behat 3 Zend Framework 3 Extension
-----
[![Build Status](https://travis-ci.org/vircom/behat3-zendframework3-extension.svg?branch=master)](https://travis-ci.org/vircom/behat3-zendframework3-extension)
[![Code Coverage](https://scrutinizer-ci.com/g/acelaya/doctrine-enum-type/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/acelaya/doctrine-enum-type/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vircom/behat3-zendframework3-extension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/vircom/behat3-zendframework3-extension/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/vircom/behat3-zendframework3-extension/v/stable.png)](https://packagist.org/packages/vircom/behat3-zendframework3-extension)
[![Total Downloads](https://poser.pugx.org/vircom/behat3-zendframework3-extension/downloads.png)](https://packagist.org/vircom/behat3-zendframework3-extension)
[![License](https://poser.pugx.org/vircom/behat3-zendframework3-extension/license.png)](https://packagist.org/packages/vircom/behat3-zendframework3-extension)

This package provides a base implementation to test applications developed with Zend Framework 3 library. It able to pass to your Behat context files services, declares in your application.

### Installation
```bash
composer require vircom/behat3-zendframework3-extension
```

### Usage
##### Create behat.yml file
Within your project root, create behat.yml file with content below or add this code to your existing file on the root level:

```yml
default:
    extensions:
        VirCom\Behat3ZendFramework3Extension:
            configuration_path: /config/application.config.php
```
**Parameters:**
* configuration_path - path to main Zend Framework 3 configuration file. Default to: /config/application.config.php.


#### Create your feature context file
Just run command:

```bash
vendor/bin/behat --init 
```

Now, Behat generate for your fist context file:
```
features/bootstrap/FeatureContext.php
```

Change its content to:

```php
<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Zend\EventManager\EventManagerInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(EventManagerInterface $eventManager)
    {
        echo get_class($eventManager);
    }
}
```

#### Create example feature file
Put text below to file
```
features/example.feature
```

```
Feature: Product basket
  In order to buy products
  As a customer
  I need to be able to put interesting products into a basket
```

##### Configure service injection within behat.yml file
Configure your context:

```yml
default:
   suites:
        default:
            contexts:
                - FeatureContext:
                    eventManager: '@EventManager'
    extensions:
        VirCom\Behat3ZendFramework3Extension:
            configuration_path: /config/application.config.php
```

Each defined context argument, if starts with `@` character, will be resolved to matching service instance. Otherwise, will return raw parameter as string.

For example it could be registered any custom service:
```
My\Application\Namespace\ExampleService
```