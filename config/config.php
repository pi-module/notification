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
            'title' => _a('Push'),
            'name'  => 'push',
        ],
        [
            'title' => _a('Cron'),
            'name'  => 'cron',
        ],
        [
            'title' => _a('Sms'),
            'name'  => 'sms',
        ],
    ],
    'item'     => [
        
        // admin
        'admin_number'      => [
            'category' => 'admin',
            'title'    => _a('Admin mobile number'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        
        // push
        'save_notification'       => [
            'category'    => 'push',
            'title'       => _a('Save each user notification on database'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'fcm_default_topic' => [
            'category'    => 'push',
            'title'       => _a('Default fcm topic name'),
            'description' => _a('Put default topic name if you want sent faster, format like /topics/MY_TOPIC'),
            'edit'        => 'text',
            'filter'      => 'string',
        ],
        
        // cron
        'module_cron'       => [
            'category'    => 'cron',
            'title'       => _a('Active this module cron system'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 1,
        ],
        
        // sms
        'sms_send_time'     => [
            'title'       => _a('Set send time'),
            'description' => _a('If select send sms by cron, need install tools module and set cron job time'),
            'edit'        => [
                'type'    => 'select',
                'options' => [
                    'options' => [
                        'live' => _a('Live'),
                        'cron' => _a('Cron'),
                    ],
                ],
            ],
            'filter'      => 'text',
            'value'       => 'live',
            'category'    => 'sms',
        ],
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
                        'nexmo'  => _a('Nexmo'),
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
        'sms_iran_number' => [
            'category' => 'sms',
            'title'    => _a('Iran sms number'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        'sms_iran_soap_url' => [
            'category' => 'sms',
            'title'    => _a('Iran sms soap url'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        'nexmo_number'   => [
            'category' => 'sms',
            'title'    => _a('Nexmo number'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        'nexmo_key'   => [
            'category' => 'sms',
            'title'    => _a('Nexmo key'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
        'nexmo_secret' => [
            'category' => 'sms',
            'title'    => _a('Nexmo secret'),
            'edit'     => 'text',
            'filter'   => 'string',
        ],
    ],
];
