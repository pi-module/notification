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

class Cron extends AbstractApi
{
    public function start()
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Check cron active for this module
        if ($config['module_cron']) {

            // Set log
            Pi::service('audit')->log('cron', 'notification - Start cron on server');

            // Set info
            $where = ['send' => 0];
            $order = ['time_create ASC', 'id ASC'];
            $limit = 25;

            // select sms
            $select = Pi::model('sms', $this->getModule())->select()->where($where)->order($order)->limit($limit);
            $rowset = Pi::model('sms', $this->getModule())->selectWith($select);

            // Make list
            foreach ($rowset as $row) {

                // Update result
                //if (isset($result['send']) && $result['send'] == 1) {
                    Pi::model('sms', $this->getModule())->update(
                        //['send' => $result['send'], 'delivery' => $result['delivery']],
                        ['send' => 1, 'delivery' => 1],
                        ['id' => $row->id]
                    );
                //}

                // Send
                switch ($config['sms_send_country']) {
                    case 'iran':
                        $result = Pi::api('sms', 'notification')->sendSmsIran($row->content, $row->number);
                        break;

                    case 'france':
                        $result = Pi::api('sms', 'notification')->sendSmsFrance($row->content, $row->number);
                        break;
                }


                // Set log
                Pi::service('audit')->log('cron', $result['send']);
            }

            // Set log
            Pi::service('audit')->log('cron', 'notification - End cron on server');

        } else {
            // Set log
            Pi::service('audit')->log('cron', 'notification - cron system not active for this module');
        }
    }
}