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
        // Get page
        $page = $this->params('page', 1);
        $list = array();
        $limit = 50;
        // Set info
        $order = array('time_create DESC', 'id DESC');
        $offset = (int)($page - 1) * $limit;
        // Get info
        $select = $this->getModel('push')->select()->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('push')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            // markup content
            $list[$row->id]['body'] = Pi::service('markup')->compile(
                $row->body,
                'html',
                array('nl2br' => false)
            );
            // Time send view
            $list[$row->id]['time_create_view'] = _date($row->time_create);
        }
        // Set paginator
        $columns = array('count' => new Expression('count(*)'));
        $select = $this->getModel('push')->select()->columns($columns);
        $count = $this->getModel('push')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter(array(
                'module' => $this->getModule(),
                'controller' => 'push',
                'action' => 'index',
            )),
        ));
        // Set push url
        $pushUrl = pi::url($this->url('', array(
            'action' => 'send',
        )));
        // Set view
        $this->view()->setTemplate('push-index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('pushUrl', $pushUrl);
    }

    public function sendAction()
    {
        $return = array();
        // Set form
        $form = new PushForm('push');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new PushFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();

                // Send push notification
                $pushData = array(
                    'title' => $values['title'],
                    'body' => $values['body'],
                );
                $result = Pi::service('notification')->fcm($pushData);

                // Save sms
                if ($result['status'] == 1) {
                    $push = $this->getModel('push')->createRow();
                    $push->time_create = time();
                    $push->to = $result['fields']['to'];
                    $push->title = $values['title'];
                    $push->body = $values['body'];
                    $push->sound  = '';
                    $push->time_to_live = '';
                    $push->save();
                }

                // Set return
                $return['status'] = $result['status'];
                $return['data'] = json_encode($result);
            } else {
                $return['status'] = 0;
                $return['data'] = '';
            }
            return $return;
        } else {
            $form->setAttribute('action', $this->url('', array('action' => 'send')));
        }
        // Set view
        $this->view()->setTemplate('system:component/form-popup');
        $this->view()->assign('title', __('Send push notification'));
        $this->view()->assign('form', $form);
    }
}