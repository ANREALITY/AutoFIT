<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class IncludeParameterSetFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('include_parameter_set', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'include_parameters',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('include parameters'),
                    'count' => 1,
                    'should_create_template' => true,
                    'template_placeholder' => '__index__',
                    'allow_add' => true,
                    'target_element' => array(
                        'type' => 'Order\Form\Fieldset\IncludeParameter'
                    ),
                    'label_attributes' => [
                        'class' => 'col-md-12 required include-parameters'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'add_include_parameter',
                'type' => 'button',
                'options' => [
                    'label' => _('+')
                ],
                'attributes' => [
                    'class' => 'btn btn-default button-add',
                    'id' => 'add-include-parameter-button',
                    'value' => _('add an include parameter')
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
