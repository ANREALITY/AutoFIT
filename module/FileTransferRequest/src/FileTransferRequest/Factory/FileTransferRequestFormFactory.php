<?php
namespace FileTransferRequest\Factory;

use Zend\ServiceManager\FactoryInterface;
use FileTransferRequest\Form\Fieldset\BillingFieldset;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\ServiceLocatorInterface;
use FileTransferRequest\Form\FileTransferRequestForm;

class FileTransferRequestFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new FileTransferRequestForm();
        $billingFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\BillingFieldset');
        $sourceFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\SourceFieldset');
        $targetFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\TargetFieldset');
        
        $form->add(
            array(
                'name' => 'billing',
                'type' => 'FileTransferRequest\Form\Fieldset\BillingFieldset',
                'options' => array(),
                'use_as_base_fieldset' => true
            ))
        // 'targetObject' =>
        ;
        $form->add(
            array(
                'type' => 'FileTransferRequest\Form\Fieldset\SourceFieldset',
                'name' => 'source'
            ));
        $form->add(
            array(
                'type' => 'FileTransferRequest\Form\Fieldset\TargetFieldset',
                'name' => 'target'
            ));
        $form->add(
            array(
                'type' => 'button',
                'name' => 'submit',
                'options' => array(
                    'label' => _('send')
                ),
                'attributes' => array(
                    'class' => 'btn btn-default'
                )
            ));
        
        return $form;
    }
}
