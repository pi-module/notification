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
namespace Module\Notification\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

/*
 * Pi::api('mail', 'notification')->send($to, $template, $information, $module, $uid);
 */

class Mail extends AbstractApi
{
    public function send($to, $template, $information, $module, $uid = 0)
    {
        Pi::service('notification')->send(
            $to,
            $template,
            $information,
            $module,
            $uid
        );
    }
}