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
use Laminas\InputFilter\InputFilter;

class PushFilter extends InputFilter
{
    public function __construct($option = [])
    {
        switch ($option['type']) {
            case 'token':

                // device_token
                $this->add(
                    [
                        'name'     => 'device_token',
                        'required' => true,
                        'filters'  => [
                            [
                                'name' => 'StringTrim',
                            ],
                        ],
                    ]
                );
                break;

            case 'user':

                // user
                $this->add(
                    [
                        'name'     => 'user',
                        'required' => true,
                        'filters'  => [
                            [
                                'name' => 'StringTrim',
                            ],
                        ],
                    ]
                );
                break;

            case 'topic':

                // topic
                $this->add(
                    [
                        'name'     => 'topic',
                        'required' => true,
                        'filters'  => [
                            [
                                'name' => 'StringTrim',
                            ],
                        ],
                    ]
                );
                break;

            case 'all':
                break;
        }

        // title
        $this->add(
            [
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ]
        );

        // body
        $this->add(
            [
                'name'     => 'body',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ]
        );

        // image
        $this->add(
            [
                'name'     => 'image',
                'required' => false,
                'filters'  => [
                    [
                        'name' => 'StringTrim',
                    ],
                ],
            ]
        );
    }
}