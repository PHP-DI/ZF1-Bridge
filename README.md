# PHP-DI integration with Zend Framework 1

This library provides integration for PHP-DI with Zend Framework 1.

This project also contains the [Zend Framework quickstart](http://framework.zend.com/manual/en/learning.quickstart.intro.html)
configured with [PHP-DI](http://github.com/mnapoli/PHP-DI).

[PHP-DI](http://github.com/mnapoli/PHP-DI) is a Dependency Injection Container for PHP.

## Use

Require the libraries with Composer:

```json
{
    "require": {
        "mnapoli/php-di": "*",
        "mnapoli/php-di-zf1": "*"
    }
}
```

To use PHP-DI in your ZF1 application, you need to change the Dispatcher used by the Front Controller in the Bootstrap.

```php
    /**
     * Initialize the dependency injection container
     */
    protected function _initDependencyInjection()
	{
		$container = new \DI\Container();

        $dispatcher = new \DI\ZendFramework1\Dispatcher();
        $dispatcher->setContainer($container);

        $frontController = Zend_Controller_Front::getInstance();
        $frontController->setDispatcher($dispatcher);
	}
```

That's it!

Now you can inject dependencies in your controllers!

For example, here is the GuestbookController of the quickstart:

```php
use DI\Annotation\Inject;

class GuestbookController extends Zend_Controller_Action
{
    /**
     * This dependency will be injected by PHP-DI
     * @Inject
     * @var Application_Service_GuestbookService
     */
    private $guestbookService;

    public function indexAction()
    {
        $this->view->entries = $this->guestbookService->getAllEntries();
    }

    public function signAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Guestbook();

        if ($this->getRequest()->isPost() && $form->isValid($request->getPost())) {
            $this->guestbookService->addEntry($form->getValues());
            return $this->_helper->redirector('index');
        }

        $this->view->form = $form;
    }

}
```

## Quickstart

The quickstart is in the `quickstart/` folder. You can look at it to see how PHP-DI can be integrated to a ZF1 application.

To run the quickstart, get [composer](http://getcomposer.org/doc/00-intro.md) and install the dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install

**Note**: I tried not to diverge too much from the official quickstart. So the code may look messy, but that's
how the ZF quickstart is ;)
