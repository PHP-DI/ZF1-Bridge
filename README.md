# Zend Framework Quickstart with PHP-DI (Dependency Injection)

This project is an update of the [Zend Framework quickstart](http://framework.zend.com/manual/en/learning.quickstart.intro.html)
with [PHP-DI](http://github.com/mnapoli/PHP-DI) configured (version 3.0).

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
