<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FileParameterSetFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('file_parameter_set', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'file_parameters',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('file parameters'),
                    'count' => 1,
                    'should_create_template' => true,
                    'template_placeholder' => '__index__',
                    'allow_add' => true,
                    'target_element' => array(
                        'type' => 'Order\Form\Fieldset\FileParameter'
                    ),
                    'label_attributes' => [
                        'class' => 'col-md-12 file-parameters'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'add_file_parameter',
                'type' => 'button',
                'options' => [
                    'label' => _('+')
                ],
                'attributes' => [
                    'class' => 'btn btn-default button-add',
                    'id' => 'add-file-parameter-button',
                    'value' => _('add an file parameter')
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
