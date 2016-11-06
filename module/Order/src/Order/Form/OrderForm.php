<?php
namespace Order\Form;

use Zend\Form\Form;
use DbSystel\Validator\MinOneNotEmpty;
use DbSystel\Validator\MaxOneNotEmpty;
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
use Order\Form\Fieldset\EndpointFtgwProtocolServerSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwProtocolServerTargetFieldset;

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
        $minOneServerExternalServerOrClusterNotEmptySource = $this->validateMinOneNotEmptyValidatorSource($endpointSourceFieldset);
        $onesIpOrDnsNotEmptySource = $this->validateOnesIpOrDnsNotEmptySource($endpointSourceFieldset);
        $isValidEndpintSource = $minOneServerExternalServerOrClusterNotEmptySource && $onesIpOrDnsNotEmptySource;
        $minOneServerExternalServerOrClusterNotEmptyTarget = $this->validateMinOneNotEmptyValidatorTarget($endpointTargetFieldset);
        $onesIpOrDnsNotEmptyTarget = $this->validateOnesIpOrDnsNotEmptyTarget($endpointTargetFieldset);
        $isValidEndpintTarget = $minOneServerExternalServerOrClusterNotEmptyTarget && $onesIpOrDnsNotEmptyTarget;
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

    protected function validateOnesIpOrDnsNotEmptySource(AbstractEndpointFieldset $endpointSourceFieldset)
    {
        $isValid = true;

        $elementsSource = [];
        if ($endpointSourceFieldset instanceof EndpointFtgwProtocolServerSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('ip');
            $elementsSource[] = $endpointSourceFieldset->get('dns_address');
        }

        $minOneNotEmptyValidatorSource = new MinOneNotEmpty(['elements' => $elementsSource]);
        $maxOneNotEmptyValidatorSource = new MaxOneNotEmpty(['elements' => $elementsSource]);

        if ($endpointSourceFieldset instanceof EndpointFtgwProtocolServerSourceFieldset) {
            $isValid = $minOneNotEmptyValidatorSource->isValid(null) && $maxOneNotEmptyValidatorSource->isValid(null);
        }

        if (! $isValid) {
            $this->addErrorMessage('Either the IP or the DNS address (but only ones from them) may and must be defined for the source endpoint.');
        }
        return $isValid;
    }

    protected function validateOnesIpOrDnsNotEmptyTarget(AbstractEndpointFieldset $endpointTargetFieldset)
    {
        $isValid = true;

        $elementsTarget = [];
        if ($endpointTargetFieldset instanceof EndpointFtgwProtocolServerTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('ip');
            $elementsTarget[] = $endpointTargetFieldset->get('dns_address');
        }

        $minOneNotEmptyValidatorTarget = new MinOneNotEmpty(['elements' => $elementsTarget]);
        $maxOneNotEmptyValidatorTarget = new MaxOneNotEmpty(['elements' => $elementsTarget]);

        if ($endpointTargetFieldset instanceof EndpointFtgwProtocolServerTargetFieldset) {
            $isValid = $minOneNotEmptyValidatorTarget->isValid(null) && $maxOneNotEmptyValidatorTarget->isValid(null);
        }

        if (! $isValid) {
            $this->addErrorMessage('Either the IP or the DNS address (but only ones from them) may and must be defined for the target endpoint.');
        }
        return $isValid;
    }

}
