<?php
namespace Core\Html\Form;

use Core\Html\Form\Traits\ValueTrait;

/**
 * Option Form Element
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @license MIT
 * @copyright 2015 by author
 */
class Option extends AbstractForm
{
    use ValueTrait;

    protected $element = 'option';

    protected $data = [
        'control' => 'option'
    ];

    protected $attribute = [
        'value' => 1
    ];

    private $selected = false;

    /**
     * Set option to be selected
     *
     * @return Option
     */
    public function isSelected(): Option
    {
        $this->selected = true;

        return $this;
    }

    /**
     * Set option to not selected
     *
     * @return Option
     */
    public function notSelected(): Option
    {
        $this->selected = false;

        return $this;
    }

    /**
     * Returns options selcted state
     *
     * @return bool
     */
    public function getSelected(): bool
    {
        return $this->selected;
    }

    public function build()
    {
        if ($this->selected) {
            $this->attribute['selected'] = false;
        }

        if (! $this->checkAttribute('value') && ! empty($this->inner)) {
            $this->attribute['value'] = $this->inner;
        }

        if ($this->checkAttribute('value') && empty($this->inner)) {
            $this->inner = $this->attribute['value'];
        }

        return parent::build();
    }
}
