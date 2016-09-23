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
use Order\Form\Fieldset\EndpointFtgwCdLinuxUnixSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwCdLinuxUnixTargetFieldset;

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
            && ! $endpointSourceFieldset instanceof EndpointFtgwCdLinuxUnixSourceFieldset
        ) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_server_config')->get('server')->get('name');
        }
        if (! $endpointSourceFieldset instanceof EndpointCdWindowsShareSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('external_server')->get('name');
        }
        if ($endpointSourceFieldset instanceof EndpointCdLinuxUnixSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        if ($endpointSourceFieldset instanceof EndpointFtgwLinuxUnixSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        $minOneNotEmptyValidatorSource = new MinOneNotEmpty(['elements' => $elementsSource]);
        $isValid = $minOneNotEmptyValidatorSource->isValid(null);
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
            && ! $endpointTargetFieldset instanceof EndpointFtgwCdLinuxUnixTargetFieldset
        ) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_server_config')->get('server')->get('name');
        }
        if (! $endpointTargetFieldset instanceof EndpointCdWindowsShareTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('external_server')->get('name');
        }
        if ($endpointTargetFieldset instanceof EndpointCdLinuxUnixTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        if ($endpointTargetFieldset instanceof EndpointFtgwLinuxUnixTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        $minOneNotEmptyValidatorTarget = new MinOneNotEmpty(['elements' => $elementsTarget]);
        $isValid = $minOneNotEmptyValidatorTarget->isValid(null);
        if (! $isValid) {
            $this->addErrorMessage('Neither a server (internal/external), nor a cluster is defined for the target endpoint.');
        }
        return $isValid;
    }

}
