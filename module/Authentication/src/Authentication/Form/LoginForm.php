<?php
namespace Authentication\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect user's login, password and 'Remember Me' flag.
 */
class LoginForm extends Form
{

    /**
     * LoginForm constructor.
     */
    public function __construct()
    {
        parent::__construct('login-form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * @return void
     */
    protected function addElements() 
    {
        $this->add([
            'type'  => 'text',
            'name' => 'username',
            'options' => [
                'label' => 'Your username',
            ],
        ]);

        $this->add([
            'type'  => 'hidden',
            'name' => 'redirect_url'
        ]);

        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                'timeout' => 600
                ]
            ],
        ]);

        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Sign in',
                'id' => 'submit',
            ],
        ]);
    }

    /**
     * @return void
     */
    private function addInputFilter() 
    {
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
                'name'     => 'username',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 64
                        ],
                    ],
                ],
            ]);

        $inputFilter->add([
                'name'     => 'redirect_url',
                'required' => false,
                'filters'  => [
                    ['name'=>'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 0,
                            'max' => 2048
                        ]
                    ],
                ],
            ]);
    }        

}
