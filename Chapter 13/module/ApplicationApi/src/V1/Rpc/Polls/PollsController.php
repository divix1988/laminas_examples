<?php
namespace ApplicationApi\V1\Rpc\Polls;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ApiTools\ContentNegotiation\ViewModel;

class PollsController extends AbstractActionController
{
    private $pollsLibrary;

    public function __construct($pollsLibrary)
    {
        $this->pollsLibrary = $pollsLibrary;
    }
    public function pollsAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            exit($this->pollsLibrary->getActiveInJson());
        }
        $inputFilter = $this->getEvent()->getParam('Laminas\ApiTools\ContentValidation\InputFilter');
        $answer = $inputFilter->getValue('answer');
        $csrf = $inputFilter->getValue('csrf');
        $response = false;
        $message = null;
        $pollForm = $this->pollsLibrary->getForm();
        $pollForm->setData(['answer' => $answer, 'csrf_field' => $csrf]);

        if (!$pollForm->isValid()) {
            $message = 'Incorrectly completed form';
        } else {
            if ($this->pollsLibrary->canVote($answer)) {
                $this->pollsLibrary->addVote($answer);
                $response = true;
            } elseif (!is_null($this->pollsLibrary->getMessage())) {
                $message = $this->pollsLibrary->getMessage();
            }
        }
        return new ViewModel([
            'success' => $response,
            'message' => $message
        ]);
    }
}

