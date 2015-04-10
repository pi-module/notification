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

class ToolsController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set cron url
        $cronUrl = Pi::url($this->url('default', array(
        	'module'      => 'notification',
        	'controller'  => 'cron',
        	'action'      => 'index',
        	'password'    => $config['cron_password'],
        )));
        // Set template
        $this->view()->setTemplate('tools_index');
        $this->view()->assign('cronUrl', $cronUrl);
    }
}