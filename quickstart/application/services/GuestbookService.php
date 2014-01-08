<?php

class Application_Service_GuestbookService
{
    /**
     * @Inject
     * @var Application_Model_GuestbookMapper
     */
    private $guestbookMapper;

    public function getAllEntries()
    {
        return $this->guestbookMapper->fetchAll();
    }

    public function addEntry($fields)
    {
        $comment = new Application_Model_Guestbook($fields);
        $this->guestbookMapper->save($comment);
    }
}
