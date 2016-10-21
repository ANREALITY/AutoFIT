<?php
namespace Order\Form;

use Zend\Form\Form;
use DbSystel\Validator\MinOneNotEmpty;
use Order\Form\Fieldset\EndpointFtgwSelfServiceSourceFieldset;
use Order\Form\Fieldset\EndpointCdLinuxUnixSourceFieldset;
use Order\Form\Fieldset\EndpointCdLinuxUnixTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwSelfServiceTargetFieldset;
use Order\Form\Fieldset\AbstractEndpointFieldset;
use Order\Form\Fieldset\EndpointCdWindowsShareSourceFieldset;
use Order\Form\Fieldset\EndpointCdWindowsShareTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwLinuxUnixTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwLinuxUnixSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsShareSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsShareTargetFieldset;

class OrderForm extends Form
{

    protected $fileTransferRequestFieldsetServiceName;

    protected $errorMessages = [];

    public function __construct($name = null, $options = [], string $fileTransferRequestFieldsetServiceName)
    {
        parent::__construct('create_file_transfer_request');

        $this->fileTransferRequestFieldsetServiceName = $fileTransferRequestFieldsetServiceName;
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add(
            [
                'type' => $this->fileTransferRequestFieldsetServiceName,
                'options' => [
                    'use_as_base_fieldset' => true
                ]
            ]);

        $this->add(
            [
                'name' => 'save',
                'attributes' => [
                    'type' => 'submit',
                    'value' => _('save'),
                    'class' => 'btn btn-default'
                ]
            ]);

        $this->add(
            [
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => _('binding order'),
                    'class' => 'btn btn-default'
                ]
            ]);
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function getMessages($elementName = null)
    {
        if ($elementName) {
            $messages = parent::getMessages($elementName);
        } else {
            $messages = array_merge(parent::getMessages($elementName), $this->getErrorMessages());
        }
        return $messages;
    }

    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
        return $this;
    }

    public function isValid() {
        $isValid = $isValidBasic = parent::isValid();
        $logicalConnectionFieldset = $this->get('file_transfer_request')->get('logical_connection');
        if ($logicalConnectionFieldset->has('physical_connection_end_to_end')) {
            $physicalConnectionCdEndToEndFieldset = $logicalConnectionFieldset->get('physical_connection_end_to_end');
            $endpointSourceFieldset = $physicalConnectionCdEndToEndFieldset->get('endpoint_source');
            $endpointTargetFieldset = $physicalConnectionCdEndToEndFieldset->get('endpoint_target');
        } else {
            $physicalConnectionFtgwEndToMiddleFieldset = $logicalConnectionFieldset->get('physical_connection_end_to_middle');
            $physicalConnectionFtgwMiddleToEndFieldset = $logicalConnectionFieldset->get('physical_connection_middle_to_end');
            $endpointSourceFieldset = $physicalConnectionFtgwEndToMiddleFieldset->get('endpoint_source');
            $endpointTargetFieldset = $physicalConnectionFtgwMiddleToEndFieldset->get('endpoint_target');
        }
        $isValidEndpintSource = $this->validateMinOneNotEmptyValidatorSource($endpointSourceFieldset);
        $isValidEndpintTarget = $this->validateMinOneNotEmptyValidatorTarget($endpointTargetFieldset);
        $isValid = $isValidBasic && $isValidEndpintSource && $isValidEndpintTarget;
        return $isValid;
    }

    protected function validateMinOneNotEmptyValidatorSource(AbstractEndpointFieldset $endpointSourceFieldset)
    {
        $elementsSource = [];
        if (
            ! $endpointSourceFieldset instanceof EndpointFtgwSelfServiceSourceFieldset
        ) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_server_config')->get('server')->get('name');
        }
        if (! $endpointSourceFieldset instanceof EndpointCdWindowsShareSourceFieldset
            && ! $endpointSourceFieldset instanceof EndpointFtgwWindowsShareSourceFieldset
            && ! $endpointSourceFieldset instanceof EndpointFtgwLinuxUnixSourceFieldset
            && ! $endpointSourceFieldset instanceof EndpointFtgwWindowsSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('external_server')->get('name');
        }
        if ($endpointSourceFieldset instanceof EndpointCdLinuxUnixSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        if ($endpointSourceFieldset instanceof EndpointFtgwLinuxUnixSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }

        $minOneNotEmptyValidatorSource = new MinOneNotEmpty(['elements' => $elementsSource]);

        if ($endpointSourceFieldset instanceof EndpointFtgwSelfServiceSourceFieldset) {
            $isValid = true;
        } else {
            $isValid = $minOneNotEmptyValidatorSource->isValid(null);
        }
        
        if (! $isValid) {
            $this->addErrorMessage('Neither a server (internal/external), nor a cluster is defined for the source endpoint.');
        }
        return $isValid;
    }

    protected function validateMinOneNotEmptyValidatorTarget(AbstractEndpointFieldset $endpointTargetFieldset)
    {
        $elementsTarget = [];
        if (
            ! $endpointTargetFieldset instanceof EndpointFtgwSelfServiceTargetFieldset
        ) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_server_config')->get('server')->get('name');
        }
        if (! $endpointTargetFieldset instanceof EndpointCdWindowsShareTargetFieldset
            && ! $endpointTargetFieldset instanceof EndpointFtgwWindowsShareTargetFieldset
            && ! $endpointTargetFieldset instanceof EndpointFtgwLinuxUnixTargetFieldset
            && ! $endpointTargetFieldset instanceof EndpointFtgwWindowsTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('external_server')->get('name');
        }
        if ($endpointTargetFieldset instanceof EndpointCdLinuxUnixTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        if ($endpointTargetFieldset instanceof EndpointFtgwLinuxUnixTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }

        $minOneNotEmptyValidatorTarget = new MinOneNotEmpty(['elements' => $elementsTarget]);

        if ($endpointTargetFieldset instanceof EndpointFtgwSelfServiceTargetFieldset) {
            $isValid = true;
        } else {
            $isValid = $minOneNotEmptyValidatorTarget->isValid(null);
        }

        if (! $isValid) {
            $this->addErrorMessage('Neither a server (internal/external), nor a cluster is defined for the target endpoint.');
        }
        return $isValid;
    }

}
