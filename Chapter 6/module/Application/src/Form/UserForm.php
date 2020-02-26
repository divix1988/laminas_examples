<?php

namespace Application\Form;

class UserForm extends \Laminas\Form\Form
{
    public function __construct($name = 'user')
    {
        parent::__construct($name);
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
