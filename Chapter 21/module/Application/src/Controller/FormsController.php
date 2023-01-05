<?php

namespace Application\Controller;

use Application\Form\UserForm;

class FormsController extends AbstractController
{
    public function indexAction()
    {
        $userForm = new UserForm(
            'user_form',
            [
                'baseUrl' => $this->baseUrl
            ]
        );
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $userForm];
        }
        $userForm->setData($request->getPost());

        if (!$userForm->isValid()) {
            return ['form' => $userForm];
        }
        //some our logic
        return [
            'form' => $userForm
        ];
    }
}

