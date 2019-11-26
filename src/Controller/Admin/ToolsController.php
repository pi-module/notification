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

class ToolsController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set cron url
        $cronUrl = Pi::url(
            $this->url(
                'default', [
                'module'     => 'notification',
                'controller' => 'cron',
                'action'     => 'index',
                'password'   => $config['cron_password'],
            ]
            )
        );
        // Set template
        $this->view()->setTemplate('tools_index');
        $this->view()->assign('cronUrl', $cronUrl);
    }
}