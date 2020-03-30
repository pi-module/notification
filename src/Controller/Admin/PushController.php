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
        $module = $this->params('module');
        $type = $this->params('type');

        // Get config
        $config = Pi::service('registry')->config->read($module);

        // Set option
        $option = [
            'type'              => $type,
            'fcm_default_topic' => $config['fcm_default_topic']
        ];

        // Set form
        $form = new PushForm('push', $option);
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new PushFilter($option));
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                // Set type
                $values['type'] = $type;

                // Send push notification
                $result = Pi::api('push', 'notification')->send($values);

                // Set return
                $return['status'] = $result['status'];
                $return['result'] = $result;
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