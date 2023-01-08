<?php

namespace Application\Form;

use Laminas\Form\Element;

class UserForm extends \Laminas\Form\Form
{
    public function __construct($name = 'user', array $params = [])
    {
        parent::__construct($name, $params);
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'username',
            'type' => 'text',
            'options' => [
                'label' => 'Username'
            ]
        ]);
        $this->add([
            'name' => 'email',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'Email Address'
            ],
            'attributes' => array(
                'required' => 'required'
            )
        ]);
        $this->add([
            'type' => UserInfoFieldset::class,
            'name' => 'user_info',
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id' => 'saveUserForm'
            ]
        ]);
        //by default it’s also POST
        $this->setAttribute('method', 'POST');
    }
}
