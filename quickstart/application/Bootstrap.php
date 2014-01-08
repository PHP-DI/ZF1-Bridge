<?php

use DI\Bridge\ZendFramework1\Dispatcher;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    /**
     * Initialize the dependency injection container
     */
    protected function _initDependencyInjection()
    {
        $container = \DI\ContainerBuilder::buildDevContainer();

        $dispatcher = new Dispatcher();
        $dispatcher->setContainer($container);

        $frontController = Zend_Controller_Front::getInstance();
        $frontController->setDispatcher($dispatcher);
    }
}
