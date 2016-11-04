<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AccessConfigSetFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('access_config_set', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'access_configs',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('access configurations'),
                    'count' => 1,
                    'should_create_template' => true,
                    'template_placeholder' => '__index__',
                    'allow_add' => true,
                    'target_element' => array(
                        'type' => 'Order\Form\Fieldset\AccessConfig'
                    ),
                    'label_attributes' => [
                        'class' => 'col-md-12 required access-configs'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'add_access_config',
                'type' => 'button',
                'options' => [
                    'label' => _('+')
                ],
                'attributes' => [
                    'class' => 'btn btn-default add-access-config-button button-add',
                    'value' => _('add an access config')
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
