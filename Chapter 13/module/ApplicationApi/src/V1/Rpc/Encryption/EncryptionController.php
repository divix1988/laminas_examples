<?php
namespace ApplicationApi\V1\Rpc\Encryption;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ApiTools\ContentNegotiation\ViewModel;

class EncryptionController extends AbstractActionController
{
    public function encryptionAction()
    {
        $event = $this->getEvent();
        $inputFilter = $event->getParam('Laminas\ApiTools\ContentValidation\InputFilter');
        $input = $inputFilter->getValue('input');
        
        return new ViewModel([
            $input => sha1($input)
        ]);
    }
}
