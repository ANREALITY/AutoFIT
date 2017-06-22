<?php
namespace Order\Form;

use DbSystel\DataObject\Article;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\Server;
use DbSystel\Validator\MaxOneNotEmpty;
use DbSystel\Validator\MinOneNotEmpty;
use Order\Form\Fieldset\AbstractEndpointFieldset;
use Order\Form\Fieldset\AbstractFileTransferRequestFieldset;
use Order\Form\Fieldset\AbstractServiceInvoicePositionFieldset;
use Order\Form\Fieldset\ApplicationFieldset;
use Order\Form\Fieldset\EndpointCdLinuxUnixSourceFieldset;
use Order\Form\Fieldset\EndpointCdLinuxUnixTargetFieldset;
use Order\Form\Fieldset\EndpointCdWindowsShareSourceFieldset;
use Order\Form\Fieldset\EndpointCdWindowsShareTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwLinuxUnixSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwLinuxUnixTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwProtocolServerSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwProtocolServerTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwSelfServiceSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwSelfServiceTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsShareSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsShareTargetFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsSourceFieldset;
use Order\Form\Fieldset\EndpointFtgwWindowsTargetFieldset;
use Order\Form\Fieldset\EnvironmentFieldset;
use Order\Service\ServiceInvoicePositionServiceInterface;
use Zend\Form\Form;
use Order\Validator\Db\ServerMatchesEndpointType;

class OrderForm extends Form
{

    protected $fileTransferRequestFieldsetServiceName;

    protected $errorMessages = [];

    protected $dbAdapter;

    /** @var ServiceInvoicePositionServiceInterface */
    protected $serviceInvoicePositionService;

    public function __construct(
        $name = null,
        $options = [],
        string $fileTransferRequestFieldsetServiceName,
        $dbAdapter,
        ServiceInvoicePositionServiceInterface $serviceInvoicePositionService
    ) {
        parent::__construct('create_file_transfer_request');

        $this->fileTransferRequestFieldsetServiceName = $fileTransferRequestFieldsetServiceName;
        $this->dbAdapter = $dbAdapter;
        $this->serviceInvoicePositionService = $serviceInvoicePositionService;
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

        $connectionType = $this->getConnectionTypeFromFileTransferRequestFieldsetServiceName(
            $this->fileTransferRequestFieldsetServiceName
        );
        $serviceInvoicePositionBasicIsValid = $this->validateServiceInvoicePosition(
            $this->get('file_transfer_request'),
            $connectionType,
            Article::TYPE_BASIC
        );
        $serviceInvoicePositionPersonalIsValid = $this->validateServiceInvoicePosition(
            $this->get('file_transfer_request'),
            $connectionType,
            Article::TYPE_PERSONAL
        );
        $isValidBilling = $serviceInvoicePositionBasicIsValid && $serviceInvoicePositionPersonalIsValid;

        $minOneServerExternalServerOrClusterNotEmptySource = $this->validateMinOneNotEmptyValidatorSource($endpointSourceFieldset);
        $onesIpOrDnsNotEmptySource = $this->validateOnesIpOrDnsNotEmptySource($endpointSourceFieldset);
        $folderIsNotEmptySource = $this->validateFolderIsNotEmptySource($endpointSourceFieldset);
        $transmissionTypeIsNotEmptySource = $this->validateTransmissionTypeIsNotEmptySource($endpointSourceFieldset);
        $transmissionIntervalIsNotEmptySource = $this->validateTransmissionIntervalIsNotEmptySource($endpointSourceFieldset);
        $serverMatchesEndpointTypeSource = true;
        if (! empty($endpointSourceFieldset->get('endpoint_server_config')->get('server')->get('name')->getValue())) {
            $serverMatchesEndpointTypeSource = $this->validateServerMatchesEndpointTypeSource($endpointSourceFieldset);
        }
        $isValidEndpintSource =
            $minOneServerExternalServerOrClusterNotEmptySource
            && $onesIpOrDnsNotEmptySource
            && $folderIsNotEmptySource
            && $transmissionTypeIsNotEmptySource
            && $transmissionIntervalIsNotEmptySource
            && $serverMatchesEndpointTypeSource;

        $minOneServerExternalServerOrClusterNotEmptyTarget = $this->validateMinOneNotEmptyValidatorTarget($endpointTargetFieldset);
        $onesIpOrDnsNotEmptyTarget = $this->validateOnesIpOrDnsNotEmptyTarget($endpointTargetFieldset);
        $serverMatchesEndpointTypeTarget = true;
        if (! empty($endpointTargetFieldset->get('endpoint_server_config')->get('server')->get('name')->getValue())) {
            $serverMatchesEndpointTypeTarget = $this->validateServerMatchesEndpointTypeTarget($endpointTargetFieldset);
        }
        $isValidEndpintTarget =
            $minOneServerExternalServerOrClusterNotEmptyTarget
            && $onesIpOrDnsNotEmptyTarget
            && $serverMatchesEndpointTypeTarget;

        $isValid = $isValidBasic && $isValidBilling && $isValidEndpintSource && $isValidEndpintTarget;
        return $isValid;
    }

    protected function validateServiceInvoicePosition(
        AbstractFileTransferRequestFieldset $fileTransferRequestFieldset,
        string $connectionType,
        string $articleType
    ) {
        $isValid = false;
        $applicationTechnicalShortName = $fileTransferRequestFieldset->get('application_technical_short_name')->getValue();
        $environmentSeverity = $fileTransferRequestFieldset->get('environment')->get('severity')->getValue();
        $serviceInvoicePositionFieldset = $articleType === Article::TYPE_BASIC
            ? $fileTransferRequestFieldset->get('service_invoice_position_basic')
            : $fileTransferRequestFieldset->get('service_invoice_position_personal')
        ;
        $validServiceInvoicePositions = $this->serviceInvoicePositionService->findValidForOrder(
            $serviceInvoicePositionFieldset->get('number')->getValue(),
            $applicationTechnicalShortName,
            $environmentSeverity,
            $connectionType,
            $articleType
        )->toArray();
        $isValid = ! empty($validServiceInvoicePositions);

        if (! $isValid) {
            $this->addErrorMessage('The service invoice position (' . strtolower($articleType) . ') is invalid.');
        }
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
            && ! $endpointSourceFieldset instanceof EndpointFtgwWindowsSourceFieldset
            && ! $endpointSourceFieldset instanceof EndpointFtgwProtocolServerSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('external_server')->get('name');
        }
        if ($endpointSourceFieldset instanceof EndpointCdLinuxUnixSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        if ($endpointSourceFieldset instanceof EndpointFtgwLinuxUnixSourceFieldset) {
            $elementsSource[] = $endpointSourceFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }

        $minOneNotEmptyValidatorSource = new MinOneNotEmpty(['elements' => $elementsSource]);

        if ($endpointSourceFieldset instanceof EndpointFtgwSelfServiceSourceFieldset
            || $endpointSourceFieldset instanceof EndpointFtgwProtocolServerSourceFieldset) {
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
            && ! $endpointTargetFieldset instanceof EndpointFtgwWindowsTargetFieldset
            && ! $endpointTargetFieldset instanceof EndpointFtgwProtocolServerTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('external_server')->get('name');
        }
        if ($endpointTargetFieldset instanceof EndpointCdLinuxUnixTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }
        if ($endpointTargetFieldset instanceof EndpointFtgwLinuxUnixTargetFieldset) {
            $elementsTarget[] = $endpointTargetFieldset->get('endpoint_cluster_config')->get('cluster')->get('id');
        }

        $minOneNotEmptyValidatorTarget = new MinOneNotEmpty(['elements' => $elementsTarget]);

        if ($endpointTargetFieldset instanceof EndpointFtgwSelfServiceTargetFieldset
            || $endpointTargetFieldset instanceof EndpointFtgwProtocolServerTargetFieldset) {
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

    protected function validateFolderIsNotEmptySource(AbstractEndpointFieldset $endpointSourceFieldset)
    {
        $isValid = true;

        if ($endpointSourceFieldset instanceof EndpointCdLinuxUnixSourceFieldset) {
            if ($endpointSourceFieldset->get('server_place')->getValue() == Server::PLACE_INTERNAL) {
                $test = $endpointSourceFieldset->get('folder')->getValue();
                $isValid = ! empty($endpointSourceFieldset->get('folder')->getValue());
            }
        }

        if (! $isValid) {
            $this->addErrorMessage('A folder must be defined for the source endpoint.');
        }
        return $isValid;
    }

    protected function validateTransmissionTypeIsNotEmptySource(AbstractEndpointFieldset $endpointSourceFieldset)
    {
        $isValid = true;

        if ($endpointSourceFieldset instanceof EndpointCdLinuxUnixSourceFieldset) {
            if ($endpointSourceFieldset->get('server_place')->getValue() == Server::PLACE_INTERNAL) {
                $test = $endpointSourceFieldset->get('transmission_type')->getValue();
                $isValid = ! empty($endpointSourceFieldset->get('transmission_type')->getValue());
            }
        }

        if (! $isValid) {
            $this->addErrorMessage('A transmission type must be defined for the source endpoint.');
        }
        return $isValid;
    }

    protected function validateTransmissionIntervalIsNotEmptySource(AbstractEndpointFieldset $endpointSourceFieldset)
    {
        $isValid = true;

        if ($endpointSourceFieldset instanceof EndpointCdLinuxUnixSourceFieldset) {
            if ($endpointSourceFieldset->get('server_place')->getValue() == Server::PLACE_INTERNAL) {
                $test = $endpointSourceFieldset->get('transmission_interval')->getValue();
                $isValid = ! empty($endpointSourceFieldset->get('transmission_interval')->getValue());
            }
        }

        if (! $isValid) {
            $this->addErrorMessage('A transmission interval must be defined for the source endpoint.');
        }
        return $isValid;
    }

    protected function validateServerMatchesEndpointTypeSource(AbstractEndpointFieldset $endpointSourceFieldset)
    {
        $isValid = true;

        $reflection = new \ReflectionClass($endpointSourceFieldset);
        $endpointType = str_ireplace(['Endpoint', 'SourceFieldset'], '', $reflection->getShortName());
        $validator = new ServerMatchesEndpointType([
            'adapter' => $this->dbAdapter,
            'endpoint_type_name' => $endpointType
        ]);
        $serverNameField = $endpointSourceFieldset->get('endpoint_server_config')->get('server')->get('name');
        $serverName = $serverNameField->getValue();
        $isValid = $validator->isValid($serverName);

        if (! $isValid) {
            $this->addErrorMessage('The server for the source endpoint does not match the endpoint type.');
        }
        return $isValid;
    }

    protected function validateServerMatchesEndpointTypeTarget(AbstractEndpointFieldset $endpointTargetFieldset)
    {
        $isValid = true;

        $reflection = new \ReflectionClass($endpointTargetFieldset);
        $endpointType = str_ireplace(['Endpoint', 'TargetFieldset'], '', $reflection->getShortName());
        $validator = new ServerMatchesEndpointType([
            'adapter' => $this->dbAdapter,
            'endpoint_type_name' => $endpointType
        ]);
        $serverNameField = $endpointTargetFieldset->get('endpoint_server_config')->get('server')->get('name');
        $serverName = $serverNameField->getValue();
        $isValid = $validator->isValid($serverName);

        if (! $isValid) {
            $this->addErrorMessage('The server for the target endpoint does not match the endpoint type.');
        }
        return $isValid;
    }

    protected function getConnectionTypeFromFileTransferRequestFieldsetServiceName(string $fileTransferRequestFieldsetServiceName)
    {
        $connectionType = null;
        $cdPattern = '/' . LogicalConnection::TYPE_CD . '$/i';
        $ftgwPattern = '/' . LogicalConnection::TYPE_FTGW . '$/i';
        $matches = [];
        if (preg_match($cdPattern, $fileTransferRequestFieldsetServiceName, $matches) === 1) {
            $connectionType = LogicalConnection::TYPE_CD;
        } elseif (preg_match($ftgwPattern, $fileTransferRequestFieldsetServiceName, $matches) === 1) {
            $connectionType = LogicalConnection::TYPE_FTGW;
        }
        return $connectionType;
    }

}
