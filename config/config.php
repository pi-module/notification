<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return [
    'category' => [
        [
            'title' => _a('Admin'),
            'name'  => 'admin',
        ],
        [
            'title' => _a('Sms'),
            'name'  => 'sms',
        ],
    ],
    'item'     => [
        // Admin
        'admin_number'      => [
            'category' => 'admin',
            'title'    => _a('Admin mobile number'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        // Sms
        'sms_send_country'  => [
            'title'       => _a('Select country for use local sms system'),
            'description' => '',
            'edit'        => [
                'type'    => 'select',
                'options' => [
                    'options' => [
                        'null'   => _a('Not set'),
                        'iran'   => _a('Iran'),
                        'france' => _a('France'),
                    ],
                ],
            ],
            'filter'      => 'text',
            'value'       => 'null',
            'category'    => 'sms',
        ],
        'sms_iran_username' => [
            'category' => 'sms',
            'title'    => _a('Iran sms panel username'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        'sms_iran_password' => [
            'category' => 'sms',
            'title'    => _a('Iran sms panel password'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        'sms_iran_number'   => [
            'category' => 'sms',
            'title'    => _a('Iran sms panel number'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        'sms_iran_soap_url' => [
            'category' => 'sms',
            'title'    => _a('Iran sms panel soap url'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
    ],
];