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
 * Pi::api('cron', 'notification')->doCron();
 */

class Cron extends AbstractApi
{
    public function doCron()
    {
    	// Set module list
    	$moduleList = array('order');
        // Check all modules
    	foreach ($moduleList as $module) {
    		if (Pi::service('module')->isActive(strtolower($module))) {
    			$class = sprintf('Module\%s\Api\Notification', ucfirst(strtolower($module)));
    			if (class_exists($class)) {
    				Pi::api('notification', strtolower($module))->doCron();
    			}
    		}
    	}
    }
}