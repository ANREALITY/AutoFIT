<?php
namespace FileTransferRequest\Factory;

use Zend\ServiceManager\FactoryInterface;
use FileTransferRequest\Form\BillingFieldset;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\ServiceLocatorInterface;
use FileTransferRequest\Form\FileTransferRequestForm;

class FileTransferRequestFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new FileTransferRequestForm();
        $billingFieldset = $serviceLocator->get('FileTransferRequest\Form\BillingFieldset');
        $sourceFieldset = $serviceLocator->get('FileTransferRequest\Form\SourceFieldset');
        $targetFieldset = $serviceLocator->get('FileTransferRequest\Form\TargetFieldset');

        $form->add(array(
            'name' => 'billing',
            'type' => 'FileTransferRequest\Form\BillingFieldset',
            'options' => array(),
            'use_as_base_fieldset' => true
            // 'targetObject' =>
        ));
        $form->add(array(
            'type' => 'FileTransferRequest\Form\SourceFieldset',
            'name' => 'source',
        ));
        $form->add(array(
            'type' => 'FileTransferRequest\Form\TargetFieldset',
            'name' => 'target',
        ));
        $form->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => _('send')
            ),
        ));

        return $form;
    }
}
