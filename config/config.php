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
    'category' => array(
        array(
            'title'  => _a('Admin'),
            'name'   => 'admin'
        ),
        array(
            'title'  => _a('Cron'),
            'name'   => 'cron'
        ),
        array(
            'title'  => _a('Sms'),
            'name'   => 'sms'
        ),
    ),
    'item' => array(
        // Admin
        'admin_number' => array(
            'category'     => 'admin',
            'title'        => _a('Admin mobile number'),
            'edit'         => 'text',
            'filter'       => 'string',
        ),
        // Cron
        'cron_password' => array(
            'category'     => 'cron',
            'title'        => _a('Cron password'),
            'edit'         => 'text',
            'filter'       => 'string',
            'value'        => md5(rand()),
        ),
        // Sms
        'sms_send_country' => array(
            'title'        => _a('Select country for use local sms system'),
            'description'  => '',
            'edit'         => array(
                'type' => 'select',
                'options' => array(
                    'options' => array(
                        'null'    => _a('Not set'),
                        'iran'    => _a('Iran'),
                        'france'  => _a('France'),
                    ),
                ),
            ),
            'filter'       => 'text',
            'value'        => 'null',
            'category'     => 'sms',
        ),
        'sms_iran_username' => array(
            'category'     => 'sms',
            'title'        => _a('Iran sms panel username'),
            'edit'         => 'text',
            'filter'       => 'string',
        ),
        'sms_iran_password' => array(
            'category'     => 'sms',
            'title'        => _a('Iran sms panel password'),
            'edit'         => 'text',
            'filter'       => 'string',
        ),
        'sms_iran_number' => array(
            'category'     => 'sms',
            'title'        => _a('Iran sms panel number'),
            'edit'         => 'text',
            'filter'       => 'string',
        ),
        'sms_iran_soap_url' => array(
            'category'     => 'sms',
            'title'        => _a('Iran sms panel soap url'),
            'edit'         => 'text',
            'filter'       => 'string',
        ),
    )   
);