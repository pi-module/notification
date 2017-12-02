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

namespace Module\Notification\Form;

use Pi;
use Zend\InputFilter\InputFilter;

class PushFilter extends InputFilter
{
    public function __construct($option = [])
    {
        switch ($option['type']) {
            case 'token':
                // device_token
                $this->add([
                    'name'     => 'device_token',
                    'required' => true,
                    'filters'  => [
                        [
                            'name' => 'StringTrim',
                        ],
                    ],
                ]);
                break;

            case 'user':
                // user
                $this->add([
                    'name'     => 'user',
                    'required' => true,
                    'filters'  => [
                        [
                            'name' => 'StringTrim',
                        ],
                    ],
                ]);
                break;

            case 'topic':
                // topic
                $this->add([
                    'name'     => 'topic',
                    'required' => true,
                    'filters'  => [
                        [
                            'name' => 'StringTrim',
                        ],
                    ],
                ]);
                break;

            case 'all':

                break;
        }
        // message
        $this->add([
            'name'     => 'message',
            'required' => true,
            'filters'  => [
                [
                    'name' => 'StringTrim',
                ],
            ],
        ]);
    }
}