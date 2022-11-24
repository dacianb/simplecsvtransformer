<?php

$_transformerRules = [
    [
        'target_column' => 0,
        'output_column_name' => 'record_id',
        'transformations' => []
    ],
    [
        'target_column' => 2,
        'output_column_name' => 'gender',
        'transformations' => [
            [
                'type' => 'str',
                'options' => [
                    'operation' => 'replace',
                    'condition' => 'equal',
                    'value' => 'Female',
                    'replace_with' => 2
                ]
            ],
            [
                'type' => 'str',
                'options' => [
                    'operation' => 'replace',
                    'condition' => 'equal',
                    'value' => 'Male',
                    'replace_with' => 1
                ]
            ]

        ]
    ],
    [
        'target_column' => 3,
        'output_column_name' => 'height_cm',
        'transformations' => [
            [
                'type' => 'math',
                'options' => [
                    'operation' => 'multiply',
                    'by' => 100,
                ]
            ],


        ]
    ],
    [
        'target_column' => 4,
        'output_column_name' => 'weight_kg',
        'transformations' => []
    ],
    [
        'target_column' => 5,
        'output_column_name' => 'pregnant',
        'output_order' => 1,
        'transformations' => [
            [
                'type' => 'str',
                'options' => [
                    'operation' => 'replace',
                    'condition' => 'equal',
                    'value' => 'Yes',
                    'replace_with' => 1
                ]
            ],
            [
                'type' => 'str',
                'options' => [
                    'operation' => 'replace',
                    'condition' => 'equal',
                    'value' => 'No',
                    'replace_with' => 0
                ]
            ]

        ]
    ],
    [
        'target_column' => 6,
        'output_column_name' => 'pregnancy_duration_weeks',
        'transformations' => [
            [
                'type' => 'math',
                'options' => [
                    'operation' => 'multiply',
                    'by' => 4
                ]
            ],

        ]
    ],
    [
        'target_column' => 7,
        'output_column_name' => 'date_diagnosis',
        'transformations' => [
            [
                'type' => 'date',
                'options' => [
                    'operation' => 'format',
                    'input_format' => 'DD-MM-YYYY',
                    'output_format' => 'Y-m-d'
                ]
            ],

        ]
    ],

]; 