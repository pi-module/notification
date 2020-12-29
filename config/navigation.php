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
    // Hide from front menu
    'front' => false,
    // Admin side
    'admin' => [
        'dashboard' => [
            'label'      => _a('Dashboard'),
            'permission' => [
                'resource' => 'dashboard',
            ],
            'route'      => 'admin',
            'controller' => 'dashboard',
            'action'     => 'index',
        ],
        'sms'       => [
            'label'      => _a('Sms'),
            'permission' => [
                'resource' => 'sms',
            ],
            'route'      => 'admin',
            'controller' => 'sms',
            'action'     => 'index',
        ],
        'push'      => [
            'label'      => _a('Push notification'),
            'permission' => [
                'resource' => 'push',
            ],
            'route'      => 'admin',
            'controller' => 'push',
            'action'     => 'index',
        ],
    ],
];
