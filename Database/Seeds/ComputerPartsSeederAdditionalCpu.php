<?php

namespace Database\Seeds;

use Database\AbstractSeeder;

class ComputerPartsSeederAdditionalCpu extends AbstractSeeder
{
    protected ?string $tableName = 'computer_parts';
    protected array $tableColumns = [
        [
            'data_type' => 'string',
            'column_name' => 'name'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'type'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'brand'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'model_number'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'release_date'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'description'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'performance_score'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'market_price'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'rsm'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'power_consumptionw'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'lengthm'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'widthm'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'heightm'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'lifespan'
        ]
    ];

    public function createRowData(): array
    {
        return [
            [
                'Ryzen 7 5800X',
                'CPU',
                'AMD',
                '100-000000060',
                '2020-11-05',
                'A high-performance 8-core processor.',
                90,
                549.99,
                0.05,
                105.0,
                0.04,
                0.04,
                0.005,
                5
            ],
            [
                'Ryzen 7 5700X',
                'CPU',
                'AMD',
                '100-000000059',
                '2020-11-05',
                'A high-performance 8-core processor.',
                90,
                549.99,
                0.05,
                105.0,
                0.04,
                0.04,
                0.005,
                5
            ],
            [
                'Ryzen 5 5600X',
                'CPU',
                'AMD',
                '100-000000058',
                '2020-11-05',
                'A middle-performance 6-core processor.',
                90,
                549.99,
                0.05,
                105.0,
                0.04,
                0.04,
                0.005,
                5
            ],
            [
                'Ryzen 5 5600',
                'CPU',
                'AMD',
                '100-000000057',
                '2020-11-05',
                'A middle-performance 6-core processor.',
                90,
                549.99,
                0.05,
                105.0,
                0.04,
                0.04,
                0.005,
                5
            ],
            [
                'Ryzen 3 5300X',
                'CPU',
                'AMD',
                '100-000000056',
                '2020-11-05',
                'A middle-performance 4-core processor.',
                90,
                549.99,
                0.05,
                105.0,
                0.04,
                0.04,
                0.005,
                5
            ],
        ];
    }
}
