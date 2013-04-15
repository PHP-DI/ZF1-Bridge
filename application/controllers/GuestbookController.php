<?php

class GuestbookController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $guestbookService = $this->get('Application_Service_GuestbookService');

        $this->view->entries = $guestbookService->getAllEntries();
    }

    public function signAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Guestbook();

        if ($this->getRequest()->isPost() && $form->isValid($request->getPost())) {
            $guestbookService = $this->get('Application_Service_GuestbookService');

            $guestbookService->addEntry($form->getValues());
            return $this->_helper->redirector('index');
        }

        $this->view->form = $form;
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function get($name)
    {
        /** @var $container \DI\Container */
        $container = Zend_Registry::get('container');

        return $container->get($name);
    }

}
