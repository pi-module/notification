<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return array(
    // Hide from front menu
    'front' => false,
    // Admin side
    'admin' => array(
        'dashboard' => array(
            'label'         => _a('Dashboard'),
            'permission'    => array(
                'resource'  => 'dashboard',
            ),
            'route'         => 'admin',
            'controller'    => 'dashboard',
            'action'        => 'index',
        ),
        'sms' => array(
            'label'         => _a('Sms'),
            'permission'    => array(
                'resource'  => 'sms',
            ),
            'route'         => 'admin',
            'controller'    => 'sms',
            'action'        => 'index',
        ),
        'push' => array(
            'label'         => _a('Push notification'),
            'permission'    => array(
                'resource'  => 'push',
            ),
            'route'         => 'admin',
            'controller'    => 'push',
            'action'        => 'index',
        ),
    ),
);