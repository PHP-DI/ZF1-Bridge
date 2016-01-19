# PHP-DI integration with Zend Framework 1

This library provides integration for PHP-DI with Zend Framework 1. [PHP-DI](http://php-di.org) is a Dependency Injection Container for PHP.

This project also contains the [Zend Framework quickstart](http://framework.zend.com/manual/en/learning.quickstart.intro.html)
configured with [PHP-DI](http://php-di.org).

If you are looking for Zend Framework 2 integration, head over [here](https://github.com/PHP-DI/ZF2-Bridge).

## Documentation

**The full documentation is available on [PHP-DI's website](http://php-di.org/doc/frameworks/zf1.html).**

## Zend Framework quickstart

The quickstart is in the `quickstart/` folder. You can look at it to see how PHP-DI can be integrated to a ZF1 application.

To run the quickstart, get [composer](http://getcomposer.org/doc/00-intro.md) and install the dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install

Please be aware that the quickstart uses [annotations](http://php-di.org/doc/annotations.html). Since PHP-DI 5 annotations are disabled by default, please follow [the installation instructions to enable them](http://php-di.org/doc/annotations.html).

**Note**: I tried not to diverge too much from the official quickstart. So the code may look messy, but that's
how the ZF quickstart is ;)

## Change log

See https://github.com/PHP-DI/ZF1-Bridge/releases
