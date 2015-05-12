<?php
/**
 * PHP-DI
 *
 * @link      http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace UnitTests\DI;

use DI\ContainerBuilder;
use DI\Bridge\ZendFramework1\Dispatcher;

/**
 * Test class for Dispatcher
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetContainer()
    {
        $container = ContainerBuilder::buildDevContainer();

        $dispatcher = new Dispatcher();
        $dispatcher->setContainer($container);

        $this->assertSame($container, $dispatcher->getContainer());
    }

    public function testDispatch()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->setControllerDirectory( __DIR__ . '/Fixtures');

        $valueDependency = new \stdClass();

        $container = ContainerBuilder::buildDevContainer();
        $container->set("SomeName", $valueDependency);

        $dispatcher->setContainer($container);


        $request = new \Zend_Controller_Request_Simple();
        $request->setControllerName("mock");
        $request->setActionName("method");

        $response = new \Zend_Controller_Response_Http();

        $dispatcher->dispatch($request, $response);

        $this->assertEquals("a value", $valueDependency->somedata);
    }
}
