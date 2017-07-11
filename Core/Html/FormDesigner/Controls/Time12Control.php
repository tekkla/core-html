<?php
namespace Core\Html\FormDesigner\Controls;

use Core\Html\Controls\DateTimePicker;

/**
 * Time12Control.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015
 * @license MIT
 */
class Time12Control extends DateTimePicker
{

    protected $format = 'hh:mm A/PM';

    protected $data = [
        'form-mask' => '99:99'
    ];

    protected $attribute = [
        'maxlenght' => 5,
        'size' => 5
    ];
}
