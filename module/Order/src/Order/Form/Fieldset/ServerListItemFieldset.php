<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class ServerListItemFieldset extends AbstractServerFieldset
{

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'name' => [
                'required' => false,
                'allow_empty' => true,
                'validators' => [
                    [
                        'name' => 'MasterData\Validator\Db\ServerNotInUseForCd',
                        'options' => [
                            'adapter' => $this->dbAdapter,
                        ],
                    ]
                ]
            ]
        ];
        return array_merge_recursive(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

}
