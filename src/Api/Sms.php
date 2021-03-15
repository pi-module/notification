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
use Laminas\Soap\Client as LaminasSoapClient;
use Laminas\Json\Json;

/*
 * Pi::api('sms', 'notification')->sendToUser($content, $number, $operator);
 * Pi::api('sms', 'notification')->sendToAdmin($content, $number, $operator);
 */

class Sms extends AbstractApi
{
    public function sendToUser($content, $number = '', $operator = '')
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
        $this->send($content, $number, $operator);
    }

    public function sendToAdmin($content, $number = '', $operator = '')
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
            $this->send($content, $number, $operator);
        }
    }

    public function send($content, $number, $operator = '')
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Check send time
        if ($config['sms_send_time'] == 'live') {
            // Select
            switch ($config['sms_send_country']) {
                case 'iran':
                    $result = $this->sendSmsIran($content, $number, $operator);
                    break;

                case 'france':
                    $result = $this->sendSmsFrance($content, $number, $operator);
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

    public function sendSmsIran($content, $number, $operator = '')
    {
        // Set result
        $result = [
            'delivery' => 0,
            'send'     => 0,
            'message'  => __('Nothing todo !'),
        ];

        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        switch ($operator) {
            case 'fanava':
                $parameters                       = [];
                $parameters['strServiceID']       = "RahyabSMS";
                $parameters['strServiceToken']    = "R@hy@bSoap_V1";
                $parameters['strMessageText']     = $content;
                $parameters['strRecipientNumber'] = ltrim($number, 0);
                $parameters['strSenderNumber']    = $config['sms_iran_number'];
                $parameters['strNumberUsername']  = $config['sms_iran_username'];
                $parameters['strNumberPassword']  = $config['sms_iran_password'];
                $parameters['strNumberCompany']   = "FANAVASYSTEM";
                $parameters['strIP']              = '';
                $parameters['strResultMessage']   = '';

                // Send
                try {
                    $client = new LaminasSoapClient($config['sms_iran_soap_url']);
                    $client->SendSMS_Single($parameters);

                    $result = [
                        'delivery' => 1,
                        'send'     => 1,
                        'message'  => __('Sms send successfully !'),
                    ];
                } catch (SoapFault $fault) {
                    $result['message'] = __('Error to send SMS');
                }
                break;

            default:
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
                    $client = new LaminasSoapClient($config['sms_iran_soap_url']);
                    $client->SendSms($parameters)->SendSmsResult;

                    $result = [
                        'delivery' => 1,
                        'send'     => 1,
                        'message'  => __('Sms send successfully !'),
                    ];
                } catch (SoapFault $fault) {
                    $result['message'] = __('Error to send SMS');
                }
                break;
        }

        // result
        return $result;
    }

    public function sendSmsFrance($content, $number, $operator = '')
    {
        return false;
    }

    // More information at : https://developer.nexmo.com/messaging/sms/overview
    public function nexmo($content, $number, $operator = '')
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());

        // Set client
        $basic  = new \Vonage\Client\Credentials\Basic($config['nexmo_key'], $config['nexmo_secret']);
        $client = new \Vonage\Client($basic);

        // Send SMS
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($number, Pi::config('sitename'), $content)
        );

        // Get message
        $message = $response->current();

        if ($message->getStatus() == 0) {
            $result = [
                'delivery' => 1,
                'send'     => 1,
                'message'  => __('The message was sent successfully'),
            ];
        } else {
            $result = [
                'delivery' => 0,
                'send'     => 0,
                'message'  => sprintf(__('The message failed with status: '), $message->getStatus()),
            ];
        }

        // result
        return $result;
    }
}
