<?php
namespace FileTransferRequest\Form\DataPreparator;

use Zend\Hydrator\HydratorInterface;

class FileTransferRequestDataPreparator implements DataPreparator
{
    
    const ENDPOINT_ROLE_SOURCE = 'source';
    
    const ENDPOINT_ROLE_TARGET = 'target';
    
    const ENDPOINT_TYPE_CD = 'CD';
    
    const ENDPOINT_TYPE_FTGW = 'FTGW';
    
    const LOGICAL_CONNECTION_TYPE_CD = 'CD';
    
    const LOGICAL_CONNECTION_FTGW = 'FTGW';

    protected $fileTransferRequestHydrator = null;

    protected $fileTransferRequestPrototype = null;

    protected $sourceEndpointHydrator = null;

    protected $sourceEndpointPrototype = null;

    protected $targetEndpointHydrator = null;

    protected $targetEndpointPrototype = null;

    protected $physicalConnectionHydrator = null;

    protected $physicalConnectionPrototype = null;

    public function __construct(
        HydratorInterface $fileTransferRequestHydrator, $fileTransferRequestPrototype,
        HydratorInterface $sourceEndpointHydrator, $sourceEndpointPrototype,
        HydratorInterface $targetEndpointHydrator, $targetEndpointPrototype,
        HydratorInterface $physicalConnectionHydrator, $physicalConnectionPrototype
    ) {
        $this->fileTransferRequestHydrator = $fileTransferRequestHydrator;
        $this->fileTransferRequestPrototype = $fileTransferRequestPrototype;
        $this->sourceEndpointHydrator = $sourceEndpointHydrator;
        $this->sourceEndpointPrototype = $sourceEndpointPrototype;
        $this->targetEndpointHydrator = $targetEndpointHydrator;
        $this->targetEndpointPrototype = $targetEndpointPrototype;
        $this->physicalConnectionHydrator = $physicalConnectionHydrator;
        $this->physicalConnectionPrototype = $physicalConnectionPrototype;
    }

    public function prepare($data)
    {
//         echo '<pre>';
//         print_r($data);
        
        $targetArray = [
            'file_transfer_request' => [
                'id' => isset($data['id']) ? $data['id'] : null,
                'change_number' => isset($data['billing']['change_number']) ? $data['billing']['change_number'] : null,
                'application' => [
                    'technical_short_name' => isset($data['billing']['application_technical_short_name']) ? $data['billing']['application_technical_short_name'] : null,
                ],
                'service_invoice_position_basic' => [
                    'number' => isset($data['billing']['service_invoice_position_basic_number']) ? $data['billing']['service_invoice_position_basic_number'] : null
                ],
                'service_invoice_position_personal' => [
                    'number' => isset($data['billing']['service_invoice_position_personal_number']) ? $data['billing']['service_invoice_position_personal_number'] : null
                ],
                'user' => [
                    'id' => isset($data['billing']['user_id']) ? $data['billing']['user_id'] : null,
                    'username' => isset($data['billing']['user_username']) ? $data['billing']['user_username'] : null
                ]
            ],
            'source' => [
                'username' => isset($data['source_endpoint']['username']) ? $data['source_endpoint']['username'] : null,
                'endpoint' => [
                    'role' => static::ENDPOINT_ROLE_SOURCE,
                    'type' => static::ENDPOINT_TYPE_CD,
                    'server_place' => isset($data['source']['server_place']) ? $data['source']['server_place'] : null,
                    'contact_person' => isset($data['source']['contact_person']) ? $data['source']['contact_person'] : null,
                    'server' => [
                        'name' => isset($data['source']['server_name']) ? $data['source']['server_name'] : null
                    ],
                    'application' => [
                        'technical_short_name' => isset($data['source']['application_technical_short_name']) ? $data['source']['application_technical_short_name'] : null
                    ],
                    'customer' => [
                        'id' => isset($data['source']['customer_id']) ? $data['source']['customer_id'] : null,
                        'name' => isset($data['source']['customer_name']) ? $data['source']['customer_name'] : null
                    ]
                ]
            ],
            'target' => [
                'username' => isset($data['target_endpoint']['username']) ? $data['target_endpoint']['username'] : null,
                'folder' => isset($data['target_endpoint']['folder']) ? $data['target_endpoint']['folder'] : null,
                'endpoint' => [
                    'role' => static::ENDPOINT_ROLE_TARGET,
                    'type' => static::ENDPOINT_TYPE_CD,
                    'server_place' => isset($data['target']['server_place']) ? $data['target']['server_place'] : null,
                    'contact_person' => isset($data['target']['contact_person']) ? $data['target']['contact_person'] : null,
                    'server' => [
                        'name' => isset($data['target']['server_name']) ? $data['target']['server_name'] : null
                    ],
                    'application' => [
                        'technical_short_name' => isset($data['target']['application_technical_short_name']) ? $data['target']['application_technical_short_name'] : null
                    ],
                    'customer' => [
                        'id' => isset($data['target']['customer_id']) ? $data['target']['customer_id'] : null,
                        'name' => isset($data['target']['customer_name']) ? $data['target']['customer_name'] : null
                    ]
                ]
            ],
            'physical_connection' => [
                'secure_plus' => isset($data['physical_connection']['secure_plus']) ? $data['physical_connection']['secure_plus'] : null,
                'physical_connection' => [
                    'logical_connection' => [
                        'type' => static::LOGICAL_CONNECTION_TYPE_CD
                    ]
                ]
            ]
        ];
        
//         $fileTransferRequest = $this->fileTransferRequestHydrator->hydrate($targetArray['file_transfer_request'], $this->fileTransferRequestPrototype);
//         $sourceEndpoint = $this->sourceEndpointHydrator->hydrate($targetArray['source'], $this->sourceEndpointPrototype);
//         $targetEndpoint = $this->targetEndpointHydrator->hydrate($targetArray['target'], $this->targetEndpointPrototype);
//         $fileTransferRequest = $this->physicalConnectionHydrator->hydrate($data['physical_connection'], $this->physicalConnectionPrototype);

        $hydratedData = [
            'fileTransferRequest' => $this->fileTransferRequestHydrator->hydrate($targetArray['file_transfer_request'], $this->fileTransferRequestPrototype),
            'sourceEndpoint' => $this->sourceEndpointHydrator->hydrate($targetArray['source'], $this->sourceEndpointPrototype),
            'targetEndpoint' => $this->targetEndpointHydrator->hydrate($targetArray['target'], $this->targetEndpointPrototype),
            'fileTransferRequest' => $this->physicalConnectionHydrator->hydrate($data['physical_connection'], $this->physicalConnectionPrototype),
        ];

        echo '<pre>';
        print_r($targetArray);
        die();

        return $hydratedData;
    }
}
