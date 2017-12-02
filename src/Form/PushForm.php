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
use Pi\Form\Form as BaseForm;

class PushForm extends BaseForm
{
    public function __construct($name = null, $option = [])
    {
        $this->option = $option;
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new PushFilter($this->option);
        }
        return $this->filter;
    }

    public function init()
    {
        switch ($this->option['type']) {
            case 'token':
                // device_token
                $this->add([
                    'name'       => 'device_token',
                    'options'    => [
                        'label' => __('Device token'),
                    ],
                    'attributes' => [
                        'type'        => 'textarea',
                        'rows'        => '5',
                        'cols'        => '40',
                        'description' => __('Use `|` as delimiter to separate'),
                        'required'    => true,
                    ],
                ]);
                break;

            case 'user':
                // user
                $this->add([
                    'name'       => 'user',
                    'options'    => [
                        'label' => __('User ids'),
                    ],
                    'attributes' => [
                        'type'        => 'textarea',
                        'rows'        => '5',
                        'cols'        => '40',
                        'description' => __('Use `|` as delimiter to separate'),
                        'required'    => true,
                    ],
                ]);
                break;

            case 'topic':
                // topic
                $this->add([
                    'name'       => 'topic',
                    'options'    => [
                        'label' => __('Topic'),
                    ],
                    'attributes' => [
                        'type'        => 'text',
                        'description' => '',
                        'required'    => true,
                    ],
                ]);
                break;

            case 'all':
                break;
        }
        // message
        $this->add([
            'name'       => 'message',
            'options'    => [
                'label' => __('Message'),
            ],
            'attributes' => [
                'type'        => 'textarea',
                'rows'        => '5',
                'cols'        => '40',
                'description' => '',
                'required'    => true,
            ],
        ]);
        // Save
        $this->add([
            'name'       => 'submit',
            'type'       => 'submit',
            'attributes' => [
                'value' => __('Send'),
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}