<?php

namespace Application\Controller;

class PollingController extends AbstractController
{
    private $pollsLibrary;
    public function __construct($pollsLibrary)
    {
        $this->pollsLibrary = $pollsLibrary;
    }
    public function indexAction()
    {
    }
    public function manageAction()
    {
        return [
            'polls' => $this->pollsLibrary->getAll()
        ];
    }
    public function viewAction()
    {
        $pollForm = $this->pollsLibrary->getForm();
        $viewParams = [
            'poll' => $this->pollsLibrary->getActive(),
            'form' => $pollForm
        ];
        return $viewParams;
    }
    public function activateAction()
    {
        $id = $this->params()->fromRoute('id');
        $this->pollsLibrary->activate($id);
        $this->redirect()->toRoute('polling', ['action' => 'manage']);
    }
}
