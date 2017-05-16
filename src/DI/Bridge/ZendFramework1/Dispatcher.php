<?php
/**
 * PHP-DI
 *
 * @link      http://php-di.org/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace DI\Bridge\ZendFramework1;

use DI\Container;
use Exception;
use Zend_Controller_Action;
use Zend_Controller_Action_Interface;
use Zend_Controller_Dispatcher_Exception;
use Zend_Controller_Dispatcher_Standard;
use Zend_Controller_Request_Abstract;
use Zend_Controller_Response_Abstract;

/**
 * Zend Framework 1 dispatcher.
 *
 * Provides integration with Zend Framework 1.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Dispatcher extends Zend_Controller_Dispatcher_Standard
{
    /**
     * @var Container
     */
    private $container;

    /**
     * {@inheritdoc}
     *
     * The body of this method is a copy-paste of the parent class
     */
    public function dispatch(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response)
    {
        $this->setResponse($response);

        /**
         * Get controller class
         */
        if (!$this->isDispatchable($request)) {
            $controller = $request->getControllerName();
            if (!$this->getParam('useDefaultControllerAlways') && !empty($controller)) {
                throw new Zend_Controller_Dispatcher_Exception('Invalid controller specified (' . $request->getControllerName() . ')');
            }

            $className = $this->getDefaultControllerClass($request);
        } else {
            $className = $this->getControllerClass($request);
            if (!$className) {
                $className = $this->getDefaultControllerClass($request);
            }
        }

        /**
         * If we're in a module or prefixDefaultModule is on, we must add the module name
         * prefix to the contents of $className, as getControllerClass does not do that automatically.
         * We must keep a separate variable because modules are not strictly PSR-0: We need the no-module-prefix
         * class name to do the class->file mapping, but the full class name to insantiate the controller
         */
        $moduleClassName = $className;
        if (($this->_defaultModule != $this->_curModule)
            || $this->getParam('prefixDefaultModule'))
        {
            $moduleClassName = $this->formatClassName($this->_curModule, $className);
        }

        /**
         * Load the controller class file
         */
        $className = $this->loadClass($className);

        $controller = new $moduleClassName($request, $this->getResponse(), $this->getParams());

        // Code edited for PHP-DI
        // -----------------------------------------------
        // Inject the dependencies on the controller
        $this->container->injectOn($controller);
        // -----------------------------------------------

        if (!($controller instanceof Zend_Controller_Action_Interface) &&
            !($controller instanceof Zend_Controller_Action)) {
            require_once 'Zend/Controller/Dispatcher/Exception.php';
            throw new Zend_Controller_Dispatcher_Exception(
                'Controller "' . $moduleClassName . '" is not an instance of Zend_Controller_Action_Interface'
            );
        }

        /**
         * Retrieve the action name
         */
        $action = $this->getActionMethod($request);

        /**
         * Dispatch the method call
         */
        $request->setDispatched(true);

        // by default, buffer output
        $disableOb = $this->getParam('disableOutputBuffering');
        $obLevel   = ob_get_level();
        if (empty($disableOb)) {
            ob_start();
        }

        try {
            $controller->dispatch($action);
        } catch (Exception $e) {
            // Clean output buffer on error
            $curObLevel = ob_get_level();
            if ($curObLevel > $obLevel) {
                do {
                    ob_get_clean();
                    $curObLevel = ob_get_level();
                } while ($curObLevel > $obLevel);
            }
            throw $e;
        }

        if (empty($disableOb)) {
            $content = ob_get_clean();
            $response->appendBody($content);
        }

        // Destroy the page controller instance and reflection objects
        $controller = null;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
