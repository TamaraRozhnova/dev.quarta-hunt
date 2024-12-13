<?php

namespace Sprint\Migration;


class Version20241115133458 extends Version
{
    protected $author = "admin";

    protected $description = "111971 | Программа лояльности / Правила корзины | Новые правила корзины";

    protected $moduleVersion = "4.15.1";

    public function up()
    {
        $helper = $this->getHelperManager();
        \Bitrix\Main\Loader::IncludeModule('sale');

        $rule1 = \Bitrix\Sale\Internals\DiscountTable::add([
            'NAME' => 'Скидка для группы 10%',
            'LID' => 's1',
            'CURRENCY' => 'RUB',
            'DISCOUNT_TYPE' => 'P',
            'ACTIVE' => 'Y',
            'SORT' => 95,
            'PRIORITY' => 1,
            'LAST_DISCOUNT' => 'Y',
            'LAST_LEVEL_DISCOUNT' => 'N',
            'CONDITIONS_LIST' => [
                'CLASS_ID' => 'CondGroup',
                'DATA' => [
                    'All' => 'AND',
                    'True' => 'True'
                ],

                'CHILDREN' => [],
            ],
            'USER_GROUPS' => [25],
            'ACTIONS_LIST' => [

                'CLASS_ID' => 'CondGroup',
                'DATA' => [
                    'All' => 'AND'
                ],
                'CHILDREN' => [
                    0 => [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' => [
                            'Type' => 'Discount',
                            'Value' => 10,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True'
                        ],

                        'CHILDREN' => [
                            0 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 1149,
                                ],
                            ],

                            1 => [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 3532
                                ],

                            ],

                            2 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 584
                                ]

                            ],

                            3 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 588
                                ]

                            ],

                            4 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 590
                                ]

                            ],

                            5 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 593
                                ]

                            ]

                        ]

                    ],

                    1 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' => [
                            'Type' => 'Discount',
                            'Value' => 10,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 584
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3546
                                ]

                            ],

                            2 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3465
                                ]

                            ],

                            3 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3700
                                ]

                            ],

                            4 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3541
                                ]

                            ]

                        ],

                    ],

                    2 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 10,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 588
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3546
                                ]

                            ],

                            2 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3700
                                ]

                            ],

                            3 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3465
                                ]

                            ],

                            4 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3460
                                ]

                            ]

                        ],

                    ],

                    3 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 10,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 590
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3546
                                ]

                            ],

                            2 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3589
                                ]

                            ],

                            3 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 6045
                                ]

                            ],

                            4 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 6544
                                ]

                            ],

                            5 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3541
                                ]

                            ],

                            6 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 4775
                                ]

                            ],

                            7 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3543
                                ]

                            ],

                            8 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3586
                                ]

                            ],

                            9 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 3515
                                ]

                            ]

                        ]

                    ]

                ]

            ]

        ]);

        if ($rule1->isSuccess()) {
            $id = $rule1->getId();
            \Bitrix\Sale\Internals\DiscountGroupTable::updateByDiscount($id, [25], "Y", true);
        }

        $rule2 = \Bitrix\Sale\Internals\DiscountTable::add([
            'NAME' => 'Скидка для группы 7%',
            'LID' => 's1',
            'CURRENCY' => 'RUB',
            'DISCOUNT_TYPE' => 'P',
            'ACTIVE' => 'Y',
            'SORT' => 95,
            'PRIORITY' => 1,
            'LAST_DISCOUNT' => 'Y',
            'LAST_LEVEL_DISCOUNT' => 'N',
            'CONDITIONS_LIST' => [
                'CLASS_ID' => 'CondGroup',
                'DATA' => [
                    'All' => 'AND',
                    'True' => 'True'
                ],

                'CHILDREN' => [],
            ],
            'USER_GROUPS' => [24],
            'ACTIONS_LIST' => [

                'CLASS_ID' => 'CondGroup',
                'DATA' => [
                    'All' => 'AND'
                ],
                'CHILDREN' => [
                    0 => [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' => [
                            'Type' => 'Discount',
                            'Value' => 7,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True'
                        ],

                        'CHILDREN' => [
                            0 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 1149,
                                ],
                            ],

                            1 => [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 3532
                                ],

                            ],

                            2 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 584
                                ]

                            ],

                            3 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 588
                                ]

                            ],

                            4 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 590
                                ]

                            ],

                            5 => [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 593
                                ]

                            ]

                        ]

                    ],

                    1 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' => [
                            'Type' => 'Discount',
                            'Value' => 7,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 584
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3546
                                ]

                            ],

                            2 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3465
                                ]

                            ],

                            3 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3700
                                ]

                            ],

                            4 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3541
                                ]

                            ]

                        ],

                    ],

                    2 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 7,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 588
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3546
                                ]

                            ],

                            2 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3700
                                ]

                            ],

                            3 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3465
                                ]

                            ],

                            4 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3460
                                ]

                            ]

                        ],

                    ],

                    3 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 7,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 590
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3546
                                ]

                            ],

                            2 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3589
                                ]

                            ],

                            3 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 6045
                                ]

                            ],

                            4 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 6544
                                ]

                            ],

                            5 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3541
                                ]

                            ],

                            6 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 4775
                                ]

                            ],

                            7 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3543
                                ]

                            ],

                            8 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Not',
                                    'value' => 3586
                                ]

                            ],

                            9 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' => [
                                    'logic' => 'Not',
                                    'value' => 3515
                                ]

                            ]

                        ]

                    ]

                ]

            ]

        ]);

        if ($rule2->isSuccess()) {
            $id = $rule2->getId();
            \Bitrix\Sale\Internals\DiscountGroupTable::updateByDiscount($id, [24], "Y", true);
        }

        $rule3 = \Bitrix\Sale\Internals\DiscountTable::add([
            'NAME' => 'Исключения для групп 7% и 10%',
            'LID' => 's1',
            'CURRENCY' => 'RUB',
            'DISCOUNT_TYPE' => 'P',
            'ACTIVE' => 'Y',
            'SORT' => 100,
            'PRIORITY' => 2,
            'LAST_DISCOUNT' => 'N',
            'LAST_LEVEL_DISCOUNT' => 'N',
            'CONDITIONS_LIST' => [
                'CLASS_ID' => 'CondGroup',
                'DATA' => [
                    'All' => 'AND',
                    'True' => 'True'
                ],

                'CHILDREN' => [],
            ],
            'USER_GROUPS' => [24, 25],
            'ACTIONS_LIST' =>
            [
                'CLASS_ID' => 'CondGroup',
                'DATA' =>
                [
                    'All' => 'AND'
                ],

                'CHILDREN' =>
                [
                    0 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 5,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'OR',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBProp:16:198',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 3532
                                ]

                            ]

                        ]

                    ],

                    1 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 5,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 584
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'ActSaleSubGrp',
                                'DATA' =>
                                [
                                    'All' => 'OR',
                                    'True' => 'True'
                                ],

                                'CHILDREN' =>
                                [
                                    0 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3546
                                        ]

                                    ],

                                    1 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3700
                                        ]

                                    ],

                                    2 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3465
                                        ]

                                    ],

                                    3 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3541
                                        ]

                                    ]

                                ]

                            ]

                        ]

                    ],

                    2 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 5,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True'
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 588
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'ActSaleSubGrp',
                                'DATA' =>
                                [
                                    'All' => 'OR',
                                    'True' => 'True'
                                ],

                                'CHILDREN' =>
                                [
                                    0 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3546
                                        ]

                                    ],

                                    1 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3700
                                        ]

                                    ],

                                    2 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3465
                                        ]

                                    ],

                                    3 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3460
                                        ]

                                    ]

                                ]

                            ]

                        ]

                    ],

                    3 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 5,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True'
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 590
                                ]

                            ],

                            1 =>
                            [
                                'CLASS_ID' => 'ActSaleSubGrp',
                                'DATA' =>
                                [
                                    'All' => 'OR',
                                    'True' => 'True'
                                ],

                                'CHILDREN' =>
                                [
                                    0 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3546
                                        ]

                                    ],

                                    1 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 6045
                                        ]

                                    ],

                                    2 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3589
                                        ]

                                    ],

                                    3 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 6544
                                        ]

                                    ],

                                    4 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3541
                                        ]

                                    ],

                                    5 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 4775
                                        ]

                                    ],

                                    6 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3543
                                        ]

                                    ],

                                    7 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3586
                                        ]

                                    ],

                                    8 =>
                                    [
                                        'CLASS_ID' => 'CondIBProp:16:198',
                                        'DATA' =>
                                        [
                                            'logic' => 'Equal',
                                            'value' => 3515
                                        ]

                                    ]

                                ]

                            ]

                        ]

                    ],

                    4 =>
                    [
                        'CLASS_ID' => 'ActSaleBsktGrp',
                        'DATA' =>
                        [
                            'Type' => 'Discount',
                            'Value' => 5,
                            'Unit' => 'Perc',
                            'Max' => 0,
                            'All' => 'AND',
                            'True' => 'True',
                        ],

                        'CHILDREN' =>
                        [
                            0 =>
                            [
                                'CLASS_ID' => 'CondIBSection',
                                'DATA' =>
                                [
                                    'logic' => 'Equal',
                                    'value' => 593
                                ]

                            ]

                        ]

                    ]

                ]

            ]


        ]);

        if ($rule3->isSuccess()) {
            $id = $rule3->getId();
            \Bitrix\Sale\Internals\DiscountGroupTable::updateByDiscount($id, [24, 25], "Y", true);
        }

        $rule4 = \Bitrix\Sale\Internals\DiscountTable::add(
            [
                'NAME' => 'Скидка для группы 5%',
                'LID' => 's1',
                'CURRENCY' => 'RUB',
                'DISCOUNT_TYPE' => 'P',
                'ACTIVE' => 'Y',
                'SORT' => 95,
                'PRIORITY' => 1,
                'LAST_DISCOUNT' => 'Y',
                'LAST_LEVEL_DISCOUNT' => 'N',
                'CONDITIONS_LIST' => [
                    'CLASS_ID' => 'CondGroup',
                    'DATA' => [
                        'All' => 'AND',
                        'True' => 'True'
                    ],

                    'CHILDREN' => [],
                ],
                'USER_GROUPS' => [23],
                'ACTIONS_LIST' =>
                [
                    'CLASS_ID' => 'CondGroup',
                    'DATA' => [
                        'All' => 'AND'
                    ],

                    'CHILDREN' => [
                        0 => [
                            'CLASS_ID' => 'ActSaleBsktGrp',
                            'DATA' => [
                                'Type' => 'Discount',
                                'Value' => 5,
                                'Unit' => 'Perc',
                                'Max' => 0,
                                'All' => 'AND',
                                'True' => 'True',
                            ],

                            'CHILDREN' => [
                                0 => [
                                    'CLASS_ID' => 'CondIBSection',
                                    'DATA' => [
                                        'logic' => 'Not',
                                        'value' => 1149
                                    ]

                                ]

                            ]

                        ]

                    ]

                ]
            ]
        );

        if ($rule4->isSuccess()) {
            $id = $rule4->getId();
            \Bitrix\Sale\Internals\DiscountGroupTable::updateByDiscount($id, [23], "Y", true);
        }

        $rule5 = \Bitrix\Sale\Internals\DiscountTable::add(
            [
                'NAME' => 'Скидка для группы 3%',
                'LID' => 's1',
                'CURRENCY' => 'RUB',
                'DISCOUNT_TYPE' => 'P',
                'ACTIVE' => 'Y',
                'SORT' => 95,
                'PRIORITY' => 1,
                'LAST_DISCOUNT' => 'Y',
                'LAST_LEVEL_DISCOUNT' => 'N',
                'CONDITIONS_LIST' => [
                    'CLASS_ID' => 'CondGroup',
                    'DATA' => [
                        'All' => 'AND',
                        'True' => 'True'
                    ],

                    'CHILDREN' => [],
                ],
                'USER_GROUPS' => [22],
                'ACTIONS_LIST' =>
                [
                    'CLASS_ID' => 'CondGroup',
                    'DATA' => [
                        'All' => 'AND'
                    ],

                    'CHILDREN' => [
                        0 => [
                            'CLASS_ID' => 'ActSaleBsktGrp',
                            'DATA' => [
                                'Type' => 'Discount',
                                'Value' => 3,
                                'Unit' => 'Perc',
                                'Max' => 0,
                                'All' => 'AND',
                                'True' => 'True',
                            ],

                            'CHILDREN' => [
                                0 => [
                                    'CLASS_ID' => 'CondIBSection',
                                    'DATA' => [
                                        'logic' => 'Not',
                                        'value' => 1149
                                    ]

                                ]

                            ]

                        ]

                    ]

                ]
            ]
        );

        if ($rule5->isSuccess()) {
            $id = $rule5->getId();
            \Bitrix\Sale\Internals\DiscountGroupTable::updateByDiscount($id, [22], "Y", true);
        }
    }

    public function down()
    {
        //your code ...
    }
}
