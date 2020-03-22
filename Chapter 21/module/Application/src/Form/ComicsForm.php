<?php

namespace Application\Form;

use Laminas\Form\Element;

class ComicsForm extends \Laminas\Form\Form
{
    public function __construct($name = 'comics')
    {
        parent::__construct($name);
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title'
            ]
        ]);

        $this->add([
            'name' => 'thumb',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Thumbnail'
            ],
            'attributes' => array(
                'required' => 'required'
            )
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
            ]
        ]);
    }
}
