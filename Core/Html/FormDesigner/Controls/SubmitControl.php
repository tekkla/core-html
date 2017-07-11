<?php
namespace Core\Html\FormDesigner\Controls;

use Core\Html\Form\Button;

/**
 * SubmitControl.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015
 * @license MIT
 */
class SubmitControl extends Button
{

    protected $type = 'submit';

    protected $inner = 'submit';

    protected $icon = 'save';

    protected $button_type = 'primary';
}
