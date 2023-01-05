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
            'name' => 'apctha',
            'type' => Element\Captcha::class,
            'options' => [
                'label' => 'Rewrite Captcha text:',
                'captcha' => new \Laminas\Captcha\Image([
                    'name' => 'myCaptcha',
                    'messages' => array(
                        'badCaptcha' => 'incorrectly rewritten image text'
                    ),
                    'wordLen' => 5,
                    'timeout' => 100,
                    'font' => APPLICATION_PATH.'/public/fonts/arbli.ttf',
                    'imgDir' => APPLICATION_PATH.'/public/img/captcha/',
                    'imgUrl' => $this->getOption('baseUrl').'/public/img/captcha/',
                    'lineNoiseLevel' => 4,
                    'width' => 200,
                    'height' => 70
                ]),
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
