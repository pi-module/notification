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
 * Pi::api('sms', 'notification')->sendToUser($content, $number);
 * Pi::api('sms', 'notification')->sendToAdmin($content, $number);
 */

class Sms extends AbstractApi
{
    public function sendToUser($content, $number = '')
    {
        if (empty($number)) {
            $uid    = Pi::user()->getId();
            $fields = ['mobile'];
            $user   = Pi::user()->get($uid, $fields);
            if (!isset($user['mobile']) && empty($user['mobile'])) {
                return false;
            }
            $number = $user['mobile'];
        }
        $this->send($content, $number);
    }

    public function sendToAdmin($content, $number = '')
    {
        if (empty($number)) {
            // Get config
            $config = Pi::service('registry')->config->read($this->getModule());
            // Send
            $numbers = explode(',', $config['admin_number']);
            foreach ($numbers as $number) {
                $this->send($content, $number);
            }
        } else {
            $this->send($content, $number);
        }
    }

    protected function send($content, $number)
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Check send time
        if ($config['sms_send_time'] == 'live') {
            // Select
            switch ($config['sms_send_country']) {
                case 'iran':
                    $result = $this->sendSmsIran($content, $number);
                    break;

                case 'france':
                    $result = $this->sendSmsFrance($content, $number);
                    break;
            }
        }

        // Save sms
        $sms              = Pi::model('sms', $this->getModule())->createRow();
        $sms->number      = $number;
        $sms->content     = $content;
        $sms->uid         = Pi::user()->getId();
        $sms->time_create = time();
        $sms->delivery    = isset($result['delivery']) ? $result['delivery'] : 0;
        $sms->send        = isset($result['send']) ? $result['send'] : 0;
        $sms->save();
    }

    protected function sendSmsIran($content, $number)
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Set mobile
        $to   = [];
        $to[] = ltrim($number, 0);

        // Set parameters
        $parameters             = [];
        $parameters['username'] = $config['sms_iran_username'];
        $parameters['password'] = $config['sms_iran_password'];
        $parameters['from']     = $config['sms_iran_number'];
        $parameters['to']       = $to;
        $parameters['text']     = $content;
        $parameters['isflash']  = false;
        $parameters['udh']      = "";
        $parameters['recId']    = [0];
        $parameters['status']   = 0x0;

        // Send
        try {
            $client = new ZendSoapClient($config['sms_iran_soap_url']);
            $client->SendSms($parameters)->SendSmsResult;
            $delivery = 1;
            $send = 1;
        } catch (SoapFault $fault) {
            //$content  = json::encode($fault);
            $delivery = 0;
            $send = 0;
        }

        // result
        return [
            'delivery' => $delivery,
            'send' => $send,
        ];
    }

    protected function sendSmsFrance($content, $number)
    {
        return false;
    }
}