<?php
return [
    'test' => [
        'db' => [
            'scripts' => [
                'schema' => __DIR__ . '/../../../data/database/schema.sql',
                'stored-procedures' => __DIR__ . '/../../../data/database/stored-procedures.sql',
                'basic-data' => __DIR__ . '/../../../data/database/basic-data.sql',
                'test-data' => [
                    'server' => __DIR__ . '/../../../data/database/test-data/server.sql',
                    'application' => __DIR__ . '/../../../data/database/test-data/application.sql',
                    'article' => __DIR__ . '/../../../data/database/test-data/article.sql',
                    'service_invoice' => __DIR__ . '/../../../data/database/test-data/service_invoice.sql',
                    'service_invoice_position' => __DIR__ . '/../../../data/database/test-data/service_invoice_position.sql',
                    'user' => __DIR__ . '/../../../data/database/test-data/user.sql',
                ]
            ]
        ]
    ]
];
