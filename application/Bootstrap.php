<?php

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
		$container = new \DI\Container();

        Zend_Registry::set('container', $container);
	}
}

