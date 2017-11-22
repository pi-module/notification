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

namespace Module\Notification\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class CheckController extends ActionController
{
    public function indexAction()
    {
        // ToDo : build check system for show notification for each use

        return false;

        // Set result array
        /* $result = [
            'status' => 0,
            'title'  => '',
            'body'   => '',
            'logo'   => '',
        ];

        // Check user
        if (Pi::service('authentication')->hasIdentity()) {

            // Get user id
            $uid = Pi::user()->getId();

            // Set time
            $timeStart = time() - 15;

            // Check message module for example
            if (Pi::service('module')->isActive('message')) {
                // Get new message
                $where = [
                    'uid'            => $uid,
                    'is_deleted'     => 0,
                    'is_read'        => 0,
                    'time_send >= ?' => $timeStart,
                ];
                $select = Pi::model('notification', 'message')->select()->where($where)->limit(1);
                $row = Pi::model('notification', 'message')->selectWith($select)->current();
                if ($row) {
                    $result = [
                        'status' => 1,
                        'title'  => $row['subject'],
                        'body'   => $row['content'],
                        'logo'   => Pi::service('asset')->logo(),
                    ];
                }
            }
        }

        return $result; */
    }
}