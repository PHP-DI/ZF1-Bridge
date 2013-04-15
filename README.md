# Zend Framework Quickstart with PHP-DI

This project is the [Zend Framework quickstart](http://framework.zend.com/manual/en/learning.quickstart.intro.html)
configured with [PHP-DI](http://github.com/mnapoli/PHP-DI) (version 3.0).

[PHP-DI](http://github.com/mnapoli/PHP-DI) is a Dependency Injection Container for PHP.

To run the project, get [composer](http://getcomposer.org/doc/00-intro.md):

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install


**Note**: I tried not to diverge too much from the official quickstart. So the code may look messy, but that's
how the ZF quickstart is ;)

## Differences

Here is a short summary of what's different with the official ZF quickstart:

Composer:

    {
        "require": {
            "mnapoli/php-di": "3.*"
        }
    }

Bootstrap:

    /**
     * Initialize the dependency injection container
     */
    protected function _initDependencyInjection()
    {
        $container = new \DI\Container();
        Zend_Registry::set('container', $container);
    }

Controllers:

Use the `get()` action helper:

    $guestbookService = $this->get('Application_Service_GuestbookService');

**Note**: As presented, the container is used as a Service Locator in the controllers because we use `get()` (but not in the services).
The Service Locator is considered to be an anti-pattern because it introduces a dependency to the container,
but in Zend Framework 1 it is very complicated to do otherwise due to how controllers are instantiated.

However, this shouldn't be too much of a problem if you don't unit test your controllers (you shold do integrations test however)
and if you have a correct service layer (i.e. logic code is in the models and in the services, not in the controllers).

Keep in mind that Zend Framework 2 and Symfony 2 both propose the same functionnality (container as a service locator in controllers).
