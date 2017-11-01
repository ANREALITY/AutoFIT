<?php
namespace Order\Form\Fieldset;

use MasterData\Validator\Db\ServerNotInUseForCd;

class ServerListItemFieldset extends AbstractServerFieldset
{

    public function getInputFilterSpecification()
    {
        $ServerNotInUseForCdValidator = new ServerNotInUseForCd([
            'adapter' => $this->dbAdapter,
            'entityManager' => $this->entityManager
        ]);

        $inputFilterSpecification = [
            'name' => [
                'required' => false,
                'allow_empty' => true,
                'validators' => [
                    $ServerNotInUseForCdValidator
                ]
            ]
        ];
        return array_merge_recursive(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

}
