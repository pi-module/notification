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
use Zend\Soap\Client as ZendSoapClient;

/*
 * Pi::api('sms', 'notification')->send($content, $number);
 * Pi::api('sms', 'notification')->sendToAdmin($content);
 */

class Sms extends AbstractApi
{
	public function send($content, $number)
	{
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // Select
        switch ($config['sms_send_country']) {
        	case 'iran':
        		$this->sendSmsIran($content, $number);
        		break;

        	case 'france':
        	    $this->sendSmsFrance($content, $number);
        		break;
        }
	}

    public function sendToAdmin($content)
    {
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // Send
        $numbers = explode(',', $config['admin_number']);
        foreach ($numbers as $number) {
            $this->send($content, $number);
        }
    }

	public function sendSmsIran($content, $number)
	{
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // Set mobile
        $to = array();
        $to[] = ltrim($number, 0);
        // Set parameters
        $parameters = array();
        $parameters['username'] = $config['sms_iran_username'];
        $parameters['password'] = $config['sms_iran_password'];
        $parameters['from'] = $config['sms_iran_number'];
        $parameters['to'] = $to;
        $parameters['text'] = $content;
        $parameters['isflash'] = false;
        $parameters['udh'] = "";
        $parameters['recId'] = array(0);
        $parameters['status'] = 0x0;
        // Send
        $client = new ZendSoapClient($config['sms_iran_soap_url']);
        $client->SendSms($parameters)->SendSmsResult;
        // Save sms
    	$sms = Pi::model('sms', $this->getModule())->createRow();
    	$sms->number = $number;
    	$sms->content = $content;
    	$sms->uid = Pi::user()->getId();
    	$sms->time_create = time();
    	$sms->save();
	}

	public function sendSmsFrance($content, $number)
	{}
}