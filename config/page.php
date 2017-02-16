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
    // Admin section
    'admin' => array(
        array(
            'title'         => _a('Dashboard'),
            'controller'    => 'dashboard',
            'permission'    => 'dashboard',
        ),
        array(
            'title'         => _a('Sms'),
            'controller'    => 'sms',
            'permission'    => 'sms',
        ),
        array(
            'title'         => _a('Push notification'),
            'controller'    => 'push',
            'permission'    => 'push',
        ),
    ),
);