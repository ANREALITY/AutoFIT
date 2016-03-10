<?php
namespace FileTransferRequest\Form\Factory;

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
        $sourceFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\EndpointCdSourceFieldset');
        $targetFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\EndpointCdTargetFieldset');
        $sourceEndpointFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\EndpointCdAs400SourceFieldset');
        $targetEndpointFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\EndpointCdTandemTargetFieldset');
        $physicalConnectionFieldset = $serviceLocator->get('FileTransferRequest\Form\Fieldset\PhysicalConnectionCdFieldset');
        
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
                'type' => 'FileTransferRequest\Form\Fieldset\EndpointCdSourceFieldset',
                'name' => 'source'
            ));
        $form->add(
            array(
                'type' => 'FileTransferRequest\Form\Fieldset\EndpointCdTargetFieldset',
                'name' => 'target'
            ));
        $form->add(
            array(
                'type' => 'FileTransferRequest\Form\Fieldset\EndpointCdAs400SourceFieldset',
                'name' => 'source_endpoint'
            ));
        $form->add(
            array(
                'type' => 'FileTransferRequest\Form\Fieldset\EndpointCdTandemTargetFieldset',
                'name' => 'target_endpoint'
            ));
        $form->add(
            array(
                'type' => 'FileTransferRequest\Form\Fieldset\PhysicalConnectionCdFieldset',
                'name' => 'physical_connection'
            ));
        $form->add(
            array(
                'type' => 'submit',
                'name' => 'submit',
                'attributes' => array(
                    'value' => _('send'),
                    'class' => 'btn btn-default'
                )
            ));
        
        return $form;
    }
}
