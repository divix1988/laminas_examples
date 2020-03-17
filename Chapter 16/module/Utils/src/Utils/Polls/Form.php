<?php
namespace Utils\Polls;

use Laminas\Form\Element;

class Form extends \Zend\Form\Form
{
    public function __construct(array $answers)
    {
        parent::__construct('poll');
        $this->add([
            'name' => 'csrf_field',
            'type' => 'csrf',
            'options' => [
                'salt' => 'unique',
                'timeout' => 300 //5 minutes
            ],
            'attributes' => array(
                'id' => 'csrf_field'
             )
        ]);
        
        $this->add(array(
             'name' => 'answer',
             'type' => Element\Radio::class,
             'options' => array(
                'value_options' => $answers
             ),
             'attributes' => array(
                 'required' => 'required'
             )
         ));
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Vote',
                'id'    => 'vote',
                'class' => 'btn btn-primary'
            ]
        ]);
        $this->setAttribute('method', 'POST');
    }
}