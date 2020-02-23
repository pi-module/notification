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

namespace Module\Notification\Api;

use Pi;
use Pi\Application\Api\AbstractApi;
use Zend\Soap\Client as ZendSoapClient;
use Zend\Json\Json;

/*
 * Pi::api('push', 'notification')->send($params);
 * Pi::api('push', 'notification')->log($notification);
 */

class Push extends AbstractApi
{
    public function send($params)
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Set user id list
        $userIdes = [];

        // Set data
        $notification = [
            'title'            => $params['title'],
            'body'             => $params['body'],
            'registration_ids' => [],
        ];

        // Check image
        if (isset($params['image']) && !empty($params['image'])) {
            $notification['image'] = $params['image'];
        }

        // Set device id or topic
        switch ($params['type']) {
            case 'token':
                $notification['registration_ids'] = is_array($params['device_token']) ? $params['device_token'] : explode('|', $params['device_token']);
                break;

            case 'user':
                // Set info
                $uid     = is_array($params['user']) ? $params['user'] : explode('|', $params['user']);
                $columns = ['uid', 'device_token'];
                $where   = ['device_token IS NOT NULL ?', 'uid' => $uid];
                $limit   = 1000;
                $order   = ['uid DESC'];

                // Select
                $select = Pi::model('profile', 'user')->select()->columns($columns)->where($where)->order($order)->limit($limit);
                $rowset = Pi::model('profile', 'user')->selectWith($select);

                // Set data
                foreach ($rowset as $row) {
                    $userIdes[$row->uid]                = $row->uid;
                    $notification['registration_ids'][] = $row->device_token;
                    $notification['user'][$row->uid]    = [
                        'uid'   => $row->uid,
                        'token' => $row->device_token,
                    ];
                }
                break;

            case 'topic':
                $notification['topic'] = $params['topic'];
                break;

            case 'all':
                // Set info
                $columns = ['uid', 'device_token'];
                $where   = ['device_token IS NOT NULL ?'];
                $limit   = 1000;
                $order   = ['uid DESC'];

                // Select
                $select = Pi::model('profile', 'user')->select()->columns($columns)->where($where)->order($order)->limit($limit);
                $rowset = Pi::model('profile', 'user')->selectWith($select);

                // Set data
                foreach ($rowset as $row) {
                    $userIdes[$row->uid]                = $row->uid;
                    $notification['registration_ids'][] = $row->device_token;
                    $notification['user'][$row->uid]    = [
                        'uid'   => $row->uid,
                        'token' => $row->device_token,
                    ];
                }
                break;
        }

        // Send push notification
        $result = Pi::service('notification')->fcm($notification);

        // Save log
        Pi::api('push', 'notification')->log(
            [
                'params'       => $params,
                'notification' => $notification,
                'result'       => $result,
            ]
        );

        // Save notification on db
        if (Pi::service('module')->isActive('message') && $config['save_notification'] && !empty($userIdes)) {
            foreach ($userIdes as $userId) {
                Pi::api('api', 'message')->notify(
                    $userId,
                    $params['body'],
                    $params['title'],
                    isset($params['tag']) ? $params['tag'] : 'general',
                    isset($params['image']) ? $params['image'] : ''
                );
            }
        }

        return $result;
    }

    public function log($notification)
    {
        Pi::service('audit')->log(
            'notification',
            json_encode($notification)
        );
    }
}
