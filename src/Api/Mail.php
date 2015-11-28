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
 * Pi::api('mail', 'notification')->send($to, $template, $information, $module);
 */

class Mail extends AbstractApi
{
    public function send($to, $template, $information, $module, $uid = 0)
    {
        // Set template
        $data = Pi::service('mail')->template(
            array(
                'file'      => $template,
                'module'    => $module,
            ),
            $information
        );

        // Set message
        $message = Pi::service('mail')->message($data['subject'], $data['body'], $data['format']);
        $message->addTo($to);
        //$message->setEncoding("UTF-8");

        // Set as notification
        if (Pi::service('module')->isActive('message') && $uid > 0) {
            Pi::api('api', 'message')->notify($uid, $data['body'], $data['subject']);
        }

        // Send mail
        try {
            Pi::service('mail')->send($message);
        } catch (\Exception $e) {
            return false;
        }
    }
}