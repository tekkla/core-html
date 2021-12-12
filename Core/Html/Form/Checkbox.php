<?php
namespace Core\Html\Form;

use Core\Html\Form\Traits\ValueTrait;
use Core\Html\Form\Traits\IsCheckedTrait;

/**
 * Checkbox.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2021
 * @license MIT
 */
class Checkbox extends Input
{
    use ValueTrait;
    use IsCheckedTrait;

    protected string $type = 'checkbox';
    protected string $element = 'input';
    protected array $data = [
        'control' => 'checkbox'
    ];
    protected array $attribute = [
        'value' => 1
    ];
}

