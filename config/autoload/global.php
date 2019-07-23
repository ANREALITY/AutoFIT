<?php
use Base\DataObject\FileTransferRequest;

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return [
    'status' => [
        'order' => [
            'all' => [
                FileTransferRequest::STATUS_EDIT,
                FileTransferRequest::STATUS_PENDING,
                FileTransferRequest::STATUS_CANCELED,
                FileTransferRequest::STATUS_CHECK,
                FileTransferRequest::STATUS_ACCEPTED,
                FileTransferRequest::STATUS_DECLINED,
                FileTransferRequest::STATUS_COMPLETED
            ],
            'per_operation' => [
                'startEditing' => [
                    FileTransferRequest::STATUS_PENDING,
                    FileTransferRequest::STATUS_DECLINED
                ],
                'edit' => [
                    FileTransferRequest::STATUS_EDIT
                ],
                'submit' => [
                    FileTransferRequest::STATUS_EDIT
                ],
                'cancel' => [
                    FileTransferRequest::STATUS_EDIT,
                    FileTransferRequest::STATUS_PENDING,
                    FileTransferRequest::STATUS_DECLINED
                ],
                'accept' => [
                    FileTransferRequest::STATUS_CHECK
                ],
                'decline' => [
                    FileTransferRequest::STATUS_CHECK
                ],
                'startChecking' => [
                    FileTransferRequest::STATUS_PENDING
                ],
                'complete' => [
                    FileTransferRequest::STATUS_ACCEPTED
                ]
            ]
        ]
    ]
];
