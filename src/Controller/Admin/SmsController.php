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
use Laminas\Db\Sql\Predicate\Expression;

class SmsController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page  = $this->params('page', 1);
        $list  = [];
        $limit = 50;
        $users = [];
        // Set info
        $order  = ['time_create DESC', 'id DESC'];
        $offset = (int)($page - 1) * $limit;
        // Get info
        $select = $this->getModel('sms')->select()->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('sms')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            // markup content
            $list[$row->id]['content'] = Pi::service('markup')->compile(
                $row->content,
                'html',
                ['nl2br' => false]
            );
            // user to
            if (isset($users[$row->uid])) {
                $list[$row->id]['user'] = $users[$row->uid];
            } else {
                $user                   = Pi::user()->getUser($row->uid)->toArray();
                $users[$row->uid]       = $user;
                $list[$row->id]['user'] = $user;
            }
            // Time send view
            $list[$row->id]['time_create_view'] = _date($row->time_create);
        }
        // Set paginator
        $columns   = ['count' => new Expression('count(*)')];
        $select    = $this->getModel('sms')->select()->columns($columns);
        $count     = $this->getModel('sms')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(
            [
                'router' => $this->getEvent()->getRouter(),
                'route'  => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
                'params' => array_filter(
                    [
                        'module'     => $this->getModule(),
                        'controller' => 'sms',
                        'action'     => 'index',
                    ]
                ),
            ]
        );
        // Set view
        $this->view()->setTemplate('sms-index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
    }
}
