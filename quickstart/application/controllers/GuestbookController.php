<?php

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
