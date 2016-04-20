<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class UserFieldset extends Fieldset implements InputFilterProviderInterface
{

    /**
     * 
     * @var string
     */
    protected $username;

    public function __construct($name = null, $options = [], $username)
    {
        parent::__construct('user', $options);

        $this->username = $username;
    }

    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add(
            [
                'name' => 'username',
                'type' => 'text',
                'options' => [
                    'label' => _('username'),
                    'label_attributes' => [
                        'class' => 'col-md-6'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'readonly' => 'readonly',
                    'value' => $this->username
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'username' => [
                'required' => true
            ]
        ];
    }

}
