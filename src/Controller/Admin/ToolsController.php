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
        // Set template
        $this->view()->setTemplate('tools_index');
        // Test send sms
        //Pi::api('sms', 'notification')->sendSms('Test 1', '');
    }
}