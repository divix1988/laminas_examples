<?php

namespace Application\Form;

use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Element;
use Laminas\Validator;
use Application\Form\Validator as CustomValidator;

class UserInfoFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('user_info');
        $this->add(array(
            'name' => 'gender',
            'type' => Element\Radio::class,
            'options' => array(
                'label' => 'Gender',
                'value_options' => [
                    'male' => 'Male',
                    'female' => 'Female',
                ]
            ),
            'attributes' => array(
                'required' => 'required'
            ),
        ));
        
        $this->add(array(
            'name' => 'education',
            'type' => Element\Select::class,
            'options' => array(
                'label' => 'Education',
                'value_options' => [
                    'primary' => 'Primary',
                    'college' => 'Secondary',
                    'highschool' => 'High school',
                    'graduate' => 'Graduate'
                ]
            ),
            'attributes' => array(
                'required' => 'required'
            ),
        ));

        $this->add(array(
            'name' => 'hobby',
            'type' => Element\MultiCheckbox::class,
            'options' => array(
                'label' => 'Interests',
                'value_options' => [
                    'books' => 'Books',
                    'sport' => 'Sport',
                    'movies' => 'Movies',
                    'music' => 'Music'
                ]
            )
        ));

        $this->add(array(
            'name' => 'comments',
            'type' => Element\Textarea::class,
            'options' => array(
                'label' => 'Comments'
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
	return array(
            'gender' => array(
                'required' => true,
                'validators' => [$this->getAlphaValidator()]
            ),
            'education' => array(
                'required' => true,
                'validators' => [$this->getAlphaValidator()]
            ),
            'hobby' => array(
                'required' => true
            ),
            'comments' => array(
                'required' => true
            )
	);
    }

    private function getAlphaValidator()
    {
	return [
            'name' => CustomValidator\Alpha::class
	];
    }
}

