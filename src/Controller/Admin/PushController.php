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

namespace Module\Notification\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;
use Module\Notification\Form\PushForm;
use Module\Notification\Form\PushFilter;

class PushController extends ActionController
{
    public function indexAction()
    {
        // Set push url
        $pushUrl = [
            'all'   => pi::url(
                $this->url(
                    '', [
                        'action' => 'send',
                        'type'   => 'all',
                    ]
                )
            ),
            'token' => pi::url(
                $this->url(
                    '', [
                        'action' => 'send',
                        'type'   => 'token',
                    ]
                )
            ),
            'user'  => pi::url(
                $this->url(
                    '', [
                        'action' => 'send',
                        'type'   => 'user',
                    ]
                )
            ),
            'topic' => pi::url(
                $this->url(
                    '', [
                        'action' => 'send',
                        'type'   => 'topic',
                    ]
                )
            ),
        ];

        // Set view
        $this->view()->setTemplate('push-index');
        $this->view()->assign('pushUrl', $pushUrl);
    }

    public function sendAction()
    {
        $return = [];
        // Get page
        $type = $this->params('type');

        // Set option
        $option = [
            'type' => $type,
        ];

        // Set form
        $form = new PushForm('push', $option);
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new PushFilter($option));
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                // Set data
                $notification = [
                    'message'          => $values['message'],
                    'registration_ids' => [],
                ];

                // Set device id or topic
                switch ($type) {
                    case 'token':
                        $notification['registration_ids'] = explode('|', $values['device_token']);
                        break;

                    case 'user':
                        // Set info
                        $columns  = ['uid', 'device_token'];
                        $where    = ['device_token IS NOT NULL ?', 'uid' => explode('|', $values['user'])];
                        $limit    = 1000;
                        $order    = ['uid DESC'];

                        // Select
                        $select = Pi::model('profile', 'user')->select()->columns($columns)->where($where)->order($order)->limit($limit);
                        $rowset = Pi::model('profile', 'user')->selectWith($select);

                        // Set data
                        foreach ($rowset as $row) {
                            $notification['registration_ids'][] = $row->device_token;
                            $notification['user'][$row->uid]    = [
                                'uid'   => $row->uid,
                                'token' => $row->device_token,
                            ];
                        }
                        break;

                    case 'topic':
                        $notification['token'] = $values['topic'];
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
                        'values'       => $values,
                        'notification' => $notification,
                        'result'       => $result,
                    ]
                );

                // Set return
                $return['status'] = $result['status'];
                $return['data']   = '';
            } else {
                $return['status'] = 0;
                $return['data']   = '';
            }
            return $return;
        } else {
            $form->setAttribute('action', $this->url('', ['action' => 'send', 'type' => $type]));
        }

        // Set view
        $this->view()->setTemplate('system:component/form-popup');
        $this->view()->assign('title', __('Send push notification'));
        $this->view()->assign('form', $form);
    }
}