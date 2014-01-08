<?php

use DI\Annotation\Inject;

class MockController extends Zend_Controller_Action
{
    /**
     * @Inject(name="SomeName")
     * @var stdClass
     */
    public $namedDependency;

    public function methodAction()
    {
        $this->namedDependency->somedata = "a value";
    }
}
